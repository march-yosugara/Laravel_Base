@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/guest.css') }}">
@endsection

@section('subtitle')
{{ __('auth.reset_email.subtitle1') }}
@endsection

@section('contents')
<form method="POST" action="{{ route('password.email') }}">
  @csrf
  <div class="card board">
    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
      required autocomplete="email" autofocus placeholder="{{ __('auth.reset_email.ph_email') }}">
    @error('email')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
    <button type="submit" class="submit_button card_item">{{ __('auth.reset_email.btn_send') }}</button>
  </div>
  @if (session('status'))
  <div class="card board">
    <div class="alert alert-primary card_item" role="alert">
      {{ session('status') }}
    </div>
  </div>
  @endif
</form>
@endsection

@section('scripts')
@endsection
