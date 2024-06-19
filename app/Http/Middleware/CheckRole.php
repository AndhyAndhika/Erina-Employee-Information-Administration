<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        if (Auth::check() && Auth::user()->role == "admin") {
            return $next($request);
        }

        Alert::toast('You are no\'t admin!, Please call to programmer', 'error')->autoClose(3000);
        return redirect()->route('dashboard');
    }
}
