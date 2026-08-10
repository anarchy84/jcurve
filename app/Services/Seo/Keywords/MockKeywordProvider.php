<?php

namespace App\Services\Seo\Keywords;

/**
 * 샘플 키워드 제공자 — 도메인 기반 결정론적 가짜 데이터(같은 도메인 → 같은 값).
 * 반드시 sample:true. 유료 API 키 확보 시 실어댑터로 교체.
 */
class MockKeywordProvider implements KeywordProvider
{
    private const SEEDS = [
        '마케팅 대행사', '퍼포먼스 마케팅', 'SEO 대행', '바이럴 마케팅', '검색광고 대행',
        '리워드 광고', 'CPA 마케팅', '콘텐츠 마케팅', '브랜드 마케팅', '온라인 마케팅',
        '구글 광고 대행', '인스타그램 마케팅', '유튜브 마케팅', '데이터 마케팅', '그로스 해킹',
    ];

    private const INTENTS = ['정보성', '상업성', '거래성', '탐색성'];

    public function fetch(string $domain): array
    {
        $domain = $this->normalize($domain);
        $seed = crc32('kw:'.$domain);
        mt_srand($seed);

        $total = 120 + ($seed % 3800);      // 120~3919
        $top10 = (int) max(3, round($total * (0.04 + ($seed % 8) / 100)));
        $top3 = (int) max(1, round($top10 * 0.35));

        $rows = [];
        $picked = [];
        $count = 10;
        for ($i = 0; $i < $count; $i++) {
            $kw = self::SEEDS[($seed + $i * 7) % count(self::SEEDS)];
            if (in_array($kw, $picked, true)) {
                $kw .= ' '.['추천', '비용', '순위', '후기', '가격'][mt_rand(0, 4)];
            }
            $picked[] = $kw;
            $pos = $i < 3 ? mt_rand(1, 3) : ($i < 6 ? mt_rand(4, 10) : mt_rand(11, 40));
            $rows[] = [
                'keyword' => $kw,
                'position' => $pos,
                'volume' => [10, 20, 50, 90, 170, 320, 590, 1000, 1900, 3600][mt_rand(0, 9)],
                'share' => 0.0, // 아래서 재계산
                'url' => '/'.['', 'services/', 'insights/', 'work/', 'solutions/'][mt_rand(0, 4)],
                'intent' => self::INTENTS[mt_rand(0, count(self::INTENTS) - 1)],
                'trend' => mt_rand(1, 10) > 3 ? 'up' : (mt_rand(0, 1) ? 'flat' : 'down'),
            ];
        }
        // 순위 오름차순(상위 노출 먼저)
        usort($rows, fn ($a, $b) => $a['position'] <=> $b['position']);
        // 트래픽 점유율(순위 가중치 기반) 근사 계산
        $ctr = fn ($p) => $p <= 1 ? 0.30 : ($p <= 3 ? 0.15 : ($p <= 10 ? 0.05 : 0.01));
        $weights = array_map(fn ($r) => $r['volume'] * $ctr($r['position']), $rows);
        $sum = array_sum($weights) ?: 1;
        foreach ($rows as $i => &$r) {
            $r['share'] = round($weights[$i] / $sum * 100, 1);
        }
        unset($r);

        mt_srand();

        return [
            'sample' => true,
            'domain' => $domain,
            'total_keywords' => (int) $total,
            'top3' => (int) $top3,
            'top10' => (int) $top10,
            'keywords' => $rows,
        ];
    }

    private function normalize(string $input): string
    {
        $host = parse_url(str_contains($input, '://') ? $input : "https://{$input}", PHP_URL_HOST) ?: $input;

        return preg_replace('/^www\./', '', strtolower(trim($host)));
    }
}
