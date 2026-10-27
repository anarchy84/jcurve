{{--
    순위 확인 폼 (랭크프리로 이동). 사이트 안에서 데이터를 받지 않는다 → 백엔드 불필요.
    variant: 'stack' = 홈 검정 띠(세로), 'row' = 셀프마케팅 띠(가로)
    랭크프리 검색 파라미터 이름은 확정 전 — resources/js/jc.js 의 RANKFREE_URL 주석 참고.
--}}
@php($jcRow = ($variant ?? 'stack') === 'row')
<form class="{{ $jcRow ? 'jc-check__form' : 'jc-rankform' }}" data-jc-rankcheck action="https://rankfree.kr" method="GET" target="_blank">
    @unless ($jcRow)
        <h3 class="jc-display jc-rankform__title">사장님, 지금 몇 등인지 아세요?</h3>
    @endunless
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
