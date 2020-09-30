@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/note_editread.css') }}">
@endsection

@section('root')
<a href="{{ route('note_edit', ['group_id' => $note->group_id, 'note_id' => $note->note_id]) }}"
  class="list-group-item list-group-item-action">Note Read</a>
@endsection

@section('subtitle')
Note Read
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
      <p class="col-12">{{ $item->memo }}</p>
    </div>
  </div>
</div>
@endforeach
@endif
@endauth
@endsection

@section('scripts')
@endsection
