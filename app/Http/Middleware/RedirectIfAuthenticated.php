<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $guard = NULL){
        if (Auth::guard($guard)->check()) {
            if (Auth::user()->role_id == 3) {
                return redirect("/dashboard-UPPS");
            } else if (Auth::user()->role_id == 2) {
                return redirect("/dashboard-prodi");
            } else if (Auth::user()->role_id == 1) {
                return redirect("/dashboard-asesor");
            } else {
                return redirect("/");
            }
        }

        return $next($request);
    }
}
