<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @hasSection('pageName')
        <title>@yield('pageName') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <meta property="og:locale" content="fr_FR"/>
    <meta property="og:locale:alternate" content="en_US"/>

    @yield('head')

    @vite(['resources/scss/websites/showcase/showcase.scss'])
</head>
<body>
@yield('body')

<h3>Bienvenue</h3>
<code>
    {{ auth()->user()->username }}
</code>

{{--<x-footer/>--}}

@vite(['resources/js/app.js'])
@stack('scripts')
</body>
</html>
