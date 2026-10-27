<?php

namespace App\Services\Rankfree;

use RuntimeException;

class RankfreeException extends RuntimeException
{
    public function __construct(
        public readonly string $reason,
        public readonly ?int $httpStatus = null,
        public readonly ?string $field = null,
    ) {
        parent::__construct(match ($reason) {
            'disabled' => '랭크프리 API 연동이 비활성화되어 있습니다.',
            'not_configured' => '랭크프리 서버 설정을 확인해야 합니다.',
            'account_not_connected' => '고객의 랭크프리 계정 연결이 필요합니다.',
            'account_mismatch' => '고객의 계정 연결 정보가 일치하지 않습니다.',
            'submission_disabled' => '주문 전송이 비활성화되어 있습니다.',
            'product_not_approved' => '검수되지 않은 상품입니다.',
            'not_orderable' => 'API로 주문할 수 없는 상품입니다.',
            'invalid_input' => '주문 입력값을 확인해 주세요.',
            'rejected' => '랭크프리가 요청을 거절했습니다.',
            'submission_uncertain' => '주문 접수 여부 확인이 필요합니다. 같은 주문을 다시 전송하지 마세요.',
            'invalid_response' => '랭크프리 응답을 확인할 수 없습니다.',
            default => '랭크프리에 연결할 수 없습니다.',
        });
    }
}
