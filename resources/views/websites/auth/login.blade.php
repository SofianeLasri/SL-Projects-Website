@extends('websites.auth.layouts.form-layout')

@section('pageName', trans("general/noun.login"))

@section('subtitle', trans("general/verbal.authentication.sign_into_your_account"))

@section('route', route('login'))

@section("form")
    <x-input name="username" type="text" data-form-type="username"
             label="{{ __('general/compound.username') }}"
             value="{{ old('username') }}"
             placeholder="{{ __('general/verbal.authentication.enter_your_username') }}" required/>

    <x-input name="password" type="password" data-form-type="password"
             label="{{ __('general/compound.password') }}"
             value="{{ old('password') }}"
             placeholder="{{ __('general/verbal.authentication.enter_your_password') }}" required/>

    <x-checkbox name="remember" id="remember" label="{{ __('general/verbal.authentication.remember_me') }}"/>

    <button type="submit"
            class="btn btn-primary p-2 mt-3">{{ __('general/verb.to_log_in') }}</button>
    <a href="{{ route('password.request') }}" class="text-center">{{ __('general/compound.forgotten_password') }}
        ?</a>

    @php
        if($request->has('redirect'))
            Session::put('url.intended', $request->get('redirect'));
    @endphp
@endsection
