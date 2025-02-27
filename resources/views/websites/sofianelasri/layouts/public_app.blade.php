<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @hasSection('pageName')
        <title>@yield('pageName') - Sofiane Lasri</title>
        <meta property="og:title" content="@yield('pageName') - Sofiane Lasri"/>
    @else
        <title>Sofiane Lasri</title>
        <meta property="og:title" content="Sofiane Lasri"/>
    @endif

    @hasSection('pageDesc')
        <meta name="description" content="@yield('pageDesc')">
        <meta property="og:description" content="@yield('pageDesc')"/>
    @else
        <meta name="description" content="Développeur web Full-Stack la semaine, programmeur tout langage le week-end.">
        <meta property="og:description"
              content="Développeur web Full-Stack la semaine, programmeur tout langage le week-end."/>
    @endif

    <meta property="og:locale" content="fr_FR"/>

    <meta property="og:image" content="{{ Vite::asset('resources/images/sofianelasri/sofianelasri.png') }}"/>
    <link rel="icon" type="image/png" href="{{ Vite::asset('resources/images/sofianelasri/sofianelasri.png') }}">
    <meta name="theme-color" content="#f78e57"/>

    @yield('head')

    @vite(['resources/scss/websites/sofianelasri/sofianelasri.scss'])
</head>
<body>
@yield('body')

{{--<x-footer/>--}}

@vite(['resources/js/app.js'])
@stack('scripts')
</body>
</html>
