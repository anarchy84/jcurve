<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- 로그인·회원가입·비밀번호 찾기 화면: 검색 결과에 나올 페이지가 아니다 → noindex (SEO-KW-01, 2026-11-04). 옛 log-in·join 주소가 여기로 301 된다 --}}
        <meta name="robots" content="noindex, follow">
        @php
            $jcGuestTitles = ['login' => '로그인', 'register' => '회원가입', 'password.request' => '비밀번호 찾기', 'password.reset' => '비밀번호 재설정', 'verification.notice' => '이메일 인증', 'password.confirm' => '비밀번호 확인'];
            $jcGuestTitle = $jcGuestTitles[request()->route()?->getName()] ?? '회원';
        @endphp
        <title>{{ $jcGuestTitle }} | 제이커브인터렉티브</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
