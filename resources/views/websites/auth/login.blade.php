@extends('websites.auth.layouts.form-layout')

@section('pageName', trans("noun.login"))

@section('subtitle', trans("verbal.authentication.sign_into_your_account"))

@section('route', route('login'))

@section("form")
    <div class="d-flex flex-column">
        <label for="email" class="form-label">{{ __('compound.email_adress') }}</label>
        <input type="email" name="email" id="email" placeholder="{{ __('verbal.authentication.enter_your_email_adress') }}"
               data-form-type="email" value="{{ old('email') }}"
               class="form-control" required>
    </div>
    <div class="d-flex flex-column">
        <label for="password" class="form-label">{{ __('compound.password') }}</label>
        <input type="password" name="password" id="password" placeholder="{{ __('verbal.authentication.enter_your_password') }}"
               data-form-type="password"
               class="form-control" required>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember">{{ __('verbal.authentication.remember_me') }}</label>
    </div>

    <button type="submit"
            class="btn btn-primary p-2 mt-3">{{ __('verb.to_log_in') }}</button>
    <a href="{{ route('password.request') }}" class="text-center">{{ __('compound.forgotten_password') }}
        ?</a>
@endsection
