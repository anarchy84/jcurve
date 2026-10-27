<?php

namespace App\Services\Rankfree;

use JsonSerializable;
use LogicException;
use SensitiveParameter;
use SensitiveParameterValue;

/** Ephemeral server credential, loaded by a trusted per-customer storage/authentication layer. */
final class CustomerCredential implements JsonSerializable
{
    private readonly SensitiveParameterValue $key;

    public function __construct(public readonly int $customerId, #[SensitiveParameter] string $apiKey)
    {
        if ($customerId < 1) {
            throw new RankfreeException('invalid_input');
        }
        if (! preg_match('/^rk_[A-Za-z0-9_-]+$/D', $apiKey)) {
            throw new RankfreeException('not_configured');
        }
        $this->key = new SensitiveParameterValue($apiKey);
    }

    /** Server transport only. Never return this value in a response or log it. */
    public function authorizationKey(): string
    {
        return $this->key->getValue();
    }

    public function jsonSerialize(): array
    {
        return ['customer_id' => $this->customerId];
    }

    public function __debugInfo(): array
    {
        return $this->jsonSerialize();
    }

    public function __serialize(): array
    {
        throw new LogicException('Customer credentials must not be serialized.');
    }

    public function __unserialize(array $data): void
    {
        throw new LogicException('Customer credentials must not be restored from serialized data.');
    }
}
