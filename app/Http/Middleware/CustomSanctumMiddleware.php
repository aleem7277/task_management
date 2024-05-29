<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Laravel\Sanctum\Exceptions\MissingScopeException;
use Illuminate\Auth\AuthenticationException;

class CustomSanctumMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (AuthenticationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token mismatch or unauthorized'
            ], 401);
        } catch (MissingAbilityException | MissingScopeException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token lacks required ability or scope'
            ], 403); // 403 is the HTTP status code for "Forbidden"
        }
    }
}
