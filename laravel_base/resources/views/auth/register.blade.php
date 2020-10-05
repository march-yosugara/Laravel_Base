@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/guest.css') }}">
@endsection

@section('subtitle')
Register
@endsection

@section('contents')
<div class="card board">
  <form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-item">
      <label for="name"></label>
      <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
        required autocomplete="name" autofocus placeholder="Name">
      @error('name')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="form-item">
      <label for="email"></label>
      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
        value="{{ old('email') }}" required autocomplete="email" placeholder="Mail">
      @error('email')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="form-item">
      <label for="password"></label>
      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
        required autocomplete="new-password" placeholder="Password">
      @error('password')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="form-item">
      <label for="password-confirm"></label>
      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
        autocomplete="new-password" placeholder="Password Confirm">
    </div>
    <div class="button-panel">
      <button type="submit" class="button">Register</button>
    </div>
  </form>
</div>
@endsection

@section('scripts')
@endsection
