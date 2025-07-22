<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */ public function handle($request, Closure $next, $role)
    {
        // dd($role);
        // Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Periksa role pengguna
        $user = Auth::user();
        // dd($user->role);
        if ($user->role !== $role) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini. Silahkan Login terlebih dahulu');
        }

        return $next($request);
    }
}
