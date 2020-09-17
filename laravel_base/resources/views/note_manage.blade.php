@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/note_manage.css') }}">
@endsection

@section('root')
<a href='{{ route('note_manage') }}'>Note Manage</a>
@endsection

@section('subtitle')
Note Manage
@endsection

@section('contents')
@auth
@if(count($groups) > 0)
<form>
  @csrf
  <div class="card group" id="group">
    <div class="card-body">
      <div class="row">
        <select name="group_id" id="group_id" class="form-control">
          <option value=""></option>
          @foreach($groups as $group)
          <option value="{{ $group->group_id }}">{{ $group->group_name }}</option>
          @endforeach
        </select>
        <button id="btn_select" type=“button” class="btn btn-outline-light">　</button>
      </div>
    </div>
  </div>
  <div class="card add_note">
    <input id="note_name" type="text" class="form-control" name="note_name" required maxlength="100"
      placeholder="Note name">
    <button id="btn_create" type=“button” class="btn btn-outline-secondary">Create Note</button>
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
</script>
<script src="{{ asset('/js/note_manage.js') }}"></script>
@endsection
