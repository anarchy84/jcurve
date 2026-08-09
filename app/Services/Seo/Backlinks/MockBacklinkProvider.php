<?php

namespace App\Services\Seo\Backlinks;

/**
 * 샘플 백링크 제공자 — 실제 백링크 인덱스가 없으므로 도메인 기반으로
 * "그럴듯하지만 가짜"인 데이터를 결정론적으로 생성한다(같은 도메인 → 같은 값).
 * 반드시 sample:true 로 표기하며, 화면/PDF에서 "샘플" 라벨을 붙여야 한다.
 * 유료 API 키 확보 시 AhrefsBacklinkProvider 등으로 교체.
 */
class MockBacklinkProvider implements BacklinkProvider
{
    /** 앵커 텍스트 후보(현실적인 한국형 앵커) */
    private const ANCHORS = [
        '자세히 보기', '홈페이지', '공식 사이트', '바로가기', '참고 자료',
        '마케팅 대행', '여기', 'read more', '원문 보기', '블로그',
    ];

    /** 그럴듯한 참조 도메인 후보 */
    private const REF_DOMAINS = [
        'blog.naver.com', 'brunch.co.kr', 'tistory.com', 'medium.com',
        'velog.io', 'news.example.co.kr', 'wordpress.com', 'notion.site',
        'daum.net', 'dcinside.com', 'clien.net', 'brandpress.co.kr',
    ];

    public function fetch(string $domain): array
    {
        $domain = $this->normalize($domain);
        // 도메인 문자열을 시드로 → 같은 도메인은 항상 같은 결과(결정론적)
        $seed = crc32($domain);
        mt_srand($seed);

        $dr = 25 + ($seed % 46);                 // 25~70
        $refDomains = 30 + ($seed % 420);         // 30~449
        $total = $refDomains * (2 + ($seed % 5)); // 참조도메인당 2~6 링크
        $dofollow = 0.6 + (($seed % 35) / 100);   // 0.60~0.94

        $top = [];
        $count = min(8, max(5, $refDomains > 100 ? 8 : 6));
        for ($i = 0; $i < $count; $i++) {
            $ref = self::REF_DOMAINS[mt_rand(0, count(self::REF_DOMAINS) - 1)];
            $sub = mt_rand(0, 1) ? '' : ['guide', 'review', 'best', 'top', 'news'][mt_rand(0, 4)].'-';
            $slug = ['post', 'article', 'entry', 'p'][mt_rand(0, 3)].'/'.mt_rand(100, 99999);
            $top[] = [
                'domain' => $ref,
                'url' => "https://{$ref}/{$sub}{$slug}",
                'dr' => 30 + mt_rand(0, 55),      // 30~85
                'anchor' => self::ANCHORS[mt_rand(0, count(self::ANCHORS) - 1)],
                'type' => mt_rand(1, 10) > 3 ? 'dofollow' : 'nofollow',
                'first_seen' => sprintf('%04d.%02d.%02d', 2024 + mt_rand(0, 1), mt_rand(1, 12), mt_rand(1, 28)),
            ];
        }
        // DR 내림차순 정렬(상위 백링크 느낌)
        usort($top, fn ($a, $b) => $b['dr'] <=> $a['dr']);

        mt_srand(); // 시드 해제(전역 랜덤 오염 방지)

        return [
            'sample' => true,
            'domain' => $domain,
            'domain_rating' => (int) $dr,
            'referring_domains' => (int) $refDomains,
            'total_backlinks' => (int) $total,
            'dofollow_ratio' => round($dofollow, 2),
            'top' => $top,
        ];
    }

    private function normalize(string $input): string
    {
        $host = parse_url(str_contains($input, '://') ? $input : "https://{$input}", PHP_URL_HOST) ?: $input;

        return preg_replace('/^www\./', '', strtolower(trim($host)));
    }
}
