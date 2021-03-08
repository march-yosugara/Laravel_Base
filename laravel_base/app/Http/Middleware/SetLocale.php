<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Support\Facades\Cookie;

class SetLocale
{
  public function handle($request, Closure $next)
  {
    if (session(env('S_Locale'))) {
      App::setLocale(session(env('S_Locale')));
      Cookie::queue(env('C_Locale'), session(env('S_Locale')), 60 * 24 * 7);
    } else if (Cookie::get(env('C_Locale'))) {
      App::setLocale(Cookie::get(env('C_Locale')));
      session()->put(env('S_Locale'), Cookie::get(env('C_Locale')));
      Cookie::queue(env('C_Locale'), session(env('S_Locale')), 60 * 24 * 7);
    }

    return $next($request);
  }
}
