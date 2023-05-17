@extends('layouts.form-layout')

@section('pageName', trans("generic.forgotten_password"))

@section('subtitle', trans("generic.forgotten_password").'?')

@section('route', route('password.request'))

@section("form")
    <p class="text-sm text-gray-600">{{ __('generic.forgotten_password_page_explaination') }}</p>
    <div class="flex flex-col">
        <label for="email" class="fw-bold">{{ __('generic.email_adress') }}</label>
        <input type="email" name="email" id="email" placeholder="{{ __('generic.enter_your_email_adress') }}"
               data-form-type="email" value="{{ old('email') }}"
               class="form-control" required>
    </div>

    <button type="submit"
            class="bg-primary hover:bg-primary-dark text-white p-2 mt-4">{{ __('generic.reset_password') }}
    </button>
    <a href="{{ route('login') }}" class="text-sm fw-bold text-center">{{ __('generic.go_back_to_the_login_page') }}</a>
@endsection
