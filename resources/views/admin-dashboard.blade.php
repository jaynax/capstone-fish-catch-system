@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <!-- Welcome Carousel -->
    <div class="row mb-4">
        <div class="col-12">
            <div id="welcomeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="card bg-gradient-primary text-white">
                            <div class="card-body p-5">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h2 class="display-4 fw-bold">Welcome to BFAR Fish Monitoring System</h2>
                                        <p class="lead">Manage fish catches, users, and generate comprehensive reports for better fisheries management.</p>
                                        <div class="mt-4">
                                            <a href="{{ route('admin.catches') }}" class="btn btn-light btn-lg me-3">
                                                <i class="bx bx-list-ul me-2"></i>View Catches
                                            </a>
                                            <a href="{{ route('admin.users') }}" class="btn btn-outline-light btn-lg">
                                                <i class="bx bx-user me-2"></i>Manage Users
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <i class="bx bx-fish bx-lg" style="font-size: 8rem; opacity: 0.3;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card bg-gradient-success text-white">
                            <div class="card-body p-5">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h2 class="display-4 fw-bold">Real-time Data Analytics</h2>
                                        <p class="lead">Track fish species, catch locations, and user activities with advanced analytics and reporting tools.</p>
                                        <div class="mt-4">
                                            <a href="{{ route('admin.reports') }}" class="btn btn-light btn-lg me-3">
                                                <i class="bx bx-chart me-2"></i>View Reports
                                            </a>
                                            <a href="#" class="btn btn-outline-light btn-lg">
                                                <i class="bx bx-download me-2"></i>Export Data
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <i class="bx bx-chart bx-lg" style="font-size: 8rem; opacity: 0.3;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card bg-gradient-info text-white">
                            <div class="card-body p-5">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h2 class="display-4 fw-bold">AI-Powered Fish Recognition</h2>
                                        <p class="lead">Advanced machine learning algorithms help identify fish species and estimate measurements automatically.</p>
                                        <div class="mt-4">
                                            <a href="{{ route('catch.create') }}" class="btn btn-light btn-lg me-3">
                                                <i class="bx bx-plus-circle me-2"></i>Record Catch
                                            </a>
                                            <a href="#" class="btn btn-outline-light btn-lg">
                                                <i class="bx bx-cog me-2"></i>System Settings
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <i class="bx bx-brain bx-lg" style="font-size: 8rem; opacity: 0.3;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\FishCatch::count() }}</h3>
                            <p class="card-text">Total Catches</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-fish bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\User::where('role_id', 2)->count() }}</h3>
                            <p class="card-text">BFAR Personnel</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-user bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\FishCatch::whereDate('created_at', today())->count() }}</h3>
                            <p class="card-text">Today's Catches</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-calendar bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\FishCatch::distinct('species')->count() }}</h3>
                            <p class="card-text">Fish Species</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-category bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bx bx-list-ul bx-lg text-primary"></i>
                    </div>
                    <h5 class="card-title">Data Verification</h5>
                    <p class="card-text">Review and verify fish catch entries submitted by BFAR personnel.</p>
                    <a href="{{ route('admin.catches') }}" class="btn btn-primary">
                        <i class="bx bx-right-arrow-alt me-1"></i>View Data
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bx bx-user-check bx-lg text-success"></i>
                    </div>
                    <h5 class="card-title">User Management</h5>
                    <p class="card-text">Manage user accounts, roles, and permissions for system access.</p>
                    <a href="{{ route('admin.users') }}" class="btn btn-success">
                        <i class="bx bx-right-arrow-alt me-1"></i>Manage Users
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bx bx-chart bx-lg text-info"></i>
                    </div>
                    <h5 class="card-title">System Reporting</h5>
                    <p class="card-text">Generate comprehensive reports and analytics for fisheries management.</p>
                    <a href="{{ route('admin.reports') }}" class="btn btn-info">
                        <i class="bx bx-right-arrow-alt me-1"></i>View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-time me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    @if(\App\Models\FishCatch::count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Personnel</th>
                                        <th>Action</th>
                                        <th>Details</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\FishCatch::with('user')->latest()->take(5)->get() as $catch)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $catch->user->profile_image ? asset('storage/profile_images/' . $catch->user->profile_image) : asset('assets/img/avatars/1.png') }}" 
                                                     class="rounded-circle me-2" width="32" height="32" style="object-fit: cover;">
                                                <span class="fw-semibold">{{ $catch->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">New Catch</span>
                                        </td>
                                        <td>{{ $catch->species }} - {{ $catch->length_cm }}cm, {{ $catch->weight_g }}g</td>
                                        <td>{{ $catch->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bx bx-time bx-lg text-muted mb-3"></i>
                            <p class="text-muted">No recent activity to display.</p>
                            <p class="text-muted">Start recording fish catches to see activity here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.carousel-item .card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.carousel-control-prev,
.carousel-control-next {
    width: 5%;
}

.carousel-indicators {
    bottom: 20px;
}

.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 5px;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.btn {
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 500;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
}
</style>

<script>
// Auto-advance carousel
document.addEventListener('DOMContentLoaded', function() {
    const carousel = new bootstrap.Carousel(document.getElementById('welcomeCarousel'), {
        interval: 5000,
        wrap: true
    });
});
</script>
@endsection 