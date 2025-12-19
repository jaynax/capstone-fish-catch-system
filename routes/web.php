<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\FishCatchController;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\Auth\GoogleAuthController;

// Include test routes
require __DIR__.'/oauth-test.php';
require __DIR__.'/test-oauth.php';

// Pending approval route - accessible to logged-in users with pending status
Route::middleware(['auth', 'user.status'])->get('/pending-approval', function () {
    return view('auth.pending-approval');
})->name('pending-approval');

// Protected routes that require authentication and approved status
Route::middleware(['auth', 'user.status'])->group(function () {
    // Admin Dashboard and User Management
    // Admin routes - Accessible to both ADMIN and REGIONAL_ADMIN roles
    Route::prefix('admin')->name('admin.')->middleware(['role:ADMIN,REGIONAL_ADMIN'])->group(function () {
        // Admin Dashboard - Main admin dashboard view
        Route::get('/dashboard', function () {
            return view('admin-dashboard');
        })->name('dashboard');
        
        // Admin Catches Management
        Route::get('/catches', [App\Http\Controllers\FishCatchController::class, 'adminIndex'])->name('catches');
        Route::get('/catches/{catch}', [App\Http\Controllers\FishCatchController::class, 'adminShow'])->name('catches.show');
        Route::get('/catches/{catch}/edit', [App\Http\Controllers\FishCatchController::class, 'edit'])->name('catches.edit');
        
        // User Management
        Route::get('/users', function () {
            $users = \App\Models\User::with('role')->latest()->paginate(10);
            return view('admin.users', compact('users'));
        })->name('users.index');
        
        // User resource routes
        Route::prefix('users')->name('users.')->group(function () {
            // Show user details
            Route::get('/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])
                ->name('show');
                
            // Show edit form
            Route::get('/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])
                ->name('edit');
                
            // Update user
            Route::put('/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])
                ->name('update');
                
            // Create user
            Route::post('/', [App\Http\Controllers\Admin\UserController::class, 'store'])
                ->name('store');
                
            // Approve user
            Route::patch('/{user}/approve', [App\Http\Controllers\Admin\UserController::class, 'approve'])
                ->name('approve');
                
            // Reject user
            Route::patch('/{user}/reject', [App\Http\Controllers\Admin\UserController::class, 'reject'])
                ->name('reject');
                
            // Delete user
            Route::delete('/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])
                ->name('destroy');
        });
    });

    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/preferences', [App\Http\Controllers\ProfileController::class, 'updatePreferences'])->name('user.profile.preferences');
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Regulations
    Route::get('/regulations', function () {
        return view('regulations');
    })->name('regulations');
    
    // Fish Catch Routes
    Route::resource('catches', FishCatchController::class)->except(['destroy']);
    
    // Boat Search Route
    Route::get('/boats/search', [BoatController::class, 'search'])->name('boats.search');
    Route::get('/catches/{catch}/pdf', [FishCatchController::class, 'generatePdf'])->name('catches.pdf');
    Route::delete('/catches/{catch}', [FishCatchController::class, 'destroy'])->name('catches.destroy');
    Route::post('/catches/{catch}/analyze', [FishCatchController::class, 'analyzeImage'])->name('catches.analyze');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Registration form
Route::get('/register', function () {
    $roles = DB::table('roles')->get();
    return view('auth.register', compact('roles'));
})->name('register');

// Registration handler
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:BFAR_PERSONNEL,REGIONAL_ADMIN',
    ]);
    
    // Get the role ID based on the role slug
    $role = DB::table('roles')->where('slug', $request->role)->first();
    
    if (!$role) {
        return back()->withErrors(['role' => 'Invalid role selected.'])->withInput();
    }
    
    // Determine if the user should be auto-approved (if they're an admin or regional admin)
    $status = (in_array($request->role, ['ADMIN', 'REGIONAL_ADMIN'])) ? 'approved' : 'pending';
    
    // Create user with appropriate status
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $role->id,
        'status' => $status,
    ]);
    
    if ($status === 'pending') {
        // Notify admins about the new registration (only for non-admin users)
        $admins = User::whereHas('role', function($query) {
            $query->where('slug', 'ADMIN');
        })->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\NewUserRegistered($user));
        }
    }
    
    // Log the user in
    Auth::login($user);
    
    // Redirect based on user status
    if ($user->isApproved()) {
        return redirect()->intended('/dashboard');
    } else {
        return redirect()->route('pending-approval');
    }
});

// Google OAuth Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Use the LoginController for authentication
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->name('login.submit');

