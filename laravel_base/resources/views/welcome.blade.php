@extends('layouts.app')

@section('styles')
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
      <label for="email"></label>
      <input type="email" name="email" required="required" placeholder="Email Address"></input>
    </div>
    <div class="form-item">
      <label for="password"></label>
      <input type="password" name="password" required="required" placeholder="Password"></input>
    </div>
    <div class="button-panel">
      <button type="submit" class="button">Sign In</button>
    </div>
  </form>
</div>
<div class="card board">
  <a class="btn btn-link" href="{{ route('register') }}">Register</a>
  <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Password</a>
</div>
@endsection

@section('scripts')
@endsection
