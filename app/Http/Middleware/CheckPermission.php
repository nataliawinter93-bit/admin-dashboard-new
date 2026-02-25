<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->user(); // ← исправлено

        if (!$user || !$user->role || !$user->role->permissions->contains('name', $permission)) {
            abort(403, 'У вас нет прав для выполнения этого действия.');
        }

        return $next($request);
    }
}
