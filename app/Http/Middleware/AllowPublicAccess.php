<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowPublicAccess
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
        // Allow public access - don't redirect to login
        return $next($request);
    }
}
