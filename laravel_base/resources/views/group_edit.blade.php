@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection

@section('root')
<a href="{{ route('group_manage') }}" class="list-group-item list-group-item-action">Group Manage</a>
<a href="" class="list-group-item list-group-item-action">{{ $group->group_id }}:{{ $group->group_name }}</a>
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
  @csrf
  <input id="group_id" type="hidden" name="group_id" value="{{ $group->group_id }}">
  <input id="group_name" type="text" class="form-control" name="group_name" value="{{ $group->group_name }}" required
    maxlength="100" autofocus placeholder="Group Name">
  <input id="group_pass" type="password" class="form-control" name="group_pass" required placeholder="Group Password">
  <input id="group_pass_confirmation" type="password" class="form-control" name="group_pass_confirmation" required
    placeholder="Password Confirm">
  <div class="row">
    <button id="btn_commit" type="button" class="btn btn-outline-success col-5">Commit</button>
    @if($isCreate != '1')
    <button id="btn_delete" type="button" class=" btn btn-outline-danger col-5">Delete</button>
    @endif
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
