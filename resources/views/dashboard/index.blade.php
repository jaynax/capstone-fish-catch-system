@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">BFAR Personnel Dashboard</h4>
                        <span class="badge bg-primary">BFAR Personnel</span>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Welcome, {{ Auth::user()->name }}!</h5>
                                    <p class="card-text">You are logged in as BFAR personnel.</p>
                                    <a href="{{ route('catch.create') }}" class="btn btn-light">
                                        <i class="fas fa-plus-circle"></i> New Fish Catch Report
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <a href="{{ route('catch.index') }}" class="btn btn-outline-primary w-100 mb-2">
                                                <i class="fas fa-list"></i> View All Reports
                                            </a>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <a href="#" class="btn btn-outline-success w-100 mb-2">
                                                <i class="fas fa-chart-bar"></i> View Analytics
                                            </a>
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
@endsection
