<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        
        // Check if user is authenticated
        if (!$user) {
            throw new HttpException(403, 'Unauthenticated');
        }
        
        // Load the role relationship if not already loaded
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }
        
        // Check if user has any of the required roles
        if (!$user->role || !in_array($user->role->slug, $roles)) {
            throw new HttpException(403, 'Forbidden: Insufficient role');
        }
        
        return $next($request);
    }
} 