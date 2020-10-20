@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('subtitle')
{{ __('messages.home.subtitle') }}
@endsection

@section('contents')
@auth
<div class="card board">
  <h3 class="card-title">{{ __('messages.home.card_title_mypage') }}</h3>
  {{ __('messages.home.mes_mypage') }}
</div>
<div class="card board">
  <h3 class="card-title">{{ __('messages.home.service_notes') }}</h2>
    <button id="btn_notes" type="button" class=" btn btn-outline-primary"
      onclick="window.open('{{ route('note_manage') }}','_blank')">{{ __('messages.home.btn_notes') }}</button>
</div>
@endauth
@guest
<div class="card board">
  <h3 class="card-title">{{ __('messages.home.card_title_mypage') }}</h3>
  {{ __('messages.home.mes_guest') }}
</div>
@endguest
@endsection

@section('scripts')
@endsection
