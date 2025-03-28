<?php

namespace App\Http\Middleware;

use Closure;

class admin
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
        if (Auth::user()) {
            if (Auth::user()->role == 'admin') {
                return $next($request);
            } else {
                return redirect('/login');
            }
        }
    }
}