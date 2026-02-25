<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = auth()->user();

        if (!$user || !$user->role || $user->role->slug !== $role) {
            abort(403, 'Доступ запрещён.');
        }

        return $next($request);
    }
}
