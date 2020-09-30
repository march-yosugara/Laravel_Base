@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/group_manage.css') }}">
@endsection

@section('root')
<a href="{{ route('group_manage') }}" class="list-group-item list-group-item-action">Group Manage</a>
@endsection

@section('subtitle')
Group Manage
@endsection

@section('contents')
@auth
@foreach ($groups as $group)
<div class="card card_with_title">
  <div class="card-header">
    <p class="card-title group_name">{{ $group->group_name }}</p>
  </div>
  <div class="card-body">
    <p class="card-subtitle text-muted group_id">ID : {{ $group->group_id }}</p>
    <div class="row">
      <button type="button" class=" btn btn-outline-primary col-5"
        onclick="location.href='{{ route('group_edit', ['group_id' => $group->group_id]) }}'">Edit</button>
      <button type="button" class=" btn btn-outline-danger btn_remove col-5"
        name='{{ $group->group_id }}'>Remove</button>
    </div>
  </div>
</div>
@endforeach
@if(count($add_groups) > 0)
<div class="card board">
  <select name="add_group_id" id="add_group_id" class="form-control">
    <option value=""></option>
    @foreach($add_groups as $group)
    <option value="{{ $group->group_id }}">{{ $group->group_name }}</option>
    @endforeach
  </select>
  <input id="add_group_pass" type="password" class="form-control" name="add_group_pass" required
    placeholder="Group Password">
  <button id="btn_add" type="button" class=" btn btn-outline-info">Add</button>
</div>
@endif
<div class="card board">
  <button id="btn_create" type="button" class=" btn btn-outline-secondary"
    onclick="location.href='{{ route('group_edit', ['group_id' => '0']) }}'">＋</button>
</div>
@endauth
@endsection

@section('scripts')
<script>
  var _urls = {
    url_add: '{{ route('group_add') }}',
    url_remove: '{{ route('group_remove') }}',
  };
</script>
<script src="{{ asset('/js/group_manage.js') }}"></script>
@endsection
