<?php

namespace App\Services\Seo\Traffic;

/**
 * 샘플 트래픽 제공자 — 도메인 기반 결정론적 가짜 데이터. 반드시 sample:true.
 * 유료 API/GSC 연동 시 실어댑터로 교체.
 */
class MockTrafficProvider implements TrafficProvider
{
    public function fetch(string $domain): array
    {
        $domain = $this->normalize($domain);
        $seed = crc32('tr:'.$domain);
        mt_srand($seed);

        $base = 1500 + ($seed % 48000);          // 월 방문 1.5k~49.5k
        $value = (int) round($base * (80 + ($seed % 220)));  // 방문당 80~300원 근사

        // 최근 6개월 추이(±20% 변동, 완만한 우상향 경향)
        $months = ['3월', '4월', '5월', '6월', '7월', '8월'];
        $trend = [];
        $v = (int) round($base * 0.75);
        foreach ($months as $m) {
            $v = (int) round($v * (0.95 + mt_rand(0, 25) / 100)); // 0.95~1.20배
            $trend[] = ['month' => $m, 'visits' => max(100, $v)];
        }
        // 마지막 달을 base에 맞춤(표기 일관성)
        $trend[count($trend) - 1]['visits'] = $base;

        // 채널 구성(합 100)
        $organic = 45 + ($seed % 25);            // 45~69
        $direct = 15 + ($seed % 15);
        $referral = 8 + ($seed % 10);
        $social = max(3, 100 - $organic - $direct - $referral);
        $channels = [
            ['name' => '오가닉 검색', 'pct' => $organic],
            ['name' => '직접 유입', 'pct' => $direct],
            ['name' => '레퍼럴', 'pct' => $referral],
            ['name' => '소셜', 'pct' => $social],
        ];

        $kr = 68 + ($seed % 22);                 // 국내 비중 68~89
        $countries = [
            ['name' => '대한민국', 'pct' => $kr],
            ['name' => '미국', 'pct' => (int) round((100 - $kr) * 0.5)],
            ['name' => '기타', 'pct' => max(1, 100 - $kr - (int) round((100 - $kr) * 0.5))],
        ];

        mt_srand();

        return [
            'sample' => true,
            'domain' => $domain,
            'monthly_visits' => (int) $base,
            'traffic_value_krw' => $value,
            'trend' => $trend,
            'channels' => $channels,
            'countries' => $countries,
        ];
    }

    private function normalize(string $input): string
    {
        $host = parse_url(str_contains($input, '://') ? $input : "https://{$input}", PHP_URL_HOST) ?: $input;

        return preg_replace('/^www\./', '', strtolower(trim($host)));
    }
}
