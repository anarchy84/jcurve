{{--
    아이콘 한 개 그리기: <x-jc.icon name="seo" /> , 크기·색은 class로 (기본 24px, currentColor)
    아이콘 목록은 partials/jc/icons.blade.php (레이아웃에서 한 번 include)
--}}
@props(['name', 'label' => null])
<svg {{ $attributes->merge(['class' => 'jc-ico']) }} viewBox="0 0 24 24" @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" focusable="false" @endif><use href="#ji-{{ $name }}"/></svg>
