@extends('websites.auth.layouts.main-layout')

@section("body")
    <div
            class="authentication-container">
        <div class="logo">
            <x-logo-short/>
        </div>
        <h4 class="text-white">@yield("subtitle")</h4>
        <div class="w-100 d-flex flex-column">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif (session('status'))
                <div class="alert alert-success">
                    {!! Str::markdown(session('status')) !!}
                </div>
            @endif
            <form method="post" class="p-3 bg-white d-flex flex-column gap-3 selection-primary"
                  action="@yield("route")">
                @csrf
                @yield("form")
            </form>
        </div>
    </div>
@endsection
