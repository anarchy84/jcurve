<?php

namespace Tests\Feature;

use App\Models\RankfreeConnection;
use App\Models\User;
use App\Services\Rankfree\ConnectionStore;
use Illuminate\Encryption\Encrypter;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Tests\TestCase;

class RankfreeConnectionApiTest extends TestCase
{
    use RefreshDatabase;

    private const URL = '/api/account/rankfree-connection';

    private const KEY = 'rk_customer_secret_marker';

    private User $customer;

    protected function setUp(): void
    {
        parent::setUp();
        config(['rankfree.connections_enabled' => true, 'rankfree.enabled' => false, 'rankfree.submission_enabled' => false]);
        Crypt::swap(new Encrypter(str_repeat('a', 32), 'AES-256-CBC'));
        Http::preventStrayRequests();
        $this->customer = User::factory()->create(['password' => 'local-test-password']);
    }

    protected function tearDown(): void
    {
        Http::assertNothingSent();
        parent::tearDown();
    }

    public function test_guest_receives_private_json_even_when_accepting_html(): void
    {
        $this->get(self::URL, ['Accept' => 'text/html'])->assertUnauthorized()
            ->assertJsonPath('error.code', 'unauthenticated')->assertHeader('Content-Type', 'application/json')
            ->assertHeader('Cache-Control', 'no-store, private')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->putJson(self::URL, $this->payload())->assertUnauthorized();
        $this->deleteJson(self::URL, ['current_password' => 'local-test-password'])->assertUnauthorized();
        $this->assertDatabaseCount('rankfree_connections', 0);
    }

    public function test_registration_stores_authenticated_ciphertext_without_returning_key_material(): void
    {
        $this->actingAs($this->customer)->getJson(self::URL)->assertExactJson(['data' => [
            'registered' => false, 'provider_verified' => false, 'revision' => null, 'registered_at' => null, 'updated_at' => null,
        ]]);
        $response = $this->putJson(self::URL, $this->payload())->assertOk()
            ->assertJsonPath('data.registered', true)->assertJsonPath('data.provider_verified', false)
            ->assertHeader('Cache-Control', 'no-store, private');
        $raw = DB::table('rankfree_connections')->where('user_id', $this->customer->id)->first();
        $this->assertNotSame(self::KEY, $raw->credential_ciphertext);
        $this->assertSame(self::KEY, Crypt::decryptString($raw->credential_ciphertext));
        $this->assertStringNotContainsString(self::KEY, $response->getContent());
        $this->assertStringNotContainsString($raw->credential_ciphertext, $response->getContent());
        $this->assertArrayNotHasKey('credential_ciphertext', RankfreeConnection::query()->first()->toArray());
        $this->assertSame(['registered', 'provider_verified', 'revision', 'registered_at', 'updated_at'], array_keys($response->json('data')));
    }

    public function test_replacement_preserves_one_row_and_changes_revision_and_resolved_key(): void
    {
        $first = $this->actingAs($this->customer)->putJson(self::URL, $this->payload())->assertOk()->json('data');
        $this->travel(2)->seconds();
        $second = $this->putJson(self::URL, $this->payload('rk_replacement_secret'))->assertOk()->json('data');
        $this->assertNotSame($first['revision'], $second['revision']);
        $this->assertSame($first['registered_at'], $second['registered_at']);
        $this->assertNotSame($first['updated_at'], $second['updated_at']);
        $this->assertDatabaseCount('rankfree_connections', 1);
        $this->assertSame('rk_replacement_secret', app(ConnectionStore::class)->credentialFor($this->customer)->authorizationKey());
    }

    public function test_other_customer_cannot_view_replace_or_disconnect_a_connection_by_id_injection(): void
    {
        $this->actingAs($this->customer)->putJson(self::URL, $this->payload())->assertOk();
        $other = User::factory()->create(['password' => 'local-test-password']);
        $this->actingAs($other)->getJson(self::URL)->assertJsonPath('data.registered', false);
        $this->putJson(self::URL, $this->payload() + ['user_id' => $this->customer->id])->assertUnprocessable();
        $this->deleteJson(self::URL, ['current_password' => 'local-test-password', 'user_id' => $this->customer->id])->assertUnprocessable();
        $this->getJson(self::URL.'/'.$this->customer->id)->assertNotFound()->assertJsonPath('error.code', 'not_found');
        $this->assertSame(self::KEY, app(ConnectionStore::class)->credentialFor($this->customer)->authorizationKey());
        $this->assertDatabaseCount('rankfree_connections', 1);
    }

    public function test_current_password_is_required_for_registration_and_disconnect(): void
    {
        $this->actingAs($this->customer)->putJson(self::URL, ['api_key' => self::KEY])->assertUnprocessable()
            ->assertJsonPath('error.fields.current_password.0', '현재 비밀번호를 확인해 주세요.');
        $this->putJson(self::URL, ['api_key' => self::KEY, 'current_password' => 'wrong'])->assertUnprocessable();
        $this->putJson(self::URL, $this->payload())->assertOk();
        $this->deleteJson(self::URL, ['current_password' => 'wrong'])->assertUnprocessable();
        $this->assertDatabaseCount('rankfree_connections', 1);
    }

