<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BodyAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->cookie('XSRF-TOKEN');

        if (!Auth::guard($guard)->check() && null !== ($token)) {
            $request->headers->add([
                'Authorization' => 'Bearer ' . $token,
            ]);

        }


        return $next($request);
    }
}

?>
