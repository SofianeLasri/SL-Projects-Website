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
                <div class="first"></div>
                <div class="second"></div>
                <div class="third"></div>
                <div class="fourth"></div>
                <div class="fifth"></div>
                <div class="sixth"></div>
            </div>
        </div>
    </div>

    <div class="transitionVitrine"></div>
    <div class="transitionDetails">
        <div class="first"></div>
        <div class="second"></div>
        <div class="third"></div>
        <div class="fourth"></div>
    </div>

    <div class="container">
        <h1>Titre génial</h1>
    </div>
@endsection