    public function test_disconnect_is_idempotent_and_reregistration_uses_a_new_revision(): void
    {
        $first = $this->actingAs($this->customer)->putJson(self::URL, $this->payload())->assertOk()->json('data.revision');
        $this->deleteJson(self::URL, ['current_password' => 'local-test-password'])->assertNoContent()->assertHeader('Cache-Control', 'no-store, private');
        $this->getJson(self::URL)->assertJsonPath('data.registered', false);
        $this->deleteJson(self::URL, ['current_password' => 'local-test-password'])->assertNoContent();
        $this->assertDatabaseCount('rankfree_connections', 0);
        $next = $this->putJson(self::URL, $this->payload())->assertOk()->json('data.revision');
        $this->assertNotSame($first, $next);
    }

    public function test_invalid_types_key_length_unknown_fields_and_query_values_do_not_mutate_or_flash(): void
    {
        $this->actingAs($this->customer);
        foreach ([['api_key' => ['nested' => self::KEY]], ['api_key' => 'bad-secret'], ['api_key' => 'rk_'.str_repeat('s', 513)]] as $invalid) {
            $response = $this->putJson(self::URL, $invalid + ['current_password' => 'local-test-password'])->assertUnprocessable();
            $this->assertStringNotContainsString('bad-secret', $response->getContent());
            $this->assertStringNotContainsString(self::KEY, $response->getContent());
        }
        $this->getJson(self::URL.'?user_id=999')->assertUnprocessable();
        $this->putJson(self::URL.'?user_id=999', $this->payload())->assertUnprocessable();
        $this->assertDatabaseCount('rankfree_connections', 0);
        $this->assertEmpty(session()->getOldInput());
    }

    public function test_only_json_objects_with_a_small_body_are_accepted(): void
    {
        $this->actingAs($this->customer)->put(self::URL, $this->payload())->assertStatus(415)->assertJsonPath('error.code', 'json_required');
        $this->call('PUT', self::URL, [], [], [], ['CONTENT_TYPE' => 'application/json'], '{bad')->assertStatus(400);
        $this->putJson(self::URL, [self::KEY])->assertStatus(400);
        $this->call('PUT', self::URL, [], [], [], ['CONTENT_TYPE' => 'application/json'], str_repeat('x', 8193))->assertStatus(413);
        $this->assertDatabaseCount('rankfree_connections', 0);
    }

    public function test_csrf_is_enforced_outside_the_framework_unit_test_bypass(): void
    {
        $this->app->bind(PreventRequestForgery::class, fn ($app) => new class($app, $app['encrypter']) extends PreventRequestForgery
        {
            protected function runningUnitTests()
            {
                return false;
            }
        });
        $this->actingAs($this->customer)->putJson(self::URL, $this->payload())->assertStatus(419)->assertJsonPath('error.code', 'csrf_mismatch');
        $token = 'local-csrf-token';
        $this->withSession(['_token' => $token])->putJson(self::URL, $this->payload(), ['X-CSRF-TOKEN' => $token])->assertOk();
        $this->withSession(['_token' => $token])->deleteJson(self::URL, ['current_password' => 'local-test-password'], ['X-CSRF-TOKEN' => $token])->assertNoContent();
    }

    public function test_feature_flag_is_closed_and_does_not_enable_order_flags(): void
    {
        config(['rankfree.connections_enabled' => false]);
        $this->actingAs($this->customer)->getJson(self::URL)->assertStatus(503)->assertJsonPath('error.code', 'connections_disabled');
        $this->putJson(self::URL, $this->payload())->assertStatus(503);
        $this->assertFalse(config('rankfree.enabled'));
        $this->assertFalse(config('rankfree.submission_enabled'));
        $this->assertDatabaseCount('rankfree_connections', 0);
    }

    public function test_write_rate_limit_is_per_customer_and_shared_by_put_and_delete(): void
    {
        $this->actingAs($this->customer);
        for ($i = 0; $i < 5; $i++) {
            $this->putJson(self::URL, ['api_key' => self::KEY, 'current_password' => 'wrong'])->assertUnprocessable();
        }
        $this->deleteJson(self::URL, ['current_password' => 'local-test-password'])->assertStatus(429)
            ->assertJsonPath('error.code', 'rate_limited')->assertHeader('Retry-After');
        $other = User::factory()->create(['password' => 'local-test-password']);
        $this->actingAs($other)->putJson(self::URL, $this->payload())->assertOk();
        $this->assertDatabaseCount('rankfree_connections', 1);
    }

    public function test_debug_error_is_redacted_in_json_and_default_exception_log(): void
    {
        config(['app.debug' => true]);
        Log::spy();
        $this->app->instance(ConnectionStore::class, new class extends ConnectionStore
        {
            public function statusFor(User $user): array
            {
                throw new RuntimeException('rk_customer_secret_marker exception private payload');
            }
        });
        $response = $this->actingAs($this->customer)->get(self::URL, ['Accept' => 'text/html'])->assertStatus(500)
            ->assertExactJson(['error' => ['code' => 'internal_error', 'message' => '계정 연결을 처리할 수 없습니다.']]);
        $this->assertStringNotContainsString(self::KEY, $response->getContent());
        Log::shouldHaveReceived('warning')->with('rankfree_connection_request_failed', ['exception_type' => RuntimeException::class])->once();
        Log::shouldNotHaveReceived('error');
        $this->assertEmpty(session()->getOldInput());
    }

    public function test_deleted_user_with_a_stale_auth_instance_cannot_read_or_register(): void
    {
        $this->customer->delete();
        $this->actingAs($this->customer)->getJson(self::URL)->assertUnauthorized();
        $this->putJson(self::URL, $this->payload())->assertUnauthorized();
        $this->assertDatabaseCount('rankfree_connections', 0);
    }

    private function payload(string $key = self::KEY): array
    {
        return ['api_key' => $key, 'current_password' => 'local-test-password'];
    }
}
