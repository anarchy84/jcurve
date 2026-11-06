{{-- 공통 푸터 (11/06 ncloud 배치 참고: 짙은 바탕 · 위 문의 줄 · 여러 열 링크 · 아래 약관·회사 정보). 메뉴는 partials/jc/menu.php 공용, 회사 정보는 기존 표기 그대로. 스타일 public/css/jc-nc.css --}}
@php($jcMenu = require resource_path('views/partials/jc/menu.php'))
<footer class="jc-footer jc-ncf {{ $variant ?? '' }}">
    <div class="jc-wrap">
        <div class="jc-ncf__top">
            <p class="jc-ncf__ask"><strong>프로젝트 문의</strong><span>1:1 상담 신청</span></p>
            <div class="jc-ncf__topbtns">
                <a class="jc-ncf__btn jc-ncf__btn--line" href="tel:0216682612">전화 02-1668-2612</a>
                <a class="jc-ncf__btn jc-ncf__btn--fill" href="{{ route('contact') }}">문의하기</a>
            </div>
        </div>
        <div class="jc-footer__grid jc-ncf__grid">
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
                    @foreach ($jcMenu['self']['children'] ?? [] as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                    @foreach ($jcMenu['operations'] as $op)
                        <li><a href="{{ $op['href'] }}">{{ $op['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>
            <div class="jc-ncf__stack">
                <nav aria-label="고객센터">
                    <h2>고객센터</h2>
                    <ul>
                        @foreach ($jcMenu['support'] as $link)
                            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
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
        </div>
        <div class="jc-ncf__bottom">
            <div class="jc-ncf__brandrow">
                <a class="jc-ncf__brand" href="{{ route('home') }}">제이커브 <span>Interactive</span></a>
                <nav class="jc-ncf__legal" aria-label="약관">
                    <a class="is-strong" href="{{ route('privacy') }}">개인정보처리방침</a>
                    <a href="{{ route('company') }}">회사소개</a>
                    <a href="{{ route('contact') }}">문의하기</a>
                </nav>
            </div>
            <address class="jc-footer__company jc-ncf__company">
                <span><strong>(주)제이커브인터렉티브</strong><i></i>대표이사 김태훈<i></i>사업자등록번호 753-88-01488</span>
                <span>서울특별시 금천구 가산디지털1로, 가산더블유센터 703호<i></i>02-1668-2612<i></i>jcurve19@gmail.com</span>
                <span class="jc-ncf__copy">© 2026 J-Curve Interactive Corporation.</span>
            </address>
        </div>
    </div>
</footer>
