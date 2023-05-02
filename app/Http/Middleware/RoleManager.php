<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
class RoleManager
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
            if(auth()->user()->role !== User::ROLE_MANAGER) {
                abort(404);
            }
        } else {
            abort(404);
        }
        
        return $next($request);
    }
}
