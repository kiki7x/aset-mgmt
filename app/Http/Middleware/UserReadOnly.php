<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserReadOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->hasRole('user') && ! $request->isMethodSafe()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => 'Role user hanya dapat melihat data.'], 403);
            }

            abort(403, 'Role user hanya dapat melihat data.');
        }

        return $next($request);
    }
}
