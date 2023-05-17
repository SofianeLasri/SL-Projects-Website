@extends('websites.auth.layouts.form-layout')

@section('pageName', trans("generic.login"))

@section('subtitle', trans("generic.login_to_your_account"))

@section('route', route('login'))

@section("form")
    <div class="d-flex flex-column">
        <label for="email" class="form-label">{{ __('generic.email_adress') }}</label>
        <input type="email" name="email" id="email" placeholder="{{ __('generic.enter_your_email_adress') }}"
               data-form-type="email" value="{{ old('email') }}"
               class="form-control" required>
    </div>
    <div class="d-flex flex-column">
        <label for="password" class="form-label">{{ __('generic.password') }}</label>
        <input type="password" name="password" id="password" placeholder="{{ __('generic.enter_your_password') }}"
               data-form-type="password"
               class="form-control" required>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember">{{ __('generic.remember_me') }}</label>
    </div>

    <button type="submit"
            class="btn btn-primary p-2 mt-3">{{ __('generic.login_action') }}</button>
    <a href="{{ route('password.request') }}" class="text-center">{{ __('generic.forgotten_password') }}
        ?</a>
@endsection
