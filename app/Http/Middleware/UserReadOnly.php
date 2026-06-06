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

        // Additional per-module restrictions:
        // - Prevent users with role admin_tik or staf_tik from performing non-safe methods on Aset RT routes
        // - Prevent users with role admin_rt, staf_driver, staf_engineering from performing non-safe methods on Aset TIK routes
        // Determine module from URL segment: routes are prefixed with /admin/{module}
        $module = $request->segment(2); // e.g. 'asetrt' or 'asettik'

        $forbiddenByModule = [
            'asetrt' => ['admin_tik', 'staf_tik'],
            'asettik' => ['admin_rt', 'staf_driver', 'staf_engineering'],
        ];

        if ($module && isset($forbiddenByModule[$module]) && $user) {
            foreach ($forbiddenByModule[$module] as $forbiddenRole) {
                if ($user->hasRole($forbiddenRole) && ! $request->isMethodSafe()) {
                    if ($request->expectsJson() || $request->ajax()) {
                        return response()->json(['message' => 'Role Anda tidak memiliki izin mengubah data pada modul ini.'], 403);
                    }

                    abort(403, 'Role Anda tidak memiliki izin mengubah data pada modul ini.');
                }
            }
        }

        return $next($request);
    }
}