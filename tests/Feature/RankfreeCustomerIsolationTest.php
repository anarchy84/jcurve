<?php

namespace Tests\Feature;

use App\Services\Rankfree\CustomerCredential;
use App\Services\Rankfree\RankfreeClient;
use App\Services\Rankfree\RankfreeException;
use Error;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use LogicException;
use Tests\TestCase;

class RankfreeCustomerIsolationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'rankfree.enabled' => true, 'rankfree.submission_enabled' => true,
            'rankfree.api_key' => 'rk_legacy_global_key', 'rankfree.product_fields' => [12 => []],
        ]);
        Http::preventStrayRequests();
    }

    public function test_unlinked_or_wrong_customer_cannot_fall_back_to_global_key(): void
    {
        $this->reason('account_not_connected', fn () => RankfreeClient::forCustomer(1, null));
        $this->reason('account_not_connected', fn () => RankfreeClient::forCustomer(0, null));
        $this->reason('account_mismatch', fn () => RankfreeClient::forCustomer(2, new CustomerCredential(1, 'rk_customer_a')));
        Http::assertNothingSent();
    }

    public function test_alternating_customer_calls_keep_their_original_keys_without_shared_cache(): void
    {
        $seen = [];
        Http::fake(function (Request $request) use (&$seen) {
            $token = $request->header('Authorization')[0];
            $seen[] = $token;

            return Http::response(['products' => [$this->product($token === 'Bearer rk_customer_a' ? 'A' : 'B')]]);
        });
        $a = RankfreeClient::forCustomer(1, new CustomerCredential(1, 'rk_customer_a'));
        $b = RankfreeClient::forCustomer(2, new CustomerCredential(2, 'rk_customer_b'));
        $this->assertSame(1, $a->customerId());
        $this->assertSame(2, $b->customerId());
        $this->assertSame('A', $a->products()[0]['title']);
        $this->assertSame('B', $b->products()[0]['title']);
        config(['rankfree.api_key' => 'rk_replaced_global_key']);
        $this->assertSame('A', $a->products()[0]['title']);
        $this->assertSame(['Bearer rk_customer_a', 'Bearer rk_customer_b', 'Bearer rk_customer_a'], $seen);
        Http::assertSentCount(3);
    }

    public function test_preflight_order_and_status_all_use_the_same_customer_and_other_account_order_is_rejected(): void
    {
        $seen = [];
        Http::fake(function (Request $request) use (&$seen) {
            $token = $request->header('Authorization')[0];
            $seen[] = $token;
            $owner = $token === 'Bearer rk_customer_a' ? 'A' : 'B';
            if (str_contains($request->url(), '/products/12')) {
                return Http::response(['product' => $this->product($owner)]);
            }
            if ($request->method() === 'POST') {
                return Http::response(['order' => $this->order($owner)], 201);
            }
            if (! str_ends_with($request->url(), '/MO-'.$owner)) {
                return Http::response(['message' => 'private provider text'], 404);
            }

            return Http::response(['order' => $this->order($owner)]);
        });
        $a = RankfreeClient::forCustomer(1, new CustomerCredential(1, 'rk_customer_a'));
        $b = RankfreeClient::forCustomer(2, new CustomerCredential(2, 'rk_customer_b'));
        $this->assertSame('MO-A', $a->createOrder(12)['order_no']);
        $this->assertSame('MO-B', $b->createOrder(12)['order_no']);
        $this->assertSame('MO-A', $a->order('MO-A')['order_no']);
        $error = $this->reason('rejected', fn () => $a->order('MO-B'));
        $this->assertSame(404, $error->httpStatus);
        $this->assertStringNotContainsString('private provider text', $error->getMessage());
        $this->assertSame(array_merge(array_fill(0, 2, 'Bearer rk_customer_a'), array_fill(0, 2, 'Bearer rk_customer_b'), array_fill(0, 2, 'Bearer rk_customer_a')), $seen);
        Http::assertSentCount(6);
    }

    public function test_credential_and_client_debug_json_and_export_never_include_the_key(): void
    {
        $credential = new CustomerCredential(41, 'rk_customer_secret_marker');
        $client = RankfreeClient::forCustomer(41, $credential);
        $this->assertSame(['customer_id' => 41], json_decode(json_encode($credential), true));
        foreach ([$credential, $client] as $value) {
            ob_start();
            var_dump($value);
            $dump = ob_get_clean();
            foreach ([$dump, print_r($value, true), var_export($value, true), json_encode($value)] as $rendered) {
                $this->assertStringNotContainsString('rk_customer_secret_marker', $rendered);
            }
        }
        Http::assertNothingSent();
    }

    public function test_credentials_cannot_be_persisted_via_serialization_or_change_customer(): void
    {
        $credential = new CustomerCredential(41, 'rk_customer_secret_marker');
        foreach ([$credential, RankfreeClient::forCustomer(41, $credential)] as $value) {
            try {
                serialize($value);
                $this->fail('Credentials must not be serialized.');
            } catch (LogicException $exception) {
                $this->assertStringNotContainsString('rk_customer_secret_marker', $exception->getMessage());
            }
        }
        $class = CustomerCredential::class;
        try {
            unserialize('O:'.strlen($class).':"'.$class.'":0:{}');
            $this->fail('Credentials must not be restored from serialized data.');
        } catch (LogicException $exception) {
            $this->assertStringContainsString('must not be restored', $exception->getMessage());
        }
        try {
            $credential->customerId = 42;
            $this->fail('Customer identity must be immutable.');
        } catch (Error $exception) {
            $this->assertSame(41, $credential->customerId);
        }
        Http::assertNothingSent();
    }

    public function test_invalid_credential_errors_hide_constructor_arguments(): void
    {
        $previous = ini_set('zend.exception_ignore_args', '0');
        try {
            $exception = $this->reason('not_configured', fn () => new CustomerCredential(1, "rk_secret_marker\r\ninjected"));
            $this->assertStringNotContainsString('rk_secret_marker', $exception->getMessage().$exception->getTraceAsString());
            $this->reason('invalid_input', fn () => new CustomerCredential(0, 'rk_secret_marker'));
        } finally {
            ini_set('zend.exception_ignore_args', $previous);
        }
        Http::assertNothingSent();
    }

    private function reason(string $reason, callable $action): RankfreeException
    {
        try {
            $action();
            $this->fail('Expected '.$reason);
        } catch (RankfreeException $exception) {
            $this->assertSame($reason, $exception->reason);

            return $exception;
        }
    }

    private function product(string $title): array
    {
        return ['id' => 12, 'title' => $title, 'unit_price' => 200, 'orderable' => true, 'fields' => []];
    }

    private function order(string $owner): array
    {
        return [
            'order_no' => 'MO-'.$owner, 'status' => 'pending', 'product' => ['id' => 12, 'title' => $owner],
            'quantity' => 1, 'days' => null, 'unit_price' => 200, 'discount_amount' => 0, 'total_price' => 200,
            'fields' => [], 'created_at' => '2026-10-27T14:00:00+09:00',
        ];
    }
}
