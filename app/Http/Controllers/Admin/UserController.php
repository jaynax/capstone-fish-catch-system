<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:BFAR_PERSONNEL,REGIONAL_ADMIN'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            // Map role names to their corresponding IDs from the database
            $roleMap = [
                'BFAR_PERSONNEL' => 1,  // BFAR Personnel
                'REGIONAL_ADMIN' => 2,  // Regional Admin
            ];
            
            // Default to BFAR Personnel if role not found
            $roleId = $roleMap[strtoupper($request->role)] ?? 1;
            
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $roleId,
                'phone' => $request->phone,
                'address' => $request->address,
                'email_verified_at' => now(),
            ]);

            return redirect()->route('admin.users')
                ->with('success', 'User created successfully');

        } catch (\Exception $e) {
            \Log::error('Error creating user: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create user: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified user.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $user = User::with('role')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        // Validate the request data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'integer', 'in:1,2'], // 1: BFAR Personnel, 2: Regional Admin
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'email_verified' => ['nullable', 'boolean'],
            'is_active' => ['required', 'boolean'],
        ]);

        try {
            // Update user data
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->is_active = $request->is_active;
            
            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            
            // Update email verification status
            if ($request->has('email_verified') && $request->email_verified && !$user->email_verified_at) {
                $user->email_verified_at = now();
            } elseif (!$request->has('email_verified') || !$request->email_verified) {
                $user->email_verified_at = null;
            }
            
            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                if ($user->profile_image) {
                    $oldImagePath = public_path('storage/profile_images/' . $user->profile_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                // Store new image
                $image = $request->file('profile_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('storage/profile_images'), $imageName);
                $user->profile_image = $imageName;
            }
            
            $user->save();
            
            return redirect()->route('admin.users.show', $user->id)
                ->with('success', 'User updated successfully');
                
        } catch (\Exception $e) {
            \Log::error('Error updating user: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update user: ' . $e->getMessage()]);
        }
    }

    /**
     * Approve the specified user.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent approving yourself if already approved
            if ($user->id === auth()->id() && $user->isApproved()) {
                return redirect()->route('admin.users')
                    ->with('error', 'Your account is already approved.');
            }
            
            // Update user status
            $user->status = 'approved';
            $user->save();
            
            // Send approval notification to the user
            $user->notify(new \App\Notifications\UserApproved($user));
            
            return redirect()->route('admin.users')
                ->with('success', 'User approved successfully. The user has been notified.');
                
        } catch (\Exception $e) {
            \Log::error('Error approving user: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->route('admin.users')
                ->with('error', 'Failed to approve user: ' . $e->getMessage());
        }
    }
    
    /**
     * Reject the specified user.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent rejecting yourself
            if ($user->id === auth()->id()) {
                return redirect()->route('admin.users')
                    ->with('error', 'You cannot reject your own account.');
            }
            
            // Get the rejection reason from the request
            $reason = request()->input('reason', null);
            
            // Update user status
            $user->status = 'rejected';
            $user->save();
            
            // Send rejection notification to the user with the reason
            $user->notify(new \App\Notifications\UserRejected($user, $reason));
            
            return redirect()->route('admin.users')
                ->with('success', 'User rejected successfully. The user has been notified.');
                
        } catch (\Exception $e) {
            \Log::error('Error rejecting user: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->route('admin.users')
                ->with('error', 'Failed to reject user: ' . $e->getMessage());
        }
    }
    
    /**
     * Remove the specified user from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting yourself
            if ($user->id === auth()->id()) {
                return redirect()->route('admin.users')
                    ->with('error', 'You cannot delete your own account.');
            }
            
            $user->delete();
            
            return redirect()->route('admin.users')
                ->with('success', 'User deleted successfully');
                
        } catch (\Exception $e) {
            \Log::error('Error deleting user: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->route('admin.users')
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
