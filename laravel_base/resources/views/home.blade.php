@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('subtitle')
{{ __('messages.home.subtitle') }}
@endsection

@section('gm_list')
@auth
@php
$gm_title = \App\User::getGMTitle('G');
$gm_list = \App\User::getGMList('G');
@endphp
@endauth
<h5 class="card-title">{{ $gm_title }}</h5>
@if(count($gm_list) > 0)
<div class="list-group list-group-flush">
  @foreach($gm_list as $item)
  <a href="{{ route('group_edit', ['group_id' => $item['id']]) }}"
    class="list-group-item list-group-item-action">{{ $item['name'] }}</a>
  @endforeach
</div>
@endif
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
