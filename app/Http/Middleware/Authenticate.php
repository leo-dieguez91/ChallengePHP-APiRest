<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            abort(401, 'No autenticado');
        }
        return route('login');
    }

    protected function unauthenticated($request, array $guards)
    {
        if ($request->is('api/*')) {
            abort(401, 'No autorizado');
        }

        return parent::unauthenticated($request, $guards);
    }
}
