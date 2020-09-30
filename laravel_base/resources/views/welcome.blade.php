@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/guest.css') }}">
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection

@section('subtitle')
Sign In
@endsection

@section('contents')
<div class="card board">
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-item">
      <input type="email" name="email" required="required" placeholder="Email Address"></input>
    </div>
    <div class="form-item">
      <input type="password" name="password" required="required" placeholder="Password"></input>
    </div>
    <div class="button-panel">
      <button type="submit" class="button">Sign In</button>
    </div>
  </form>
</div>
<div class="card board">
  <button class="btn btn-outline-secondary" onclick="location.href='{{ route('register') }}'">Register</button>
  <button class="btn btn-outline-light" onclick="location.href='{{ route('password.request') }}'">Forgot
    Password</button>
</div>
@endsection

@section('scripts')
@endsection
