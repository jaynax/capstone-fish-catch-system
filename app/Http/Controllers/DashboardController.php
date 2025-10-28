<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get the authenticated user
        $user = Auth::user();
        
        // Check if user is BFAR personnel
        if ($user->role_id !== 2) {
            return redirect('/')->with('error', 'You do not have permission to access this page.');
        }

        // Return the personnel dashboard view for BFAR personnel
        return view('personnel-dashboard', [
            'user' => $user
        ]);
    }
}
