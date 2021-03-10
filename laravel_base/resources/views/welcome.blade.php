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
    <input type="email" name="email" required placeholder="{{ __('auth.welcome.ph_email') }}"
      value="{{ old('email') ? old('email') : Cookie::get(env('C_ID')) }}" autocomplete="email" autofocus></input>
    <input type="password" name="password" required placeholder="{{ __('auth.welcome.ph_password') }}"
      autocomplete="current-password" @error('email') class="is-invalid" @enderror @error('password') class="is-invalid"
      @enderror></input>
    @error('email')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
    @enderror
    @error('password')
    <div class="invalid-feedback">
      {{ $message }}
    </div>
    @enderror
    <div class="custom-control custom-switch switch-div">
      <input type="hidden" name="remember_id" value="0">
      <input type="checkbox" class="custom-control-input" id="remember_id" name="remember_id" value="1"
        {{ Cookie::get(env('C_ID')) ? " checked" : "" }}>
      <label class="custom-control-label" for="remember_id">{{ __('auth.welcome.remember_id') }}</label>
    </div>
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
