@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('root')
<a href="{{ route('group_manage') }}" class="list-group-item list-group-item-action">
  {{ __('messages.group_manage.subtitle') }}</a>
@if ($isCreate != '1')
<a href="" class="list-group-item list-group-item-action">{{ $group->group_id }}:{{ $group->group_name }}</a>
@endif
@endsection

@section('subtitle')
@if ($isCreate == '1')
{{ __('messages.group_edit.subtitle_create') }}
@else
{{ __('messages.group_edit.subtitle_update') }}
@endif
@endsection

@section('gm_list')
@auth
@php
if ($isCreate == '1') {
$gm_title = \App\User::getGMTitle('G');
$gm_list = \App\User::getGMList('G');
} else {
$gm_title = \App\User::getGMTitle('M', $group->group_id);
$gm_list = \App\User::getGMList('M', $group->group_id);
}
@endphp
@endauth
<h5 class="card-title">{{ $gm_title }}</h5>
@if(count($gm_list) > 0)
@if ($isCreate == '1')
<div class="list-group list-group-flush">
  @foreach($gm_list as $item)
  <a href="{{ route('group_edit', ['group_id' => $item['id']]) }}"
    class="list-group-item list-group-item-action">{{ $item['name'] }}</a>
  @endforeach
</div>
@else
<ul class="list-group list-group-flush">
  @foreach($gm_list as $item)
  <li class="list-group-item">{{ $item['name'] }}</li>
  @endforeach
</ul>
@endif
@endif
@endsection

@section('contents')
@auth
@csrf
<input type="hidden" name="is_create" value="{{ $isCreate }}">
<input type="hidden" name="group_id" value="{{ $group->group_id }}">
<div class="card board">
  <input id="group_name" type="text" class="form-control" name="group_name" value="{{ $group->group_name }}" required
    maxlength="100" autofocus placeholder="{{ __('messages.group_edit.ph_group_name') }}">
  @if ($isCreate != '1')
  <div class="custom-control custom-switch card_item">
    <input type="checkbox" class="custom-control-input" id="change_pass" name="change_pass" value="1">
    <label class="custom-control-label" for="change_pass">{{ __('messages.group_edit.change_pass') }}</label>
  </div>
  @endif
  <div id='pass_update' @if ($isCreate !='1' )class='d-none' @endif>
    <input id="group_pass" type="password" class="form-control card_item" name="group_pass" required
      placeholder="{{ __('messages.group_edit.ph_new_group_pass') }}">
    <input id="group_pass_confirmation" type="password" class="form-control card_item" name="group_pass_confirmation"
      required placeholder="{{ __('messages.group_edit.ph_new_group_pass_confirm') }}">
  </div>
</div>
<div class="card board">
  @if ($isCreate =='1' )
  <div class="row">
    <button id="btn_create" type="button" class="btn btn-outline-success w-100">
      {{ __('messages.group_edit.btn_create') }}</button>
  </div>
  @else
  <h5 class="card_item">{{ __('messages.group_edit.commit_sign') }}</h5>
  <input id="group_pass" type="password" class="form-control" name="sign_group_pass" required
    placeholder="{{ __('messages.group_edit.ph_sign_group_pass') }}">
  <div class="row">
    <button id="btn_update" type="button" class="btn btn-outline-success col-5">
      {{ __('messages.group_edit.btn_update') }}</button>
    <button id="btn_delete" type="button" class=" btn btn-outline-danger col-5">
      {{ __('messages.group_edit.btn_delete') }}</button>
  </div>
  @endif
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
</script>
<script src="{{ asset('/js/group_edit.js') }}"></script>
@endsection
