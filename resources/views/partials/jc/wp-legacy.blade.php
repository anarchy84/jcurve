{{--
    운영 워드프레스 본문 원문 보존 구간 (Claude 구역, 2026-11-03)
    - 왜: 같은 주소에서 구글·AI 답변이 인용하던 문장이 전환 뒤에도 그 주소에 남아 있게 한다.
      제코 11/3 「옛 문장 그대로 넣기」·「전부 그대로 넣기」(성과 숫자 포함). 문구·숫자를 고치지 말 것.
    - 데이터: partials/jc/wp-legacy/{이름}.json — 2026-11-03 운영 j-curve.co.kr <main> 본문에서 뽑은 제목·문단·목록 블록.
      검토용 원문: docs/content/wp-legacy/{이름}.md
    - 사용: @include('partials.jc.wp-legacy', ['wpLegacy' => 'seo', 'wpStyle' => 'landing'|'jc'])
      wpLegacy 를 안 주면 현재 원주소(/seo-backlinks/ → seo-backlinks)로 찾는다. 파일이 없으면 아무것도 안 나온다.
--}}
@php
    $wpName = $wpLegacy ?? trim(\App\Services\Seo\Publishing\PreservedPaths::path('/'.ltrim(request()->path(), '/')), '/');
    $wpName = $wpName === '' ? 'home' : $wpName;
    $wpFile = preg_match('/^[a-z0-9-]+$/', $wpName) ? resource_path('views/partials/jc/wp-legacy/'.$wpName.'.json') : null;
    $wpBlocks = $wpFile && is_file($wpFile) ? (json_decode((string) file_get_contents($wpFile), true)['blocks'] ?? []) : [];
    // 연속된 목록 항목은 하나의 <ul> 로 묶는다
    $wpGroups = [];
    foreach ($wpBlocks as $wpBlock) {
        $wpLast = array_key_last($wpGroups);
        if (($wpBlock['type'] ?? '') === 'li') {
            if ($wpLast !== null && $wpGroups[$wpLast]['type'] === 'ul') {
                $wpGroups[$wpLast]['items'][] = $wpBlock['text'];
            } else {
                $wpGroups[] = ['type' => 'ul', 'items' => [$wpBlock['text']]];
            }
        } else {
            $wpGroups[] = $wpBlock;
        }
    }
    $wpJc = ($wpStyle ?? 'landing') === 'jc';
@endphp
@if ($wpGroups)
<section id="service-detail" class="{{ $wpJc ? 'jc-section' : 'landing__section landing__section--light' }} jc-wp-legacy" aria-label="서비스 상세 안내">
    <div class="{{ $wpJc ? 'jc-wrap' : 'landing__inner' }}">
        <div class="{{ $wpJc ? 'jc-prose' : 'prose' }} jc-wp-legacy__body">
            @foreach ($wpGroups as $wpGroup)
                @if ($wpGroup['type'] === 'ul')
                    <ul>
                        @foreach ($wpGroup['items'] as $wpItem)
                            <li>{{ $wpItem }}</li>
                        @endforeach
                    </ul>
                @elseif ($wpGroup['type'] === 'h' && mb_strlen($wpGroup['text']) <= 60)
                    {{-- 페이지 H1 은 이미 있으므로 원문 단계를 한 칸씩 내린다: 원문 1단계 → h2, 2단계 → h3, 그 아래 → h4 --}}
                    @php $wpLevel = (int) ($wpGroup['level'] ?? 2); @endphp
                    @if ($wpLevel <= 1)
                        <h2>{{ $wpGroup['text'] }}</h2>
                    @elseif ($wpLevel === 2)
                        <h3>{{ $wpGroup['text'] }}</h3>
                    @else
                        <h4>{{ $wpGroup['text'] }}</h4>
                    @endif
                @elseif ($wpGroup['type'] === 'h')
                    {{-- 원문에서 제목 태그로 쓴 긴 문장은 문단으로 보여 준다(문장은 그대로) --}}
                    <p><strong>{{ $wpGroup['text'] }}</strong></p>
                @else
                    <p>{{ $wpGroup['text'] }}</p>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif
