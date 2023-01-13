@extends('layouts.public_app')

@section('head')
    <meta name="author" content="SofianeLasri">
    {{--<meta property="article:author" content="SofianeLasri">--}}
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ config('app.url') }}"/>
    <meta property="og:image" content="{{ config('app.url').config('app.img.og.large') }}"/>
    <meta property="og:image:width" content="512"/>
    <meta property="og:image:height" content="512"/>
@endsection

@section('body')
    <x-navbar/>

    {{--Vitrine--}}
    <div class="home-showcase">
        <div class="projects-presentations">
            <div class="desktop-controls">
                <div class="left">
                    <button class="control-button" type="button" title="{{ __('word.previous') }}"><i class="fa-solid fa-chevron-left"></i></button>
                </div>
                <div class="right">
                    <button class="control-button" type="button" title="{{ __('word.next') }}"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="presentation first active">
                <div class="content">
                    <div class="notice-text">
                        <span>Projet en vedette</span>
                    </div>
                    <h1>Starisland</h1>
                    <p>Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod empor incididunt.</p>
                </div>
            </div>
            <div class="presentation second">
                <div class="content">
                    <div class="notice-text">
                        <span>Projet en vedette</span>
                    </div>
                    <h1>Rosewood</h1>
                    <p>Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod empor incididunt.</p>
                </div>
            </div>
            <div class="presentation">
                <div class="content">
                    <div class="notice-text">
                        <span>Projet en vedette</span>
                    </div>
                    <h1>Maisonette 9</h1>
                    <p>Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod empor incididunt.</p>
                </div>
            </div>
        </div>
        <div class="projects-cards">
            <div class="cards">
                <div class="card active first">
                    <div class="title">Starisland</div>
                    <div class="description">Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod empor incididunt.</div>
                </div>
                <div class="card second">
                    <div class="title">Rosewood</div>
                    <div class="description">Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod empor incididunt.</div>
                </div>
                <div class="card third">
                    <div class="title">Maisonette 9</div>
                    <div class="description">Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod empor incididunt.</div>
                </div>
            </div>
            <div class="dots-indicators">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </div>
@endsection
