<?php

namespace App\Services\Rankfree;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

/** Server-only adapter. Public routes must add customer ownership and durable duplicate protection. */
class RankfreeClient
{
    private const BASE_URL = 'https://rankfree.kr/api/v1';

    private const STATUSES = [
        'pending' => '접수', 'processing' => '진행중', 'completed' => '완료', 'canceled' => '취소',
    ];

    private const FIELD_TYPES = [
        'TEXT', 'TEXTAREA', 'URL', 'NUMBER', 'SELECT', 'MULTI_SELECT',
        'TOGGLE', 'DATE', 'ADDRESS', 'MISSION_OPTIONS', 'TAGS', 'FILE', 'IMAGE',
    ];

    public function products(): array
    {
        if (! is_array(config('rankfree.product_fields', []))) {
            throw new RankfreeException('not_configured');
        }
        $data = $this->request('GET', '/products');
        if (! isset($data['products']) || ! is_array($data['products']) || ! array_is_list($data['products'])) {
            throw new RankfreeException('invalid_response');
        }
        $products = [];
        foreach ($data['products'] as $product) {
            if (! is_array($product) || ! is_int($product['id'] ?? null)) {
                throw new RankfreeException('invalid_response');
            }
            if (array_key_exists($product['id'], config('rankfree.product_fields', []))) {
                $products[] = $this->publicProduct($product);
            }
        }

        return $products;
    }

    public function product(int $id): array
    {
        $this->approvedFields($id);
        $data = $this->request('GET', '/products/'.$id);
        if (! is_array($data['product'] ?? null) || ($data['product']['id'] ?? null) !== $id) {
            throw new RankfreeException('invalid_response');
        }

        return $this->publicProduct($data['product'], true);
    }

    public function createOrder(int $productId, array $fields = [], ?int $quantity = null, ?int $days = null, ?int $couponId = null): array
    {
        if (config('rankfree.submission_enabled') !== true) {
            throw new RankfreeException('submission_disabled');
        }
        $allowed = $this->approvedFields($productId);
        foreach (['quantity' => $quantity, 'days' => $days, 'user_coupon_id' => $couponId] as $name => $value) {
            if ($value !== null && $value < 1) {
                throw new RankfreeException('invalid_input', field: $name);
            }
        }
        foreach ($fields as $key => $value) {
            if (! is_string($key) || ! in_array($key, $allowed, true) || ! $this->inputValue($value)) {
                throw new RankfreeException('invalid_input');
            }
        }
        $product = $this->product($productId);
        if (! $product['orderable']) {
            throw new RankfreeException('not_orderable');
        }
        $supported = array_column($product['fields'], 'key');
        if (array_diff(array_keys($fields), $supported) !== []) {
            throw new RankfreeException('invalid_input');
        }
        $payload = ['product_id' => $productId, 'fields' => (object) $fields];
        foreach (['quantity' => $quantity, 'days' => $days, 'user_coupon_id' => $couponId] as $name => $value) {
            if ($value !== null) {
                $payload[$name] = $value;
            }
        }
        $data = $this->request('POST', '/orders', $payload, $allowed);
        $order = $this->publicOrder($data['order'] ?? null, true);
        if ($order['product']['id'] !== $productId || $order['status'] !== 'pending') {
            throw new RankfreeException('submission_uncertain');
        }

        return $order;
    }

    /** Caller must authorize this order number against its own customer order ledger. */
    public function order(string $number): array
    {
        if (! preg_match('/^[A-Za-z0-9][A-Za-z0-9_-]{0,63}$/D', $number)) {
            throw new RankfreeException('invalid_input');
        }
        $data = $this->request('GET', '/orders/'.$number);
        $order = $this->publicOrder($data['order'] ?? null);
        if ($order['order_no'] !== $number) {
            throw new RankfreeException('invalid_response');
        }

        return $order;
    }

