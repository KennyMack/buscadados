<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Request;

class RegistrationComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check() &&
            !Auth::user()->isAdmin() &&
            !Auth::user()->registrationCompleted()) {
            \Session::flash('register', 'Seu cadastro ainda não foi concluido.');
            return redirect('/register/company');
        }

        return $next($request);
    }
}
