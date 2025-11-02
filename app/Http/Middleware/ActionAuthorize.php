<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AllowedAction;

class ActionAuthorize
{
    /** Primer segmento permitido sin verificar (igual que tu $allowedUrls) */
    private  $allowedBase = ['login', 'main', 'logout', 'account'];

    /** Palanca existente: si llegara a true, consulta AllowedAction por acción */
    private  $allowManager = false;

    // ---------------------------
    // Entry point
    // ---------------------------
    public function handle(Request $request, Closure $next)
    {
        // [S1] Autenticación obligatoria
        if (!$this->isAuthenticated()) {
            return $this->unauthorized($request);
        }

        // [S2] Datos base de la request
        $segments = $request->segments();
        $user     = $request->user();
        $roleIds  = $this->extractRoleIds($user);

        // [S3] Pases rápidos (sin consultar más)
        if ($this->isSuperAdmin($roleIds)) {
            return $next($request);
        }
        if ($this->isEmptyPath($segments)) {
            return $next($request);
        }
        if ($this->isFirstSegmentWhitelisted($segments)) {
            return $next($request);
        }

        // [S4] Normalización y compatibilidad con tu "index"
        $firstSegment   = $segments[0] ?? '';
        $urlComparable  = $this->buildComparablePath($segments);
        $actionUrlToken = $this->inferActionUrl($segments);
        if ($actionUrlToken === 'index') {
            $urlComparable = $firstSegment;
        }

        // [S5] Autorización por roles/acciones (MISMAS CONSULTAS que ya tenías)
        $allowed = $this->isAllowedForRoles($user, $urlComparable);

        // [S6] Manejo de no autorizado (excepto main/unauthorized)
        if (!$allowed && !$this->isExplicitUnauthorizedPath($segments)) {
            return $this->unauthorized($request);
        }

        // [S7] Continuar request (responder JSON si el cliente lo espera)
        return $this->proceed($request, $next);
    }

    // ===========================
    // S1. Auth
    // ===========================
    private function isAuthenticated(): bool
    {
        return Auth::check();
    }

    // ===========================
    // S2. Utilidades de request/usuario
    // ===========================
    private function extractRoleIds($user): array
    {
        return $user->roles->pluck('id')->toArray();
    }

    // ===========================
    // S3. Pases rápidos
    // ===========================
    private function isSuperAdmin(array $roleIds): bool
    {
        return in_array(1, $roleIds, true);
    }

    private function isEmptyPath(array $segments): bool
    {
        return empty($segments);
    }

    private function isFirstSegmentWhitelisted(array $segments): bool
    {
        $first = $segments[0] ?? '';
        return in_array($first, $this->allowedBase, true);
    }

    // ===========================
    // S4. Normalización de URL
    // ===========================
    /**
     * Construye el path comparable eliminando IDs numéricos.
     * Ej: ['users','42','edit']  => 'users'
     *     ['orders','create']    => 'orders/create'
     */
    private function buildComparablePath(array $segments): string
    {
        $parts = [];
        foreach ($segments as $seg) {
            if (is_numeric($seg)) {
                break;
            }
            $parts[] = $seg;
        }
        return implode('/', $parts);
    }

    /**
     * Equivalente a tu cálculo de $action_url simplificado.
     * Mantiene tu comportamiento:
     * - si hay 2 segmentos => usa el primero
     * - si vacío          => ''
     * - caso contrario    => primero
     */
    private function inferActionUrl(array $segments): string
    {
        if (is_array($segments) && count($segments) === 2) {
            return $segments[0] ?? '';
        }
        if (empty($segments)) {
            return '';
        }
        return $segments[0] ?? '';
    }

    // ===========================
    // S5. Autorización contra BDD
    // ===========================
    /**
     * MISMAS QUERIES que tu código:
     * - $user->roles -> actions (relación cargada bajo demanda)
     * - si $this->allowManager es true, hace AllowedAction::where('action_id', ...) por acción
     */
    private function isAllowedForRoles($user, string $urlComparable): bool
    {
        foreach ($user->roles as $role) {
            $actions = $role->actions; // misma lectura que ya hacías

            foreach ($actions as $action) {
                if ($this->allowManager) {
                    // MISMA consulta por acción
                    $allowedActions = AllowedAction::where('action_id', '=', $action->id)->get();
                    foreach ($allowedActions as $allAct) {
                        if ($allAct->url === $urlComparable) {
                            return true;
                        }
                    }
                } else {
                    if ($action->link === $urlComparable) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    // ===========================
    // S6. No autorizado explícito
    // ===========================
    private function isExplicitUnauthorizedPath(array $segments): bool
    {
        return ($segments[0] ?? null) === 'main' && ($segments[1] ?? null) === 'unauthorized';
    }

    // ===========================
    // S7. Continuación / respuesta
    // ===========================
    private function proceed(Request $request, Closure $next)
    {
        if ($request->expectsJson() || $request->ajax()) {
            $response = $next($request);
            // Si el controller devolvió contenido "original", envolver a JSON
            return method_exists($response, 'getOriginalContent')
                ? response()->json($response->getOriginalContent())
                : $response;
        }
        return $next($request);
    }

    private function unauthorized(Request $request)
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        abort(401);
    }
}
