<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name', 'J-Curve Interactive'))</title>
        @yield('meta')
        {{-- 리뉴얼 v3: 공통 SEO head + 새 헤더/푸터(jc.css) + 기존 페이지 새 톤(jc-legacy.css).
             기존 페이지의 문장·구조(app.css 마크업)는 그대로 두고 색·글꼴·부품 모양만 다시 칠한다. --}}
        @include('partials.jc.head')
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/jc.css', 'resources/css/legacy-reskin.css', 'resources/js/jc.js'])
    </head>
    <body class="site jc-legacy">
        @include('partials.jc.icons')
        @include('partials.jc.header')

        @isset($header)
            <section class="page-header">
                {{ $header }}
            </section>
        @endisset

        <div id="main">
        @hasSection('content')
            @yield('content')
        @else
            <main class="site-main">
                {{ $slot ?? '' }}
            </main>
        @endif
        </div>

        @include('partials.jc.footer')

        @stack('scripts')
    </body>
</html>
