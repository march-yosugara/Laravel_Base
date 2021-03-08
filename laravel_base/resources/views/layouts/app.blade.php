<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @auth
  @php
  $user = Auth::user();
  @endphp
  @endauth
  <title>@lang('messages.app_name')</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
  @yield('styles')
</head>

<body>
  <div class="wrapper">
    <div class="header">
      <a href="{{ route('home') }}">
        <h1>@lang('messages.app_name')</h1>
      </a>
      <select name="lang" id="lang" class="form-control d-inline">
        <option value="en">English</option>
        <option value="ja">Japanese</option>
      </select>
    </div>
    <div class="right-menu">
      @auth
      <div class="user">
        <div class="card board">
          <p>Name : {{ $user->name }}</p>
          <p>Mail : {{ $user->email }}</p>
          <button id="btn_group" type="button" class="btn btn-outline-primary"
            onclick="location.href='{{ route('group_manage') }}'">{{ __('auth.app.btn_group') }}</button>
          <button id="btn_logout" type="button" class="btn btn-outline-light">{{ __('auth.app.btn_logout') }}</button>
        </div>
      </div>
      @endauth
    </div>
    <div class="subtitle">
      <div class="root list-group list-group-flush">
        @yield('root')
      </div>
      <h2>
        @yield('subtitle')
      </h2>
    </div>
    <div class="contents">
      @yield('contents')
    </div>
    <div class="footer">
      <p>&copy; 2021 March Yosugara</p>
    </div>
  </div>
  <script>
    var _app_urls = {
      url_logout: '{{ route('logout') }}',
      url_welcome: '{{ route('welcome') }}',
      url_ja: '{{ route('locale', ['locale' => 'ja']) }}',
      url_en: '{{ route('locale', ['locale' => 'en']) }}',
    };
    var _app_js_mes = {
      mes_logged_out: '{{ __('messages.js.mes_logged_out') }}',
    };
  </script>
  <script type="text/javascript" src="//webfonts.xserver.jp/js/xserver.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  @yield('scripts')
</body>

</html>
