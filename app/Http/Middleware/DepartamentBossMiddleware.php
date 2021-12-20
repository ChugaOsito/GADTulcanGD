<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DepartamentBossMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth()->check())
        return redirect('login');
        
        if(auth()->user()->rol != 1)//No es Super administrador
        return redirect('home');
        return $next($request);
    }
}