    private function request(string $method, string $path, array $payload = [], array $fields = []): array
    {
        if (config('rankfree.enabled') !== true) {
            throw new RankfreeException('disabled');
        }
        $key = config('rankfree.api_key');
        if (! is_string($key) || ! preg_match('/^rk_[A-Za-z0-9_-]+$/D', $key)) {
            throw new RankfreeException('not_configured');
        }
        $creating = $method === 'POST';
        try {
            $response = Http::withToken($key)->acceptJson()->asJson()->withoutRedirecting()
                ->connectTimeout(5)->timeout(15)
                ->send($method, self::BASE_URL.$path, $creating ? ['json' => $payload] : []);
        } catch (ConnectionException) {
            throw new RankfreeException($creating ? 'submission_uncertain' : 'unavailable');
        }
        $expected = $creating ? 201 : 200;
        if ($response->status() !== $expected) {
            $status = $response->status();
            $reason = $creating && ! in_array($status, [400, 401, 403, 404, 422, 429], true)
                ? 'submission_uncertain' : 'rejected';
            $field = $response->json('field');
            $safeFields = array_merge(['product_id', 'quantity', 'days', 'user_coupon_id'], array_map(fn ($key) => 'f_'.$key, $fields));

            throw new RankfreeException($reason, $status, is_string($field) && in_array($field, $safeFields, true) ? $field : null);
        }
        $data = $response->json();
        if (! is_array($data)) {
            throw new RankfreeException($creating ? 'submission_uncertain' : 'invalid_response', $response->status());
        }

        return $data;
    }

    private function approvedFields(int $id): array
    {
        $products = config('rankfree.product_fields', []);
        if ($id < 1 || ! is_array($products) || ! array_key_exists($id, $products)) {
            throw new RankfreeException('product_not_approved');
        }
        $fields = $products[$id];
        if (! is_array($fields) || ! array_is_list($fields)) {
            throw new RankfreeException('not_configured');
        }
        foreach ($fields as $field) {
            if (! is_string($field) || ! preg_match('/^[a-zA-Z][a-zA-Z0-9_]{0,99}$/D', $field)) {
                throw new RankfreeException('not_configured');
            }
        }

        return $fields;
    }

    private function publicProduct(array $product, bool $detail = false): array
    {
        if (! is_int($product['id'] ?? null) || ! is_string($product['title'] ?? null)
            || ! is_bool($product['orderable'] ?? null) || ! is_int($product['unit_price'] ?? null) || $product['unit_price'] < 0) {
            throw new RankfreeException('invalid_response');
        }
        foreach (['type', 'type_name', 'quantity_mode', 'earliest_start_date'] as $field) {
            if (array_key_exists($field, $product) && ! is_string($product[$field])) {
                throw new RankfreeException('invalid_response');
            }
        }
        foreach (['min_quantity', 'max_quantity', 'min_days', 'fixed_quantity', 'fixed_days'] as $field) {
            if (array_key_exists($field, $product) && (! in_array($field, ['fixed_quantity', 'fixed_days'], true) || $product[$field] !== null)
                && (! is_int($product[$field]) || $product[$field] < 1)) {
                throw new RankfreeException('invalid_response');
            }
        }
        if ((isset($product['quantity_mode']) && ! in_array($product['quantity_mode'], ['daily', 'total'], true))
            || (isset($product['earliest_start_date']) && ! $this->date($product['earliest_start_date']))) {
            throw new RankfreeException('invalid_response');
        }
        $allowed = $this->approvedFields($product['id']);
        $result = Arr::only($product, [
            'id', 'title', 'type', 'type_name', 'unit_price', 'quantity_mode',
            'min_quantity', 'max_quantity', 'min_days', 'fixed_quantity', 'fixed_days', 'earliest_start_date', 'orderable',
        ]);
        if ($detail) {
            if (! is_array($product['fields'] ?? null) || ! array_is_list($product['fields'])) {
                throw new RankfreeException('invalid_response');
            }
            $result['fields'] = [];
            foreach ($product['fields'] as $field) {
                if (! is_array($field) || ! in_array($field['key'] ?? null, $allowed, true)) {
                    continue;
                }
                if (! is_string($field['label'] ?? null) || ! is_string($field['type'] ?? null)
                    || ! in_array($field['type'], self::FIELD_TYPES, true) || ! is_bool($field['required'] ?? null)
                    || ! is_bool($field['api_supported'] ?? null)) {
                    throw new RankfreeException('invalid_response');
                }
                foreach (['help', 'contains'] as $name) {
                    if (isset($field[$name]) && ! is_string($field[$name])) {
                        throw new RankfreeException('invalid_response');
                    }
                }
                if (! $field['api_supported'] || in_array($field['type'], ['FILE', 'IMAGE'], true)) {
                    if ($field['required']) {
                        $result['orderable'] = false;
                    }

                    continue;
                }
                $safe = Arr::only($field, ['key', 'label', 'type', 'required', 'help', 'contains', 'api_supported']);
                $safe['options'] = [];
                if (isset($field['options']) && (! is_array($field['options']) || ! array_is_list($field['options']))) {
                    throw new RankfreeException('invalid_response');
                }
                foreach ($field['options'] ?? [] as $option) {
                    if (! is_array($option) || ! is_scalar($option['value'] ?? null) || ! is_string($option['label'] ?? null)) {
                        throw new RankfreeException('invalid_response');
                    }
                    $safe['options'][] = Arr::only($option, ['value', 'label']);
                }
                $result['fields'][] = $safe;
            }
        }

        return $result;
    }

