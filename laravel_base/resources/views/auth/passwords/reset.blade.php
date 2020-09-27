@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/guest.css') }}">
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection

@section('subtitle')
Reset Password 2
@endsection

@section('contents')
<div class="card">
  <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="form-item">
      <label for="email"></label>
      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
      @error('email')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="form-item">
      <label for="password"></label>
      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
        required autocomplete="new-password" placeholder="New Password">
      @error('password')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="form-item">
      <label for="password-confirm"></label>
      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
        autocomplete="new-password" placeholder="New Password Confirm">
    </div>
    <div class="button-panel">
      <button type="submit" class="button">Reset Password</button>
    </div>
  </form>
</div>
@endsection

@section('scripts')
@endsection
