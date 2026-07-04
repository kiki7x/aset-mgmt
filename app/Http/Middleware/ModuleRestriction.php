<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleRestriction
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $forbiddenByModule = [
            'asetrt' => ['admin_tik', 'staf_tik'],
            'asettik' => ['admin_rt', 'staf_driver', 'staf_engineering'],
        ];

        $module = $request->segment(2);

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
