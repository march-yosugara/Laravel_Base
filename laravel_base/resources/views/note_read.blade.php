@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/note_read.css') }}">
@endsection

@section('subtitle')
Note Edit
@endsection

@section('contents')
@auth
<div class="card note_name">
  <h3 id="note_name" class="">{{ $note->note_name }}</h3>
  <h5 id="group_id" class="">{{ $note->group_id }}</h5>
  <h5 id="note_id" class="">{{ $note->note_id }}</h5>
</div>
@if(count($note_items) > 0)
@foreach($note_items as $item)
<div class="card note_item" id="{{ $item->note_item_id }}">
  <div class="card-header note_title">
    <h4 name="note_title" class="">{{ $item->note_item_title }}</h4>
  </div>
  <div class="row item1">
    <h5 class="col-4">{{ $item->str1 }}</h5>
    <h5 class="col-4">{{ $item->int1 }}</h5>
    <h5 class="col-2">{{ $item->unit1 }}</h5>
  </div>
  <div class="row item2">
    <h5 class="col-4">{{ $item->str2 }}</h5>
    <h5 class="col-4">{{ $item->int2 }}</h5>
    <h5 class="col-2">{{ $item->unit2 }}</h5>
  </div>
  <div class="row item_memo">
    <h5 class="col-10">{{ $item->memo }}</h5>
  </div>
</div>
@endforeach
@endif
@endauth
@endsection

@section('scripts')
@endsection