    private function publicOrder(mixed $order, bool $creating = false): array
    {
        $reason = $creating ? 'submission_uncertain' : 'invalid_response';
        if (! is_array($order) || ! is_string($order['order_no'] ?? null)
            || ! preg_match('/^[A-Za-z0-9][A-Za-z0-9_-]{0,63}$/D', $order['order_no'])
            || ! is_string($order['status'] ?? null) || ! isset(self::STATUSES[$order['status']])
            || ! is_array($order['product'] ?? null) || ! is_array($order['fields'] ?? null)
            || ! is_string($order['created_at'] ?? null) || ! array_key_exists('days', $order)
            || ($order['days'] !== null && (! is_int($order['days']) || $order['days'] < 1))) {
            throw new RankfreeException($reason);
        }
        foreach (['unit_price', 'discount_amount', 'total_price', 'quantity'] as $field) {
            if (! is_int($order[$field] ?? null) || $order[$field] < 0) {
                throw new RankfreeException($reason);
            }
        }
        if ($order['quantity'] < 1 || ! array_key_exists('id', $order['product']) || ! array_key_exists('title', $order['product'])
            || (isset($order['product']['id']) && (! is_int($order['product']['id']) || $order['product']['id'] < 1))
            || (isset($order['product']['title']) && ! is_string($order['product']['title']))) {
            throw new RankfreeException($reason);
        }
        $result = Arr::only($order, ['order_no', 'status', 'quantity', 'days', 'unit_price', 'discount_amount', 'total_price', 'created_at']);
        $result['status_label'] = self::STATUSES[$order['status']];
        $result['product'] = Arr::only($order['product'], ['id', 'title']);
        $id = $order['product']['id'] ?? null;
        $allowed = is_int($id) ? config('rankfree.product_fields.'.$id, []) : [];
        $result['fields'] = Arr::only($order['fields'], is_array($allowed) ? $allowed : []);
        foreach ($result['fields'] as $value) {
            if ($value !== null && ! $this->inputValue($value)) {
                throw new RankfreeException($reason);
            }
        }

        return $result;
    }

    private function inputValue(mixed $value): bool
    {
        if (is_scalar($value)) {
            return ! is_float($value) || is_finite($value);
        }

        return is_array($value) && array_is_list($value)
            && count(array_filter($value, fn ($item) => is_scalar($item) && (! is_float($item) || is_finite($item)))) === count($value);
    }

    private function date(string $value): bool
    {
        if (! preg_match('/^(\d{4})-(\d{2})-(\d{2})$/D', $value, $parts)) {
            return false;
        }

        return checkdate((int) $parts[2], (int) $parts[3], (int) $parts[1]);
    }
}
