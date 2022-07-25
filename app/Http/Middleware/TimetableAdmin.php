<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TimetableAdmin
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
        if(session()->get('authenticated') == true && session()->get('privilege') == 2)
        {
            return $next($request);
        }
        return redirect('/')->with('error', 'session expired! login again');
    }
}
