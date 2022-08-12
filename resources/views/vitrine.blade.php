@extends('layouts.public_app')

@section('body')
    <x-navbar></x-navbar>

    <div class="vitrine">
        <div id="backgroundVideo">
            <noscript>
                <video autoplay loop muted>
                    <source src="{{ asset('videos/vitrine/starisland-1080p-2000kbps.webm') }}" type="video/webm">
                </video>
            </noscript>
            <div id="videoOverlay"></div>
        </div>

        <div class="content">
            <div class="text-content">
                <div class="title">
                    <span class="first">Sofiane Lasri's</span>
                    <span class="second">Projects</span>
                </div>
                <div class="description">
                    <p>Développeur web Full-Stack,
                    <br>UX & Game Designer.</p>
                </div>
            </div>

            <div class="projectsForms">
                <div class="projectForm first"></div>
                <div class="projectForm second"></div>
                <div class="projectForm third"></div>
                <div class="projectForm fourth"></div>
                <div class="projectForm fifth"></div>
                <div class="projectForm sixth"></div>
            </div>
        </div>
    </div>
@endsection
