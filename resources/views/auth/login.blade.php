@extends('layouts.auth')

@section('content')
<style>
    .auth-card {
        max-width: 400px;
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

    .forgot-password-link {
        color: #4a5568;
        font-size: 0.875rem;
    }

    .forgot-password-link:hover {
        color: #2d3748;
        text-decoration: underline;
    }

    .invalid-feedback {
        font-size: 0.875rem;
    }
</style>

<div class="auth-card">
    <div class="auth-header">
        <img src="{{ asset('images/logo1.png') }}" alt="Application Logo" class="auth-logo">
        <h1 class="auth-title">{{ __('Login') }}</h1>
    </div>

    <div class="auth-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember"
                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link forgot-password-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
