<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\FishController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Fish identification endpoint
Route::post('/identify', [FishController::class, 'identify']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Registration route (for demonstration)
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role' => 'required|in:BFAR_PERSONNEL,REGIONAL_ADMIN',
    ]);
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);
    return response()->json(['message' => 'User registered', 'user' => $user], 201);
});

// Login route
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    $token = $user->createToken('api-token')->plainTextToken;
    return response()->json(['token' => $token, 'role' => $user->role]);
});

// Protected route for BFAR Personnel
Route::middleware(['auth:sanctum', 'role:BFAR_PERSONNEL'])->post('/catch', function (Request $request) {
    // Logic for inputting fish catch data (stub)
    return response()->json(['message' => 'Fish catch data submitted']);
});

// Protected route for Regional Office Admin
Route::middleware(['auth:sanctum', 'role:REGIONAL_ADMIN'])->get('/admin/reports', function () {
    // Logic for generating reports (stub)
    return response()->json(['message' => 'Report generated']);
});
