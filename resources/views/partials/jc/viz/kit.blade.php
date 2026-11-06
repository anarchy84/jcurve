{{--
    페이지 그림 묶음 (2026-11-06 2판) — 페이지 @section('content') 맨 위에서 한 번 @include.
    public/css/jc-viz.css · public/js/jc-viz.js 를 붙인다. 그림 자체는 partials/jc/fig/* 를 페이지마다 하나씩 따로 넣는다.
--}}
@once
    <link rel="stylesheet" href="{{ asset('css/jc-viz.css') }}?v={{ @filemtime(public_path('css/jc-viz.css')) }}">
    @push('scripts')
        <script src="{{ asset('js/jc-viz.js') }}?v={{ @filemtime(public_path('js/jc-viz.js')) }}" defer></script>
    @endpush
@endonce
