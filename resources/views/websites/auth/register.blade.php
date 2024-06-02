@extends('websites.auth.layouts.form-layout')

@section('pageName', trans("general/noun.register"))

@section('subtitle', trans("general/verbal.authentication.create_an_account"))

@section('route', route('register'))

@section("form")
    <x-gui.input name="username" type="text" data-form-type="username"
                 label="{{ __('general/compound.username') }}"
                 value="{{ old('username') }}" required/>

    <x-gui.input name="email" type="text" data-form-type="email"
                 label="{{ __('general/compound.email_adress') }}"
                 value="{{ old('email') }}" required/>

    <x-gui.input name="password" type="password" data-form-type="password"
                 label="{{ __('general/compound.password') }}"
                 value="{{ old('password') }}" required/>

    <x-gui.input name="password_confirmation" type="password" data-form-type="password"
                 label="{{ __('general/non-verbal.password_confirmation') }}"
                 value="{{ old('password_confirmation') }}" required/>

    <x-checkbox name="accept" id="accept"
                label="J'accepte les conditions générales d'utilisations qui n'existent pas encore"/>

    <button type="submit"
            class="btn btn-primary p-2 mt-3">{{ __('general/verbal.authentication.create_an_account') }}</button>
    <a href="{{ route('login') }}"
       class="text-center">{{ __('general/verbal.authentication.go_back_to_the_login_page') }}</a>
@endsection
