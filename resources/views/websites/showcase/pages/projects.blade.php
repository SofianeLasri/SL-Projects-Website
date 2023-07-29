@extends('websites.showcase.layouts.public_app')

@section('pageName', 'Projects')

@section('head')
    <meta name="author" content="SofianeLasri">
    <meta property="article:author" content="SofianeLasri">
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ getWebsiteUrl("showcase") }}"/>
    <meta property="og:image" content="{{ Vite::asset("resources/images/logos/og-logo-orange.jpg") }}"/>
    <meta property="og:image:width" content="512"/>
    <meta property="og:image:height" content="512"/>
@endsection

@section('body')
    <x-showcase.navbar/>

    <div id="pageHeader" class="project-page-header container-fluid bg-dark">
        <div class="container">
            <h1 class="font-black text-uppercase m-0">Projets</h1>
            <p>Retrouve tous mes projets, du premier au dernier !</p>
        </div>
    </div>

    <div class="project-page-container">
        <div class="filters-col d-flex flex-column gap-3">
            @foreach($filters as $filter)
                <x-showcase.projects-filter title="{{ $filter['title'] }}" :filters="$filter['filter']"/>
            @endforeach
        </div>
        <div class="d-flex flex-column flex-grow-1 gap-3">
            @foreach($yearGroupedProjects as $year => $projects)
                <x-showcase.project-date-container year="{{ $year }}" :projects="$projects"/>
            @endforeach
        </div>
    </div>

    <x-showcase.footer/>
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
