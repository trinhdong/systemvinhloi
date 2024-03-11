<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        foreach ($roles as $role) {
            if (Auth::user()->hasRole(constant($role))) {
                return $next($request);
            }
        }

        return abort(403, 'Unauthorized');
    }
}
