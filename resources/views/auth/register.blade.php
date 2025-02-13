<!-- resources/views/auth/register.blade.php -->
@extends('layouts.auth')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5 mb-3">
                <div class="card-header bg-transparent border-bottom-0 text-center pt-4 pb-0">
                    <h2 class="text-primary">{{ __('Register') }}</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            <label for="name">{{ __('Name') }}</label>
                            @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="phone_number" type="tel" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone">
                            <label for="phone_number">{{ __('Phone Number') }}</label>
                            @error('phone_number')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            <label for="password">{{ __('Password') }}</label>
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .card {
        transition: box-shadow 0.3s;
    }
    .card:hover {
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .form-floating > .form-control:focus ~ label {
        color: #0d6efd;  /* Match Bootstrap's primary color */
    }
    .form-floating > .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
