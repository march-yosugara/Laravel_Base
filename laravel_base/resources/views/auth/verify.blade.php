@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('subtitle')
{{ __('auth.verify_email.cardtitle') }}
@endsection

@section('contents')
<form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
  @csrf
  <div class="card card_with_title">
    <div class="card-header">
      {{ __('auth.verify_email.cardtitle') }}
    </div>
    <div class="card-body">
      <p class="text-muted card_item">
        {{ __('auth.verify_email.mes_verify') }}
      </p>
      <button type="submit" class="btn btn-outline-primary card_item">{{ __('auth.verify_email.btn_verify') }}</button>
    </div>
  </div>
  @if (session('resent'))
  <div class="card board">
    <div class="alert alert-primary card_item" role="alert">
      {{ __('auth.verify_email.mes_resent') }}
    </div>
  </div>
  @endif
</form>
@endsection

@section('scripts')
@endsection
