@extends('layouts.admin.app')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .form-required:after {
        content: " *";
        color: #dc3545;
    }
    
    /* Improved pagination styling */
    .pagination {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
        margin: 1rem 0;
    }
    
    .pagination .page-item {
        margin: 0 2px;
    }
    
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0.5rem;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        color: #0d6efd;
        transition: all 0.2s ease;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .pagination .page-link:hover:not(.active) {
        background-color: #e9ecef;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .pagination {
            gap: 0.25rem;
        }
        
        .pagination .page-link {
            min-width: 34px;
            height: 34px;
            padding: 0.25rem;
            font-size: 0.875rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-check-circle me-2" style="font-size: 1.5rem;"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-error me-2" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong>Error!</strong> Please check the form below for errors.
                            <ul class="mb-0 mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">Manage Users</h4>
                            <p class="card-subtitle mb-0">View and manage all registered users</p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                <i class="bx bx-plus"></i> Create New User
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <img src="{{ $user->profile_image ? asset('storage/profile_images/' . $user->profile_image) : asset('assets/img/avatars/1.png') }}" 
                                             class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'BFAR_PERSONNEL')
                                            <span class="badge bg-info">BFAR Personnel</span>
                                        @elseif($user->role === 'REGIONAL_ADMIN')
                                            <span class="badge bg-warning">Regional Admin</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $user->role }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->address)
                                            <span title="{{ $user->address }}">{{ Str::limit($user->address, 30) }}</span>
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->phone)
                                            {{ $user->phone }}
                                        @else
                                            <span class="text-muted">Not provided</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->phone ?: 'N/A' }}</td>
                                    <td>
                                        @if($user->isPending())
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($user->isApproved())
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($user->isRejected())
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td data-label="Actions">
                                        <div class="action-btns d-flex justify-content-end">
                                            @if($user->isPending() || $user->isRejected())
                                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to approve this user?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Approve User">
                                                        <i class="bx bx-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($user->isPending() || $user->isApproved())
                                                <button type="button" class="btn btn-sm btn-danger ms-1" data-bs-toggle="modal" data-bs-target="#rejectUserModal" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" title="Reject User">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            @endif
                                            
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-info ms-1" data-bs-toggle="tooltip" title="View Details">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary ms-1" data-bs-toggle="tooltip" title="Edit">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            @if($user->id !== Auth::id())
                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bx bx-user bx-lg mb-2"></i>
                                            <p>No users found.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($users->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->onEachSide(1)->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST" onsubmit="document.getElementById('createUserSpinner').classList.remove('d-none');">
                @csrf
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label form-required">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label form-required">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label form-required">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="form-text">Minimum 8 characters</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label form-required">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label form-required">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="BFAR_PERSONNEL">BFAR Personnel</option>
                                <option value="REGIONAL_ADMIN">Regional Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm d-none" id="createUserSpinner" role="status" aria-hidden="true"></span>
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
// Function to initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
    
    // Delete confirmation is now handled by the browser's native confirm dialog
});

// Function to confirm user deletion
function confirmDelete(event) {
    if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        event.preventDefault();
        return false;
    }
    
    // Show loading state
    const form = event.target.closest('form');
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        const originalHtml = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...';
        
        // Revert button state after form submission starts
        setTimeout(() => {
            if (!form.submitted) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
            }
        }, 5000);
    }
    
    return true;
}

// Function to handle form submission with loading state
function handleFormSubmit(form, event) {
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        const spinner = submitBtn.querySelector('.spinner-border');
        if (spinner) spinner.classList.remove('d-none');
    }
    return true;
}

// View user details
function viewUser(id) {
    // Implement view user details modal
    alert('View user details for ID: ' + id);
}

// Edit user functionality
function editUser(id) {
    // Implement edit user functionality
    alert('Edit user with ID: ' + id);
}
</script>
@endpush
@endsection