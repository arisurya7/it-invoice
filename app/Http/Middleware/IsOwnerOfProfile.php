<?php

namespace App\Http\Middleware;

use Closure;

class IsOwnerOfProfile
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
        if ($request->id == auth()->user()->id || auth()->user()->role=='Admin') {
            return $next($request);
        }
        return redirect('/');
        
    }
}
