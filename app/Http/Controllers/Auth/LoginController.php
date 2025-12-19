<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Find the user by email
        $user = User::where('email', $request->email)->first();
        
        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }
        
        // Check if user is rejected
        if ($user->isRejected()) {
            return back()->withErrors([
                'email' => 'Your account has been rejected. Please contact support for more information.',
            ])->withInput($request->only('email'));
        }
        
        // Check if user is pending approval (and not an admin)
        if ($user->isPending() && !in_array($user->role_id, [2, 3])) {
            return back()->withErrors([
                'email' => 'Your account is pending approval. Please wait for an administrator to approve your account.',
            ])->withInput($request->only('email'));
        }
        
        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Redirect based on user role
            return $this->redirectToRoleBasedDashboard($user);
        }
        
        // Fallback error if login fails for other reasons
        return back()->withErrors([
            'email' => 'Authentication failed. Please try again.',
        ])->withInput($request->only('email'));
    }
    
    /**
     * Redirect user to the appropriate dashboard based on their role
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToRoleBasedDashboard($user)
    {
        // Make sure to load the role relationship if not already loaded
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }

        // Check user role and redirect accordingly
        if (in_array($user->role_id, [2, 3])) {
            // Admin or Regional Admin - force redirect to admin dashboard
            return redirect()->to(route('admin.dashboard'));
        } 
        
        // For approved regular users (BFAR Personnel)
        if ($user->isApproved()) {
            return redirect()->intended(route('dashboard'));
        } 
        
        // For pending users (should be handled above, but just in case)
        if ($user->isPending()) {
            return redirect()->route('pending-approval');
        }
        
        // Fallback redirect (should not reach here due to previous checks)
        return redirect()->route('dashboard');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
