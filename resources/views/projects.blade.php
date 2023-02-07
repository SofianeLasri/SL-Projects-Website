@extends('layouts.public_app')

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
    <x-navbar/>

    <div id="pageHeader" class="w-full bg-dark">
        <div class="custom-container pt-32 pb-16">
            <h1 class="font-black uppercase m-0">Projets</h1>
            <p>Retrouve tous mes projets, du premier au dernier !</p>
        </div>
    </div>

    <div class="custom-container py-8">
        <div class="flex">
            <div class="flex flex-col gap-4">
                @foreach($filters as $filter)
                    <x-projects-filter title="{{ $filter['title'] }}" :filters="$filter['filter']"/>
                @endforeach
            </div>
            <div class="flex flex-col grow pl-8 gap-8">
                @foreach($yearGroupedProjects as $year => $projects)
                    <x-project-date-container year="{{ $year }}" :projects="$projects"/>
                @endforeach
            </div>
        </div>
    </div>

    <x-footer/>
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
