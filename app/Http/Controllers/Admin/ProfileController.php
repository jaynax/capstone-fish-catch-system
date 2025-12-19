<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the admin profile edit form.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        return view('layouts.admin.profile', compact('user'));
    }

    /**
     * Update the admin's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old profile image if exists
            if ($user->profile_image && Storage::exists('public/profile_images/' . $user->profile_image)) {
                Storage::delete('public/profile_images/' . $user->profile_image);
            }
            
            // Store new profile image
            $image = $request->file('profile_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store the file in the public disk
            $path = $request->file('profile_image')->storeAs('public/profile_images', $imageName);
            
            // Update the user's profile image
            $user->profile_image = $imageName;
        }

        $user->save();

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}
