<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check() || !$request->user()->hasRole($role)) {
            // Redirect หรือ return response ตามต้องการ
            return redirect()->route('users.notpermission'); // หรือใช้ response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
