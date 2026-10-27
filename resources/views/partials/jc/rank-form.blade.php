{{--
    순위 확인 폼 (랭크프리로 이동). 사이트 안에서 데이터를 받지 않는다 → 백엔드 불필요.
    variant: 'stack' = 홈 검정 띠(세로), 'row' = 셀프마케팅 띠(가로), 'hero' = 홈 첫 화면 전환 패널(세로, 짧은 안내 포함)
    랭크프리 검색 파라미터 이름은 확정 전 — resources/js/jc.js 의 RANKFREE_URL 주석 참고.
--}}
@php
    $jcVariant = $variant ?? 'stack';
    $jcRow = $jcVariant === 'row';
    $jcHero = $jcVariant === 'hero';
@endphp
<form class="{{ $jcRow ? 'jc-check__form' : 'jc-rankform' }}{{ $jcHero ? ' jc-rankform--hero' : '' }}" data-jc-rankcheck action="https://rankfree.kr" method="GET" target="_blank">
    @if ($jcHero)
        <p class="jc-display jc-rankform__title">사장님 가게, 지금 몇 등일까요?</p>
        <p class="jc-rankform__desc">플레이스·쇼핑 순위를 랭크프리로 무료 확인하고, 필요하면 바로 셀프마케팅으로 올립니다.</p>
    @elseif (! $jcRow)
        <h3 class="jc-display jc-rankform__title">사장님, 지금 몇 등인지 아세요?</h3>
    @endif
    <input type="hidden" name="area" value="place">
    <div class="jc-seg" role="group" aria-label="검색 영역" data-jc-seg>
        <button type="button" data-value="place" aria-pressed="true">플레이스</button>
        <button type="button" data-value="shopping" aria-pressed="false">쇼핑</button>
        @if ($jcRow)<button type="button" data-value="blog" aria-pressed="false">블로그</button>@endif
    </div>
    <label class="jc-field">가게 이름 또는 키워드
        <input class="jc-input" type="text" name="keyword" placeholder="예: 성수동 파스타" autocomplete="off">
    </label>
    <button class="jc-btn {{ $jcRow ? 'jc-btn--up' : 'jc-btn--primary' }}" type="submit">{{ $jcRow ? '순위 확인' : '무료로 순위 확인' }}</button>
    @unless ($jcRow)
        <a class="jc-underline" href="{{ route('self-marketing') }}#order">셀프마케팅 주문하기</a>
    @endunless
</form>
