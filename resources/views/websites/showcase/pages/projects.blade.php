@extends('websites.showcase.layouts.public_app')

@section('pageName', 'Projects')

@section('head')
    <meta name="author" content="SofianeLasri">
    <meta property="article:author" content="SofianeLasri">
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ config('app.url') }}"/>
    <meta property="og:image" content="{{ config('app.url').config('app.img.og.large') }}"/>
    <meta property="og:image:width" content="512"/>
    <meta property="og:image:height" content="512"/>
@endsection

@section('body')
    <x-showcase.navbar/>

    <div id="pageHeader" class="container-fluid bg-dark">
        <div class="container pt-32 pb-16">
            <h1 class="font-black uppercase m-0">Projets</h1>
            <p>Retrouve tous mes projets, du premier au dernier !</p>
        </div>
    </div>

    <div class="container py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex flex-col lg:w-72 gap-4">
                @foreach($filters as $filter)
                    <x-showcase.projects-filter title="{{ $filter['title'] }}" :filters="$filter['filter']"/>
                @endforeach
            </div>
            <div class="flex flex-col grow gap-4">
                @foreach($yearGroupedProjects as $year => $projects)
                    <x-showcase.project-date-container year="{{ $year }}" :projects="$projects"/>
                @endforeach
            </div>
        </div>
    </div>

    <x-showcase.footer/>
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
