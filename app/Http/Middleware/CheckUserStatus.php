<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // If user is not logged in, continue with the request
        if (!$user) {
            return $next($request);
        }

        // If user is rejected, log them out and redirect to login with message
        if ($user->isRejected()) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Your account has been rejected. Please contact the administrator.');
        }

        // If user is pending and not on the pending approval page, redirect them
        if ($user->isPending() && !$request->is('pending-approval')) {
            return redirect()->route('pending-approval');
        }

        // If user is approved but trying to access pending approval page, redirect based on role
        if ($user->isApproved() && $request->is('pending-approval')) {
            if (in_array($user->role_id, [2, 3])) { // Admin or Regional Admin
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('personnel-dashboard');
        }

        return $next($request);
    }
}
