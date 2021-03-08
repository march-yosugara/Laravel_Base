@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/note_editread.css') }}">
@endsection

@section('root')
<a href=""
  class="list-group-item list-group-item-action">{{ $note->group_id }}:{{ $note->note_id }}:{{ $note->note_name }}</a>
<a href="{{ route('note_read', ['group_id' => $note->group_id, 'note_id' => $note->note_id]) }}"
  class="list-group-item list-group-item-action">⇔{{ __('messages.note_read.subtitle') }}</a>
@endsection

@section('subtitle')
{{ __('messages.note_edit.subtitle') }}
@endsection

@section('contents')
@auth
<form>
  @csrf
  <div class="card board">
    <input id="note_name" type="text" class="form-control" name="note_name" required maxlength="100"
      placeholder="{{ __('messages.note_edit.ph_note_name') }}" value="{{ $note->note_name }}">
    <input id="group_id" type="hidden" name="group_id" value="{{ $note->group_id }}">
    <input id="note_id" type="hidden" name="note_id" value="{{ $note->note_id }}">
  </div>
  @if(count($note_items) > 0)
  @foreach($note_items as $item)
  <div class="card card_with_title note_item" id="{{ $item->note_item_id }}">
    <div class="card-header note_item_title row">
      <input name="note_item_title" type="text" class="form-control col-10" maxlength="100"
        placeholder="{{ __('messages.note_edit.ph_note_item_title') }}" value="{{ $item->note_item_title }}">
      <button type="button" class="btn btn-outline-danger rounded-circle p-0 btn_remove col-2">×</button>
    </div>
    <div class="card-body">
      <div class="row item1">
        <input name="str1" type="text" class="form-control col-5" maxlength="100"
          placeholder="{{ __('messages.note_edit.ph_str1') }}" value="{{ $item->str1 }}">
        <input name="int_val1" type="number" class="form-control col-5 int"
          placeholder="{{ __('messages.note_edit.ph_int_val1') }}" value="{{ $item->int_val1 }}">
        <input name="unit1" type="text" class="form-control col-2" maxlength="10"
          placeholder="{{ __('messages.note_edit.ph_unit1') }}" value="{{ $item->unit1 }}">
      </div>
      <div class="row item2">
        <input name="str2" type="text" class="form-control col-5" maxlength="100"
          placeholder="{{ __('messages.note_edit.ph_str2') }}" value="{{ $item->str2 }}">
        <input name="int_val2" type="number" class="form-control col-5 int"
          placeholder="{{ __('messages.note_edit.ph_int_val2') }}" value="{{ $item->int_val2 }}">
        <input name="unit2" type="text" class="form-control col-2" maxlength="10"
          placeholder="{{ __('messages.note_edit.ph_unit2') }}" value="{{ $item->unit2 }}">
      </div>
      <div class="row item_memo">
        <textarea name="memo" type="text" class="form-control col-12" rows="2"
          placeholder="{{ __('messages.note_edit.ph_memo') }}">{{ $item->memo }}</textarea>
      </div>
    </div>
  </div>
  @endforeach
  @endif
  <div class="card board" id="add_point">
    <button id="btn_add" type="button" class="btn btn-outline-secondary">＋</button>
  </div>
  <div class="card board">
    <button id="btn_update" type="button"
      class="btn btn-outline-success">{{ __('messages.note_edit.btn_update') }}</button>
  </div>
  <div class="card board">
    <button id="btn_delete" type="button"
      class="btn btn-outline-danger">{{ __('messages.note_edit.btn_delete') }}</button>
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
  var _js_mes = {
    ph_note_item_title: '{{ __('messages.note_edit.ph_note_item_title') }}',
    ph_str1: '{{ __('messages.note_edit.ph_str1') }}',
    ph_int_val1: '{{ __('messages.note_edit.ph_int_val1') }}',
    ph_unit1: '{{ __('messages.note_edit.ph_unit1') }}',
    ph_str2: '{{ __('messages.note_edit.ph_str2') }}',
    ph_int_val2: '{{ __('messages.note_edit.ph_int_val2') }}',
    ph_unit2: '{{ __('messages.note_edit.ph_unit2') }}',
    ph_memo: '{{ __('messages.note_edit.ph_memo') }}',
  };
</script>
<script src="{{ asset('/js/note_edit.js') }}"></script>
@endsection
