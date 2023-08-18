<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @hasSection('pageName')
        <title>@yield('pageName') | {{ __('dashboard/message.meta.name') }}</title>
        <meta property="og:title" content="@yield('pageName') - {{ __('dashboard/message.meta.name') }}"/>
    @else
        <title>{{ config('app.name') }}</title>
        <meta property="og:title" content="{{ config('app.name') }}"/>
    @endif

    @hasSection('pageDesc')
        <meta name="description" content="@yield('pageDesc')">
        <meta property="og:description" content="@yield('pageDesc')"/>
    @else
        <meta name="description" content="{{ __('dashboard/message.meta.desc') }}">
        <meta property="og:description" content="{{ __('dashboard/message.meta.desc') }}"/>
    @endif

    <link rel="icon" type="image/png" href="{{ Vite::asset("resources/images/logos/orange-favicon.png") }}"/>

    <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}"/>
    <meta property="og:locale:alternate" content="en_US"/>

    <meta property="og:url" content="{{ getWebsiteUrl("showcase") }}"/>
    <meta property="og:image" content="{{ Vite::asset("resources/images/logos/og-logo-orange.jpg") }}"/>
    <meta property="og:image:width" content="512"/>
    <meta property="og:image:height" content="512"/>

    @yield('head')

    @vite(['resources/scss/websites/dashboard/dashboard.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    <x-dashboard.sidebar/>
    <div id="pageContent">
        <x-dashboard.breadcrumb>
            @yield('breadcrumbHeaderContent')
        </x-dashboard.breadcrumb>
        @yield('pageContent')
    </div>
</div>

@stack('scripts')
</body>
</html>
