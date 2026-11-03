<!doctype html>
<html lang="{{ config('intl.locales.'.intl_locale().'.html_lang') }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('pages/home.title') }}</title>
    <link rel="canonical" href="{{ intl_alternates()[intl_locale()] }}">
    @foreach(intl_alternates() as $locale => $url)
        <link rel="alternate" hreflang="{{ $locale }}" href="{{ $url }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ intl_alternates()['ko'] }}">
    <meta property="og:locale" content="{{ config('intl.locales.'.intl_locale().'.og_locale') }}">
</head>
<body><h1>{{ __('pages/home.title') }}</h1></body>
</html>
