@php
    // 언어 전환 링크 KO · EN · JA (Claude 구역, 2026-11-03 INTL)
    // - 한국어 헤더와 외국어 헤더가 같이 쓴다. 한국어 화면에서 바뀌는 부분은 이 블록(data-intl-switcher)뿐이다(INTL-PLAN §1).
    // - 그 언어판이 있으면 같은 페이지로, 없으면 그 언어 홈으로 보낸다. 같은 페이지일 때만 hreflang 을 단다.
    // - 주소는 경로만 쓴다(공개 주소가 아니어도 시험 서버·로컬에서 그대로 동작).
    // 사용: @include('partials.intl.switcher', ['intlSwitcherClass' => '...'])
    $intlNow = intl_locale();
    $intlSwitchAlts = $intlAlts ?? intl_alternates();
    $intlPathOf = function (string $url): string {
        $path = parse_url($url, PHP_URL_PATH) ?: '/';
        $query = parse_url($url, PHP_URL_QUERY);

        return $path.($query ? '?'.$query : '');
    };
@endphp
<nav class="jc-lang {{ $intlSwitcherClass ?? '' }}" aria-label="{{ $intlNow === 'ko' ? '언어 선택' : __('menu.lang_switch') }}" data-intl-switcher>
    @foreach (config('intl.locales') as $intlCode => $intlLoc)
        @php($intlSame = isset($intlSwitchAlts[$intlCode]))
        <a class="jc-lang__item" href="{{ $intlPathOf($intlSame ? $intlSwitchAlts[$intlCode] : intl_route('home', [], $intlCode)) }}" lang="{{ $intlLoc['html_lang'] }}" @if ($intlSame) hreflang="{{ $intlLoc['html_lang'] }}" @endif title="{{ $intlLoc['label'] }}" @if ($intlCode === $intlNow) aria-current="true" @endif>{{ $intlLoc['short'] }}</a>
    @endforeach
</nav>
