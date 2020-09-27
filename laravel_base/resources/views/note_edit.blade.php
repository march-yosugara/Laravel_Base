@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/note_editread.css') }}">
@endsection

@section('root')
<a href='{{ route('note_read', ['group_id' => $note->group_id, 'note_id' => $note->note_id]) }}'>Note Read</a>
@endsection

@section('subtitle')
Note Edit
@endsection

@section('contents')
@auth
<form>
  @csrf
  <div class="card note_card">
    <input id="note_name" type="text" class="form-control" name="note_name" required maxlength="100"
      placeholder="Note name" value="{{ $note->note_name }}">
    <input id="group_id" type="hidden" name="group_id" value="{{ $note->group_id }}">
    <input id="note_id" type="hidden" name="note_id" value="{{ $note->note_id }}">
  </div>
  @if(count($note_items) > 0)
  @foreach($note_items as $item)
  <div class="card note_item" id="{{ $item->note_item_id }}">
    <div class="card-header note_item_title">
      <input name="note_item_title" type="text" class="form-control" maxlength="100" placeholder="Note Item Title"
        value="{{ $item->note_item_title }}">
    </div>
    <div class="card-body">
      <div class="row item1">
        <input name="str1" type="text" class="form-control col-5" maxlength="100" placeholder="Item1 String"
          value="{{ $item->str1 }}">
        <input name="int_val1" type="number" class="form-control col-5 int" placeholder="Item1 Integer"
          value="{{ $item->int_val1 }}">
        <input name="unit1" type="text" class="form-control col-2" maxlength="10" placeholder="Item1 Unit"
          value="{{ $item->unit1 }}">
      </div>
      <div class="row item2">
        <input name="str2" type="text" class="form-control col-5" maxlength="100" placeholder="Item2 String"
          value="{{ $item->str2 }}">
        <input name="int_val2" type="number" class="form-control col-5 int" placeholder="Item2 Integer"
          value="{{ $item->int_val2 }}">
        <input name="unit2" type="text" class="form-control col-2" maxlength="10" placeholder="Item2 Unit"
          value="{{ $item->unit2 }}">
      </div>
      <div class="row item_memo">
        <textarea name="memo" type="text" class="form-control col-12" rows="2"
          placeholder="Note Item Memo">{{ $item->memo }}</textarea>
      </div>
    </div>
  </div>
  @endforeach
  @endif
  <div class="card card_button" id="add_point">
    <button id="btn_add" type=“button” class="btn btn-outline-secondary">＋</button>
  </div>
  <div class="card card_button">
    <button id="btn_update" type=“button” class="btn btn-outline-success">Note update</button>
  </div>
  <div class="card card_button">
    <button id="btn_delete" type=“button” class="btn btn-outline-danger">Note delete</button>
  </div>
</form>
@endauth
@endsection

@section('scripts')
<script>
  var _urls = {
    url_update: '{{ route('note_update') }}',
    url_delete: '{{ route('note_delete') }}',
  };
</script>
<script src="{{ asset('/js/note_edit.js') }}"></script>
@endsection
