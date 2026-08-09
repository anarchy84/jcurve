{{-- 다크 섹션 배경 SVG 메시 — 코드로 그린 글로우+그리드(파일 대신 인라인 벡터).
     $k = 섹션별 고유 접미사(같은 페이지 defs id 충돌 방지). 장식이라 aria-hidden. --}}
@php($k = $k ?? \Illuminate\Support\Str::random(5))
<svg class="section-mesh" aria-hidden="true" viewBox="0 0 1440 700" preserveAspectRatio="xMidYMid slice" focusable="false">
    <defs>
        <radialGradient id="mesh-glow-{{ $k }}" cx="50%" cy="6%" r="72%">
            <stop offset="0%" stop-color="#2997ff" stop-opacity="0.16"/>
            <stop offset="55%" stop-color="#0066cc" stop-opacity="0.05"/>
            <stop offset="100%" stop-color="#0066cc" stop-opacity="0"/>
        </radialGradient>
        <pattern id="mesh-grid-{{ $k }}" width="52" height="52" patternUnits="userSpaceOnUse">
            <path d="M52 0H0V52" fill="none" stroke="#ffffff" stroke-opacity="0.035" stroke-width="1"/>
        </pattern>
    </defs>
    <rect width="1440" height="700" fill="url(#mesh-grid-{{ $k }})"/>
    <rect width="1440" height="700" fill="url(#mesh-glow-{{ $k }})"/>
    <circle cx="1200" cy="110" r="380" fill="#2997ff" fill-opacity="0.05"/>
    <circle cx="180" cy="640" r="300" fill="#0066cc" fill-opacity="0.06"/>
</svg>
