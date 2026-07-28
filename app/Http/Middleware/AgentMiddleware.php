<?php

namespace App\Http\Middleware;

use Closure;

class AgentMiddleware
{
    public function handle($request, Closure $next)
    {
        /*
        |--------------------------------------------------------------------------
        | Developer Mode
        |--------------------------------------------------------------------------
        | Si está habilitado, omite la validación de la llave.
        | Solo debe utilizarse en ambientes de desarrollo.
        |--------------------------------------------------------------------------
        */
        if (env('AGENT_DEVELOPER_MODE', false)) {
            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | Validar Agent Key
        |--------------------------------------------------------------------------
        */

        $key = $request->header('X-Agent-Key');

        if (empty($key)) {
            return response()->json([
                "success" => false,
                "message" => "Agent key required."
            ], 401);
        }

        if ($key !== env('AGENT_KEY')) {
            return response()->json([
                "success" => false,
                "message" => "Invalid agent key."
            ], 401);
        }

        return $next($request);
    }
}
