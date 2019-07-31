<?php

namespace App\Http\Middleware;

use Closure;

class ParentsAccess
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
        if(!session()->has('parent_auth')){
            return redirect()->route('parents_login');
        }

        return $next($request);
    }
}
