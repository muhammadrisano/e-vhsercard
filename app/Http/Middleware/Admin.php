<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if($request->session()->get('login')) {
            if(Auth::user()->role == 1) {
                return redirect('home_pengawas');
            } elseif(Auth::user()->role == 2) {
                return redirect('home_manager');
            } elseif(Auth::user()->role == 3) {
                return redirect('home_hse');
            }
        }
        return $next($request);
    }
}
