@extends('websites.auth.layouts.form-layout')

@section('pageName', trans("general/noun.register"))

@section('subtitle', trans("general/verbal.authentication.create_an_account"))

@section('route', route('register'))

@section("form")
    <div class="d-flex flex-column">
        <label for="username" class="form-label">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" placeholder="Entrez un nom d'utilisateur"
               data-form-type="username" value="{{ old('username') }}"
               class="form-control" required>
    </div>
    <div class="d-flex flex-column">
        <label for="email" class="form-label">{{ __('general/compound.email_adress') }}</label>
        <input type="email" name="email" id="email"
               placeholder="{{ __('general/verbal.authentication.enter_your_email_adress') }}"
               data-form-type="email" value="{{ old('email') }}"
               class="form-control" required>
    </div>
    <div class="d-flex flex-column">
        <label for="password" class="form-label">{{ __('general/compound.password') }}</label>
        <input type="password" name="password" id="password"
               placeholder="{{ __('general/verbal.authentication.enter_your_password') }}"
               data-form-type="password"
               class="form-control" required>
    </div>

    <div class="d-flex flex-column">
        <label for="password_confirmation"
               class="form-label">{{ __('general/non-verbal.password_confirmation') }}</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
               placeholder="{{ __('general/verbal.authentication.re_enter_your_password') }}"
               data-form-type="password"
               class="form-control" required>
    </div>

    <div class="form-check">
        <input type="checkbox" name="accept" id="accept">
        <label for="accept">J'accepte les conditions générales d'utilisations qui n'existent pas encore</label>
    </div>

    <button type="submit"
            class="btn btn-primary p-2 mt-3">{{ __('general/verbal.authentication.create_an_account') }}</button>
    <a href="{{ route('login') }}"
       class="text-center">{{ __('general/verbal.authentication.go_back_to_the_login_page') }}</a>
@endsection
