<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if ($request->user()->role == 'admin' || $request->user()->role == 'user') {
            return $next($request);
        }        
        else{
            session()->flash('error','You do not have any permission to access this page');
            return redirect()->route($request->user()->role);
        }
    }
}
