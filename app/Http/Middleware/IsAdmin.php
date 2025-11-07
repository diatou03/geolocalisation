<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Vérifie si l'utilisateur est connecté et admin.
     */
     public function handle(Request $request, Closure $next)
     {
        // Vérifie que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', '⛔ Vous devez être connecté.');
        }

        // Vérifie que l'utilisateur est admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', '⛔ Accès réservé aux administrateurs.');
        }

        // Autorise la requête
        return $next($request);
    }
}
