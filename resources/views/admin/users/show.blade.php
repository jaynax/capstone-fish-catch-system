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
                                <i class="bx bx-user me-2"></i>User Details: {{ $user->name }}
                            </h4>
                            <p class="card-subtitle">User ID: {{ $user->id }} | Registered: {{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back me-1"></i>Back to Users
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit me-1"></i>Edit
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="mb-3">
                                <img src="{{ $user->profile_image ? asset('storage/profile_images/' . $user->profile_image) : asset('assets/img/avatars/1.png') }}" 
                                     class="img-thumbnail rounded-circle" width="150" height="150" style="object-fit: cover;">
                            </div>
                            <h5 class="mb-1">{{ $user->name }}</h5>
                            <div class="mb-2">
                                @if($user->role_id === 1)
                                    <span class="badge bg-info">BFAR Personnel</span>
                                @elseif($user->role_id === 2)
                                    <span class="badge bg-warning">Regional Admin</span>
                                @else
                                    <span class="badge bg-secondary">User</span>
                                @endif
                            </div>
                            <div class="text-muted">
                                <div>Member since {{ $user->created_at->format('M d, Y') }}</div>
                                <div>Last updated: {{ $user->updated_at->diffForHumans() }}</div>
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
                                            <label class="form-label fw-bold">Full Name:</label>
                                            <p class="form-control-plaintext">{{ $user->name }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Email Address:</label>
                                            <p class="form-control-plaintext">{{ $user->email }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Phone Number:</label>
                                            <p class="form-control-plaintext">{{ $user->phone ?? 'Not provided' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Account Status:</label>
                                            <p class="form-control-plaintext">
                                                @if($user->email_verified_at)
                                                    <span class="badge bg-success">Verified</span>
                                                @else
                                                    <span class="badge bg-warning">Unverified</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold">Address:</label>
                                            <p class="form-control-plaintext">{{ $user->address ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Activity</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Activity</th>
                                                    <th>IP Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $user->created_at->format('M d, Y h:i A') }}</td>
                                                    <td>Account Created</td>
                                                    <td>N/A</td>
                                                </tr>
                                                @if($user->last_login_at)
                                                <tr>
                                                    <td>{{ $user->last_login_at->format('M d, Y h:i A') }}</td>
                                                    <td>Last Login</td>
                                                    <td>{{ $user->last_login_ip ?? 'N/A' }}</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                </div>
            </div>
        </div>
    </div>
</div>

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
</style>
@endsection
