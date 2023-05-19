@extends('websites.auth.layouts.form-layout')

@section('pageName', trans("compound.forgotten_password"))

@section('subtitle', trans("compound.forgotten_password").'?')

@section('route', route('password.request'))

@section("form")
    <p class="">{{ __('verbal.authentication.forgotten_password_page_explaination') }}</p>
    <div class="d-flex flex-column">
        <label for="email" class="form-label">{{ __('compound.email_adress') }}</label>
        <input type="email" name="email" id="email" placeholder="{{ __('verbal.authentication.enter_your_email_adress') }}"
               data-form-type="email" value="{{ old('email') }}"
               class="form-control" required>
    </div>

    <button type="submit"
            class="btn btn-primary p-2 mt-3">{{ __('verbal.authentication.reset_password') }}
    </button>
    <a href="{{ route('login') }}" class="text-center">{{ __('verbal.authentication.go_back_to_the_login_page') }}</a>
@endsection
