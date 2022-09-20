<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>
    @yield('head')
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
</head>
<body>
@yield('body')

<x-footer></x-footer>

<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')
</html>
