@extends('layouts.users.app')

@push('styles')
<style>
    :root {
        --primary-color: #4e73df;
        --primary-hover: #2e59d9;
        --secondary-color: #6c757d;
        --success-color: #1cc88a;
        --info-color: #36b9cc;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
        --light-color: #f8f9fc;
        --dark-color: #5a5c69;
    }

    body {
        background-color: #f8f9fc;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
        border-bottom: none;
        border-radius: 0.5rem 0.5rem 0 0 !important;
        padding: 1.25rem 1.5rem;
        color: white;
    }

    .card-header.bg-white {
        background: white !important;
        color: var(--dark-color);
        border-bottom: 1px solid #e3e6f0;
    }

    .card-title {
        font-weight: 700;
        color: inherit;
        margin-bottom: 0.25rem;
        font-size: 1.25rem;
    }

    .card-subtitle {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.875rem;
        margin-bottom: 0;
    }

    .table {
        margin-bottom: 0;
        width: 100%;
        color: #5a5c69;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fc;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        color: #6e707e;
        border-top: 1px solid #e3e6f0;
        padding: 1rem 1.5rem;
        white-space: nowrap;
    }

    .table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-color: #e3e6f0;
        transition: all 0.2s ease;
    }

    .table-hover tbody tr {
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

    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
        background-color: #f8f9fc;
        transform: translateY(-1px);
        box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, 0.05);
    }

    .badge {
        font-weight: 600;
        padding: 0.4em 0.8em;
        font-size: 0.75rem;
        border-radius: 0.35rem;
        letter-spacing: 0.5px;
    }

    .btn {
        border-radius: 0.35rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }

    .btn-sm, .btn-group-sm > .btn {
        padding: 0.35rem 0.75rem;
        font-size: 0.75rem;
        line-height: 1.5;
        border-radius: 0.35rem;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-1px);
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .pagination {
        margin: 0;
    }

    .page-link {
        color: var(--primary-color);
        border: 1px solid #e3e6f0;
        padding: 0.5rem 0.95rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .page-link:hover {
        color: #224abe;
        background-color: #eaecf4;
        border-color: #dddfeb;
    }

    .empty-state {
        padding: 4rem 1.5rem;
        text-align: center;
        color: #6c757d;
        background-color: #f8f9fc;
        border-radius: 0.5rem;
        margin: 1.5rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #d1d3e2;
        margin-bottom: 1.5rem;
        opacity: 0.8;
    }

    .empty-state h5 {
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: #4e73df;
    }

    .empty-state p {
        margin-bottom: 1.5rem;
        color: #858796;
        max-width: 30rem;
        margin-left: auto;
        margin-right: auto;
    }

    /* Status badges */
    .badge-status {
        padding: 0.35em 0.65em;
        font-weight: 600;
        border-radius: 0.35rem;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-success {
        background-color: rgba(28, 200, 138, 0.1);
        color: #1cc88a;
    }

    .badge-warning {
        background-color: rgba(246, 194, 62, 0.1);
        color: #f6c23e;
    }

    .badge-danger {
        background-color: rgba(231, 74, 59, 0.1);
        color: #e74a3b;
    }

    /* Action buttons */
    .action-btns .btn {
        margin: 0 2px;
        opacity: 0.8;
        transition: all 0.2s ease;
    }

    .action-btns .btn:hover {
        opacity: 1;
        transform: translateY(-1px);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .table-responsive {
            border: 1px solid #e3e6f0;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        }
        
        .table thead {
            display: none;
        }
        
        .table, .table tbody, .table tr, .table td {
            display: block;
            width: 100%;
        }
        
        .table tr {
            margin-bottom: 1.5rem;
            border: 1px solid #e3e6f0;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .table tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        }
        
        .table td {
            text-align: right;
            padding-left: 50%;
            position: relative;
            border-bottom: 1px solid #f0f2f5;
            padding: 1rem 1.5rem 1rem 50%;
        }
        
        .table td::before {
            content: attr(data-label);
            position: absolute;
            left: 1.5rem;
            width: 45%;
            text-align: left;
            font-weight: 600;
            color: #4e73df;
            text-transform: uppercase;
            font-size: 0.7rem;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .table td:last-child {
            border-bottom: none;
            display: flex;
            justify-content: flex-end;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
            background-color: #f8f9fc;
        }
        
        .action-btns {
            margin-top: 0.5rem;
        }
        
        .empty-state {
            padding: 3rem 1.5rem;
            margin: 1rem;
        }
        
        .empty-state i {
            font-size: 3.5rem;
        }
    }

    @media (max-width: 576px) {
        .table td {
            padding-left: 40%;
        }
        
        .table td::before {
            width: 35%;
        }
        
        .empty-state {
            padding: 2.5rem 1rem;
        }
        
        .empty-state i {
            font-size: 3rem;
        }
        
        .empty-state h5 {
            font-size: 1.25rem;
        }
    }

    /* Pagination */
    .pagination {
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div class="mb-3 mb-md-0">
                            <h4 class="card-title mb-1">
                                <i class="bx bx-clipboard me-2"></i>Fish Catch Records
                            </h4>
                            <p class="card-subtitle">Comprehensive list of all recorded fish catches</p>
                        </div>
                        <a href="{{ route('catch.create') }}" class="btn btn-primary px-4">
                            <i class="bx bx-plus me-2"></i>New Catch Record
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-check-circle me-2" style="font-size: 1.5rem;"></i>
                                <div>
                                    <h6 class="mb-0">Success!</h6>
                                    <div class="small">{{ session('status') }}</div>
                                </div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
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
                                        <th>Length (cm)</th>
                                        <th>Weight (kg)</th>
                                        <th>Region</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($catches as $catch)
                                    <tr>
                                        <td data-label="ID">
                                            <span class="badge bg-light text-dark">#{{ str_pad($catch->id, 5, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td data-label="Date & Time">
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $catch->created_at->format('M d, Y') }}</span>
                                                <small class="text-muted">{{ $catch->created_at->format('h:i A') }}</small>
                                            </div>
                                        </td>
                                        <td data-label="Fisherman">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <div class="fw-semibold">{{ $catch->fisherman_name ?? 'N/A' }}</div>
                                                    <small class="text-muted">{{ $catch->fisherman_registration_id ?? 'ID: N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Species">
                                            <div class="fw-semibold">{{ $catch->species ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $catch->species_scientific ?? '' }}</small>
                                        </td>
                                        <td data-label="Length">
                                            @if(isset($catch->length_cm) && $catch->length_cm > 0)
                                                <span class="fw-semibold">{{ number_format($catch->length_cm, 1) }}</span> cm
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td data-label="Weight">
                                            @if(isset($catch->weight_kg) && $catch->weight_kg > 0)
                                                <span class="fw-semibold">{{ number_format($catch->weight_kg, 2) }}</span> kg
                                            @elseif(isset($catch->weight_g) && $catch->weight_g > 0)
                                                <span class="fw-semibold">{{ number_format($catch->weight_g / 1000, 2) }}</span> kg
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td data-label="Region">
                                            <div class="d-flex align-items-center">
                                                <i class='bx bx-map-pin me-1 text-muted'></i>
                                                <span>{{ $catch->region ?? 'N/A' }}</span>
                                            </div>
                                            @if($catch->latitude && $catch->longitude)
                                            <small class="text-muted d-block">{{ number_format($catch->latitude, 4) }}, {{ number_format($catch->longitude, 4) }}</small>
                                            @endif
                                        </td>
                                        <td data-label="Status" class="text-center">
                                            @php
                                                $status = $catch->status ?? 'recorded';
                                                $statusClass = [
                                                    'recorded' => '',
                                                    'verified' => 'bg-success',
                                                    'rejected' => 'bg-danger',
                                                    'pending' => 'bg-warning',
                                                ][$status] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge-status {{ $statusClass }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td data-label="Actions">
                                            <div class="action-btns d-flex justify-content-end">
                                                <a href="{{ route('catches.show', $catch->id) }}" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="View Details">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="{{ route('catches.edit', $catch->id) }}" class="btn btn-sm btn-outline-primary ms-1" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <form action="{{ route('catches.destroy', $catch->id) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Are you sure you want to delete this record? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('catches.pdf', $catch->id) }}" class="btn btn-sm btn-outline-secondary ms-1" data-bs-toggle="tooltip" title="Download PDF">
                                                    <i class="bx bx-download"></i>
                                                </a>
                                            </div
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($catches->hasPages())
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-4 py-3 border-top bg-light">
                            <div class="text-muted small mb-2 mb-md-0">
                                Showing <span class="fw-semibold">{{ $catches->firstItem() }}</span> to 
                                <span class="fw-semibold">{{ $catches->lastItem() }}</span> of 
                                <span class="fw-semibold">{{ $catches->total() }}</span> entries
                                @if(request()->has('search'))
                                    <span class="text-primary">(filtered)</span>
                                @endif
                            </div>
                            <div class="mt-2 mt-md-0">
                                <nav aria-label="Page navigation">
                                    {{ $catches->onEachSide(1)->links('pagination::bootstrap-5') }}
                                </nav>
                            </div>
                        </div>
                    @endif
                    @else
                        <div class="empty-state-container">
                            <div class="empty-state-card">
                                <div class="empty-state-icon">
                                    <i class='bx bx-fish'></i>
                                    <div class="ripple"></div>
                                    <div class="ripple delay-1"></div>
                                    <div class="ripple delay-2"></div>
                                </div>
                                <h3 class="empty-state-title">No Fish Catch Records Yet</h3>
                                <p class="empty-state-description">Your fishing journey starts here! Begin by adding your first catch to track and manage your fishing activities.</p>
                                <div class="empty-state-actions">
                                    <a href="{{ route('catch.create') }}" class="btn btn-primary btn-lg px-4 py-2 shadow-sm">
                                        <i class='bx bx-plus-circle me-2'></i>Record Your First Catch
                                    </a>
                                </div>
                                <div class="empty-state-tip mt-4">
                                    <i class='bx bx-info-circle me-2'></i>
                                    <span>Tip: You can track species, weight, location, and more for each catch.</span>
                                </div>
                            </div>
                        </div>
                        
                        <style>
                        .empty-state-container {
                            min-height: 60vh;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            padding: 2rem;
                        }
                        
                        .empty-state-card {
                            max-width: 500px;
                            text-align: center;
                            padding: 3rem 2rem;
                            background: white;
                            border-radius: 1rem;
                            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.05);
                            position: relative;
                            overflow: hidden;
                            border: 1px solid rgba(0, 0, 0, 0.05);
                        }
                        
                        .empty-state-icon {
                            position: relative;
                            width: 100px;
                            height: 100px;
                            margin: 0 auto 2rem;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                        
                        .empty-state-icon i {
                            font-size: 3.5rem;
                            color: #4e73df;
                            position: relative;
                            z-index: 2;
                            background: white;
                            width: 80px;
                            height: 80px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border-radius: 50%;
                            box-shadow: 0 0.5rem 1rem rgba(78, 115, 223, 0.15);
                        }
                        
                        .ripple {
                            position: absolute;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            border: 2px solid rgba(78, 115, 223, 0.2);
                            border-radius: 50%;
                            animation: ripple 3s infinite ease-out;
                            opacity: 0;
                        }
                        
                        .delay-1 {
                            animation-delay: 0.5s;
                        }
                        
                        .delay-2 {
                            animation-delay: 1s;
                        }
                        
                        @keyframes ripple {
                            0% {
                                transform: scale(0.8);
                                opacity: 0;
                            }
                            50% {
                                opacity: 0.4;
                            }
                            100% {
                                transform: scale(1.5);
                                opacity: 0;
                            }
                        }
                        
                        .empty-state-title {
                            color: #2d3436;
                            font-weight: 700;
                            font-size: 1.75rem;
                            margin-bottom: 1rem;
                            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            background-clip: text;
                        }
                        
                        .empty-state-description {
                            color: #636e72;
                            font-size: 1.1rem;
                            line-height: 1.6;
                            margin-bottom: 2rem;
                            max-width: 400px;
                            margin-left: auto;
                            margin-right: auto;
                        }
                        
                        .empty-state-actions .btn {
                            font-weight: 600;
                            letter-spacing: 0.5px;
                            padding: 0.75rem 2rem;
                            font-size: 1rem;
                            border-radius: 0.5rem;
                            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
                            transition: all 0.3s ease;
                            position: relative;
                            overflow: hidden;
                        }
                        
                        .empty-state-actions .btn:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4);
                        }
                        
                        .empty-state-actions .btn:active {
                            transform: translateY(0);
                        }
                        
                        .empty-state-tip {
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: #6c757d;
                            font-size: 0.9rem;
                            background: #f8f9fc;
                            padding: 0.75rem 1.25rem;
                            border-radius: 0.5rem;
                            margin-top: 2rem;
                        }
                        
                        .empty-state-tip i {
                            color: #4e73df;
                            font-size: 1.25rem;
                        }
                        
                        @media (max-width: 576px) {
                            .empty-state-card {
                                padding: 2rem 1.5rem;
                            }
                            
                            .empty-state-title {
                                font-size: 1.5rem;
                            }
                            
                            .empty-state-description {
                                font-size: 1rem;
                            }
                        }
                        </style>
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
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover'
            });
        });

        // Add animation to table rows
        const tableRows = document.querySelectorAll('.table tbody tr');
        tableRows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(10px)';
            row.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, 50 * index);
        });

        // Add fade-in animation to cards
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.4s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 150 + (index * 100));
        });
    });
</script>
@endpush
@endsection