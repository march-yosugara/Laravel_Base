@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection

@section('subtitle')
Reset Password 1
@endsection

@section('contents')
<div class="card board">
  @if (session('status'))
  <div class="alert alert-success" role="alert">
    {{ session('status') }}
  </div>
  @endif
  <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="form-item">
      <label for="email"></label>
      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
        value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
      @error('email')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="button-panel">
      <button type="submit" class="button">Send Password Reset Link</button>
    </div>
  </form>
</div>
@endsection

@section('scripts')
@endsection
