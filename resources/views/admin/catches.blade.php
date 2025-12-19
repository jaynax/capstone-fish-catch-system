@extends('layouts.admin.app')

@push('styles')
<style>
    .table-hover > tbody > tr {
        cursor: pointer;
    }
    .table-hover > tbody > tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    .table > :not(caption) > * > * {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.85em;
    }
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0">All Fish Catches</h4>
                        <p class="card-subtitle mb-0">Total: {{ $catches->total() }} records</p>
                    </div>
                    <div class="d-flex gap-2">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search..." style="max-width: 250px;">
                        <button class="btn btn-outline-primary" id="toggleFilters">
                            <i class='bx bx-filter-alt'></i> Filters
                        </button>
                    </div>
                </div>
                
                <!-- Filters Panel -->
                <div class="card-body border-bottom" id="filtersPanel" style="display: none;">
                    <form action="{{ route('admin.catches') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Species</label>
                            <input type="text" name="species" class="form-control" value="{{ request('species') }}" placeholder="Filter by species">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date Range</label>
                            <div class="input-group">
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                <span class="input-group-text">to</span>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">User</label>
                            <input type="text" name="user" class="form-control" value="{{ request('user') }}" placeholder="Filter by user">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Apply Filters</button>
                            <a href="{{ route('admin.catches') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Species</th>
                                    <th>Length (cm)</th>
                                    <th>Weight (g)</th>
                                    <th>Gear Type</th>
                                    <th>Date/Time</th>
                                    <th>Location</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($catches as $catch)
                                <tr data-searchable="{{ strtolower($catch->id . ' ' . $catch->species . ' ' . $catch->user?->name . ' ' . $catch->gear_type) }}">
                                    <td class="fw-semibold">#{{ $catch->id }}</td>
                                    <td>
                                        @if($catch->user)
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $catch->user->profile_image ? asset('storage/profile_images/' . $catch->user->profile_image) : asset('assets/img/avatars/1.png') }}" 
                                                 class="rounded-circle me-2" width="32" height="32" style="object-fit: cover;">
                                            <div>
                                                <div class="fw-semibold">{{ $catch->user->name }}</div>
                                                <small class="text-muted">{{ $catch->user->email ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                        @else
                                            <span class="text-muted">User not found</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $catch->species ?? 'N/A' }}</span>
                                        @if($catch->scientific_name)
                                            <div class="small text-muted">{{ $catch->scientific_name }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $catch->length_cm ?? 'N/A' }} cm</td>
                                    <td>{{ $catch->weight_g ? number_format($catch->weight_g) . 'g' : 'N/A' }}</td>
                                    <td>{{ $catch->gear_type ?? 'N/A' }}</td>
                                    <td>
                                        @if($catch->catch_datetime)
                                            <div>{{ $catch->catch_datetime->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $catch->catch_datetime->format('H:i:s') }}</small>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($catch->latitude && $catch->longitude)
                                            <a href="https://maps.google.com/?q={{ $catch->latitude }},{{ $catch->longitude }}" target="_blank" class="d-flex align-items-center">
                                                <i class="bx bx-map-pin me-1"></i> 
                                                <span>View Map</span>
                                            </a>
                                            <div class="small text-muted">
                                                {{ number_format($catch->latitude, 4) }}, {{ number_format($catch->longitude, 4) }}
                                            </div>
                                        @else
                                            <span class="text-muted">No location</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" title="View" onclick="viewCatch({{ $catch->id }})">
                                                <i class="bx bx-show"></i>
                                            </button>
                                            <a href="{{ route('admin.catches.edit', $catch->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" title="Delete" onclick="deleteCatch({{ $catch->id }})">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bx bx-fish bx-lg mb-2"></i>
                                            <p>No fish catches found matching your criteria.</p>
                                            @if(request()->hasAny(['species', 'start_date', 'end_date', 'user']))
                                                <a href="{{ route('admin.catches') }}" class="btn btn-sm btn-outline-primary mt-2">
                                                    Clear filters
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($catches->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $catches->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function viewCatch(id) {
    window.location.href = '/admin/catches/' + id;
}

function deleteCatch(id) {
    if (!confirm('Are you sure you want to delete this catch record? This action cannot be undone.')) {
        return;
    }
    
    // Show loading state
    const deleteBtn = event.target.closest('.btn-outline-danger');
    const originalHtml = deleteBtn.innerHTML;
    deleteBtn.innerHTML = '<i class="bx bx-loader bx-spin"></i>';
    deleteBtn.disabled = true;
    
    // Send delete request
    fetch(`/admin/catches/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showToast('success', data.message);
            // Remove the row from the table
            event.target.closest('tr').remove();
            
            // Check if the table is empty and show a message
            const tbody = document.querySelector('table tbody');
            if (tbody.children.length === 1) { // Only the empty row remains
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="text-muted">
                                <i class="bx bx-fish bx-lg mb-2"></i>
                                <p>No fish catches recorded yet.</p>
                            </div>
                        </td>
                    </tr>`;
            }
        } else {
            throw new Error(data.message || 'Failed to delete catch record');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', error.message || 'An error occurred while deleting the catch record');
        deleteBtn.innerHTML = originalHtml;
        deleteBtn.disabled = false;
    });
}
</script>
@endsection

@push('scripts')
<script>
    // Toggle filters panel
    document.getElementById('toggleFilters').addEventListener('click', function() {
        const panel = document.getElementById('filtersPanel');
        panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
    });

    // Client-side search
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr[data-searchable]');
        
        rows.forEach(row => {
            const searchableText = row.getAttribute('data-searchable');
            if (searchableText.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // View catch details
    function viewCatch(id) {
        window.location.href = `/admin/catches/${id}`;
    }

    // Delete catch with confirmation
    function deleteCatch(id) {
        if (confirm('Are you sure you want to delete this catch record? This action cannot be undone.')) {
            fetch(`/admin/catches/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', data.message);
                    // Remove the row from the table
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) row.remove();
                } else {
                    throw new Error(data.message || 'Failed to delete catch');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', error.message || 'An error occurred while deleting the catch');
            });
        }
    }

    // Show toast notification
    function showToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove toast after it's hidden
        toast.addEventListener('hidden.bs.toast', function() {
            toast.remove();
        });
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
