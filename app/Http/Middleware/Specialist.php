<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Specialist
{
    /**
     * Prevent other users from accessing specialist functionality.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role !== 'specialist') {
            return redirect('display/home');
        }

        return $next($request);
    }
}
