<?php

namespace Tests\Feature;

use App\Services\Rankfree\CustomerCredential;
use App\Services\Rankfree\RankfreeClient;
use App\Services\Rankfree\RankfreeException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RankfreeClientTest extends TestCase
{
    private RankfreeClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'rankfree.enabled' => true, 'rankfree.api_key' => 'rk_legacy_global_key',
            'rankfree.submission_enabled' => true,
            'rankfree.product_fields' => [12 => ['place_url', 'daily_qty', 'start_date', 'end_date', 'tags', 'attachment']],
        ]);
        Http::preventStrayRequests();
        $this->client = RankfreeClient::forCustomer(1, new CustomerCredential(1, 'rk_unit_test_secret'));
    }

    public function test_disabled_missing_key_and_submission_gate_never_contact_remote(): void
    {
        config(['rankfree.enabled' => false]);
        $this->failsWith('disabled', fn () => $this->client->products());
        config(['rankfree.enabled' => true]);
        $this->failsWith('account_not_connected', fn () => RankfreeClient::forCustomer(1, null));
        $this->failsWith('not_configured', fn () => new CustomerCredential(1, "rk_bad\r\nInjected: header"));
        config(['rankfree.submission_enabled' => false]);
        $this->failsWith('submission_disabled', fn () => $this->client->createOrder(12));
        Http::assertNothingSent();
    }

    public function test_catalog_only_returns_reviewed_products_and_customer_fields(): void
    {
        $product = $this->product();
        $product['supplier_cost'] = 5;
        $product['api_key'] = 'must-not-leak';
        Http::fake([
            'https://rankfree.kr/api/v1/products' => Http::response(['products' => [$product, array_merge($product, ['id' => 99])]]),
            'https://rankfree.kr/api/v1/products/12' => Http::response(['product' => $product]),
        ]);
        $list = $this->client->products();
        $this->assertCount(1, $list);
        $this->assertArrayNotHasKey('fields', $list[0]);
        $this->assertArrayNotHasKey('api_key', $list[0]);
        $this->assertArrayNotHasKey('supplier_cost', $list[0]);
        $detail = $this->client->product(12);
        $this->assertSame(['place_url', 'daily_qty', 'tags'], array_column($detail['fields'], 'key'));
        $this->assertArrayNotHasKey('supplier_token', $detail['fields'][0]);
        Http::assertSent(fn (Request $request) => $request->hasHeader('Authorization', 'Bearer rk_unit_test_secret')
            && $request->hasHeader('Accept', 'application/json') && ! str_contains($request->url(), 'rk_'));
    }

    public function test_create_order_uses_server_quote_and_returns_pending_not_completed(): void
    {
        Http::fake([
            'https://rankfree.kr/api/v1/products/12' => Http::response(['product' => $this->product()]),
            'https://rankfree.kr/api/v1/orders' => Http::response(['order' => $this->order()], 201),
        ]);
        $order = $this->client->createOrder(12, ['place_url' => 'https://m.place.naver.com/place/123', 'daily_qty' => '10', 'tags' => ['서울', '마케팅']], 10, 7, 3);
        $this->assertSame('pending', $order['status']);
        $this->assertSame('접수', $order['status_label']);
        $this->assertSame(123, $order['total_price']);
        $this->assertArrayNotHasKey('supplier_secret', $order);
        $this->assertSame(['place_url' => 'https://m.place.naver.com/place/123'], $order['fields']);
        Http::assertSentCount(2);
        Http::assertSent(fn (Request $request) => $request->method() === 'POST'
            && array_keys($request->data()) === ['product_id', 'fields', 'quantity', 'days', 'user_coupon_id']
            && $request['quantity'] === 10 && $request['days'] === 7 && $request['user_coupon_id'] === 3);
    }

    public function test_unreviewed_product_path_injection_and_invalid_values_send_nothing(): void
    {
        $this->failsWith('product_not_approved', fn () => $this->client->createOrder(99));
        $this->failsWith('invalid_input', fn () => $this->client->order('../products?token=bad'));
        $this->failsWith('invalid_input', fn () => $this->client->createOrder(12, ['supplier_secret' => 'bad']));
        $this->failsWith('invalid_input', fn () => $this->client->createOrder(12, ['tags' => [['nested' => 'bad']]]));
        $this->failsWith('invalid_input', fn () => $this->client->createOrder(12, quantity: 0));
        Http::assertNothingSent();
    }

    public function test_non_orderable_and_file_fields_never_reach_order_post(): void
    {
        $product = $this->product();
        $product['orderable'] = false;
        $sequence = Http::sequence()->push(['product' => $product]);
        $product['orderable'] = true;
        $sequence->push(['product' => $product]);
        Http::fake(['https://rankfree.kr/api/v1/products/12' => $sequence]);
        $this->failsWith('not_orderable', fn () => $this->client->createOrder(12));
        $this->failsWith('invalid_input', fn () => $this->client->createOrder(12, ['attachment' => 'file.png']));
        Http::assertNotSent(fn (Request $request) => $request->method() === 'POST');
    }

    public function test_empty_fields_are_a_json_object_and_optional_numbers_are_omitted(): void
    {
        Http::fake([
            'https://rankfree.kr/api/v1/products/12' => Http::response(['product' => $this->product()]),
            'https://rankfree.kr/api/v1/orders' => Http::response(['order' => $this->order()], 201),
        ]);
        $this->client->createOrder(12);
        Http::assertSent(function (Request $request) {
            if ($request->method() !== 'POST') {
                return false;
            }
            $data = json_decode($request->body());

            return is_object($data->fields) && ! isset($data->quantity, $data->days, $data->user_coupon_id);
        });
    }

    public function test_validation_errors_are_sanitized_and_not_retried(): void
    {
        Http::fake([
            'https://rankfree.kr/api/v1/products/12' => Http::response(['product' => $this->product()]),
            'https://rankfree.kr/api/v1/orders' => Http::response(['message' => 'rk_unit_test_secret customer private data', 'field' => 'f_place_url'], 422),
        ]);
        $exception = $this->failsWith('rejected', fn () => $this->client->createOrder(12));
        $this->assertSame(422, $exception->httpStatus);
        $this->assertSame('f_place_url', $exception->field);
        $this->assertStringNotContainsString('rk_unit_test_secret', $exception->getMessage());
        $this->assertNull($exception->getPrevious());
        Http::assertSentCount(2);
    }

    public function test_post_transport_failure_is_uncertain_and_is_never_retried(): void
    {
        Http::fake([
            'https://rankfree.kr/api/v1/products/12' => Http::response(['product' => $this->product()]),
            'https://rankfree.kr/api/v1/orders' => Http::failedConnection('rk_unit_test_secret'),
        ]);
        $exception = $this->failsWith('submission_uncertain', fn () => $this->client->createOrder(12));
        $this->assertNull($exception->getPrevious());
        $this->assertStringNotContainsString('rk_unit_test_secret', $exception->getMessage());
        Http::assertSentCount(2);
    }

    public function test_post_redirect_server_error_and_malformed_success_are_uncertain(): void
    {
        $responses = [
            Http::response('', 302, ['Location' => 'https://other.example/steal']),
            Http::response(['message' => 'private'], 500),
            Http::response('<html>wrong body</html>', 201),
            Http::response(['order' => ['status' => []]], 201),
            Http::response(['order' => $this->order('MO-OTHER')], 200),
        ];
        $sequence = Http::sequence();
        foreach ($responses as $response) {
            $sequence->pushResponse($response);
        }
        Http::fake([
            'https://rankfree.kr/api/v1/products/12' => Http::response(['product' => $this->product()]),
            'https://rankfree.kr/api/v1/orders' => $sequence,
        ]);
        foreach ($responses as $response) {
            $this->failsWith('submission_uncertain', fn () => $this->client->createOrder(12));
        }
        Http::assertNotSent(fn (Request $request) => str_contains($request->url(), 'other.example'));
        Http::assertSentCount(10);
    }

    public function test_order_status_keeps_server_ownership_boundary_and_filters_internal_data(): void
    {
        $order = $this->order();
        $order['status'] = 'completed';
        Http::fake(['https://rankfree.kr/api/v1/orders/MO-TEST1' => Http::response(['order' => $order])]);
        $result = $this->client->order('MO-TEST1');
        $this->assertSame('completed', $result['status']);
        $this->assertSame('완료', $result['status_label']);
        $this->assertArrayNotHasKey('internal', $result['product']);
        $this->assertArrayNotHasKey('supplier_secret', $result['fields']);
        Http::assertSentCount(1);
    }

    public function test_read_redirect_and_malformed_json_do_not_leak_or_follow_remote(): void
    {
        Http::fake(['https://rankfree.kr/api/v1/products' => Http::sequence()
            ->push('', 301, ['Location' => 'https://other.example/steal'])->push('not-json')]);
        $this->failsWith('rejected', fn () => $this->client->products());
        $this->failsWith('invalid_response', fn () => $this->client->products());
        Http::assertSentCount(2);
    }

    public function test_nested_product_metadata_is_rejected_instead_of_returning_internal_values(): void
    {
        $sequence = Http::sequence();
        $fields = ['type', 'type_name', 'quantity_mode', 'min_quantity', 'max_quantity', 'min_days', 'fixed_quantity', 'fixed_days', 'earliest_start_date'];
        foreach ($fields as $field) {
            $product = $this->product();
            $product[$field] = ['supplier_secret' => 'rk_unit_test_secret'];
            $sequence->push(['product' => $product]);
        }
        Http::fake(['https://rankfree.kr/api/v1/products/12' => $sequence]);
        foreach ($fields as $field) {
            $this->failsWith('invalid_response', fn () => $this->client->product(12));
        }
    }

    public function test_malformed_customer_field_metadata_cannot_be_returned_or_posted(): void
    {
        $sequence = Http::sequence();
        $mutations = [
            ['label', ['supplier_secret' => 'private']], ['type', ['URL']], ['type', null], ['type', 4], ['type', 'UNKNOWN'],
            ['required', ['secret' => true]], ['help', ['secret' => 'private']], ['contains', ['secret' => 'private']],
            ['options', [['value' => ['secret' => 'private'], 'label' => '값']]],
        ];
        foreach ($mutations as [$field, $value]) {
            $product = $this->product();
            $product['fields'][0][$field] = $value;
            $sequence->push(['product' => $product]);
        }
        Http::fake(['https://rankfree.kr/api/v1/products/12' => $sequence]);
        foreach ($mutations as $mutation) {
            $this->failsWith('invalid_response', fn () => $this->client->createOrder(12));
        }
        Http::assertNotSent(fn (Request $request) => $request->method() === 'POST');
    }

    public function test_missing_or_invalid_order_product_is_a_safe_error_and_explicit_null_is_supported(): void
    {
        $sequence = Http::sequence();
        $products = [[], ['id' => 12], ['id' => 0, 'title' => 'bad'], ['id' => '12', 'title' => 'bad']];
        foreach ($products as $product) {
            $order = $this->order();
            $order['product'] = $product;
            $sequence->push(['order' => $order], 201);
        }
        Http::fake([
            'https://rankfree.kr/api/v1/products/12' => Http::response(['product' => $this->product()]),
            'https://rankfree.kr/api/v1/orders' => $sequence,
        ]);
        foreach ($products as $product) {
            $this->failsWith('submission_uncertain', fn () => $this->client->createOrder(12));
        }
        $read = Http::sequence();
        foreach ($products as $product) {
            $order = $this->order();
            $order['product'] = $product;
            $read->push(['order' => $order]);
        }
        $deleted = $this->order();
        $deleted['product'] = ['id' => null, 'title' => null];
        $read->push(['order' => $deleted]);
        Http::fake(['https://rankfree.kr/api/v1/orders/MO-TEST1' => $read]);
        foreach ($products as $product) {
            $this->failsWith('invalid_response', fn () => $this->client->order('MO-TEST1'));
        }
        $this->assertSame(['id' => null, 'title' => null], $this->client->order('MO-TEST1')['product']);
    }

    private function failsWith(string $reason, callable $action): RankfreeException
    {
        try {
            $action();
            $this->fail('Expected a RankfreeException: '.$reason);
        } catch (RankfreeException $exception) {
            $this->assertSame($reason, $exception->reason);

            return $exception;
        }
    }

    private function product(): array
    {
        return [
            'id' => 12, 'title' => '테스트 상품', 'unit_price' => 200, 'orderable' => true,
            'fields' => [
                ['key' => 'place_url', 'label' => 'URL', 'type' => 'URL', 'required' => true, 'api_supported' => true, 'supplier_token' => 'private'],
                ['key' => 'daily_qty', 'label' => '수량', 'type' => 'NUMBER', 'required' => true, 'api_supported' => true],
                ['key' => 'tags', 'label' => '태그', 'type' => 'TAGS', 'required' => false, 'api_supported' => true],
                ['key' => 'supplier_secret', 'label' => '내부', 'type' => 'TEXT', 'required' => true, 'api_supported' => true],
                ['key' => 'attachment', 'label' => '파일', 'type' => 'FILE', 'required' => false, 'api_supported' => false],
            ],
        ];
    }

    private function order(string $number = 'MO-TEST1'): array
    {
        return [
            'order_no' => $number, 'status' => 'pending', 'status_label' => 'upstream label',
            'product' => ['id' => 12, 'title' => '테스트 상품', 'internal' => 'private'],
            'quantity' => 10, 'days' => 7, 'unit_price' => 200, 'discount_amount' => 0, 'total_price' => 123,
            'fields' => ['place_url' => 'https://m.place.naver.com/place/123', 'supplier_secret' => 'private'],
            'created_at' => '2026-10-27T14:00:00+09:00', 'supplier_secret' => 'private',
        ];
    }
}
