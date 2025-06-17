@extends('layouts.auth')

@section('content')
<style>
    .auth-card {
        max-width: 500px;
        margin: 2rem auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .auth-header {
        padding: 2rem 2rem 1rem;
        text-align: center;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .auth-logo {
        width: 80px;
        margin-bottom: 1.5rem;
    }

    .auth-title {
        font-size: 1.5rem;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .auth-body {
        padding: 2rem;
    }

    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        padding: 0.5rem 0.75rem;
        height: 40px;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 1px #667eea;
    }

    .btn-primary {
        background-color: #4a5568;
        border: none;
        padding: 0.5rem 1rem;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #2d3748;
    }

    .form-check-input:checked {
        background-color: #4a5568;
        border-color: #4a5568;
    }

    .auth-footer {
        text-align: center;
        margin-top: 1rem;
        font-size: 0.875rem;
    }

    .auth-footer a {
        color: #4a5568;
        text-decoration: none;
    }

    .auth-footer a:hover {
        text-decoration: underline;
        color: #2d3748;
    }

    .invalid-feedback {
        font-size: 0.875rem;
    }
</style>

<div class="auth-card">
    <div class="auth-header">
        <img src="{{ asset('images/logo1.png') }}" alt="Company Logo" class="auth-logo">
        <h1 class="auth-title">{{ __('Create Account') }}</h1>
    </div>

    <div class="auth-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name">{{ __('Name') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone_number">{{ __('Phone Number') }}</label>
                <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                       name="phone_number" value="{{ old('phone_number') }}" required>
                @error('phone_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="form-control"
                       name="password_confirmation" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary w-100">
                    {{ __('Register') }}
                </button>
            </div>
        </form>

        <div class="auth-footer mt-4">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}">{{ __('Login') }}</a>
        </div>
    </div>
</div>
@endsection
