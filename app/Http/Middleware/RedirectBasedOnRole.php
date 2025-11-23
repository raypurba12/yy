<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    if ($request->is('dashboard') || $request->is('/')) {
                        return redirect()->route('dashboard');
                    }
                    break;
                case 'kasir':
                    // Kasir bisa ke halaman tertentu
                    if ($request->is('dashboard') || $request->is('/')) {
                        return redirect()->route('dashboard');
                    }
                    break;
                case 'customer':
                    // Customer redirect ke halaman tertentu
                    if ($request->is('dashboard') || $request->is('/')) {
                        return redirect()->route('dashboard');
                    }
                    break;
                default:
                    return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
