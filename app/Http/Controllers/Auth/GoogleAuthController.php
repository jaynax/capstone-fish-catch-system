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
                // Create a new user with bfar_personnel role (role_id = 1) by default
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(24)), // Random password as it's not needed for OAuth
                    'email_verified_at' => now(), // Email is verified by Google
                    'role_id' => 1, // Default to BFAR personnel (role_id = 1)
                ]);
                
                // Log the user in
                Auth::login($user);
                
                // Redirect to appropriate dashboard based on role
                return $this->redirectBasedOnRole($user);
            }

            // Update user's name if it has changed
            if ($user->name !== $googleUser->getName()) {
                $user->name = $googleUser->getName();
                $user->save();
            }

            // Log the existing user in
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
        // Check user role and redirect accordingly
        switch ($user->role_id) {
            case 1: // BFAR Personnel
                return redirect()->route('dashboard')
                    ->with('success', 'Welcome back, ' . $user->name . '!');
                
            case 2: // Admin
                return redirect()->route('admin-dashboard')
                    ->with('success', 'Welcome back, Administrator!');
                
            case 3: // Regional Admin
                return redirect()->route('admin-dashboard')
                    ->with('success', 'Welcome back, Regional Administrator!');
                
            default:
                return redirect()->intended('/')
                    ->with('status', 'Logged in successfully!');
        }
    }
}
