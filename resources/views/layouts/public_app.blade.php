<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @hasSection('pageName')
        <title>@yield('pageName') - {{ config('app.name') }}</title>
        <meta property="og:title" content="@yield('pageName') - {{ config('app.name') }}" />
    @else
        <title>{{ config('app.name') }}</title>
        <meta property="og:title" content="{{ config('app.name') }}" />
    @endif

    @hasSection('pageDesc')
        <meta name="description" content="@yield('pageDesc')">
        <meta property="og:description" content="@yield('pageDesc')"/>
    @else
        <meta name="description" content="{{ __('generic.global_website_description') }}">
        <meta property="og:description" content="{{ __('generic.global_website_description') }}"/>
    @endif

    <meta property="og:locale" content="fr_FR" />
    <meta property="og:locale:alternate" content="en_US" />

    @yield('head')

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
</head>
<body>
@yield('body')

<x-footer></x-footer>

<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')
</html>
