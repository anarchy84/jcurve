{{-- 플랫 씬 일러스트 (코드 네이티브 인라인 SVG) — 3D 렌더(AI 느낌) 대체.
     공통: 블루 그라디언트 카드 + 도트 그리드 + 글로우. 중앙 모티프만 $name별로 다르게.
     컨테이너(hero-figure / goalcard__media / bento__media)가 radius+overflow로 클립.
     장식이라 aria-hidden. --}}
@php($name = $name ?? '')
@php($u = \Illuminate\Support\Str::random(5))
<svg class="scene-il__svg" viewBox="0 0 400 300" preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">
    <defs>
        <linearGradient id="sbg-{{ $u }}" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="#0a2a63"/>
            <stop offset="1" stop-color="#0b4fb0"/>
        </linearGradient>
        <radialGradient id="sgl-{{ $u }}" cx="50%" cy="28%" r="72%">
            <stop offset="0" stop-color="#2997ff" stop-opacity=".45"/>
            <stop offset="100%" stop-color="#2997ff" stop-opacity="0"/>
        </radialGradient>
        <pattern id="sdot-{{ $u }}" width="26" height="26" patternUnits="userSpaceOnUse">
            <circle cx="2" cy="2" r="1.4" fill="#ffffff" fill-opacity=".07"/>
        </pattern>
    </defs>
    <rect width="400" height="300" fill="url(#sbg-{{ $u }})"/>
    <rect width="400" height="300" fill="url(#sdot-{{ $u }})"/>
    <rect width="400" height="300" fill="url(#sgl-{{ $u }})"/>

    @switch($name)
        @case('performance') {{-- 퍼포먼스: 대시보드 막대+추세선+상승 배지 --}}
            <rect x="60" y="74" width="280" height="156" rx="16" fill="#ffffff" fill-opacity=".08" stroke="#ffffff" stroke-opacity=".16"/>
            <rect x="96" y="162" width="28" height="46" rx="6" fill="#8fc2ff"/>
            <rect x="138" y="136" width="28" height="72" rx="6" fill="#cfe4ff"/>
            <rect x="180" y="114" width="28" height="94" rx="6" fill="#2997ff"/>
            <rect x="222" y="150" width="28" height="58" rx="6" fill="#8fc2ff"/>
            <rect x="264" y="126" width="28" height="82" rx="6" fill="#cfe4ff"/>
            <path d="M110 150 L152 132 L194 112 L236 144 L278 120" fill="none" stroke="#ffffff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="300" cy="92" r="22" fill="#ff7a59"/>
            <path d="M300 103 V83 M291 92 L300 83 L309 92" stroke="#fff" stroke-width="3.4" stroke-linecap="round" stroke-linejoin="round"/>
            @break

        @case('cpa') {{-- CPA: 타깃 + 클릭 커서 + 전환 배지 --}}
            <circle cx="172" cy="152" r="74" fill="#ffffff" fill-opacity=".07"/>
            <circle cx="172" cy="152" r="74" fill="none" stroke="#8fc2ff" stroke-width="3.5"/>
            <circle cx="172" cy="152" r="46" fill="none" stroke="#cfe4ff" stroke-width="3.5"/>
            <circle cx="172" cy="152" r="19" fill="#2997ff"/>
            <path d="M180 160 L252 184 L222 196 L238 226 L224 232 L208 202 L180 218 Z" fill="#ffffff"/>
            <circle cx="286" cy="92" r="23" fill="#ff7a59"/>
            <path d="M276 92 L284 100 L297 85" fill="none" stroke="#fff" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"/>
            @break

        @case('reward') {{-- 리워드 네트워크: 노드 연결 + 중앙 선물 + 별 --}}
            <g stroke="#8fc2ff" stroke-opacity=".55" stroke-width="2.6">
                <path d="M112 96 L200 150"/><path d="M200 150 L300 100"/>
                <path d="M200 150 L150 224"/><path d="M200 150 L302 214"/>
            </g>
            <rect x="176" y="146" width="48" height="38" rx="5" fill="#2997ff"/>
            <rect x="171" y="134" width="58" height="16" rx="4" fill="#cfe4ff"/>
            <rect x="195" y="134" width="10" height="50" fill="#ffffff" fill-opacity=".92"/>
            <path d="M112 96 l3.4 7 7.6 1 -5.6 5.4 1.4 7.6 -6.8-3.6 -6.8 3.6 1.4-7.6 -5.6-5.4 7.6-1z" fill="#ffffff"/>
            <path d="M302 214 l3.4 7 7.6 1 -5.6 5.4 1.4 7.6 -6.8-3.6 -6.8 3.6 1.4-7.6 -5.6-5.4 7.6-1z" fill="#cfe4ff"/>
            <circle cx="300" cy="100" r="14" fill="#8fc2ff"/>
            <circle cx="150" cy="224" r="13" fill="#ffffff" fill-opacity=".85"/>
            @break

        @case('seo') {{-- SEO·AEO·GEO: 검색바 + 순위 리스트 + 돋보기 + AI 스파크 --}}
            <rect x="70" y="70" width="220" height="34" rx="17" fill="#ffffff" fill-opacity=".1" stroke="#ffffff" stroke-opacity=".16"/>
            <rect x="88" y="83" width="120" height="8" rx="4" fill="#cfe4ff"/>
            <g>
                <rect x="70" y="120" width="200" height="20" rx="6" fill="#ffffff" fill-opacity=".14"/>
                <rect x="70" y="150" width="170" height="20" rx="6" fill="#ffffff" fill-opacity=".1"/>
                <rect x="70" y="180" width="150" height="20" rx="6" fill="#ffffff" fill-opacity=".08"/>
                <rect x="70" y="120" width="10" height="20" rx="3" fill="#2997ff"/>
                <rect x="70" y="150" width="10" height="20" rx="3" fill="#8fc2ff"/>
                <rect x="70" y="180" width="10" height="20" rx="3" fill="#8fc2ff"/>
            </g>
            <circle cx="288" cy="188" r="40" fill="#0a2a63"/>
            <circle cx="288" cy="188" r="40" fill="none" stroke="#ffffff" stroke-width="5"/>
            <path d="M316 216 L338 238" stroke="#ffffff" stroke-width="6" stroke-linecap="round"/>
            <path d="M288 172 l3 7.5 7.5 3 -7.5 3 -3 7.5 -3-7.5 -7.5-3 7.5-3z" fill="#ff7a59"/>
            @break

        @case('wordpress') {{-- 워드프레스: 브라우저 창 + 콘텐츠 블록 + 기어 + 코드 --}}
            <rect x="66" y="72" width="268" height="160" rx="14" fill="#ffffff" fill-opacity=".08" stroke="#ffffff" stroke-opacity=".16"/>
            <path d="M66 96 h268" stroke="#ffffff" stroke-opacity=".16" stroke-width="2"/>
            <circle cx="82" cy="84" r="4" fill="#ff7a59"/><circle cx="96" cy="84" r="4" fill="#cfe4ff"/><circle cx="110" cy="84" r="4" fill="#8fc2ff"/>
            <rect x="84" y="114" width="150" height="14" rx="4" fill="#cfe4ff"/>
            <rect x="84" y="138" width="120" height="10" rx="4" fill="#ffffff" fill-opacity=".3"/>
            <rect x="84" y="158" width="130" height="10" rx="4" fill="#ffffff" fill-opacity=".22"/>
            <rect x="84" y="182" width="70" height="24" rx="7" fill="#2997ff"/>
            <g transform="translate(286,152)">
                <circle r="24" fill="#8fc2ff"/>
                <g stroke="#0a2a63" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round" fill="none">
                    <path d="M-4 -8 L-12 0 L-4 8"/><path d="M4 -8 L12 0 L4 8"/>
                </g>
            </g>
            @break

        @case('boostingshop') {{-- 부스팅샵: 쇼핑백 + 상승 순위 + 별 --}}
            <rect x="96" y="150" width="24" height="60" rx="5" fill="#8fc2ff"/>
            <rect x="126" y="120" width="24" height="90" rx="5" fill="#cfe4ff"/>
            <rect x="156" y="90" width="24" height="120" rx="5" fill="#2997ff"/>
            <path d="M104 150 L138 118 L168 92" fill="none" stroke="#ffffff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M156 92 L168 92 L168 104" fill="none" stroke="#ffffff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M214 128 H300 L294 216 H220 Z" fill="#ffffff" fill-opacity=".1" stroke="#ffffff" stroke-opacity=".4" stroke-width="2.5"/>
            <path d="M232 128 V118 a12 12 0 0 1 24 0 V128" fill="none" stroke="#cfe4ff" stroke-width="3.4"/>
            <path d="M262 128 V118 a12 12 0 0 1 24 0 V128" fill="none" stroke="#cfe4ff" stroke-width="3.4"/>
            <path d="M257 200 V158 M241 174 L257 158 L273 174" fill="none" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            @break

        @case('call2sale') {{-- 콜투세일: 헤드셋 + CRM 연락처 카드 + 통화 흐름 --}}
            <path d="M120 152 v-8 a52 52 0 0 1 104 0 v8" fill="none" stroke="#ffffff" stroke-width="6" stroke-linecap="round"/>
            <rect x="104" y="146" width="30" height="52" rx="14" fill="#2997ff"/>
            <rect x="210" y="146" width="30" height="52" rx="14" fill="#2997ff"/>
            <path d="M240 196 v10 a20 20 0 0 1 -20 20 h-24" fill="none" stroke="#8fc2ff" stroke-width="5" stroke-linecap="round"/>
            <circle cx="188" cy="226" r="12" fill="#ff7a59"/>
            <g>
                <rect x="256" y="120" width="86" height="26" rx="7" fill="#ffffff" fill-opacity=".12"/>
                <circle cx="272" cy="133" r="7" fill="#cfe4ff"/>
                <rect x="286" y="128" width="46" height="4" rx="2" fill="#ffffff" fill-opacity=".5"/>
                <rect x="286" y="137" width="34" height="4" rx="2" fill="#ffffff" fill-opacity=".3"/>
                <rect x="256" y="156" width="86" height="26" rx="7" fill="#ffffff" fill-opacity=".08"/>
                <circle cx="272" cy="169" r="7" fill="#8fc2ff"/>
                <rect x="286" y="164" width="46" height="4" rx="2" fill="#ffffff" fill-opacity=".4"/>
                <rect x="286" y="173" width="34" height="4" rx="2" fill="#ffffff" fill-opacity=".25"/>
            </g>
            @break

        @case('rankfree') {{-- 랭크프리: 순위 리스트(1·2·3) + 돋보기 --}}
            <rect x="64" y="78" width="210" height="150" rx="14" fill="#ffffff" fill-opacity=".08" stroke="#ffffff" stroke-opacity=".16"/>
            @foreach ([['#2997ff', 100, '1'], ['#8fc2ff', 138, '2'], ['#8fc2ff', 176, '3']] as $row)
                <circle cx="92" cy="{{ $row[1] + 10 }}" r="12" fill="{{ $row[0] }}"/>
                <rect x="116" y="{{ $row[1] }}" width="{{ 140 - $loop->index * 26 }}" height="20" rx="6" fill="#ffffff" fill-opacity="{{ 0.16 - $loop->index * 0.04 }}"/>
            @endforeach
            <circle cx="286" cy="176" r="40" fill="#0a2a63"/>
            <circle cx="286" cy="176" r="40" fill="none" stroke="#ffffff" stroke-width="5"/>
            <path d="M314 204 L336 226" stroke="#ffffff" stroke-width="6" stroke-linecap="round"/>
            <path d="M286 162 l2.6 6.6 6.6 2.6 -6.6 2.6 -2.6 6.6 -2.6-6.6 -6.6-2.6 6.6-2.6z" fill="#ff7a59"/>
            @break

        @case('leadbay') {{-- 리드베이: 데이터 → 깔때기 → DB 적재 --}}
            <g fill="#cfe4ff">
                <circle cx="120" cy="76" r="8"/><circle cx="160" cy="68" r="8"/>
                <circle cx="200" cy="72" r="8"/><circle cx="240" cy="66" r="8"/><circle cx="280" cy="76" r="8"/>
            </g>
            <path d="M96 100 H304 L226 190 V232 L174 208 V190 Z" fill="#2997ff"/>
            <path d="M96 100 H304 L226 190 V232 L174 208 V190 Z" fill="#ffffff" fill-opacity=".08"/>
            <g fill="#8fc2ff">
                <ellipse cx="200" cy="250" rx="46" ry="12"/>
                <rect x="154" y="250" width="92" height="26" fill="#8fc2ff"/>
                <ellipse cx="200" cy="276" rx="46" ry="12"/>
            </g>
            <ellipse cx="200" cy="250" rx="46" ry="12" fill="#cfe4ff"/>
            @break

        @case('pillar_search')
        @default {{-- 통합 운영 허브: 중앙 대시보드 + 연결된 UI 카드들 --}}
            <g stroke="#8fc2ff" stroke-opacity=".5" stroke-width="2.4">
                <path d="M200 150 L96 92"/><path d="M200 150 L306 96"/>
                <path d="M200 150 L104 226"/><path d="M200 150 L300 224"/>
            </g>
            <rect x="150" y="112" width="100" height="76" rx="12" fill="#ffffff" fill-opacity=".14" stroke="#ffffff" stroke-opacity=".28"/>
            <rect x="164" y="128" width="44" height="8" rx="4" fill="#cfe4ff"/>
            <rect x="164" y="144" width="72" height="6" rx="3" fill="#ffffff" fill-opacity=".4"/>
            <rect x="164" y="158" width="60" height="6" rx="3" fill="#ffffff" fill-opacity=".3"/>
            <rect x="164" y="172" width="34" height="8" rx="4" fill="#2997ff"/>
            @foreach ([[96, 92, '#2997ff'], [306, 96, '#cfe4ff'], [104, 226, '#8fc2ff'], [300, 224, '#ffffff']] as $n)
                <circle cx="{{ $n[0] }}" cy="{{ $n[1] }}" r="18" fill="{{ $n[2] }}" fill-opacity=".9"/>
            @endforeach
            <path d="M90 92 l2.6 6.6 6.6 2.6 -6.6 2.6 -2.6 6.6 -2.6-6.6 -6.6-2.6 6.6-2.6z" transform="translate(6,0)" fill="#ffffff"/>
            @break
    @endswitch
</svg>
