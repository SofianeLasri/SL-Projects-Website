<!DOCTYPE html>
<html lang="fr">
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

@yield('footer')

<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{ mix('/js/fontawesome/all.js') }}"></script>
@stack('scripts')
</html>
