<?php

namespace Database\Seeders;

use App\Models\Work;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * 성과 사례(레퍼런스) 데모 시더.
 *
 * ⚠️ 여기 담긴 사례·수치·고객명은 전부 "익명 업종 기반 예시"이며 실제 성과가 아니다.
 *    디자인 확인·레이아웃 채움용 플레이스홀더이므로, 실데이터 확정 후 반드시 교체한다.
 *    (실제 회사명을 붙인 가짜 성과는 넣지 않는다 — 사이트의 공개 원칙과 충돌하므로.)
 */
class WorkSeeder extends Seeder
{
    public function run(): void
    {
        $cases = [
            [
                'title' => '재구매까지 설계한 뷰티 D2C 풀퍼널 운영',
                'slug' => 'beauty-d2c-fullfunnel',
                'client' => '뷰티 D2C 브랜드',
                'industry' => '화장품·이커머스',
                'summary' => '신규 유입만 늘리는 구조에서 벗어나, 첫 구매 이후 재구매·객단가까지 함께 관리하는 퍼널로 재편했습니다.',
                'metrics' => [
                    ['value' => 'ROAS 412%', 'label' => '집행 3개월 · 전분기 대비'],
                    ['value' => '재구매율 +26%', 'label' => '90일 기준'],
                ],
                'cover_image' => 'media/works/beauty.webp',
                'days' => 14,
            ],
            [
                'title' => '할인 의존을 줄인 패션 커머스 전환 구조 개선',
                'slug' => 'fashion-commerce-cvr',
                'client' => '패션 커머스',
                'industry' => '패션·이커머스',
                'summary' => '상시 할인에 기대던 매출 구조를 상세페이지·장바구니 이탈 지점 개선으로 바꿔 정가 판매 비중을 끌어올렸습니다.',
                'metrics' => [
                    ['value' => '구매전환 +38%', 'label' => 'A/B 8주 · 대조군 대비'],
                    ['value' => '객단가 +12%', 'label' => '동기간'],
                ],
                'cover_image' => 'media/works/fashion.webp',
                'days' => 28,
            ],
            [
                'title' => '주문 급증기를 버틴 F&B 프랜차이즈 배달 운영',
                'slug' => 'fnb-delivery-growth',
                'client' => 'F&B 프랜차이즈',
                'industry' => '외식·배달',
                'summary' => '지역·시간대별 수요 편차를 데이터로 읽고 매체 예산과 쿠폰을 재배분해, 피크 시간 주문을 안정적으로 늘렸습니다.',
                'metrics' => [
                    ['value' => '월 주문 2.7배', 'label' => '6개월 · 캠페인 전 대비'],
                    ['value' => '주문당비용 -33%', 'label' => '동기간'],
                ],
                'cover_image' => 'media/works/food.webp',
                'days' => 45,
            ],
            [
                'title' => '유효 상담으로 이어지는 보험 리드 운영',
                'slug' => 'insurance-lead-quality',
                'client' => '보험 GA',
                'industry' => '보험·리드',
                'summary' => 'DB 건수 경쟁 대신 유효 기준을 다시 정의하고, 상담 연결·다음 영업 단계 전환까지 함께 측정했습니다.',
                'metrics' => [
                    ['value' => '유효DB 단가 -41%', 'label' => '4개월 · 초기 대비'],
                    ['value' => '상담 연결률 +19%', 'label' => '동기간'],
                ],
                'cover_image' => 'media/works/insurance.webp',
                'days' => 62,
            ],
            [
                'title' => '설치에서 가입까지 잇는 핀테크 앱 그로스',
                'slug' => 'fintech-app-growth',
                'client' => '핀테크 앱',
                'industry' => '앱·핀테크',
                'summary' => '설치 지표에서 멈추지 않고 가입·본인인증·첫 거래까지 이어지는 활성화 구간을 기준으로 매체를 운용했습니다.',
                'metrics' => [
                    ['value' => '설치당비용 -35%', 'label' => '3개월 · 전분기 대비'],
                    ['value' => '가입 전환 +44%', 'label' => '동기간'],
                ],
                'cover_image' => 'media/works/app.webp',
                'days' => 80,
            ],
            [
                'title' => '검색 상단과 방문으로 이어진 로컬 비즈니스',
                'slug' => 'local-place-ranking',
                'client' => '로컬 요식업',
                'industry' => '로컬·플레이스',
                'summary' => '플레이스 순위 한 칸이 아니라 노출 검색어·저장·방문 예약까지 연결해, 실제 방문으로 이어지는 흐름을 만들었습니다.',
                'metrics' => [
                    ['value' => '주요 키워드 1위', 'label' => '핵심 상권 · 8주'],
                    ['value' => '방문 문의 2.1배', 'label' => '동기간'],
                ],
                'cover_image' => 'media/works/local.webp',
                'days' => 100,
            ],
        ];

        foreach ($cases as $c) {
            Work::updateOrCreate(
                ['slug' => $c['slug']],
                [
                    'title' => $c['title'],
                    'client' => $c['client'],
                    'industry' => $c['industry'],
                    'summary' => $c['summary'],
                    'metrics' => $c['metrics'],
                    'cover_image' => $c['cover_image'],
                    'content' => '<p>'.$c['summary'].'</p><p>본 사례는 레이아웃 확인용 예시 데이터입니다. 문제 정의 → 개선 범위 → 측정 기준 → 학습 순서로, 공개 동의와 근거가 확정된 실제 사례로 교체될 예정입니다.</p>',
                    'published_at' => Carbon::now()->subDays($c['days']),
                ]
            );
        }
    }
}
