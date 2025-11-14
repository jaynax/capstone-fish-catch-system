@extends('layouts.users.app')

@push('styles')
<style>
    /* Keyframe Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-50px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(50px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .dashboard-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }
    
    .stat-card {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        color: white;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }
    
    .stat-icon {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 3.5rem;
        opacity: 0.2;
    }
    
    .carousel-control-prev, .carousel-control-next {
        width: 5%;
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .carousel:hover .carousel-control-prev,
    .carousel:hover .carousel-control-next {
        opacity: 1;
    }
    
    .carousel-indicators {
        margin-bottom: 1.5rem;
    }
    
    .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 6px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
        background-color: rgba(78, 115, 223, 0.3);
    }
    
    .carousel-indicators button.active {
        background-color: #4e73df;
        transform: scale(1.3);
        border-color: white;
        box-shadow: 0 0 0 2px rgba(255,255,255,0.8);
    }
    
    .bg-gradient-1 {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: #2d3436 !important;
    }
    
    .bg-gradient-2 {
        background: linear-gradient(135deg, #ff6b6b 0%, #ff8e8e 100%);
        color: #2d3436 !important;
    }
    
    .bg-gradient-3 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: #2d3436 !important;
    }
    
    .bg-gradient-4 {
        background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
        color: #2d3436 !important;
    }
    
    .carousel-item h1, 
    .carousel-item p, 
    .carousel-item .text-muted {
        color: #2d3436 !important;
    }
    
    .carousel-item {
        transition: transform 1s ease-in-out;
    }
    
    .carousel-caption {
        position: absolute;
        right: 15%;
        bottom: 20px;
        left: 15%;
        z-index: 10;
        padding-top: 20px;
        padding-bottom: 20px;
        color: #fff;
        text-align: center;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }
    
    .carousel-item.active .carousel-caption {
        opacity: 1;
        transform: translateY(0);
    }
    
    .carousel-item h1 {
        animation: slideInLeft 0.8s ease-out 0.3s both;
    }
    
    .carousel-item p {
        animation: slideInRight 0.8s ease-out 0.5s both;
    }
    
    .carousel-item .btn {
        animation: fadeInUp 0.8s ease-out 0.7s both;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .carousel-item .btn:after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%, -50%);
        transform-origin: 50% 50%;
    }
    
    .carousel-item .btn:focus:not(:active)::after {
        animation: ripple 1s ease-out;
    }
    
    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }
        100% {
            transform: scale(20, 20);
            opacity: 0;
        }
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.75rem;
        color: white;
    }
    
    .recent-activity {
        position: relative;
        padding-left: 30px;
        border-left: 2px solid #e9ecef;
    }
    
    .activity-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .activity-item:last-child {
        padding-bottom: 0;
    }
    
    .activity-item:before {
        content: '';
        position: absolute;
        left: -31px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #4e73df;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Carousel -->
    <div class="row mb-4">
        <div class="col-12">
            <div id="personnelCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#personnelCarousel" data-bs-slide-to="0" class="active" style="background-color: #4e73df;"></button>
                    <button type="button" data-bs-target="#personnelCarousel" data-bs-slide-to="1" style="background-color: #4e73df;"></button>
                    <button type="button" data-bs-target="#personnelCarousel" data-bs-slide-to="2" style="background-color: #4e73df;"></button>
                </div>
                <div class="carousel-inner" style="border-radius: 15px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
                    <div class="carousel-item active">
                        <div class="card border-0 shadow-lg overflow-hidden h-100" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-lg-8 p-5 d-flex flex-column justify-content-center bg-gradient-1 text-dark" style="background: linear-gradient(135deg, rgba(79, 172, 254, 0.9) 0%, rgba(0, 242, 254, 0.9) 100%) !important;">
                                        <div class="mb-3">
                                            <span class="badge bg-white text-primary mb-2 px-3 py-2">Welcome, {{ Auth::user()->name }}!</span>
                                        </div>
                                        <h1 class="display-5 fw-bold mb-3">BFAR Inspection Team</h1>
                                        <p class="lead mb-4">Monitor fish landings, inspect catches, and collect vital data for sustainable fisheries management. Your work helps protect marine ecosystems and support local fishing communities.</p>
                                        <div class="d-flex gap-3 mt-4" style="animation-delay: 0.7s;">
                                            <a href="{{ route('catch.create') }}" class="btn btn-dark btn-lg px-4 rounded-pill fw-bold">
                                                <i class="bx bx-clipboard me-2"></i>Record Inspection
                                            </a>
                                            <a href="{{ route('catches.index') }}" class="btn btn-outline-dark btn-lg px-4 rounded-pill fw-bold">
                                                <i class="bx bx-search me-2"></i>View Reports
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-none d-lg-block">
                                        <div class="h-100" style="background: url('https://images.unsplash.com/photo-1564501049412-61c2a3083791?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80') center/cover; position: relative;">
                                            <div class="h-100" style="background: rgba(0,0,0,0.3);"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card border-0 shadow-lg overflow-hidden h-100" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-lg-8 p-5 d-flex flex-column justify-content-center bg-gradient-1 text-dark" style="background: linear-gradient(135deg, rgba(79, 172, 254, 0.9) 0%, rgba(0, 242, 254, 0.9) 100%) !important;">
                                        <div class="mb-3">
                                            <span class="badge bg-white text-primary mb-2 px-3 py-2">Data Collection</span>
                                        </div>
                                        <h1 class="display-5 fw-bold mb-3">Data Collection Excellence</h1>
                                        <p class="lead mb-4">Document fish species, sizes, weights, and catch locations with precision. Your accurate data supports vital fisheries research and conservation efforts across the region.</p>
                                        <div class="d-flex gap-3 mt-4" style="animation-delay: 0.7s;">
                                            <a href="{{ route('catch.create') }}" class="btn btn-dark btn-lg px-4 rounded-pill fw-bold">
                                                <i class="bx bx-camera me-2"></i>Document Catch
                                            </a>
                                            <a href="#" class="btn btn-outline-dark btn-lg px-4 rounded-pill fw-bold">
                                                <i class="bx bx-map me-2"></i>Location Data
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-none d-lg-block">
                                        <div class="h-100" style="background: url('https://images.unsplash.com/photo-1564501049412-61c2a3083791?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80') center/cover; position: relative;">
                                            <div class="h-100" style="background: rgba(0,0,0,0.3);"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card border-0 shadow-lg overflow-hidden h-100" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-lg-8 p-5 d-flex flex-column justify-content-center bg-gradient-1 text-dark" style="background: linear-gradient(135deg, rgba(79, 172, 254, 0.9) 0%, rgba(0, 242, 254, 0.9) 100%) !important;">
                                        <div class="mb-3">
                                            <span class="badge bg-white text-primary mb-2 px-3 py-2">Compliance</span>
                                        </div>
                                        <h1 class="display-5 fw-bold mb-3">Fisheries Compliance</h1>
                                        <p class="lead mb-4">Ensure compliance with fishing regulations, monitor catch limits, and protect marine resources. Your vigilance helps maintain sustainable fishing practices for future generations.</p>
                                        <div class="d-flex gap-3 mt-4" style="animation-delay: 0.7s;">
                                            <a href="#" class="btn btn-dark btn-lg px-4 rounded-pill fw-bold">
                                                <i class="bx bx-shield-check me-2"></i>Compliance Check
                                            </a>
                                            <a href="{{ route('regulations') }}" class="btn btn-outline-dark btn-lg px-4 rounded-pill fw-bold">
                                                <i class="bx bx-book-open me-2"></i>Regulations
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-none d-lg-block">
                                        <div class="h-100" style="background: url('https://images.unsplash.com/photo-1564501049412-61c2a3083791?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80') center/cover; position: relative;">
                                            <div class="h-100" style="background: rgba(0,0,0,0.3);"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#personnelCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-primary bg-opacity-75 rounded-circle p-3 shadow"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#personnelCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-primary bg-opacity-75 rounded-circle p-3 shadow"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    
    <!-- Quick Actions & Recent Activity -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <div class="feature-icon bg-gradient-1 mb-3">
                                    <i class='bx bx-clipboard'></i>
                                </div>
                                <h5>New Inspection</h5>
                                <p class="text-muted small">Record a new fish catch inspection</p>
                                <a href="{{ route('catch.create') }}" class="btn btn-sm btn-outline-primary">Start</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <div class="feature-icon bg-gradient-2 mb-3">
                                    <i class='bx bx-search-alt'></i>
                                </div>
                                <h5>View Reports</h5>
                                <p class="text-muted small">Analyze inspection data and trends</p>
                                <a href="{{ route('catches.index') }}" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <div class="feature-icon bg-gradient-3 mb-3">
                                    <i class='bx bx-line-chart'></i>
                                </div>
                                <h5>Statistics</h5>
                                <p class="text-muted small">View detailed statistics and analytics</p>
                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card dashboard-card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body recent-activity">
                    <div class="activity-item mb-4">
                        <h6 class="mb-1 fw-bold">New inspection recorded</h6>
                        <p class="text-muted small mb-1">Tuna catch - 45kg</p>
                        <span class="text-muted small">10 minutes ago</span>
                    </div>
                    <div class="activity-item mb-4">
                        <h6 class="mb-1 fw-bold">Report generated</h6>
                        <p class="text-muted small mb-1">Weekly compliance report</p>
                        <span class="text-muted small">2 hours ago</span>
                    </div>
                    <div class="activity-item">
                        <h6 class="mb-1 fw-bold">New regulation added</h6>
                        <p class="text-muted small mb-1">Updated size limits for Grouper</p>
                        <span class="text-muted small">Yesterday</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\FishCatch::where('user_id', Auth::id())->count() }}</h3>
                            <p class="card-text">Inspections Today</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-clipboard bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\FishCatch::where('user_id', Auth::id())->whereDate('created_at', today())->count() }}</h3>
                            <p class="card-text">Today's Inspections</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-calendar-check bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-secondary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\FishCatch::where('user_id', Auth::id())->distinct('species')->count() }}</h3>
                            <p class="card-text">Species Documented</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-category bx-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-dark text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-0">{{ \App\Models\FishCatch::where('user_id', Auth::id())->sum('weight_g') }}</h3>
                            <p class="card-text">Total Weight (g)</p>
                        </div>
                        <div class="text-end">
                            <i class="bx bx-weight bx-lg"></i>
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
                        <i class="bx bx-clipboard bx-lg text-warning"></i>
                    </div>
                    <h5 class="card-title">Record Inspection</h5>
                    <p class="card-text">Document fish catches from fishermen with species identification and measurements.</p>
                    <a href="{{ route('catch.create') }}" class="btn btn-warning">
                        <i class="bx bx-right-arrow-alt me-1"></i>Start Inspection
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bx bx-search bx-lg text-danger"></i>
                    </div>
                    <h5 class="card-title">Compliance Check</h5>
                    <p class="card-text">Verify fishing permits, catch limits, and ensure regulatory compliance.</p>
                    <a href="#" class="btn btn-danger">
                        <i class="bx bx-right-arrow-alt me-1"></i>Check Compliance
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bx bx-chart bx-lg text-secondary"></i>
                    </div>
                    <h5 class="card-title">Inspection Reports</h5>
                    <p class="card-text">Generate reports on inspections, violations, and compliance statistics.</p>
                    <a href="#" class="btn btn-secondary">
                        <i class="bx bx-right-arrow-alt me-1"></i>View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Inspections -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-time me-2"></i>Recent Inspections
                    </h5>
                </div>
                <div class="card-body">
                    @if(\App\Models\FishCatch::where('user_id', Auth::id())->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Species</th>
                                        <th>Scientific Name</th>
                                        <th>Length</th>
                                        <th>Weight</th>
                                        <th>Inspection Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(\App\Models\FishCatch::where('user_id', Auth::id())->latest()->take(5)->get() as $catch)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $catch->species }}</div>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $catch->scientific_name ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ $catch->length_cm }} cm</td>
                                        <td>{{ $catch->weight_g }} g</td>
                                        <td>{{ $catch->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-warning">
                                                <i class="bx bx-show"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bx bx-clipboard bx-lg text-muted mb-3"></i>
                            <p class="text-muted">No inspections recorded yet.</p>
                            <p class="text-muted">Start by recording your first fish inspection!</p>
                            <a href="{{ route('catch.create') }}" class="btn btn-warning">
                                <i class="bx bx-plus-circle me-2"></i>Record First Inspection
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-warning {
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%);
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
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
    const carousel = new bootstrap.Carousel(document.getElementById('personnelCarousel'), {
        interval: 5000,
        wrap: true
    });
});
</script>
@endsection 