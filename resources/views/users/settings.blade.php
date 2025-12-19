@extends('layouts.app')
@section('title', 'Settings')

@section('content')
@php
    $user = Auth::user();
    // Check if user is using social login
    $isSocial = !is_null($user->provider ?? null) || is_null($user->password);
@endphp

<div class="container py-4">
    <div class="mb-4">
        <h4 class="mb-1">Account Settings</h4>
        <small class="text-muted">
            Manage your profile, security, and display preferences.
        </small>
    </div>

    <div class="row g-4">
        <!-- PROFILE SECTION -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class='bx bx-user me-2'></i>
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Avatar Upload -->
                        <div class="mb-4 text-center">
                            <div class="position-relative d-inline-block">
                                <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}" 
                                     class="rounded-circle border" 
                                     width="120" 
                                     height="120"
                                     id="avatarPreview">
                                <div class="upload-btn-wrapper">
                                    <button class="btn-upload" type="button">
                                        <i class='bx bx-camera'></i>
                                    </button>
                                    <input type="file" name="avatar" id="avatarInput" accept="image/*">
                                </div>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">Click on the camera icon to change your avatar</small>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   {{ $isSocial ? 'disabled' : 'required' }}>
                            @if($isSocial)
                                <small class="text-muted">Email is managed by your social account.</small>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save me-1'></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- PREFERENCES SECTION -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class='bx bx-moon me-2'></i>
                    <h5 class="mb-0">Display Preferences</h5>
                </div>
                <div class="card-body">
                    <form id="preferencesForm" action="{{ route('profile.preferences') }}" method="POST">
                        @csrf
                        
                        <!-- Dark Mode Toggle -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h6 class="mb-1">Dark Mode</h6>
                                <p class="text-muted small mb-0">Switch between light and dark theme</p>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" id="darkModeToggle" name="dark_mode" 
                                       {{ old('dark_mode', $user->preferences['dark_mode'] ?? false) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <!-- Theme Color Picker -->
                        <div class="mb-4">
                            <label class="form-label">Theme Color</label>
                            <div class="d-flex flex-wrap gap-2" id="themeColorPicker">
                                @php
                                    $colors = [
                                        'primary' => '#4e73df',
                                        'success' => '#1cc88a',
                                        'info' => '#36b9cc',
                                        'warning' => '#f6c23e',
                                        'danger' => '#e74a3b',
                                        'indigo' => '#6610f2',
                                        'purple' => '#6f42c1',
                                        'pink' => '#e83e8c',
                                        'teal' => '#20c9a6',
                                        'orange' => '#fd7e14'
                                    ];
                                    $currentColor = old('theme_color', $user->preferences['theme_color'] ?? 'primary');
                                @endphp
                                @foreach($colors as $name => $color)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="theme_color" 
                                               id="color-{{ $name }}" value="{{ $name }}"
                                               {{ $currentColor === $name ? 'checked' : '' }}>
                                        <label class="form-check-label" for="color-{{ $name }}">
                                            <span class="theme-color-option" style="background-color: {{ $color }};"></span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Save Preferences Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class='bx bx-save me-1'></i> Save Preferences
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(!$isSocial)
        <!-- PASSWORD SECTION -->
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class='bx bx-lock-alt me-2'></i>
                    <h5 class="mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    <form id="passwordForm" action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger">
                                <i class='bx bx-refresh me-1'></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .upload-btn-wrapper {
        position: absolute;
        bottom: 0;
        right: 0;
        overflow: hidden;
        width: 40px;
        height: 40px;
    }
    .upload-btn-wrapper input[type=file] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    .btn-upload {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #4e73df;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
    .btn-upload:hover {
        background: #2e59d9;
        transform: scale(1.1);
    }
    .theme-color-option {
        display: inline-block;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s ease;
    }
    .form-check-input:checked + .form-check-label .theme-color-option {
        border-color: #000;
        transform: scale(1.1);
    }
    .form-switch .form-check-input:checked {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    /* Dark mode styles */
    [data-bs-theme="dark"] .card {
        background-color: #2d2d2d;
        border-color: #3d3d3d;
    }
    [data-bs-theme="dark"] .card-header {
        background-color: #2d2d2d !important;
        border-bottom-color: #3d3d3d;
    }
    [data-bs-theme="dark"] .form-control, 
    [data-bs-theme="dark"] .form-select {
        background-color: #2d2d2d;
        border-color: #3d3d3d;
        color: #fff;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview avatar image before upload
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    
    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    avatarPreview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Toggle dark mode
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function() {
            const isDark = this.checked;
            document.documentElement.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
            
            // Save preference via AJAX
            fetch('{{ route("profile.preferences") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    dark_mode: isDark ? 1 : 0,
                    _token: '{{ csrf_token() }}'
                })
            });
        });
    }

    // Handle form submissions with AJAX
    const forms = ['profileForm', 'preferencesForm', 'passwordForm'];
    forms.forEach(formId => {
        const form = document.getElementById(formId);
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitButton = this.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;
                
                // Show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
                
                try {
                    const response = await fetch(this.action, {
                        method: this.method,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        showToast('Settings saved successfully!', 'success');
                        
                        // Update theme if preferences were changed
                        if (formId === 'preferencesForm' && data.theme_color) {
                            document.documentElement.setAttribute('data-theme', data.theme_color);
                        }
                    } else {
                        throw new Error(data.message || 'Failed to save settings');
                    }
                } catch (error) {
                    showToast(error.message || 'An error occurred. Please try again.', 'danger');
                    console.error('Error:', error);
                } finally {
                    // Reset button state
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            });
        }
    });
});

// Show toast notification
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bx ${type === 'success' ? 'bx-check-circle' : 'bx-error' } me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast, { autohide: true, delay: 3000 });
    bsToast.show();
    
    // Remove toast after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
        document.body.removeChild(toast);
    });
}
</script>
@endpush
