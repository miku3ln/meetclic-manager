<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;

class PointSalesAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!config('pointsales.require_token')) {
            return $next($request);
        }

        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token requerido'
            ], 401);
        }

        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido'
            ], 401);
        }

        if ($user->token_expires_at && now()->gt($user->token_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Token expirado'
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario inactivo'
            ], 403);
        }

        // 🔥 AQUÍ ES LA CLAVE
        $request->attributes->set('auth_user', $user);

        return $next($request);
    }
}
