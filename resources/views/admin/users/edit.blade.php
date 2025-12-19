@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">
                                <i class="bx bx-edit me-2"></i>Edit User: {{ $user->name }}
                            </h4>
                            <p class="card-subtitle">User ID: {{ $user->id }} | Last Updated: {{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i>Cancel
                            </a>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info">
                                <i class="bx bx-show me-1"></i>View
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Profile Picture</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <img id="profileImagePreview" 
                                                 src="{{ $user->profile_image ? asset('storage/profile_images/' . $user->profile_image) : asset('assets/img/avatars/1.png') }}" 
                                                 class="img-thumbnail rounded-circle" 
                                                 width="150" 
                                                 height="150" 
                                                 style="object-fit: cover;">
                                        </div>
                                        <div class="mb-3">
                                            <input type="file" 
                                                   class="form-control @error('profile_image') is-invalid @enderror" 
                                                   id="profile_image" 
                                                   name="profile_image" 
                                                   accept="image/*"
                                                   onchange="previewImage(this)">
                                            @error('profile_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Max file size: 2MB. Allowed formats: JPG, PNG, GIF</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0"><i class="bx bx-shield-quarter me-2"></i>Account Status</h6>
                                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }} rounded-pill">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="form-label fw-bold">Email Verification</label>
                                                <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }} text-dark">
                                                    {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                                                </span>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="email_verified" 
                                                       name="email_verified" value="1" {{ $user->email_verified_at ? 'checked' : '' }}>
                                                <label class="form-check-label" for="email_verified">
                                                    {{ $user->email_verified_at ? 'Mark as Unverified' : 'Mark as Verified' }}
                                                </label>
                                            </div>
                                            @if($user->email_verified_at)
                                                <small class="text-muted d-block mt-1">
                                                    Verified on: {{ $user->email_verified_at->format('M d, Y h:i A') }}
                                                </small>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Account Status</label>
                                            <select class="form-select @error('is_active') is-invalid @enderror" name="is_active" id="accountStatus">
                                                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active - User can log in</option>
                                                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive - Prevent user login</option>
                                            </select>
                                            <small class="text-muted d-block mt-1">
                                                Current status: 
                                                <span id="statusHelpText" class="fw-medium">
                                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </small>
                                            @error('is_active')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="account-activity">
                                            <h6 class="fw-bold mb-3">Activity</h6>
                                            <div class="d-flex mb-2">
                                                <div class="me-3 text-muted">
                                                    <i class="bx bx-calendar me-1"></i> Member since
                                                </div>
                                                <div>
                                                    {{ $user->created_at->format('M d, Y') }}
                                                    <small class="text-muted ms-1">({{ $user->created_at->diffForHumans() }})</small>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="me-3 text-muted">
                                                    <i class="bx bx-time me-1"></i> Last login
                                                </div>
                                                <div>
                                                    @if($user->last_login_at)
                                                        {{ $user->last_login_at->format('M d, Y h:i A') }}
                                                        <small class="text-muted d-block">
                                                            IP: {{ $user->last_login_ip }}
                                                            <span class="mx-2">•</span>
                                                            {{ $user->last_login_at->diffForHumans() }}
                                                        </small>
                                                    @else
                                                        <span class="text-muted">Never logged in</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Personal Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="phone" class="form-label fw-bold">Phone Number</label>
                                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="role_id" class="form-label fw-bold">User Role <span class="text-danger">*</span></label>
                                                <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                                                    <option value="" disabled>Select Role</option>
                                                    <option value="1" {{ old('role_id', $user->role_id) == 1 ? 'selected' : '' }}>BFAR Personnel</option>
                                                    <option value="2" {{ old('role_id', $user->role_id) == 2 ? 'selected' : '' }}>Regional Admin</option>
                                                </select>
                                                @error('role_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-12 mb-3">
                                                <label for="address" class="form-label fw-bold">Address</label>
                                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                                          id="address" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Change Password</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <i class="bx bx-info-circle me-2"></i> Leave password fields blank to keep the current password.
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="password" class="form-label fw-bold">New Password</label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                       id="password" name="password" autocomplete="new-password">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Minimum 8 characters</div>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                                                <input type="password" class="form-control" 
                                                       id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image preview function
    function previewImage(input) {
        const preview = document.getElementById('profileImagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Toggle email verification timestamp
    document.addEventListener('DOMContentLoaded', function() {
        const emailVerifiedCheckbox = document.getElementById('email_verified');
        
        emailVerifiedCheckbox.addEventListener('change', function() {
            const label = this.nextElementSibling;
            label.textContent = this.checked ? 'Verified' : 'Not Verified';
        });
    });
</script>
@endpush

<style>
.form-control-plaintext {
    padding: 0.375rem 0;
    margin-bottom: 0;
    line-height: 1.5;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
}

.card {
    margin-bottom: 1.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    padding: 0.75rem 1.25rem;
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.btn-group .btn {
    margin-right: 0.25rem;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

#profileImagePreview {
    max-width: 100%;
    height: auto;
}
</style>
@endsection
