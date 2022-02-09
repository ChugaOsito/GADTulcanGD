<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Position;
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

        $position=Position::find(auth()->user()->position_id);
       // dd($position->representative);
        if($position->representative != 1)//No es jefe de departamento
        return redirect('home');
        return $next($request);
    }
}
