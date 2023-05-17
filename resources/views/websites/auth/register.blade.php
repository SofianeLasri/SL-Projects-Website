@extends('layouts.form-layout')

@section('pageName', "Inscription")

@section('subtitle', "Créer un compte")

@section('route', route('register'))

@section("form")
    <div class="flex flex-col">
        <label for="name" class="fw-bold">Nom à afficher</label>
        <input type="text" name="name" id="name" placeholder="Entrez votre nom"
               data-form-type="name" value="{{ old('name') }}"
               class="form-control" required>
    </div>
    <div class="flex flex-col">
        <label for="email" class="fw-bold">{{ __('generic.email_adress') }}</label>
        <input type="email" name="email" id="email" placeholder="{{ __('generic.enter_your_email_adress') }}"
               data-form-type="email" value="{{ old('email') }}"
               class="form-control" required>
    </div>
    <div class="flex flex-col">
        <label for="password" class="fw-bold">{{ __('generic.password') }}</label>
        <input type="password" name="password" id="password" placeholder="{{ __('generic.enter_your_password') }}"
               data-form-type="password"
               class="form-control" required>
    </div>

    <div class="flex flex-col">
        <label for="password_confirmation" class="fw-bold">{{ __('generic.password_confirmation') }}</label>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('generic.enter_your_password_confirmation') }}"
               data-form-type="password"
               class="form-control" required>
    </div>

    <div class="form-check">
        <input type="checkbox" name="accept" id="accept">
        <label for="accept">J'accepte les conditions générales d'utilisations qui n'existent pas encore</label>
    </div>

    <button type="submit"
            class="bg-primary hover:bg-primary-dark text-white p-2 mt-4">Créer un compte</button>
    <a href="{{ route('login') }}" class="text-sm fw-bold text-center">{{ __('generic.go_back_to_the_login_page') }}</a>
@endsection
