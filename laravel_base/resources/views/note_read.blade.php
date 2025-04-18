@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/note_editread.css') }}">
@endsection

@section('root')
<a href=""
  class="list-group-item list-group-item-action">{{ $note->group_id }}:{{ $note->note_id }}:{{ $note->note_name }}</a>
<a href="{{ route('note_edit', ['group_id' => $note->group_id, 'note_id' => $note->note_id]) }}"
  class="list-group-item list-group-item-action">⇔{{ __('messages.note_edit.subtitle') }}</a>
@endsection

@section('subtitle')
{{ __('messages.note_read.subtitle') }}
@endsection

@section('gm_list')
@auth
@php
$gm_title = \App\User::getGMTitle('M', $note->group_id);
$gm_list = \App\User::getGMList('M', $note->group_id);
@endphp
@endauth
<h5 class="card-title">{{ $gm_title }}</h5>
@if(count($gm_list) > 0)
<ul class="list-group list-group-flush">
  @foreach($gm_list as $item)
  <li class="list-group-item">{{ $item['name'] }}</li>
  @endforeach
</ul>
@endif
@endsection

@section('contents')
@auth
<div class="card board note_title">
  <p>{{ $note->note_name }}</p>
</div>
@if(count($note_items) > 0)
@foreach($note_items as $item)
<div class="card card_with_title" id="{{ $item->note_item_id }}">
  <div class="card-header note_title">
    <p class="card-title">{{ $item->note_item_title }}</p>
  </div>
  <div class="card-body">
    <div class="row item1">
      <p class="col-5">{{ $item->str1 }}</p>
      <p class="col-5 int">{{ $item->int_val1 }}</p>
      <p class="col-2">{{ $item->unit1 }}</p>
    </div>
    <div class="row item2">
      <p class="col-5">{{ $item->str2 }}</p>
      <p class="col-5 int">{{ $item->int_val2 }}</p>
      <p class="col-2">{{ $item->unit2 }}</p>
    </div>
    <div class="row item_memo">
      <p class="col-12 memo">{{ $item->memo }}</p>
    </div>
  </div>
</div>
@endforeach
@endif
@endauth
@endsection

@section('scripts')
@endsection
