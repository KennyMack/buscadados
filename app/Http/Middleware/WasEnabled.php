<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class WasEnabled
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
        if (Auth::check() &&
            Auth::user()->isAdmin()) {
            return redirect('home');
        }


        if (Auth::check() && Auth::user()->registrationCompleted()) {
            return redirect('home');

        }


        /*if (Auth::check() &&
            Auth::user()->isAdmin() &&
            !Auth::user()->registrationCompleted())
            return redirect('home');*/

        return $next($request);
    }
}
