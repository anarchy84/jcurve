<?php

namespace App\Services\Rankfree;

use App\Models\RankfreeConnection;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SensitiveParameter;
use Throwable;

class ConnectionStore
{
    public function statusFor(User $user): array
    {
        $this->active($user);

        return $this->metadata(RankfreeConnection::query()->where('user_id', $user->getKey())->first());
    }

    public function registerFor(User $user, #[SensitiveParameter] string $apiKey): array
    {
        if (strlen($apiKey) > 512) {
            throw new RankfreeException('invalid_input');
        }
        $credential = new CustomerCredential((int) $user->getKey(), $apiKey);

        return DB::transaction(function () use ($user, $credential) {
            $this->active($user, true);
            try {
                $ciphertext = Crypt::encryptString($credential->authorizationKey());
            } catch (Throwable) {
                throw new ConnectionStoreException('encryption_unavailable');
            }
            $connection = RankfreeConnection::query()->where('user_id', $user->getKey())->first() ?? new RankfreeConnection;
            $connection->forceFill([
                'user_id' => $user->getKey(), 'credential_ciphertext' => $ciphertext, 'revision' => (string) Str::uuid(),
            ])->save();

            return $this->metadata($connection);
        });
    }

    public function disconnectFor(User $user): void
    {
        DB::transaction(function () use ($user) {
            $this->active($user, true);
            RankfreeConnection::query()->where('user_id', $user->getKey())->delete();
        });
    }

    public function credentialFor(User $user): CustomerCredential
    {
        $this->active($user);
        $connection = RankfreeConnection::query()->where('user_id', $user->getKey())->first();
        if ($connection === null) {
            throw new RankfreeException('account_not_connected');
        }
        try {
            $key = Crypt::decryptString($connection->getRawOriginal('credential_ciphertext'));

            return new CustomerCredential((int) $user->getKey(), $key);
        } catch (Throwable) {
            throw new ConnectionStoreException('credential_unreadable');
        }
    }

    public function clientFor(User $user): RankfreeClient
    {
        return RankfreeClient::forCustomer((int) $user->getKey(), $this->credentialFor($user));
    }

    private function active(User $user, bool $lock = false): void
    {
        $query = User::query()->whereKey($user->getKey());
        if ($lock) {
            $query->lockForUpdate();
        }
        if ($query->first() === null) {
            throw new AuthenticationException;
        }
    }

    private function metadata(?RankfreeConnection $connection): array
    {
        return [
            'registered' => $connection !== null, 'provider_verified' => false,
            'revision' => $connection?->revision,
            'registered_at' => $connection?->created_at?->toISOString(),
            'updated_at' => $connection?->updated_at?->toISOString(),
        ];
    }
}