// Dashboard redirection based on role
Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user()->load('role');
    
    if (!$user->role) {
        abort(403, 'User role not found');
    }
    
    // Redirect admin/regional admin to admin dashboard
    if (in_array($user->role->slug, ['ADMIN', 'REGIONAL_ADMIN'])) {
        return redirect()->route('admin.dashboard');
    }
    // Redirect BFAR personnel to their dashboard
    elseif ($user->role->slug === 'BFAR_PERSONNEL') {
        return view('personnel-dashboard');
    }
    
    abort(403, 'Unauthorized role');
})->name('dashboard');

// BFAR Personnel dashboard (kept for backward compatibility)
Route::middleware(['auth', 'role:BFAR_PERSONNEL'])->get('/dashboard/personnel', function () {
    return view('personnel-dashboard');
})->name('personnel-dashboard');

// Admin routes for managing data and users
Route::middleware(['auth', 'role:REGIONAL_ADMIN'])->group(function () {
    Route::get('/admin/catches', function () {
        $catches = \App\Models\FishCatch::with('user')->latest()->paginate(10);
        return view('admin.catches', compact('catches'));
    })->name('admin.catches');
    
    Route::delete('/admin/catches/{catch}', function (\App\Models\FishCatch $catch) {
        try {
            $catch->delete();
            return response()->json(['success' => true, 'message' => 'Catch record deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete catch record'], 500);
        }
    })->name('admin.catches.destroy');
    
    // List users
    Route::get('/admin/users', function () {
        $users = \App\Models\User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users', compact('users'));
    })->name('admin.users');
    
    // Delete user
    Route::delete('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])
        ->name('admin.users.delete');
    
    Route::get('/admin/reports', function () {
        $totalCatches = \App\Models\FishCatch::count();
        $totalUsers = \App\Models\User::count();
        $recentCatches = \App\Models\FishCatch::with('user')->latest()->take(10)->get();
        return view('admin.reports', compact('totalCatches', 'totalUsers', 'recentCatches'));
    })->name('admin.reports');
});

// User Profile Routes
Route::middleware('auth')->group(function () {
    // Regular user profile
    Route::get('/profile/edit', function () {
        return view('layouts.users.profile');
    })->name('profile.edit');

    Route::put('/profile/update', function (Request $request) {
        $user = Auth::user();
        $request->validate([
            'name' => 'required',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->storeAs('public/profile_images', $imageName);
            $user->profile_image = $imageName;
        }
        $user->save();
        return back()->with('success', 'Profile updated successfully.');
    })->name('profile.update');
});

// Admin Profile Routes
Route::middleware(['auth', 'role:ADMIN|REGIONAL_ADMIN'])->group(function () {
    Route::get('/admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
});

// Login history route (placeholder)
Route::middleware('auth')->get('/login-history', function () {
    // You can replace this with a real view or controller later
    return view('layouts.users.login-history');
})->name('login.history');

// Fish Catch Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/catch/create', [FishCatchController::class, 'create'])->name('catch.create');
    Route::post('/catch', [FishCatchController::class, 'store'])->name('catch.store');
});

// Fish catch entry form
Route::middleware('auth')->get('/catch/create', function () {
    return view('catch.create');
})->name('catch.create');

// Store fish catch
Route::middleware('auth')->post('/catch/store', [FishCatchController::class, 'store'])->name('catch.store');

// View catches
Route::middleware('auth')->get('/catches', [FishCatchController::class, 'index'])->name('catches.index');
Route::middleware('auth')->get('/catches/{catch}', [FishCatchController::class, 'show'])->name('catches.show');
Route::middleware('auth')->get('/catches/{catch}/pdf', [FishCatchController::class, 'generatePdf'])->name('catches.pdf');

// Logout
// Use the LoginController for logout
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->name('logout');

Route::post('/predict', [FishCatchController::class, 'predict'])->name('predict');

// ML API health check routes
Route::get('/ml/health', [FishCatchController::class, 'mlApiHealth'])->name('ml.health');
Route::get('/ml/models', [FishCatchController::class, 'mlApiModels'])->name('ml.models');

// Test route to verify database structure
Route::get('/test-db', function() {
    $catch = new \App\Models\FishCatch();
    $fillable = $catch->getFillable();
    echo "Fillable fields: " . implode(', ', $fillable) . "\n";
    
    // Test database connection
    try {
        \DB::connection()->getPdo();
        echo "Database connection: OK\n";
        
        // Check if catches table exists
        $columns = \DB::select('SHOW COLUMNS FROM catches');
        echo "Database columns: " . count($columns) . " columns found\n";
        
        return "Database test completed successfully!";
    } catch (\Exception $e) {
        return "Database error: " . $e->getMessage();
    }
});
