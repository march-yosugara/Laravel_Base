@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/guest.css') }}">
@endsection

@section('subtitle')
{{ __('auth.welcome.subtitle') }}
@endsection

@section('contents')
<form method="POST" action="{{ route('login') }}">
  @csrf
  <div class="card board">
    <input type="email" name="email" required="required" placeholder="{{ __('auth.welcome.ph_email') }}"></input>
    <input type="password" name="password" required="required"
      placeholder="{{ __('auth.welcome.ph_password') }}"></input>
    <button type="submit" class="submit_button">{{ __('auth.welcome.btn_signin') }}</button>
  </div>
</form>
<div class="card board">
  <button class="btn btn-outline-primary"
    onclick="location.href='{{ route('register') }}'">{{ __('auth.welcome.btn_register') }}</button>
  <button class="btn btn-outline-light"
    onclick="location.href='{{ route('password.request') }}'">{{ __('auth.welcome.btn_forget_pass') }}</button>
</div>
@endsection

@section('scripts')
@endsection
