@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/guest.css') }}">
@endsection

@section('subtitle')
{{ __('auth.register.subtitle') }}
@endsection

@section('contents')
<form method="POST" action="{{ route('register') }}">
  @csrf
  <div class="card board">
    <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
      required autocomplete="name" autofocus placeholder="{{ __('auth.register.ph_name') }}">
    @error('name')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
      required autocomplete="email" placeholder="{{ __('auth.register.ph_email') }}">
    @error('email')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required
      autocomplete="new-password" placeholder="{{ __('auth.register.ph_password') }}">
    @error('password')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
    <input id="password-confirm" type="password" class="" name="password_confirmation" required
      autocomplete="new-password" placeholder="{{ __('auth.register.ph_password_conf') }}">
    <button type="submit" class="submit_button">{{ __('auth.register.btn_register') }}</button>
  </div>
</form>
@endsection

@section('scripts')
@endsection
