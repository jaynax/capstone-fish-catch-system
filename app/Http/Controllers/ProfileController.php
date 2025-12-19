<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        return view('layouts.users.profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            \Log::info('Profile update request received', ['user_id' => $user->id, 'request' => $request->all()]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Update name and email
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                if ($user->profile_image && Storage::exists('public/profile_images/' . $user->profile_image)) {
                    Storage::delete('public/profile_images/' . $user->profile_image);
                }
                
                // Store new image with a unique name
                $file = $request->file('profile_image');
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Store the file in the public disk (storage/app/public/profile_images)
                $path = $file->storeAs('public/profile_images', $imageName);
                
                // Update user's profile image with just the filename
                $user->profile_image = $imageName;
            }

            $user->save();
            \Log::info('Profile updated successfully', ['user_id' => $user->id]);

            return redirect()->route('profile.edit')
                ->with('success', 'Profile updated successfully!');
                
        } catch (\Exception $e) {
            \Log::error('Profile update failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Failed to update profile. Please try again.')
                ->withInput();
        }
    }


}
