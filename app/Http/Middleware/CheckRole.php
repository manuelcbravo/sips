<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if(Auth::check() && Auth::user()->rol == 0){

            return $next($request);

        }

        if (Auth::check() && Auth::user()->hasAnyRoleId($roles)) {
            return $next($request);
        }

        return abort(403, 'No tienes permisos para acceder a esta página.');
    }
}
