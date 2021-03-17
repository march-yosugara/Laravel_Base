@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
<link rel="stylesheet" href="{{ asset('css/group_manage.css') }}">
@endsection

@section('root')
<a href="{{ route('group_manage') }}" class="list-group-item list-group-item-action">
  {{ __('messages.group_manage.subtitle') }}</a>
@endsection

@section('subtitle')
{{ __('messages.group_manage.subtitle') }}
@endsection

@section('gm_list')
@auth
@php
$gm_title = \App\User::getGMTitle('G');
$gm_list = \App\User::getGMList('G');
@endphp
@endauth
<h5 class="card-title">{{ $gm_title }}</h5>
@if(count($gm_list) > 0)
<div class="list-group list-group-flush">
  @foreach($gm_list as $item)
  <a href="{{ route('group_edit', ['group_id' => $item['id']]) }}"
    class="list-group-item list-group-item-action">{{ $item['name'] }}</a>
  @endforeach
</div>
@endif
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
        onclick="location.href='{{ route('group_edit', ['group_id' => $group->group_id]) }}'">
        {{ __('messages.group_manage.btn_edit') }}</button>
      <button type="button" class=" btn btn-outline-danger btn_remove col-5"
        name='{{ $group->group_id }}'>{{ __('messages.group_manage.btn_remove') }}</button>
    </div>
  </div>
</div>
@endforeach
<div class="card board">
  <h5 class="card_item">{{ __('messages.group_manage.join_group') }}</h5>
  <div class='form-inline card_item'>
    <div class="custom-control custom-radio custom-control-inline">
      <input type="radio" id="add_group_type_name" name="search_type" class="custom-control-input" value="NAME" checked>
      <label class="custom-control-label" for="add_group_type_name">{{ __('messages.group_manage.rdo_name') }}</label>
    </div>
    <div class="custom-control custom-radio custom-control-inline">
      <input type="radio" id="add_group_type_id" name="search_type" class="custom-control-input" value="ID">
      <label class="custom-control-label" for="add_group_type_id">{{ __('messages.group_manage.rdo_id') }}</label>
    </div>
  </div>
  <input id="group_name" type="text" class="form-control" name="add_group_id" required maxlength="100"
    placeholder="{{ __('messages.group_manage.ph_group_id') }}">
  <input id="add_group_pass" type="password" class="form-control" name="add_group_pass" required
    placeholder="{{ __('messages.group_manage.ph_group_pass') }}">
  <button id="btn_add" type="button" class=" btn btn-outline-info">
    {{ __('messages.group_manage.btn_add') }}</button>
</div>
<div class="card board">
  <h5 class="card_item">{{ __('messages.group_manage.create_group') }}</h5>
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
