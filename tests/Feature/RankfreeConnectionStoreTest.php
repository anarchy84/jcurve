<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Rankfree\ConnectionStore;
use App\Services\Rankfree\ConnectionStoreException;
use App\Services\Rankfree\RankfreeException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Encryption\Encrypter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class RankfreeConnectionStoreTest extends TestCase
{
    use RefreshDatabase;

    private ConnectionStore $store;

    private Encrypter $crypto;

    protected function setUp(): void
    {
        parent::setUp();
        $this->crypto = new Encrypter(str_repeat('a', 32), 'AES-256-CBC');
        Crypt::swap($this->crypto);
        config(['rankfree.connections_enabled' => true, 'rankfree.enabled' => true, 'rankfree.product_fields' => [12 => []]]);
        Http::preventStrayRequests();
        $this->store = app(ConnectionStore::class);
    }

    public function test_resolver_reads_each_customer_from_storage_and_disconnect_cannot_be_resolved_again(): void
    {
        $a = User::factory()->create();
        $b = User::factory()->create();
        $this->store->registerFor($a, 'rk_customer_a');
        $this->store->registerFor($b, 'rk_customer_b');
        Http::fake(fn (Request $request) => Http::response(['products' => [[
            'id' => 12, 'title' => $request->header('Authorization')[0], 'unit_price' => 1, 'orderable' => true,
        ]]]));
        $this->assertSame('Bearer rk_customer_a', $this->store->clientFor($a)->products()[0]['title']);
        $this->assertSame('Bearer rk_customer_b', $this->store->clientFor($b)->products()[0]['title']);
        $this->store->disconnectFor($a);
        try {
            $this->store->clientFor($a);
            $this->fail('Disconnected credentials must not be cached.');
        } catch (RankfreeException $exception) {
            $this->assertSame('account_not_connected', $exception->reason);
        }
        $this->assertSame('rk_customer_b', $this->store->credentialFor($b)->authorizationKey());
        $this->store->registerFor($a, 'rk_customer_a_rotated');
        $this->assertSame('rk_customer_a_rotated', $this->store->credentialFor($a)->authorizationKey());
        Http::assertSentCount(2);
    }

    public function test_ciphertext_tampering_fails_closed_without_chain_or_network(): void
    {
        $user = User::factory()->create();
        $this->store->registerFor($user, 'rk_customer_marker');
        DB::table('rankfree_connections')->where('user_id', $user->id)->update(['credential_ciphertext' => 'broken ciphertext']);
        try {
            $this->store->credentialFor($user);
            $this->fail('Tampered credentials must fail closed.');
        } catch (ConnectionStoreException $exception) {
            $this->assertSame('credential_unreadable', $exception->reason);
            $this->assertNull($exception->getPrevious());
            $this->assertStringNotContainsString('rk_customer_marker', $exception->getMessage());
        }
        $this->store->disconnectFor($user);
        $this->assertDatabaseCount('rankfree_connections', 0);
        Http::assertNothingSent();
    }

    public function test_replacement_failure_keeps_the_existing_ciphertext_and_revision(): void
    {
        $user = User::factory()->create();
        $this->store->registerFor($user, 'rk_existing_secret');
        $before = DB::table('rankfree_connections')->where('user_id', $user->id)->first();
        Crypt::swap(new class(str_repeat('a', 32), 'AES-256-CBC') extends Encrypter
        {
            public function encryptString($value)
            {
                throw new RuntimeException('rk_replacement_secret should not leak');
            }
        });
        try {
            $this->store->registerFor($user, 'rk_replacement_secret');
            $this->fail('Encryption failure must abort replacement.');
        } catch (ConnectionStoreException $exception) {
            $this->assertSame('encryption_unavailable', $exception->reason);
            $this->assertNull($exception->getPrevious());
        }
        $after = DB::table('rankfree_connections')->where('user_id', $user->id)->first();
        $this->assertSame($before->revision, $after->revision);
        $this->assertSame($before->credential_ciphertext, $after->credential_ciphertext);
        $this->assertSame('rk_existing_secret', $this->crypto->decryptString($after->credential_ciphertext));
    }

    public function test_soft_delete_purges_only_its_credentials_and_restore_does_not_restore_a_key(): void
    {
        $a = User::factory()->create();
        $b = User::factory()->create();
        $this->store->registerFor($a, 'rk_customer_a');
        $this->store->registerFor($b, 'rk_customer_b');
        $a->delete();
        $this->assertDatabaseMissing('rankfree_connections', ['user_id' => $a->id]);
        $this->assertDatabaseHas('rankfree_connections', ['user_id' => $b->id]);
        try {
            $this->store->registerFor($a, 'rk_stale_customer');
            $this->fail('Deleted users must not register.');
        } catch (AuthenticationException $exception) {
            $this->assertDatabaseMissing('rankfree_connections', ['user_id' => $a->id]);
        }
        $a->restore();
        $this->assertFalse($this->store->statusFor($a)['registered']);
    }

    public function test_force_delete_cascades_and_repeated_equal_keys_use_randomized_ciphertexts(): void
    {
        $user = User::factory()->create();
        $this->store->registerFor($user, 'rk_customer_marker');
        $first = DB::table('rankfree_connections')->where('user_id', $user->id)->value('credential_ciphertext');
        $this->store->registerFor($user, 'rk_customer_marker');
        $second = DB::table('rankfree_connections')->where('user_id', $user->id)->value('credential_ciphertext');
        $this->assertNotSame($first, $second);
        $this->assertSame('rk_customer_marker', $this->crypto->decryptString($second));
        $this->assertDatabaseCount('rankfree_connections', 1);
        $user->forceDelete();
        $this->assertDatabaseCount('rankfree_connections', 0);
    }
}
