<?php

// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles) {
        $user = Auth::user();

        // Periksa apakah user memiliki role yang diizinkan
        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        return redirect('/'); // Redirect jika user tidak punya akses
    }
}

