<!DOCTYPE html>
{{--
    영어·일본어 공용 레이아웃 (Claude 구역, 2026-11-03 다국어 INTL).
    - 한국어 레이아웃(layouts/jc)과 같은 CSS·JS·디자인을 쓰고, 헤더·푸터·head 만 외국어용으로 바꾼다.
    - 문구는 lang/{en,ja}/menu.php, 페이지 문구는 lang/{en,ja}/pages/*.php. 설계 정본 docs/intl/INTL-PLAN.md.
    - 카카오톡 상담 버튼은 한국어 이용자용이라 넣지 않는다.
--}}
@php($intlLocale = intl_locale())
<html lang="{{ config("intl.locales.{$intlLocale}.html_lang", $intlLocale) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'J-Curve Interactive')</title>
        @yield('meta')
        @include('partials.intl.head')
        @include('partials.jc.gtm', ['gtmSlot' => 'head'])
        @stack('head')
        @vite(['resources/css/jc.css', 'resources/js/jc.js'])
    </head>
    <body class="jc-site jc-intl jc-intl--{{ $intlLocale }}">
        @include('partials.jc.gtm', ['gtmSlot' => 'body'])
        @include('partials.jc.icons')
        @include('partials.intl.header')
        <main id="main">
            @yield('content')
        </main>
        @include('partials.intl.footer', ['variant' => trim($__env->yieldContent('footer_variant'))])
        @stack('scripts')
    </body>
</html>
