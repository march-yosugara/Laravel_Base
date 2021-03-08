@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/note_manage.css') }}">
@endsection

@section('root')
<a href="{{ route('note_manage') }}"
  class="list-group-item list-group-item-action">{{ __('messages.note_manage.subtitle') }}</a>
@endsection

@section('subtitle')
{{ __('messages.note_manage.subtitle') }}
@endsection

@section('contents')
@auth
@if(count($groups) > 0)
<form>
  @csrf
  <div class="card board" id="group">
    <div class="row">
      <select name="group_id" id="group_id" class="form-control d-inline">
        <option value=""></option>
        @foreach($groups as $group)
        <option value="{{ $group->group_id }}">{{ $group->group_name }}</option>
        @endforeach
      </select>
      <button id="btn_select" type="button" class=" btn btn-outline-light">　</button>
    </div>
  </div>
  <div class="card board">
    <input id="note_name" type="text" class="form-control" name="note_name" required maxlength="100"
      placeholder="{{ __('messages.note_manage.ph_note_name') }}">
    <button id="btn_create" type="button"
      class=" btn btn-outline-secondary">{{ __('messages.note_manage.btn_create') }}</button>
  </div>
</form>
@endif
@endauth
@endsection

@section('scripts')
<script>
  var _urls = {
    url_select: '{{ route('note_group_select') }}',
    url_edit: '{{ route('note_edit', ['group_id' => 'group_id', 'note_id' => 'note_id']) }}',
    url_read: '{{ route('note_read', ['group_id' => 'group_id', 'note_id' => 'note_id']) }}',
    url_create: '{{ route('note_create', ['group_id' => 'group_id']) }}',
  };
  var _js_mes = {
    mes_no_select_group: '{{ __('messages.js.mes_no_select_group') }}',
    btn_edit: '{{ __('messages.js.btn_edit') }}',
    btn_read: '{{ __('messages.js.btn_read') }}',
  };
</script>
<script src="{{ asset('/js/note_manage.js') }}"></script>
@endsection
