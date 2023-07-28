@extends('websites.auth.layouts.form-layout')

@section('pageName', trans("general/noun.login"))

@section('subtitle', trans("general/verbal.authentication.sign_into_your_account"))

@section('route', route('login'))

@section("form")
    <div class="d-flex flex-column">
        <label for="username" class="form-label">{{ __('general/compound.username') }}</label>
        <input type="text" name="username" id="username" placeholder="{{ __('general/verbal.authentication.enter_your_username') }}"
               data-form-type="username" value="{{ old('username') }}"
               class="form-control" required>
    </div>
    <div class="d-flex flex-column">
        <label for="password" class="form-label">{{ __('general/compound.password') }}</label>
        <input type="text" name="password" id="password" placeholder="{{ __('general/verbal.authentication.enter_your_password') }}"
               data-form-type="password"
               class="form-control" required>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember">{{ __('general/verbal.authentication.remember_me') }}</label>
    </div>

    <button type="submit"
            class="btn btn-primary p-2 mt-3">{{ __('general/verb.to_log_in') }}</button>
    <a href="{{ route('password.request') }}" class="text-center">{{ __('general/compound.forgotten_password') }}
        ?</a>

    @php
        if($request->has('redirect'))
            Session::put('url.intended', $request->get('redirect'));
    @endphp
@endsection
