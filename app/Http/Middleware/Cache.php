<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class Cache extends Middleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */
  public function handle($request, \Closure $next, $guard = null)
  {

    $request->header('Cache-Control', 'max-age=86400, public');

    return $next($request);
  }

}
