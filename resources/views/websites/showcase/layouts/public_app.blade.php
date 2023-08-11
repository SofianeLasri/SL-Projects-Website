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

    @hasSection('pageDesc')
        <meta name="description" content="@yield('pageDesc')">
        <meta property="og:description" content="@yield('pageDesc')"/>
    @else
        <meta name="description" content="{{ __('showcase/message.meta.desc') }}">
        <meta property="og:description" content="{{ __('showcase/message.meta.desc') }}"/>
    @endif

    <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}"/>
    <meta property="og:locale:alternate" content="en_US"/>

    @yield('head')

    @vite(['resources/scss/websites/showcase/showcase.scss'])
</head>
<body>
@yield('body')

{{--<x-footer/>--}}

@vite(['resources/js/app.js'])
@stack('scripts')
</body>
</html>
