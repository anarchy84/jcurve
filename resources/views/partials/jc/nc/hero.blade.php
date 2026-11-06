{{-- 11/06 히어로 일러스트 (ncloud 배치 참고: 왼쪽 글 · 오른쪽 큰 그림). 직접 그린 평면 SVG, 그라데이션 없음. 색은 사이트 파랑 계열 + 먹색 + 상승 빨강.
     사용: <figure class="jc-nc-hero">@include('partials.jc.nc.hero', ['name' => 'performance'])</figure> --}}
@php($name = $name ?? 'services')
<svg class="jc-nc-hero__svg" viewBox="0 0 560 440" role="img" aria-hidden="true" focusable="false">
    {{-- 바탕 덩어리 --}}
    <path d="M70 120C96 52 190 24 282 34c96 10 190 40 222 118 30 74-6 160-70 210-66 52-170 62-262 40C82 380 26 318 30 248c3-48 22-86 40-128Z" fill="#EEF1FF"/>
    <ellipse cx="280" cy="402" rx="190" ry="14" fill="#DDE3FF"/>
    @switch($name)
    @case('performance')
        {{-- 모니터 + 막대 + 오르는 선 + 매체 칸 3개에서 예산이 흘러 들어감 --}}
        <rect x="150" y="76" width="300" height="214" rx="14" fill="#1A1C20"/>
        <rect x="162" y="88" width="276" height="178" rx="6" fill="#fff"/>
        <rect x="176" y="102" width="90" height="10" rx="5" fill="#DDE3FF"/>
        <rect x="176" y="120" width="56" height="8" rx="4" fill="#AEBBFF"/>
        <path d="M184 246v-30M226 246v-52M268 246v-40M310 246v-72M352 246v-60M394 246v-102" stroke="#DDE3FF" stroke-width="22" stroke-linecap="round"/>
        <path d="M184 246v-12M226 246v-30M268 246v-22M310 246v-46M352 246v-38M394 246v-78" stroke="#1E3AFF" stroke-width="22" stroke-linecap="round"/>
        <path d="M184 206l42-24 42 12 42-40 42 10 42-52" fill="none" stroke="#D4200F" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="394" cy="112" r="8" fill="#D4200F"/><circle cx="394" cy="112" r="3.5" fill="#fff"/>
        <rect x="270" y="290" width="60" height="34" fill="#1A1C20"/><rect x="226" y="322" width="148" height="12" rx="6" fill="#1A1C20"/>
        <g>
            <rect x="52" y="120" width="76" height="52" rx="10" fill="#fff" stroke="#AEBBFF" stroke-width="2"/><circle cx="74" cy="146" r="11" fill="#1E3AFF"/><rect x="92" y="138" width="26" height="6" rx="3" fill="#AEBBFF"/><rect x="92" y="150" width="18" height="6" rx="3" fill="#DDE3FF"/>
            <rect x="40" y="192" width="76" height="52" rx="10" fill="#fff" stroke="#AEBBFF" stroke-width="2"/><rect x="52" y="206" width="22" height="22" rx="6" fill="#5B73FF"/><rect x="82" y="210" width="24" height="6" rx="3" fill="#AEBBFF"/><rect x="82" y="222" width="16" height="6" rx="3" fill="#DDE3FF"/>
            <rect x="56" y="264" width="76" height="52" rx="10" fill="#fff" stroke="#AEBBFF" stroke-width="2"/><path d="M70 278l18 12-18 12Z" fill="#1A1C20"/><rect x="98" y="282" width="24" height="6" rx="3" fill="#AEBBFF"/><rect x="98" y="294" width="16" height="6" rx="3" fill="#DDE3FF"/>
            <path d="M128 146c14 0 14 34 22 40M116 218h34M132 290c12 0 12-40 18-46" fill="none" stroke="#5B73FF" stroke-width="2.5" stroke-dasharray="5 6"/>
        </g>
        {{-- 사람: 가리키는 손 --}}
        <g>
            <circle cx="488" cy="244" r="15" fill="#1A1C20"/>
            <path d="M470 270c0-10 8-16 18-16s18 6 18 16v62h-36Z" fill="#1E3AFF"/>
            <path d="M474 280l-30-38" stroke="#1E3AFF" stroke-width="10" stroke-linecap="round"/>
            <path d="M474 332v54M500 332v54" stroke="#1A1C20" stroke-width="10" stroke-linecap="round"/>
        </g>
        <g><circle cx="470" cy="70" r="26" fill="#1E3AFF"/><path d="M458 76l10-12 10 8 10-14" fill="none" stroke="#fff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/></g>
        @break

    @case('cpa')
        {{-- 깔때기: 여러 행동이 들어와 승인된 것만 정산서로 --}}
        <g fill="#fff" stroke="#AEBBFF" stroke-width="2">
            <rect x="86" y="62" width="80" height="40" rx="20"/><rect x="186" y="46" width="80" height="40" rx="20"/><rect x="290" y="46" width="80" height="40" rx="20"/><rect x="392" y="62" width="80" height="40" rx="20"/>
        </g>
        <g fill="#5B73FF"><circle cx="106" cy="82" r="9"/><circle cx="206" cy="66" r="9"/><circle cx="310" cy="66" r="9"/><circle cx="412" cy="82" r="9"/></g>
        <g fill="#DDE3FF"><rect x="122" y="77" width="32" height="10" rx="5"/><rect x="222" y="61" width="32" height="10" rx="5"/><rect x="326" y="61" width="32" height="10" rx="5"/><rect x="428" y="77" width="32" height="10" rx="5"/></g>
        <path d="M120 128h320l-104 116v58l-52 26v-84Z" fill="#1E3AFF"/>
        <path d="M120 128h320l-18 20H138Z" fill="#5B73FF"/>
        <path d="M180 160h200" stroke="#fff" stroke-opacity=".35" stroke-width="3"/><path d="M216 196h128" stroke="#fff" stroke-opacity=".35" stroke-width="3"/>
        {{-- 걸러진 것 --}}
        <g><circle cx="96" cy="200" r="16" fill="#fff" stroke="#D5D7DC" stroke-width="2"/><path d="M89 193l14 14M103 193l-14 14" stroke="#9AA0AA" stroke-width="3" stroke-linecap="round"/></g>
        <g><circle cx="468" cy="214" r="16" fill="#fff" stroke="#D5D7DC" stroke-width="2"/><path d="M461 207l14 14M475 207l-14 14" stroke="#9AA0AA" stroke-width="3" stroke-linecap="round"/></g>
        {{-- 정산서 --}}
        <rect x="214" y="306" width="132" height="84" rx="10" fill="#fff" stroke="#1A1C20" stroke-width="3"/>
        <circle cx="240" cy="332" r="12" fill="#1E3AFF"/><path d="M234 332l5 5 8-9" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <rect x="260" y="326" width="70" height="8" rx="4" fill="#AEBBFF"/>
        <rect x="230" y="352" width="100" height="7" rx="3.5" fill="#DDE3FF"/><rect x="230" y="368" width="64" height="7" rx="3.5" fill="#DDE3FF"/>
        <g><circle cx="376" cy="350" r="20" fill="#1A1C20"/><circle cx="376" cy="350" r="12" fill="none" stroke="#fff" stroke-width="2.5"/><circle cx="398" cy="372" r="16" fill="#1E3AFF"/><circle cx="398" cy="372" r="9" fill="none" stroke="#fff" stroke-width="2.5"/></g>
        @break

    @case('reward')
        {{-- 광고주 → 폰 미션 → 보상 → 매체 수익 --}}
        <rect x="200" y="58" width="164" height="300" rx="26" fill="#1A1C20"/>
        <rect x="212" y="78" width="140" height="262" rx="14" fill="#fff"/>
        <rect x="256" y="66" width="52" height="6" rx="3" fill="#3A3D44"/>
        <rect x="226" y="94" width="72" height="10" rx="5" fill="#1A1C20"/>
        <g>
            <rect x="224" y="118" width="116" height="48" rx="10" fill="#EEF1FF"/><rect x="234" y="128" width="28" height="28" rx="8" fill="#1E3AFF"/><rect x="270" y="132" width="52" height="7" rx="3.5" fill="#AEBBFF"/><rect x="270" y="145" width="34" height="7" rx="3.5" fill="#DDE3FF"/>
            <rect x="224" y="174" width="116" height="48" rx="10" fill="#EEF1FF"/><rect x="234" y="184" width="28" height="28" rx="8" fill="#5B73FF"/><rect x="270" y="188" width="52" height="7" rx="3.5" fill="#AEBBFF"/><rect x="270" y="201" width="34" height="7" rx="3.5" fill="#DDE3FF"/>
            <rect x="224" y="230" width="116" height="48" rx="10" fill="#1E3AFF"/><rect x="234" y="240" width="28" height="28" rx="8" fill="#fff"/><path d="M241 254l5 5 9-10" fill="none" stroke="#1E3AFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><rect x="270" y="244" width="52" height="7" rx="3.5" fill="#fff"/><rect x="270" y="257" width="34" height="7" rx="3.5" fill="#AEBBFF"/>
            <rect x="224" y="292" width="116" height="34" rx="8" fill="#1A1C20"/><rect x="258" y="305" width="48" height="8" rx="4" fill="#fff"/>
        </g>
        {{-- 광고주 건물 --}}
        <g><rect x="52" y="168" width="96" height="136" rx="6" fill="#fff" stroke="#AEBBFF" stroke-width="2"/><rect x="52" y="168" width="96" height="22" rx="6" fill="#1E3AFF"/>
            <g fill="#DDE3FF"><rect x="68" y="204" width="20" height="18" rx="3"/><rect x="112" y="204" width="20" height="18" rx="3"/><rect x="68" y="236" width="20" height="18" rx="3"/><rect x="112" y="236" width="20" height="18" rx="3"/></g><rect x="88" y="270" width="24" height="34" rx="3" fill="#1A1C20"/></g>
        <path d="M152 216c22 0 26-30 44-30" fill="none" stroke="#5B73FF" stroke-width="3" stroke-dasharray="6 7" stroke-linecap="round"/><path d="M190 180l10 6-10 8" fill="none" stroke="#5B73FF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        {{-- 선물 상자 + 동전 --}}
        <g><rect x="400" y="190" width="96" height="74" rx="8" fill="#1E3AFF"/><rect x="392" y="172" width="112" height="28" rx="6" fill="#5B73FF"/><rect x="440" y="172" width="16" height="92" fill="#fff"/><path d="M448 172c-14-24-40-16-30 0M448 172c14-24 40-16 30 0" fill="none" stroke="#1A1C20" stroke-width="4" stroke-linecap="round"/></g>
        <g><circle cx="430" cy="316" r="22" fill="#1A1C20"/><circle cx="430" cy="316" r="13" fill="none" stroke="#fff" stroke-width="3"/><circle cx="472" cy="334" r="18" fill="#D4200F"/><circle cx="472" cy="334" r="10" fill="none" stroke="#fff" stroke-width="2.5"/></g>
        <path d="M368 150c26 0 30 12 36 20" fill="none" stroke="#5B73FF" stroke-width="3" stroke-dasharray="6 7" stroke-linecap="round"/>
        @break

    @case('seo')
        {{-- 브라우저 검색 결과 + 돋보기 + AI 답변 말풍선 --}}
        <rect x="70" y="70" width="350" height="270" rx="14" fill="#fff" stroke="#1A1C20" stroke-width="3"/>
        <path d="M70 84a14 14 0 0 1 14-14h322a14 14 0 0 1 14 14v18H70Z" fill="#1A1C20"/>
        <g fill="#fff"><circle cx="90" cy="87" r="4.5"/><circle cx="106" cy="87" r="4.5"/><circle cx="122" cy="87" r="4.5"/></g>
        <rect x="94" y="120" width="300" height="34" rx="17" fill="#EEF1FF" stroke="#AEBBFF" stroke-width="2"/>
        <circle cx="114" cy="137" r="7" fill="none" stroke="#1E3AFF" stroke-width="3"/><path d="M119 142l5 5" stroke="#1E3AFF" stroke-width="3" stroke-linecap="round"/>
        <rect x="132" y="132" width="120" height="10" rx="5" fill="#AEBBFF"/>
        <rect x="88" y="170" width="314" height="62" rx="10" fill="#1E3AFF"/>
        <rect x="104" y="184" width="26" height="8" rx="4" fill="#fff" fill-opacity=".6"/><rect x="104" y="198" width="168" height="10" rx="5" fill="#fff"/><rect x="104" y="214" width="120" height="7" rx="3.5" fill="#AEBBFF"/>
        <g><circle cx="370" cy="200" r="14" fill="#fff"/><path d="M370 207v-14M364 199l6-6 6 6" fill="none" stroke="#D4200F" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></g>
        <g fill="#DDE3FF"><rect x="104" y="248" width="150" height="10" rx="5"/><rect x="104" y="264" width="220" height="7" rx="3.5"/><rect x="104" y="290" width="130" height="10" rx="5"/><rect x="104" y="306" width="200" height="7" rx="3.5"/></g>
        {{-- 돋보기 --}}
        <g><circle cx="448" cy="296" r="44" fill="#fff" stroke="#1A1C20" stroke-width="10"/><circle cx="448" cy="296" r="28" fill="#DDE3FF"/><path d="M480 330l34 36" stroke="#1A1C20" stroke-width="16" stroke-linecap="round"/><path d="M436 282a18 18 0 0 1 18-6" fill="none" stroke="#fff" stroke-width="5" stroke-linecap="round"/></g>
        {{-- AI 답변 말풍선 --}}
        <g><path d="M404 38h112a14 14 0 0 1 14 14v52a14 14 0 0 1-14 14h-70l-20 18v-18h-22a14 14 0 0 1-14-14V52a14 14 0 0 1 14-14Z" fill="#1A1C20"/>
            <path d="M420 60l6 12 12 6-12 6-6 12-6-12-12-6 12-6Z" fill="#fff"/><rect x="446" y="62" width="64" height="8" rx="4" fill="#AEBBFF"/><rect x="446" y="78" width="46" height="8" rx="4" fill="#5B73FF"/></g>
        @break

    @case('solutions')
        {{-- 직접 만든 도구들: 순위 대시보드 · 상품 진열 · CRM 폰 · 헤드셋 --}}
        <rect x="64" y="66" width="270" height="182" rx="12" fill="#fff" stroke="#1A1C20" stroke-width="3"/>
        <path d="M64 78a12 12 0 0 1 12-12h246a12 12 0 0 1 12 12v14H64Z" fill="#1A1C20"/>
        <g><rect x="82" y="108" width="74" height="122" rx="8" fill="#EEF1FF"/><g fill="#AEBBFF"><rect x="92" y="122" width="54" height="8" rx="4"/><rect x="92" y="140" width="40" height="8" rx="4"/><rect x="92" y="158" width="48" height="8" rx="4"/></g><rect x="92" y="196" width="54" height="22" rx="6" fill="#1E3AFF"/></g>
        <g><rect x="170" y="108" width="146" height="54" rx="8" fill="#1E3AFF"/><path d="M182 148l24-14 22 6 24-20 22 4 30-16" fill="none" stroke="#fff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/></g>
        <g><rect x="170" y="174" width="68" height="56" rx="8" fill="#EEF1FF"/><text x="184" y="214" font-family="Archivo, sans-serif" font-weight="800" font-size="26" fill="#1A1C20">1</text><path d="M210 206l8-12 8 12Z" fill="#D4200F"/></g>
        <g><rect x="248" y="174" width="68" height="56" rx="8" fill="#EEF1FF"/><rect x="260" y="188" width="44" height="7" rx="3.5" fill="#AEBBFF"/><rect x="260" y="202" width="30" height="7" rx="3.5" fill="#DDE3FF"/><rect x="260" y="216" width="38" height="7" rx="3.5" fill="#DDE3FF"/></g>
        {{-- 상품 진열 칸 --}}
        <g><rect x="96" y="272" width="196" height="96" rx="12" fill="#1A1C20"/>
            <g><rect x="112" y="288" width="48" height="64" rx="6" fill="#fff"/><rect x="120" y="296" width="32" height="26" rx="4" fill="#5B73FF"/><rect x="120" y="330" width="26" height="6" rx="3" fill="#AEBBFF"/></g>
            <g><rect x="170" y="288" width="48" height="64" rx="6" fill="#fff"/><rect x="178" y="296" width="32" height="26" rx="4" fill="#1E3AFF"/><rect x="178" y="330" width="26" height="6" rx="3" fill="#AEBBFF"/></g>
            <g><rect x="228" y="288" width="48" height="64" rx="6" fill="#fff"/><rect x="236" y="296" width="32" height="26" rx="4" fill="#AEBBFF"/><rect x="236" y="330" width="26" height="6" rx="3" fill="#AEBBFF"/></g></g>
        {{-- CRM 폰 --}}
        <g><rect x="360" y="110" width="118" height="226" rx="20" fill="#1A1C20"/><rect x="370" y="126" width="98" height="196" rx="10" fill="#fff"/>
            <g><circle cx="388" cy="150" r="10" fill="#5B73FF"/><rect x="404" y="144" width="48" height="7" rx="3.5" fill="#AEBBFF"/><rect x="404" y="155" width="30" height="6" rx="3" fill="#DDE3FF"/></g>
            <g><circle cx="388" cy="186" r="10" fill="#1E3AFF"/><rect x="404" y="180" width="48" height="7" rx="3.5" fill="#AEBBFF"/><rect x="404" y="191" width="30" height="6" rx="3" fill="#DDE3FF"/></g>
            <g><circle cx="388" cy="222" r="10" fill="#AEBBFF"/><rect x="404" y="216" width="48" height="7" rx="3.5" fill="#AEBBFF"/><rect x="404" y="227" width="30" height="6" rx="3" fill="#DDE3FF"/></g>
            <rect x="380" y="282" width="78" height="26" rx="8" fill="#1E3AFF"/></g>
        {{-- 헤드셋 --}}
        <g><path d="M440 380a40 40 0 0 1 80 0" fill="none" stroke="#1A1C20" stroke-width="9" stroke-linecap="round" transform="translate(-6 -30)"/><rect x="424" y="340" width="20" height="34" rx="8" fill="#1E3AFF"/><rect x="510" y="340" width="20" height="34" rx="8" fill="#1E3AFF"/><path d="M434 374c0 16 14 22 32 22" fill="none" stroke="#1A1C20" stroke-width="4" stroke-linecap="round"/><circle cx="470" cy="396" r="6" fill="#1A1C20"/></g>
        @break

    @default
        {{-- 서비스 전체: 가운데 성장 막대를 둘러싼 다섯 채널 칸이 한 흐름으로 이어짐 --}}
        <g fill="none" stroke="#AEBBFF" stroke-width="3" stroke-dasharray="6 8"><path d="M280 220L130 110M280 220L430 110M280 220L106 300M280 220L454 300M280 220V378"/></g>
        <rect x="200" y="140" width="160" height="160" rx="22" fill="#1E3AFF"/>
        <path d="M232 268v-26M262 268v-44M292 268v-36M322 268v-74" stroke="#fff" stroke-width="16" stroke-linecap="round"/>
        <path d="M230 206l30-20 30 10 32-34" fill="none" stroke="#fff" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="322" cy="162" r="7" fill="#D4200F"/>
        {{-- 광고 --}}
        <g><rect x="76" y="70" width="108" height="76" rx="14" fill="#fff" stroke="#1A1C20" stroke-width="3"/><path d="M100 92v32l16-8V100Z" fill="#1E3AFF"/><path d="M116 100h22l18-10v52l-18-10h-22Z" fill="#5B73FF"/><path d="M164 104c6 6 6 14 0 20" fill="none" stroke="#1A1C20" stroke-width="3" stroke-linecap="round"/></g>
        {{-- 리드 --}}
        <g><rect x="376" y="70" width="108" height="76" rx="14" fill="#fff" stroke="#1A1C20" stroke-width="3"/><circle cx="414" cy="98" r="10" fill="#1E3AFF"/><path d="M398 128c0-10 7-16 16-16s16 6 16 16" fill="#1E3AFF"/><rect x="440" y="92" width="30" height="7" rx="3.5" fill="#AEBBFF"/><rect x="440" y="106" width="22" height="7" rx="3.5" fill="#DDE3FF"/><rect x="440" y="120" width="26" height="7" rx="3.5" fill="#DDE3FF"/></g>
        {{-- 리워드 --}}
        <g><rect x="52" y="262" width="108" height="76" rx="14" fill="#fff" stroke="#1A1C20" stroke-width="3"/><rect x="82" y="290" width="48" height="34" rx="5" fill="#1E3AFF"/><rect x="76" y="280" width="60" height="14" rx="4" fill="#5B73FF"/><rect x="102" y="280" width="8" height="44" fill="#fff"/></g>
        {{-- 검색 --}}
        <g><rect x="400" y="262" width="108" height="76" rx="14" fill="#fff" stroke="#1A1C20" stroke-width="3"/><circle cx="446" cy="296" r="16" fill="none" stroke="#1E3AFF" stroke-width="6"/><path d="M458 308l14 14" stroke="#1E3AFF" stroke-width="7" stroke-linecap="round"/></g>
        {{-- 웹사이트 --}}
        <g><rect x="226" y="330" width="108" height="62" rx="12" fill="#1A1C20"/><g fill="#fff"><circle cx="242" cy="344" r="3.5"/><circle cx="254" cy="344" r="3.5"/></g><rect x="238" y="356" width="84" height="26" rx="5" fill="#fff"/><rect x="246" y="364" width="40" height="7" rx="3.5" fill="#1E3AFF"/></g>
    @endswitch
</svg>
