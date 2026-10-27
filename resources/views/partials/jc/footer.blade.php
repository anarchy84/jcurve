{{-- 공통 푸터. 메뉴는 partials/jc/menu.php 공용, 회사 정보는 기존 푸터 표기 그대로 유지 --}}
@php($jcMenu = require resource_path('views/partials/jc/menu.php'))
<footer class="jc-footer {{ $variant ?? '' }}">
    <div class="jc-wrap">
        <div class="jc-footer__grid">
            @foreach ($jcMenu['marketing'] as $group => $links)
                <nav aria-label="{{ $group }}">
                    <h2>{{ $group }}</h2>
                    <ul>
                        @foreach ($links as $link)
                            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </nav>
            @endforeach
            <nav aria-label="운영 서비스">
                <h2>운영 서비스</h2>
                <ul>
                    <li><a href="{{ $jcMenu['self']['href'] }}">{{ $jcMenu['self']['label'] }}</a></li>
                    @foreach ($jcMenu['operations'] as $op)
                        <li><a href="{{ $op['href'] }}">{{ $op['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>
            <nav aria-label="회사">
                <h2>회사</h2>
                <ul>
                    @foreach ($jcMenu['company'] as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>
        </div>
        <div class="jc-footer__bottom">
            <address class="jc-footer__company">
                <strong>(주)제이커브인터렉티브</strong>
                <span>대표이사 김태훈, 사업자등록번호 753-88-01488</span>
                <span>서울특별시 금천구 가산디지털1로, 가산더블유센터 703호</span>
                <span>02-1668-2612, jcurve19@gmail.com</span>
            </address>
            <div class="jc-footer__legal">
                <a href="{{ route('privacy') }}">개인정보처리방침</a>
                <span>© 2026 J-Curve Interactive Corporation.</span>
            </div>
        </div>
    </div>
</footer>
