@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection

@section('subtitle')
@if ($isCreate == '1')
Group Create
@else
Group Update
@endif
@endsection

@section('contents')
@auth
<div class="card board">
  <div class="card-body">
    <form>
      @csrf
      <input id="group_id" type="hidden" name="group_id" value="{{ $group->group_id }}">
      <div class="form-item">
        <label for="group_name"></label>
        <input id="group_name" type="text" class="form-control" name="group_name" value="{{ $group->group_name }}"
          required maxlength="100" autofocus placeholder="Group Name">
      </div>
      <div class="form-item">
        <label for="group_pass"></label>
        <input id="group_pass" type="password" class="form-control" name="group_pass" required
          placeholder="Group Password">
      </div>
      <div class="form-item">
        <label for="group_pass_confirmation"></label>
        <input id="group_pass_confirmation" type="password" class="form-control" name="group_pass_confirmation" required
          placeholder="Password Confirm">
      </div>
      <div class="button-panel">
        <button id="btn_commit" type="button" class="button">Commit</button>
        @if($isCreate != '1')
        <button id="btn_delete" type=“button” class="button">Delete</button>
        @endif
      </div>
    </form>
  </div>
</div>
@endauth
@endsection

@section('scripts')
<script>
  var _urls = {
    url_manage: '{{ route('group_manage') }}',
    url_create: '{{ route('group_create') }}',
    url_update: '{{ route('group_update') }}',
    url_delete: '{{ route('group_delete') }}',
  };
  var isCreate = '{{ $isCreate }}';
</script>
<script src="{{ asset('/js/group_edit.js') }}"></script>
@endsection
