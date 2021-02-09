<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Display
{
    /**
     * Prevent other users from accessing display.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role !== 'display') {
            return redirect('home');
        }

        return $next($request);
    }
}
