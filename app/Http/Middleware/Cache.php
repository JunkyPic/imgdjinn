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
    $request->headers->add([
      'Cache-Control' => 'max-age=86400, public',
      'X-www-test-header' =>'test-value'
    ]);

    return $next($request);
  }

}

