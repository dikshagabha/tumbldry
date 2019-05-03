<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Store
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (Auth::check()) {
          return $next($request);
      }
      return redirect()->route('store.login');
    }
}
