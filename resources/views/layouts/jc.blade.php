<!DOCTYPE html>
{{-- 리뉴얼 v3 전용 레이아웃 (Claude 구역). 새 디자인 페이지만 이 레이아웃을 쓴다. 구 페이지는 layouts/app. --}}
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', '제이커브인터렉티브')</title>
        @yield('meta')
        @include('partials.jc.head')
        @stack('head')
        @vite(['resources/css/jc.css', 'resources/js/jc.js'])
    </head>
    <body class="jc-site">
        @include('partials.jc.icons')
        @include('partials.jc.header')
        <main id="main">
            @yield('content')
        </main>
        @include('partials.jc.footer', ['variant' => trim($__env->yieldContent('footer_variant'))])
        @include('partials.jc.kakao-float')
        @stack('scripts')
    </body>
</html>
