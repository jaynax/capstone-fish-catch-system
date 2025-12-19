@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <img src="{{ asset('assets/img/icons/brands/BFAR.png') }}" alt="BFAR Logo" class="img-fluid" style="max-height: 80px;">
                    </div>
                    <h4 class="text-center">Account Pending Approval</h4>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Your account is awaiting admin verification. You can access the personnel dashboard once an administrator approves your account.
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('logout') }}" 
                           class="btn btn-primary"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
