@extends('layouts.auth')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-5 col-lg-4">
            <div class="card login-card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white text-center py-4">
                    <h2 class="text-primary fw-bold">{{ __('Login') }}</h2>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email">{{ __('Email Address') }}</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <label for="password">{{ __('Password') }}</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2">{{ __('Login') }}</button>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-center mt-3">
                                <a class="text-decoration-none small" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- <style>
    body {
        background-color: #f8f9fa;
    }
    .login-card {
        transition: 0.3s ease-in-out;
        background: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    .login-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    .form-floating > .form-control:focus ~ label {
        color: #000000;
    }
    .form-floating > .form-control:focus {
        border-color: #111213;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .btn-primary {
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 8px;
    }
    .text-primary {
        font-size: 1.8rem;
    }
</style> --}}
