@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/guest.css') }}">
@endsection

@section('subtitle')
Confirm
{{ __('auth.confirm.subtitle') }}
@endsection

@section('contents')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card　board">
        <div class="card-header">{{ __('auth.confirm.header') }}</div>

        <div class="card-body">
          {{ __('auth.confirm.text') }}

          <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.confirm.label') }}</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                  name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-outline-primary">
                  {{ __('auth.confirm.header') }}
                </button>

                @if (Route::has('password.request'))
                <a class="btn btn-outline-link" href="{{ route('password.request') }}">
                  {{ __('auth.confirm.forgot') }}
                </a>
                @endif
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
@endsection
