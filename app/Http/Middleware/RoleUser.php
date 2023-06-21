<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
class RoleUser
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
        if(auth()->user() ) {
            if(auth()->user()->role !== User::ROLE_USER) {
                abort(404);
            }
        } else {
             abort(404);
        }
        return $next($request);
    }
}
