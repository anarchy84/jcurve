{{-- 플랫 일러스트 아이콘 (코드 네이티브 인라인 SVG).
     2-tone = currentColor(주) + 낮은 투명도(보조). 색은 컨텍스트(.icon-il)에서 상속받아 다크/라이트 자동 적응.
     $name = 아이콘 키. 장식이므로 aria-hidden. --}}
@php($name = $name ?? '')
<svg class="icon-il__svg" viewBox="0 0 48 48" fill="none" aria-hidden="true" focusable="false">
@switch($name)
    @case('performance') {{-- 퍼포먼스: 상승 막대 + 우상향 화살표 --}}
        <path d="M8 31 L19 21 L28 27 L41 13" stroke="currentColor" stroke-opacity=".3" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M33 13 H41 V21" stroke="currentColor" stroke-opacity=".3" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <rect x="7" y="30" width="8" height="11" rx="2.5" fill="currentColor"/>
        <rect x="20" y="23" width="8" height="18" rx="2.5" fill="currentColor"/>
        <rect x="33" y="17" width="8" height="24" rx="2.5" fill="currentColor"/>
        @break
    @case('leadbay') {{-- 리드 수집: 깔때기로 모이는 데이터 --}}
        <circle cx="13" cy="9" r="3" fill="currentColor" fill-opacity=".3"/>
        <circle cx="24" cy="7" r="3" fill="currentColor" fill-opacity=".3"/>
        <circle cx="35" cy="9" r="3" fill="currentColor" fill-opacity=".3"/>
        <path d="M8 16 H40 L28 30 V41 L20 37 V30 Z" fill="currentColor"/>
        @break
    @case('cpa') {{-- CPA: 타깃 + 클릭 커서 --}}
        <circle cx="20" cy="20" r="13" stroke="currentColor" stroke-opacity=".3" stroke-width="3"/>
        <circle cx="20" cy="20" r="5" fill="currentColor" fill-opacity=".3"/>
        <path d="M23 23 L41 29 L33.5 32.5 L38 41 L34 43 L29.5 34.5 L23 40 Z" fill="currentColor"/>
        @break
    @case('rankfree') {{-- 랭크프리: 순위 포디움 + 1위 별 --}}
        <rect x="7" y="26" width="9" height="15" rx="2.5" fill="currentColor" fill-opacity=".42"/>
        <rect x="19.5" y="19" width="9" height="22" rx="2.5" fill="currentColor"/>
        <rect x="32" y="30" width="9" height="11" rx="2.5" fill="currentColor" fill-opacity=".42"/>
        <path d="M24 7 l1.9 3.9 4.3.6 -3.1 3 .7 4.3 -3.8-2 -3.8 2 .7-4.3 -3.1-3 4.3-.6z" fill="currentColor"/>
        @break
    @case('seo') {{-- SEO·AEO·GEO: 돋보기 + AI 스파크 --}}
        <path d="M21 14 l1.7 4 4 1.7 -4 1.7 -1.7 4 -1.7-4 -4-1.7 4-1.7z" fill="currentColor" fill-opacity=".45"/>
        <circle cx="21" cy="21" r="12" stroke="currentColor" stroke-width="3.4"/>
        <path d="M30 30 L41 41" stroke="currentColor" stroke-width="3.6" stroke-linecap="round"/>
        @break
    @case('boostingshop') {{-- 부스팅샵: 쇼핑백(사다리꼴 몸통+손잡이 2고리) + 상승 화살표 --}}
        <path d="M13 18 H35 L37 41 H11 Z" fill="currentColor" fill-opacity=".3"/>
        <path d="M17 18 V15.5 a3.2 3.2 0 0 1 6.4 0 V18" stroke="currentColor" stroke-opacity=".45" stroke-width="2.6" stroke-linecap="round"/>
        <path d="M24.6 18 V15.5 a3.2 3.2 0 0 1 6.4 0 V18" stroke="currentColor" stroke-opacity=".45" stroke-width="2.6" stroke-linecap="round"/>
        <path d="M24 38 V25" stroke="currentColor" stroke-width="3.2" stroke-linecap="round"/>
        <path d="M19 30 L24 25 L29 30" stroke="currentColor" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"/>
        @break
    @case('call2sale') {{-- 콜투세일: 헤드셋(상담·세일즈) --}}
        <path d="M12 27 v-3 a12 12 0 0 1 24 0 v3" stroke="currentColor" stroke-width="3.2" stroke-linecap="round"/>
        <rect x="7" y="25" width="8" height="13" rx="4" fill="currentColor"/>
        <rect x="33" y="25" width="8" height="13" rx="4" fill="currentColor"/>
        <path d="M37 37 v2 a5 5 0 0 1 -5 5 h-7" stroke="currentColor" stroke-opacity=".4" stroke-width="3" stroke-linecap="round"/>
        @break
    @case('reward') {{-- 리워드: 선물상자 + 리본 --}}
        <rect x="9" y="21" width="30" height="19" rx="3" fill="currentColor" fill-opacity=".3"/>
        <rect x="7" y="14" width="34" height="8" rx="2.5" fill="currentColor"/>
        <rect x="21" y="14" width="6" height="26" fill="currentColor"/>
        <path d="M24 14 C24 9 17 8 18 12 C18.7 14.6 24 14 24 14 Z" fill="currentColor"/>
        <path d="M24 14 C24 9 31 8 30 12 C29.3 14.6 24 14 24 14 Z" fill="currentColor"/>
        @break
    @case('wordpress') {{-- 워드프레스: 코드 브래킷 + 문서 --}}
        <rect x="12" y="8" width="24" height="32" rx="3" fill="currentColor" fill-opacity=".3"/>
        <path d="M22 18 L17 24 L22 30" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M28 18 L33 24 L28 30" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        @break
    @default
        <circle cx="24" cy="24" r="14" stroke="currentColor" stroke-width="3.4"/>
@endswitch
</svg>
