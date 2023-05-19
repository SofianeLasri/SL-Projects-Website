<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @hasSection('pageName')
        <title>@yield('pageName') - {{ config('app.name') }}</title>
        <meta property="og:title" content="@yield('pageName') - {{ config('app.name') }}"/>
    @else
        <title>{{ config('app.name') }}</title>
        <meta property="og:title" content="{{ config('app.name') }}"/>
    @endif

    @yield('head')

    @vite(['resources/scss/websites/auth/auth.scss'])
</head>
<body>
@yield('body')

@vite(['resources/js/app.js'])
@stack('scripts')
</body>
</html>
