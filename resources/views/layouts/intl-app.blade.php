<!DOCTYPE html>
{{--
    영어·일본어 공용 「기존 랜딩 톤」 레이아웃 (Claude 구역, 2026-11-03 INTL) — 한국어 layouts/app 과 같은 CSS·JS(app.css + legacy-reskin).
    회사소개·서비스 상세처럼 한국어가 layouts/app 을 쓰는 페이지의 외국어판이 이걸 쓴다. 헤더·푸터·head 는 외국어용.
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
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/jc.css', 'resources/css/legacy-reskin.css', 'resources/js/jc.js'])
    </head>
    <body class="site jc-legacy jc-intl jc-intl--{{ $intlLocale }}">
        @include('partials.jc.gtm', ['gtmSlot' => 'body'])
        @include('partials.jc.icons')
        @include('partials.intl.header')
        <div id="main">
            @yield('content')
        </div>
        @include('partials.intl.footer')
        @stack('scripts')
    </body>
</html>
