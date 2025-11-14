@extends('layouts.app')

@push('styles')
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    body {
        overflow: hidden;
        height: 100vh;
        margin: 0;
        padding: 0;
    }

    .login-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url("{{ asset('/assets/img/backgrounds/BFAR.jpg') }}") no-repeat center center;
        background-size: cover;
        overflow: hidden;
    }

    .login-container::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 0;
    }

    .card {
        position: relative;
        z-index: 1;
        background: rgba(255, 255, 255, 0.95);
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
        animation: fadeIn 0.8s ease-out;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        max-height: 90vh;
        overflow-y: auto;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
    }

    .btn-primary {
        background: linear-gradient(45deg, #1e3c72, #2a5298);
        border: none;
        background-size: 200% auto;
        transition: all 0.3s ease;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .btn-primary:hover {
        background-position: right center;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3);
    }

    .form-control {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #1e3c72;
        box-shadow: 0 0 0 0.25rem rgba(30, 60, 114, 0.15);
    }

    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-header h4 {
        color: #1e3c72;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .login-header p {
        color: #6c757d;
        margin-bottom: 0;
    }

    .form-check-label {
        color: #495057;
    }

    .divider {
        position: relative;
        margin: 1.5rem 0;
        text-align: center;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e0e0e0;
        z-index: -1;
    }

    .divider span {
        background: white;
        padding: 0 1rem;
        color: #6c757d;
        font-size: 0.875rem;
    }
</style>
@endpush

@section('content')
<div class="login-container">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card">
                    <div class="card-body p-4 p-md-5">
                        <div class="login-header">
                            <a href="/" class="d-inline-block mb-3">
                                <img src="{{ asset('/assets/img/icons/brands/BFAR.png') }}" alt="BFAR Logo" style="width: 100px; height: auto;">
                            </a>
                            <h4>Create an Account</h4>
                            <p>Fill in your details to get started</p>
                        </div>
                        <form id="formAuthentication" action="{{ route('register') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" placeholder="Enter your name" value="{{ old('name') }}" required autofocus />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="Enter your email" value="{{ old('email') }}" required />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="Enter your password" required autocomplete="new-password" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                <input type="password" id="password-confirm" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirm your password" />
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->slug }}" {{ old('role') == $role->slug ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required />
                                <label class="form-check-label" for="terms-conditions">
                                    I agree to
                                    <a href="javascript:void(0);">privacy policy & terms</a>
                                </label>
                            </div>
                            <div class="d-grid gap-3">
                                <button class="btn btn-primary btn-lg py-2" type="submit">
                                    <i class="fas fa-user-plus me-2"></i>{{ __('Register') }}
                                </button>
                            </div>
                        </form>
                        <p class="text-center mt-4 mb-0 text-muted">
                            Already have an account?
                            <a href="/login" class="text-primary text-decoration-none fw-medium">
                                Sign in instead
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection