<?php

namespace App\Http\Middleware\v1;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();
        if (!$user->roles->contains('name', $role)  ) {
            return response()->json(['error' => 'Forbidden'], 403);

        }
        return $next($request);
    }
}
