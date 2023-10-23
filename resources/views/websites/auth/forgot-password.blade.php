@extends('websites.auth.layouts.form-layout')

@section('pageName', trans("general/compound.forgotten_password"))

@section('subtitle', trans("general/compound.forgotten_password").'?')

@section('route', route('password.request'))

@section("form")
    <p class="">{{ __('general/verbal.authentication.forgotten_password_page_explaination') }}</p>

    <x-input name="email" type="text" data-form-type="email"
             label="{{ __('general/compound.email_adress') }}"
             value="{{ old('email') }}" required/>

    <button type="submit"
            class="btn btn-primary p-2 mt-3">{{ __('general/verbal.authentication.reset_password') }}
    </button>
    <a href="{{ route('login') }}"
       class="text-center">{{ __('general/verbal.authentication.go_back_to_the_login_page') }}</a>
@endsection
