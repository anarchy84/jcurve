{{-- 다크 섹션 배경 SVG — 콘텐츠 특성별로 다른 패턴을 코드로 그린다(파일 대신 인라인 벡터).
     $k       = 섹션별 고유 접미사(같은 페이지 defs id 충돌 방지)
     $variant = data(수치/데이터) · mesh(네트워크) · orbit(궤도/솔루션) · rays(집중/CTA). 기본 glow.
     장식이라 aria-hidden. --}}
@php($k = $k ?? \Illuminate\Support\Str::random(5))
@php($variant = $variant ?? 'glow')
<svg class="section-mesh section-mesh--{{ $variant }}" aria-hidden="true" viewBox="0 0 1440 700" preserveAspectRatio="xMidYMid slice" focusable="false">
    <defs>
        <radialGradient id="mesh-glow-{{ $k }}"
            @switch($variant)
                @case('data') cx="16%" cy="4%" r="70%" @break
                @case('mesh') cx="82%" cy="8%" r="72%" @break
                @case('orbit') cx="50%" cy="120%" r="80%" @break
                @case('rays') cx="50%" cy="0%" r="70%" @break
                @default cx="50%" cy="6%" r="72%"
            @endswitch>
            <stop offset="0%" stop-color="#2997ff" stop-opacity="0.16"/>
            <stop offset="55%" stop-color="#0066cc" stop-opacity="0.05"/>
            <stop offset="100%" stop-color="#0066cc" stop-opacity="0"/>
        </radialGradient>
    </defs>

    <rect width="1440" height="700" fill="url(#mesh-glow-{{ $k }})"/>

    @switch($variant)
        @case('data')
            {{-- 수치/데이터: 도트 그리드 + 바닥의 상승 막대 실루엣 --}}
            <defs>
                <pattern id="mesh-dots-{{ $k }}" width="46" height="46" patternUnits="userSpaceOnUse">
                    <circle cx="2" cy="2" r="1.6" fill="#ffffff" fill-opacity="0.05"/>
                </pattern>
            </defs>
            <rect width="1440" height="700" fill="url(#mesh-dots-{{ $k }})"/>
            <g fill="#2997ff" fill-opacity="0.05">
                <rect x="120" y="560" width="70" height="140" rx="8"/>
                <rect x="210" y="500" width="70" height="200" rx="8"/>
                <rect x="300" y="420" width="70" height="280" rx="8"/>
                <rect x="1050" y="520" width="70" height="180" rx="8"/>
                <rect x="1140" y="440" width="70" height="260" rx="8"/>
                <rect x="1230" y="360" width="70" height="340" rx="8"/>
            </g>
            <circle cx="1180" cy="120" r="300" fill="#2997ff" fill-opacity="0.05"/>
            @break

        @case('mesh')
            {{-- 네트워크: 노드 + 연결선 --}}
            <g stroke="#2997ff" stroke-opacity="0.12" stroke-width="1.4">
                <path d="M180 140 L430 250 L360 470 L120 400 Z"/>
                <path d="M430 250 L700 180 L760 420 L360 470"/>
                <path d="M1010 120 L1260 220 L1200 460 L980 380 Z"/>
                <path d="M1260 220 L1180 90"/>
                <path d="M700 180 L1010 120"/>
                <path d="M760 420 L980 380"/>
            </g>
            <g fill="#2997ff" fill-opacity="0.16">
                <circle cx="180" cy="140" r="6"/><circle cx="430" cy="250" r="7"/>
                <circle cx="360" cy="470" r="6"/><circle cx="120" cy="400" r="5"/>
                <circle cx="700" cy="180" r="7"/><circle cx="760" cy="420" r="6"/>
                <circle cx="1010" cy="120" r="6"/><circle cx="1260" cy="220" r="7"/>
                <circle cx="1200" cy="460" r="6"/><circle cx="980" cy="380" r="5"/>
                <circle cx="1180" cy="90" r="5"/>
            </g>
            @break

        @case('orbit')
            {{-- 궤도: 동심원 링 + 공전 도트 (자체 솔루션 = 하나의 축을 도는 도구들) --}}
            <g fill="none" stroke="#2997ff" stroke-opacity="0.1" stroke-width="1.4">
                <ellipse cx="720" cy="350" rx="620" ry="250"/>
                <ellipse cx="720" cy="350" rx="440" ry="175"/>
                <ellipse cx="720" cy="350" rx="260" ry="105"/>
            </g>
            <g fill="#2997ff" fill-opacity="0.18">
                <circle cx="100" cy="350" r="7"/>
                <circle cx="280" cy="475" r="6"/>
                <circle cx="1160" cy="240" r="7"/>
                <circle cx="980" cy="455" r="6"/>
                <circle cx="720" cy="245" r="5"/>
            </g>
            <circle cx="720" cy="350" r="14" fill="#2997ff" fill-opacity="0.1"/>
            @break

        @case('rays')
            {{-- 집중/CTA: 상단 소실점으로 모이는 방사선 + 강한 중앙 글로우 --}}
            <g stroke="#2997ff" stroke-opacity="0.08" stroke-width="1.4">
                <path d="M720 40 L120 700"/><path d="M720 40 L360 700"/>
                <path d="M720 40 L560 700"/><path d="M720 40 L720 700"/>
                <path d="M720 40 L880 700"/><path d="M720 40 L1080 700"/>
                <path d="M720 40 L1320 700"/>
            </g>
            <circle cx="720" cy="60" r="360" fill="#2997ff" fill-opacity="0.06"/>
            @break

        @default
            {{-- glow: 기본 그리드 + 오브 --}}
            <defs>
                <pattern id="mesh-grid-{{ $k }}" width="52" height="52" patternUnits="userSpaceOnUse">
                    <path d="M52 0H0V52" fill="none" stroke="#ffffff" stroke-opacity="0.035" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="1440" height="700" fill="url(#mesh-grid-{{ $k }})"/>
            <circle cx="1200" cy="110" r="380" fill="#2997ff" fill-opacity="0.05"/>
            <circle cx="180" cy="640" r="300" fill="#0066cc" fill-opacity="0.06"/>
    @endswitch
</svg>
