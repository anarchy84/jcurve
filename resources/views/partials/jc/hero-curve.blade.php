{{--
    홈 첫 화면 배경 — 'J커브(성장 곡선)' 모션 그래픽
    - 바탕 이미지: public/images/hero/hero-bg.webp (Codex 이미지 생성, 2026-10-27 · 글자·로고 없음)
      → 왼쪽에서 오른쪽으로 빛이 번지듯 드러난 뒤 아주 천천히 다가온다(줌).
    - 그 위에 코드(SVG)로 같은 곡선을 따라 흐르는 빛점·기록점, 캔버스 입자를 얹는다.
      SVG viewBox를 이미지 크기(1672×941)와 같게 두고 slice로 맞춰, 어떤 화면 비율에서도 곡선 위치가 겹친다.
    - 이미지가 없으면 코드로 그린 곡선·격자로 대신한다.
    - 움직임 줄이기 설정이면 정지 화면으로 보인다.
--}}
@php($jcHeroImg = file_exists(public_path('images/hero/hero-bg.webp')))
<div class="jc-stage__bg" aria-hidden="true">
    @if ($jcHeroImg)
        <div class="jc-stage__media">
            <img class="jc-stage__img" src="{{ asset('images/hero/hero-bg.webp') }}" alt="" width="1672" height="941" fetchpriority="high" decoding="async">
            <svg class="jc-curve jc-curve--overlay" viewBox="0 0 1672 941" preserveAspectRatio="xMidYMid slice">
                <path id="jc-curve-path" d="M0 832 C 520 856 1000 796 1250 646 S 1585 236 1662 0" fill="none" stroke="none"/>
                <g class="jc-curve__dots" fill="#C9D2FF">
                    <circle cx="1010" cy="770" r="5"/><circle cx="1262" cy="636" r="5"/><circle cx="1440" cy="430" r="5"/><circle cx="1560" cy="230" r="5"/>
                </g>
                <circle class="jc-curve__comet" r="6" fill="#fff">
                    <animateMotion dur="5.5s" repeatCount="indefinite" begin="1.6s" keyPoints="0;1" keyTimes="0;1" calcMode="spline" keySplines=".5 0 .2 1"><mpath href="#jc-curve-path"/></animateMotion>
                </circle>
            </svg>
        </div>
    @else
        <svg class="jc-curve" viewBox="0 0 1440 800" preserveAspectRatio="xMidYMid slice">
            <defs>
                <linearGradient id="jc-curve-stroke" x1="0" y1="1" x2="1" y2="0">
                    <stop offset="0" stop-color="#1E3AFF" stop-opacity="0"/><stop offset=".35" stop-color="#1E3AFF" stop-opacity=".55"/>
                    <stop offset=".75" stop-color="#4F68FF"/><stop offset="1" stop-color="#A9B6FF"/>
                </linearGradient>
                <linearGradient id="jc-curve-fill" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stop-color="#1E3AFF" stop-opacity=".22"/><stop offset="1" stop-color="#1E3AFF" stop-opacity="0"/>
                </linearGradient>
                <filter id="jc-curve-glow" x="-20%" y="-20%" width="140%" height="140%"><feGaussianBlur stdDeviation="9"/></filter>
            </defs>
            <g class="jc-curve__grid" stroke="#fff" stroke-opacity=".06">
                @for ($x = 0; $x <= 1440; $x += 80)<line x1="{{ $x }}" y1="0" x2="{{ $x }}" y2="800"/>@endfor
                @for ($y = 40; $y <= 800; $y += 80)<line x1="0" y1="{{ $y }}" x2="1440" y2="{{ $y }}"/>@endfor
            </g>
            <path class="jc-curve__area" d="M-40 640 C 220 670 430 730 650 650 S 1080 330 1480 70 L 1480 800 L -40 800 Z" fill="url(#jc-curve-fill)"/>
            <path class="jc-curve__glow" d="M-40 640 C 220 670 430 730 650 650 S 1080 330 1480 70" fill="none" stroke="#2B47FF" stroke-width="10" filter="url(#jc-curve-glow)" pathLength="1"/>
            <path id="jc-curve-path" class="jc-curve__line" d="M-40 640 C 220 670 430 730 650 650 S 1080 330 1480 70" fill="none" stroke="url(#jc-curve-stroke)" stroke-width="2.5" stroke-linecap="round" pathLength="1"/>
            <g class="jc-curve__dots" fill="#A9B6FF"><circle cx="650" cy="650" r="4"/><circle cx="872" cy="538" r="4"/><circle cx="1060" cy="400" r="4"/><circle cx="1250" cy="236" r="4"/></g>
            <circle class="jc-curve__comet" r="5" fill="#fff">
                <animateMotion dur="6s" repeatCount="indefinite" begin="2.2s" keyPoints="0;1" keyTimes="0;1" calcMode="spline" keySplines=".45 0 .25 1"><mpath href="#jc-curve-path"/></animateMotion>
            </circle>
        </svg>
    @endif
    <canvas class="jc-stage__particles" data-jc-particles></canvas>
    <div class="jc-stage__shade"></div>
</div>
