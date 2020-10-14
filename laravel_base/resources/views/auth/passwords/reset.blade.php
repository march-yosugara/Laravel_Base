@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/guest.css') }}">
@endsection

@section('subtitle')
{{ __('auth.reset_email.subtitle2') }}
@endsection

@section('contents')
<form method="POST" action="{{ route('password.update') }}">
  @csrf
  <div class="card board">
    <input type="hidden" name="token" value="{{ $token }}">
    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
      value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
      placeholder="{{ __('auth.reset_email.ph_email') }}">
    @error('email')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required
      autocomplete="new-password" placeholder="{{ __('auth.reset_email.ph_new_password') }}">
    @error('password')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
    <input id="password-confirm" type="password" class="" name="password_confirmation" required
      autocomplete="new-password" placeholder="{{ __('auth.reset_email.ph_new_password_conf') }}">
    <button type="submit" class="submit_button">{{ __('auth.reset_email.btn_reset') }}</button>
</form>
</div>
@endsection

@section('scripts')
@endsection
