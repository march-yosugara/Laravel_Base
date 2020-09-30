@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection

@section('subtitle')
Home
@endsection

@section('contents')
@auth
<div class="card board">
  <h3 class="card-title">My Page</h3>
  You are logged in!
</div>
<div class="card board">
  <h3 class="card-title">Notes</h2>
    <button id="btn_notes" type="button" class=" btn btn-outline-primary"
      onclick="window.open('{{ route('note_manage') }}','_blank')">Go Notes</button>
</div>
@endauth
@guest
<div class="card board">
  <h3 class="card-title">My Page</h3>
  Are You logged in!?
</div>
@endguest
@endsection

@section('scripts')
@endsection
