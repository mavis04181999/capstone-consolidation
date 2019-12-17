<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Adminmiddleware
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
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'organizer'){
            return $next($request);
        }else{
            return redirect()->back()->with('error', 'Unauthorized Page Access');
        }

    }
}
