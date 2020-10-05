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
  <title>LaravelBase</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
  @yield('styles')
</head>

<body>
  <div class="wrapper">
    <div class="header">
      <a href="{{ route('home') }}">
        <h1>LaravelBase</h1>
      </a>
    </div>
    <div class="right-menu">
      @auth
      <div class="user">
        <div class="card board">
          <p>Name : {{ $user->name }}</p>
          <p>Mail : {{ $user->email }}</p>
          <button id="btn_group" type="button" class="btn btn-outline-primary"
            onclick="location.href='{{ route('group_manage') }}'">Group Manage</button>
          <button id="btn_logout" type="button" class="btn btn-outline-light">Logout</button>
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
      <p>&copy; 2020 March Yosugara</p>
    </div>
  </div>
  <script type="text/javascript" src="//webfonts.xserver.jp/js/xserver.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    var _url_logout = '{{ route('logout') }}';
    var _url_welcome = '{{ route('welcome') }}';
  </script>
  @yield('scripts')
</body>

</html>
