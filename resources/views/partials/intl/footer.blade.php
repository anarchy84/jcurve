{{-- 영어·일본어 공통 푸터 (Claude 구역, 2026-11-03 INTL). 메뉴는 partials/intl/menu.php, 회사 정보는 한국어 푸터와 같은 사실을 옮긴 것 --}}
@php($intlMenu = require resource_path('views/partials/intl/menu.php'))
<footer class="jc-footer {{ $variant ?? '' }}">
    <div class="jc-wrap">
        <div class="jc-footer__grid">
            @foreach ($intlMenu['marketing'] as $group => $links)
                <nav aria-label="{{ $group }}">
                    <h2>{{ $group }}</h2>
                    <ul>
                        @foreach ($links as $link)
                            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </nav>
            @endforeach
            <nav aria-label="{{ __('menu.operations') }}">
                <h2>{{ __('menu.operations') }}</h2>
                <ul>
                    <li><a href="{{ $intlMenu['self']['href'] }}">{{ $intlMenu['self']['label'] }}</a></li>
                    @foreach ($intlMenu['operations'] as $op)
                        <li><a href="{{ $op['href'] }}">{{ $op['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>
            <nav aria-label="{{ __('menu.support') }}">
                <h2>{{ __('menu.support') }}</h2>
                <ul>
                    @foreach ($intlMenu['support'] as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>
            <nav aria-label="{{ __('menu.footer.company_group') }}">
                <h2>{{ __('menu.footer.company_group') }}</h2>
                <ul>
                    @foreach ($intlMenu['company'] as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>
        </div>
        <div class="jc-footer__bottom">
            <address class="jc-footer__company">
                <strong>{{ __('menu.footer.company_name') }}</strong>
                <span>{{ __('menu.footer.ceo') }}</span>
                <span>{{ __('menu.footer.address') }}</span>
                <span>{{ __('menu.footer.contact') }}</span>
            </address>
            <div class="jc-footer__legal">
                <a href="{{ intl_route('privacy') }}">{{ __('menu.footer.privacy') }}</a>
                <span>{{ __('menu.footer.copyright') }}</span>
            </div>
        </div>
    </div>
</footer>
