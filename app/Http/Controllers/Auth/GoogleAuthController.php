<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['hd' => '*'])  // Optional: Restrict to specific domain
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create a new user with pending status by default
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(24)), // Random password as it's not needed for OAuth
                    'email_verified_at' => now(), // Email is verified by Google
                    'role_id' => 1, // Default to BFAR personnel (role_id = 1)
                    'status' => 'pending' // Set status to pending until approved by admin
                ]);
                
                // Log the user in
                Auth::login($user);
                
                // Redirect to pending approval page
                return redirect()->route('pending-approval')
                    ->with('status', 'Your account is pending approval. Please wait for an administrator to approve your account.');
            }

            // Update user's name if it has changed
            if ($user->name !== $googleUser->getName()) {
                $user->name = $googleUser->getName();
                $user->save();
            }

            // Check if user is approved
            if ($user->isPending()) {
                Auth::login($user);
                return redirect()->route('pending-approval')
                    ->with('status', 'Your account is still pending approval. Please wait for an administrator to approve your account.');
            }
            
            // If rejected, don't log in
            if ($user->isRejected()) {
                return redirect()->route('login')
                    ->with('error', 'Your account has been rejected. Please contact the administrator.');
            }
            
            // Log the user in if approved
            Auth::login($user);
            
            // Redirect based on user role
            return $this->redirectBasedOnRole($user);

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Unable to login using Google. Please try again.');
        }
    }

    /**
     * Redirect user based on their role
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBasedOnRole($user)
    {
        if (!$user->isApproved()) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Your account is not approved yet. Please contact the administrator.');
        }

        // Check user role and redirect accordingly
        switch ($user->role_id) {
            case 1: // BFAR Personnel
                return redirect()->route('dashboard')
                    ->with('success', 'Welcome back, ' . $user->name . '!');
                
            case 2: // Admin
            case 3: // Regional Admin
                return redirect()->route('admin.dashboard')
                    ->with('success', $user->role_id === 2 ? 'Welcome back, Administrator!' : 'Welcome back, Regional Administrator!');
                
            default:
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Invalid user role. Please contact the administrator.');
        }
    }
}
