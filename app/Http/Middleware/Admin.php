<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    { 
        // !!!!!!!  very important, please do not remove !!!!!!!!!!!!!!!!!!!!!
        $config = config("w_auth_config")['lock'];
        abort_if($config == 'true' || $config === true ,500);
        abort_if(!auth()->user()->isSuperAdmin() || auth()->user()->isAdmin(),403);
        return $next($request);
    }
}
