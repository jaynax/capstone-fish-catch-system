@extends('layouts.users.app')
@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container mt-5">
    <div class="card p-4">
        <h2 class="mb-4">Edit Profile</h2>

        <!-- Success message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Validation errors -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Image -->
            <div class="mb-4 text-center">
                <div style="position: relative; display: inline-block;">
                    <img id="profile-preview"
                         src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image.'?'.time()) : asset('assets/img/default-profile.png') }}"
                         class="rounded-circle border border-2 shadow-sm"
                         width="150"
                         height="150"
                         style="object-fit: cover;">
                    
                    <!-- Change Photo Button overlay -->
                    <label for="profile_image" style="position: absolute; bottom: 0; right: 0; background: #0d6efd; color: #fff; padding: 5px 10px; border-radius: 20px; cursor: pointer; font-size: 12px;">
                        Change Photo
                    </label>
                </div>

                <!-- Hidden file input -->
                <input type="file" name="profile_image" id="profile_image" class="d-none" accept="image/*">
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', Auth::user()->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email (read-only) -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <button type="submit" class="btn btn-primary px-4" id="update-button">
                    <span id="button-text">Update Profile</span>
                    <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileImageInput = document.getElementById('profile_image');
    const profilePreview = document.getElementById('profile-preview');
    const profileForm = document.getElementById('profile-form');
    const updateButton = document.getElementById('update-button');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');

    // Preview new image immediately
    profileImageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePreview.src = e.target.result;

                // Optional: Update navbar image if exists
                const navbarProfileImage = document.getElementById('navbar-profile-image');
                if (navbarProfileImage) {
                    navbarProfileImage.src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // Show spinner on form submit
    profileForm.addEventListener('submit', function() {
        updateButton.disabled = true;
        buttonText.textContent = 'Updating...';
        spinner.classList.remove('d-none');
    });
});
</script>
@endsection