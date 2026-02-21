<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEmailVerified
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
        // Jika user login dan belum verifikasi email
        if (Auth::check() && !Auth::user()->is_verified) {
            // Redirect ke dashboard dengan pesan
            return redirect()->route('dashboard')
                           ->with('warning', 'Anda harus memverifikasi email terlebih dahulu untuk mengakses fitur ini.');
        }

        return $next($request);
    }
}
