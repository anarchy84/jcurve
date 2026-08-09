@php
    // dompdf 최적화: flex/grid 미사용, 테이블/블록 레이아웃, 인라인 <style>.
    $catScores = $result['catScores'] ?? [];
    $groups = collect($result['checks'])->groupBy(fn ($ck) => $ck['category'] ?? 'seo');
    $sections = [
        'seo' => ['온페이지 SEO', '검색엔진이 페이지를 읽고 순위 매기는 기본 요소'],
        'geo' => ['GEO · AEO (AI 답변 최적화)', 'AI 검색·챗봇이 이 페이지를 인용하도록 만드는 요소'],
    ];
    $statusLabel = ['pass' => '통과', 'warn' => '주의', 'fail' => '개선'];
@endphp
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<style>
    @font-face {
        font-family: 'Pretendard';
        font-weight: 400; font-style: normal;
        src: url("{{ storage_path('fonts/Pretendard-Regular.ttf') }}") format("truetype");
    }
    @font-face {
        font-family: 'Pretendard';
        font-weight: 700; font-style: normal;
        src: url("{{ storage_path('fonts/Pretendard-Bold.ttf') }}") format("truetype");
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Pretendard', sans-serif; color: #1d1d1f; font-size: 11px; line-height: 1.5; }
    .wrap { padding: 4px 2px; }

    /* 헤더 */
    .hd { border-bottom: 2px solid #1d1d1f; padding-bottom: 12px; margin-bottom: 18px; }
    .hd .brand { font-size: 13px; font-weight: 700; color: #0066cc; }
    .hd h1 { font-size: 20px; font-weight: 700; margin-top: 6px; }
    .hd .url { font-size: 11px; color: #6e6e73; margin-top: 4px; word-break: break-all; }
    .hd .date { font-size: 10px; color: #86868b; margin-top: 2px; }

    /* 점수 밴드 */
    .score-band { width: 100%; margin-bottom: 20px; }
    .score-band td { vertical-align: middle; }
    .score-box { width: 130px; }
    .score-num { font-size: 44px; font-weight: 700; letter-spacing: -1px; line-height: 1; }
    .score-num small { font-size: 14px; color: #86868b; font-weight: 400; }
    .grade { display: inline-block; margin-top: 4px; padding: 2px 12px; border-radius: 20px; color: #fff; font-size: 12px; font-weight: 700; }
    .g-a, .g-b { background: #1f9d55; } .g-c { background: #d08700; } .g-d, .g-f { background: #c64545; }
    .sub { display: inline-block; margin-right: 8px; padding: 5px 12px; border: 1px solid #d2d2d7; border-radius: 20px; font-size: 11px; }
    .sub strong { font-size: 13px; }

    /* 섹션 */
    .sec { margin-bottom: 18px; }
    .sec-title { font-size: 14px; font-weight: 700; border-left: 3px solid #0066cc; padding-left: 8px; margin-bottom: 2px; }
    .sec-desc { font-size: 10px; color: #86868b; margin: 0 0 8px 11px; }

    /* 체크 테이블 */
    table.checks { width: 100%; border-collapse: collapse; }
    table.checks td { padding: 7px 8px; border-bottom: 1px solid #ececed; vertical-align: top; }
    .st { width: 46px; }
    .pill { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; color: #fff; text-align: center; }
    .p-pass { background: #1f9d55; } .p-warn { background: #d08700; } .p-fail { background: #c64545; }
    .ck-label { font-weight: 700; font-size: 11px; }
    .ck-detail { color: #6e6e73; font-size: 10px; }

    /* 백링크 */
    .bl-badge { display: inline-block; margin-left: 8px; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 700; color: #a06a00; background: #fbf1dc; border: 1px solid #e6c684; }
    .bl-note { font-size: 10px; color: #a06a00; margin: 4px 0 10px 11px; }
    table.blstats { width: 100%; border-collapse: separate; border-spacing: 6px 0; margin-bottom: 12px; }
    table.blstats td { width: 25%; background: #f5f5f7; border: 1px solid #e5e5ea; border-radius: 8px; padding: 12px 8px; text-align: center; }
    .blstat-n { font-size: 22px; font-weight: 700; letter-spacing: -0.5px; }
    .blstat-l { font-size: 9px; color: #86868b; }
    table.bltop { width: 100%; border-collapse: collapse; font-size: 10px; }
    table.bltop th { text-align: left; padding: 6px 6px; border-bottom: 1.5px solid #d2d2d7; font-size: 9px; color: #86868b; text-transform: uppercase; }
    table.bltop td { padding: 6px 6px; border-bottom: 1px solid #ececed; vertical-align: top; }
    .bl-from { font-weight: 700; }
    .bl-from span { display: block; color: #86868b; font-weight: 400; font-size: 9px; word-break: break-all; }
    .df { color: #1f7a45; } .nf { color: #86868b; }

    /* 푸터 CTA */
    .cta { margin-top: 22px; padding: 14px 16px; background: #1d1d1f; color: #fff; border-radius: 10px; }
    .cta h3 { font-size: 13px; font-weight: 700; margin-bottom: 3px; }
    .cta p { font-size: 10px; color: #c7c7cc; }
    .cta .site { color: #2997ff; font-weight: 700; }
    .foot { margin-top: 10px; text-align: center; font-size: 9px; color: #aeaeb2; }
</style>
</head>
<body>
<div class="wrap">

    <div class="hd">
        <div class="brand">J-Curve Interactive · SEO · GEO·AEO Report</div>
        <h1>SEO + AI 답변 최적화 진단 리포트</h1>
        <div class="url">{{ $result['url'] }}</div>
        <div class="date">생성일 {{ $generatedAt->format('Y.m.d H:i') }}</div>
    </div>

    <table class="score-band">
        <tr>
            <td class="score-box">
                <div class="score-num">{{ $result['score'] }}<small> / 100</small></div>
                <span class="grade g-{{ strtolower($result['grade']) }}">{{ $result['grade'] }}등급</span>
            </td>
            <td>
                <div style="font-size:12px;font-weight:700;margin-bottom:6px;">종합 점수 (온페이지 SEO + GEO·AEO)</div>
                @isset($catScores['seo'])
                    <span class="sub">온페이지 SEO <strong>{{ $catScores['seo']['score'] }}</strong></span>
                @endisset
                @isset($catScores['geo'])
                    <span class="sub">GEO·AEO <strong>{{ $catScores['geo']['score'] }}</strong></span>
                @endisset
            </td>
        </tr>
    </table>

    @foreach ($sections as $cat => $meta)
        @if ($groups->has($cat))
            <div class="sec">
                <div class="sec-title">{{ $meta[0] }}@isset($catScores[$cat]) <span style="font-size:10px;color:#86868b;font-weight:400;">{{ $catScores[$cat]['score'] }}점</span>@endisset</div>
                <div class="sec-desc">{{ $meta[1] }}</div>
                <table class="checks">
                    @foreach ($groups->get($cat) as $ck)
                        <tr>
                            <td class="st"><span class="pill p-{{ $ck['status'] }}">{{ $statusLabel[$ck['status']] ?? $ck['status'] }}</span></td>
                            <td>
                                <div class="ck-label">{{ $ck['label'] }}</div>
                                <div class="ck-detail">{{ $ck['detail'] }}</div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    @endforeach

    @isset($backlinks)
        <div class="sec">
            <div class="sec-title">백링크 프로필@if (! empty($backlinks['sample']))<span class="bl-badge">샘플 데이터</span>@endif</div>
            @if (! empty($backlinks['sample']))
                <div class="bl-note">아래 수치는 레이아웃 확인용 예시입니다. 실제 백링크 데이터 연동은 준비 중입니다.</div>
            @endif
            <table class="blstats">
                <tr>
                    <td><div class="blstat-n">{{ $backlinks['domain_rating'] }}</div><div class="blstat-l">도메인 등급 (DR)</div></td>
                    <td><div class="blstat-n">{{ number_format($backlinks['referring_domains']) }}</div><div class="blstat-l">참조 도메인</div></td>
                    <td><div class="blstat-n">{{ number_format($backlinks['total_backlinks']) }}</div><div class="blstat-l">전체 백링크</div></td>
                    <td><div class="blstat-n">{{ round($backlinks['dofollow_ratio'] * 100) }}%</div><div class="blstat-l">Dofollow 비율</div></td>
                </tr>
            </table>
            <table class="bltop">
                <thead>
                    <tr><th>참조 페이지</th><th>DR</th><th>앵커</th><th>유형</th><th>최초 발견</th></tr>
                </thead>
                <tbody>
                    @foreach ($backlinks['top'] as $bl)
                        <tr>
                            <td class="bl-from">{{ $bl['domain'] }}<span>{{ \Illuminate\Support\Str::after($bl['url'], $bl['domain']) }}</span></td>
                            <td>{{ $bl['dr'] }}</td>
                            <td>{{ $bl['anchor'] }}</td>
                            <td class="{{ $bl['type'] === 'dofollow' ? 'df' : 'nf' }}">{{ $bl['type'] }}</td>
                            <td>{{ $bl['first_seen'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endisset

    <div class="cta">
        <h3>백링크·키워드·경쟁사까지, 실데이터로 더 깊게</h3>
        <p>온페이지 너머의 정밀 SEO·GEO 분석은 제이커브가 이어서 도와드립니다. 문의: <span class="site">j-curve.co.kr</span></p>
    </div>
    <div class="foot">© {{ $generatedAt->format('Y') }} 제이커브인터렉티브 (J-Curve Interactive) · 본 리포트는 온페이지 자동 진단 결과입니다.</div>

</div>
</body>
</html>
