<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            //dd("Authenticate Middleware");
           // return route('login');
            //return $next($request);
        }
        dd("Asdjsd");
        if ($request->ajax()) {
            return response('Unauthorized.', 401);
        } else {
            return "redirect()->guest('login')";
        }
    }

    //  public function handle($request, Closure $next, ...$guards)
    // {
    //     //dd("jerere");
    //     return $next($request);
    // }

   
}
