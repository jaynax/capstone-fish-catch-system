@extends('layouts.admin.app')

@section('content')
<div class="container mt-5">
    <div class="card p-4">
        <h2 class="mb-4"><i class="bx bx-user me-2"></i>Edit Profile</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bx bx-error-circle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form id="profile-form" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Left Column - Profile Image -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Profile Photo</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <img id="profile-preview" 
                                    src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : asset('assets/img/avatars/1.png') }}" 
                                    class="rounded-circle border border-3 border-primary shadow mb-3" 
                                    width="200" 
                                    height="200"
                                    style="object-fit: cover;">
                                
                                <div class="d-grid">
                                    <label for="profile_image" class="btn btn-outline-primary btn-sm">
                                        <i class="bx bx-upload me-1"></i> Change Photo
                                    </label>
                                    <input type="file" 
                                           name="profile_image" 
                                           id="profile_image" 
                                           class="d-none" 
                                           accept="image/*">
                                    <small class="text-muted d-block mt-2">
                                        JPG, PNG or GIF. Max size 2MB
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Form Fields -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Profile Information</h6>
                        </div>
                        <div class="card-body">
                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', Auth::user()->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', Auth::user()->email) }}" 
                                       required
                                       {{ Auth::user()->email_verified_at ? 'readonly' : '' }}>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(!Auth::user()->email_verified_at)
                                    <small class="text-warning">
                                        <i class="bx bx-info-circle"></i> 
                                        Please verify your email address.
                                    </small>
                                @endif
                            </div>

                            <!-- Current Password -->
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password <small class="text-muted">(required to update email/password)</small></label>
                                <div class="input-group">
                                    <input type="password" 
                                           id="current_password" 
                                           name="current_password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           placeholder="Enter current password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="bx bx-hide"></i>
                                    </button>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
                                <div class="input-group">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Enter new password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="bx bx-hide"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">
                                    Must be at least 8 characters long
                                </small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           class="form-control" 
                                           placeholder="Confirm new password">
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="bx bx-hide"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i> Save Changes
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-1"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Image preview
const profileImage = document.getElementById('profile_image');
const profilePreview = document.getElementById('profile-preview');

if (profileImage) {
    profileImage.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePreview.src = e.target.result;
                
                // Update navbar profile image if it exists
                const navbarProfileImage = document.getElementById('navbar-profile-image');
                if (navbarProfileImage) {
                    navbarProfileImage.src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    });
}

// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function() {
        const input = this.previousElementSibling;
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bx-hide');
            icon.classList.add('bx-show');
        } else {
            input.type = 'password';
            icon.classList.remove('bx-show');
            icon.classList.add('bx-hide');
        }
    });
});

// Auto-hide alerts after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>
@endpush
        }
    };
    reader.readAsDataURL(event.target.files[0]);
});
</script>
@endsection
