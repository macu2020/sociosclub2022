<?php

namespace App\Http\Middleware;

use Closure,Auth;
use Illuminate\Http\Request;

class IsAdmin
{
     
    public function handle(Request $request, Closure $next)
    {
         //Si el rol es 1 es admin sera direccionado
        if (Auth::user()->role=="1") {
            return $next($request);
        }else{
            return redirect('/');
        }
    }
}
