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
  @yield('styles')
</head>

<body>
  <div class="wrapper">
    <div class="header">
      <a href="{{ route('home') }}">
        <h1>LaravelBase</h1>
      </a>
    </div>
    @auth
    <div class="user">
      <div class="card">
        <h4>Name : {{ $user->name }}</h4>
        <h4>Mail : {{ $user->email }}</h4>
        <button id="btn_group" type=“button” class="btn btn-outline-primary"
          onclick="location.href='{{ route('group_manage') }}'">Group Manage</button>
        <button id="btn_logout" type="button" class="btn btn-outline-light">Logout</button>
      </div>
    </div>
    @endauth
    <div class="subtitle">
      @yield('root')
      <h2>
        @yield('subtitle')
      </h2>
    </div>
    <div class="contents">
      @yield('contents')
    </div>
    <div class="footer">
      &copy; 2020 March Yosugara
    </div>
  </div>
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    var _url_logout = '{{ route('logout') }}';
    var _url_welcome = '{{ route('welcome') }}';
  </script>
  @yield('scripts')
</body>

</html>
