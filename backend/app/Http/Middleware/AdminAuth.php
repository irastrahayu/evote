<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $jwt = $request->bearerToken();
            $key = new Key(env('JWT_SECRET'), 'HS256');

            $decoded = JWT::decode($jwt, $key, ['HS256']);
            if ($decoded->role !== 'admin') {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            return $next($request);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

    }
}