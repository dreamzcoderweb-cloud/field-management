<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
class SentinelAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! Sentinel::check()) {
            return redirect('auth/login')->with('info', 'You must be logged in to access the resource!');
        }
    /*    if (! Sentinel::inRole('admin')) {
            return redirect('my-account');
        }*/

        return $next($request);
    }
}
