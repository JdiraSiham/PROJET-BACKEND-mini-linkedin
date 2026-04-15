<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::guard('api')->user();

        if (! $user || ! in_array($user->role, $roles)) {
            return response()->json([
                'error' => 'Accès interdit.',
            ], 403);
        }

        return $next($request);
    }
}
