@extends('layouts.users.app')

@push('styles')
<style>
    /* Custom styles for the table */
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
    }

    .card-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .card-subtitle {
        color: #6c757d;
        font-size: 0.875rem;
        margin-bottom: 0;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-top: none;
        padding: 1rem 1.5rem;
    }

    .table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-color: #f1f3f6;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .empty-state i {
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-link {
        color: #0d6efd;
        border-color: #dee2e6;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
        background-color: rgba(0, 0, 0, 0.015);
    }

    .badge {
        font-size: 0.7rem;
        font-weight: 500;
        padding: 0.35em 0.65em;
        border-radius: 50rem;
    }

    .btn-group .btn {
        padding: 0.35rem 0.5rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease-in-out;
    }

    .btn-group .btn:hover {
        transform: translateY(-1px);
    }

    .btn-primary {
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }

    /* Responsive table styles */
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table thead {
            display: none;
        }
        
        .table, .table tbody, .table tr, .table td {
            display: block;
            width: 100%;
        }
        
        .table tr {
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }
        
        .table td {
            text-align: right;
            padding-left: 50%;
            position: relative;
            border-bottom: 1px solid #dee2e6;
        }
        
        .table td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            width: 45%;
            padding-right: 1rem;
            text-align: left;
            font-weight: 600;
            color: #6c757d;
        }
        
        .table td:last-child {
            border-bottom: 0;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    }

    /* Pagination */
    .pagination {
        margin: 1.5rem 0 0 0;
    }
    
    .page-link {
        color: #2c3e50;
        border: 1px solid #dee2e6;
        margin: 0 0.25rem;
        border-radius: 0.375rem !important;
        min-width: 2.5rem;
        text-align: center;
        transition: all 0.2s ease-in-out;
    }
    
    .page-link:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div class="mb-3 mb-md-0">
                            <h4 class="card-title mb-1">
                                <i class='bx bx-list-ul me-2'></i>My Fish Catch Records
                            </h4>
                            <p class="card-subtitle">View and manage your submitted fish catch reports</p>
                        </div>
                        <a href="{{ route('catches.create') }}" class="btn btn-primary">
                            <i class='bx bx-plus me-1'></i>New Catch Report
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($catches->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date & Time</th>
                                        <th>Fisherman</th>
                                        <th>Species</th>
                                        <th>Length</th>
                                        <th>Weight</th>
                                        <th>Region</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($catches as $catch)
                                    <tr>
                                        <td data-label="ID">
                                            <span class="badge bg-primary">#{{ $catch->id }}</span>
                                        </td>
                                        <td data-label="Date & Time">
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium">{{ \Carbon\Carbon::parse($catch->date_sampling)->format('M d, Y') }}</span>
                                                <small class="text-muted">{{ $catch->time_landing }}</small>
                                            </div>
                                        </td>
                                        <td data-label="Fisherman">{{ $catch->fisherman_name }}</td>
                                        <td data-label="Species">
                                            <span class="badge bg-label-primary">{{ $catch->species }}</span>
                                        </td>
                                        <td data-label="Length">{{ $catch->length_cm }} cm</td>
                                        <td data-label="Weight">{{ $catch->weight_g }} g</td>
                                        <td data-label="Region">
                                            <span class="badge bg-label-info">{{ $catch->region }}</span>
                                        </td>
                                        <td data-label="Latitude">
                                            @if($catch->fishingOperations->isNotEmpty() && $catch->fishingOperations->first()->latitude)
                                                {{ number_format($catch->fishingOperations->first()->latitude, 6) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td data-label="Longitude">
                                            @if($catch->fishingOperations->isNotEmpty() && $catch->fishingOperations->first()->longitude)
                                                {{ number_format($catch->fishingOperations->first()->longitude, 6) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td data-label="Status">
                                            @if($catch->image_path)
                                                <span class="badge bg-success">
                                                    <i class="bx bx-image me-1"></i>With Photo
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bx bx-edit me-1"></i>Manual Entry
                                                </span>
                                            @endif
                                        </td>
                                        <td data-label="Actions">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('catches.show', $catch) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="View Details"
                                                   data-bs-toggle="tooltip">
                                                    <i class="bx bx-show"></i>
                                                    <span class="d-none d-md-inline ms-1">View</span>
                                                </a>
                                                <a href="{{ route('catches.pdf', $catch) }}" 
                                                   class="btn btn-sm btn-outline-success" 
                                                   title="Download PDF"
                                                   data-bs-toggle="tooltip">
                                                    <i class="bx bx-download"></i>
                                                    <span class="d-none d-md-inline ms-1">PDF</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($catches->hasPages())
                        <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                            <div class="text-muted small">
                                Showing {{ $catches->firstItem() }} to {{ $catches->lastItem() }} of {{ $catches->total() }} entries
                            </div>
                            <div>
                                {{ $catches->links() }}
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <div class="mb-3">
                                <i class="bx bx-fish bx-lg"></i>
                            </div>
                            <h5 class="mb-2">No catch records found</h5>
                            <p class="text-muted mb-4">You haven't submitted any fish catch reports yet.</p>
                            <a href="{{ route('catch.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus me-1"></i>Create Your First Report
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Enable Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection