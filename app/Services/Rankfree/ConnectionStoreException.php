<?php

namespace App\Services\Rankfree;

use RuntimeException;

class ConnectionStoreException extends RuntimeException
{
    public function __construct(public readonly string $reason)
    {
        parent::__construct('랭크프리 계정 연결을 처리할 수 없습니다.');
    }
}
