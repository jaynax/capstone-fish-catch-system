@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <a href="/" class="d-inline-block mb-2">
                            <img src="{{ asset('/assets/img/icons/brands/BFAR.png') }}" alt="BFAR Logo" style="width: 120px;">
                        </a>
                        <h4 class="mb-1">Adventure starts here 🚀</h4>
                        <p class="mb-3 text-muted">Make your app management easy and fun!</p>
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
                        <div class="d-grid mb-3">
                            <button class="btn btn-primary" type="submit">{{ __('Register') }}</button>
                        </div>
                    </form>
                    <p class="text-center mt-3 mb-0">
                        <span>Already have an account?</span>
                        <a href="/login">
                            <span>Sign in instead</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection