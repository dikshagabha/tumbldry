<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class checkPrefix
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

        $prefix = ($request->route()->getPrefix());

        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($prefix=="/store" && $role==3) {
                return $next($request);
            }


            Auth::logout();
        }

        return $next($request);
    }
}
