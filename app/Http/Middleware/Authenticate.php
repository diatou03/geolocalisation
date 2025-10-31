<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // Ne pas rediriger, simplement renvoyer null
        return null;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->authenticate($request, $guards)) {
            return $next($request);
        }

        // Si requête AJAX ou API, retourne 401 Unauthorized
        if ($request->expectsJson()) {
            abort(401, 'Non authentifié.');
        }

        // Sinon, tu peux retourner une réponse personnalisée ou abort(403)
        abort(403, 'Accès refusé. Vous devez être connecté.');
    }
}
