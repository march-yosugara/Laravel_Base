@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/note_manage.css') }}">
@endsection

@section('subtitle')
Note Edit
@endsection

@section('contents')
@auth
<div class="card note_name">
  <input id="note_name" type="text" class="form-control" name="note_name" required maxlength="100" placeholder="Note name">
  <input id="group_id" type="hidden" name="group_id" value="{{ $note->group_id }}">
  <input id="note_id" type="hidden" name="note_id" value="{{ $note->note_id }}">
</div>
@if(count($note_items) > 0)
@foreach($note_items as $item)
<div class="card note_item" id="{{ $item->note_item_id }}">
  <div class="card-header note_title">
    <input name="note_title" type="text" class="form-control col-4"
      maxlength="100" placeholder="Item1 String" value="{{ $item->note_item_title }}">
  </div>
  <div class="row item1">
    <input name="str1" type="text" class="form-control col-4"
      maxlength="100" placeholder="Item1 String" value="{{ $item->str1 }}">
    <input name="int1" type="number" class="form-control col-4"
      placeholder="Item1 Integer" value="{{ $item->int1 }}">
    <input name="unit1" type="text" class="form-control col-2"
      maxlength="10" placeholder="Item1 Unit" value="{{ $item->unit1 }}">
  </div>
  <div class="row item2">
    <input name="str2" type="text" class="form-control col-4"
      maxlength="100" placeholder="Item2 String" value="{{ $item->str2 }}">
    <input name="int2" type="number" class="form-control col-4"
      placeholder="Item2 Integer" value="{{ $item->int2 }}">
    <input name="unit2" type="text" class="form-control col-2"
      maxlength="10" placeholder="Item2 Unit" value="{{ $item->unit2 }}">
  </div>
</div>
@endforeach
<div class="card card_button" id="add_point">
  <button id="btn_add" type=“button” class="btn btn-light">＋</button>
</div>
<div class="card card_button">
  <button id="btn_update" type=“button” class="btn btn-success">Note update</button>
</div>
@endif
@endauth
@endsection

@section('scripts')
<script>
  var _urls = {
    url_update: '{{ route('note_update') }}',
  };
</script>
<script src="{{ asset('/js/note_manage.js') }}"></script>
@endsection
