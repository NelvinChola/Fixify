@extends('layouts.simple')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
                <!-- Card Header with Gradient -->
                <div class="card-header text-center text-white py-4" style="background: linear-gradient(135deg, #203046 0%, #3a4a6b 100%);">
                    <h3 class="mb-0">
                        <i class="fas fa-tools me-2"></i>{{ __('FIXIFY') }}
                    </h3>
                    <p class="mb-0 mt-2 opacity-75">Login to the service tracking System</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <!-- Email Verification Alert -->
                    @if (session('verification_sent'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('verification_sent') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('verified'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('verified') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Unverified Account Alert -->
                    @if (session('unverified'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-envelope me-2"></i>
                            <strong>Email Verification Required</strong>
                            <p class="mb-1 mt-2">{{ session('unverified') }}</p>
                            <div class="mt-2">
                                <form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ session('unverified_email') }}">
                                    <button type="submit" class="btn btn-sm btn-warning">
                                        <i class="fas fa-paper-plane me-1"></i>Resend Verification Email
                                    </button>
                                </form>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Temporary Password Alert -->
                    @if (session('temp_password'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-key me-2"></i>
                            <strong>Temporary Password Detected</strong>
                            <p class="mb-0 mt-1">{{ session('temp_password') }}</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- General Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Login Failed</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                       placeholder="Enter your email">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password"
                                       placeholder="Enter your password">
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #203046;">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg py-2 fw-semibold" 
                                    style="background: linear-gradient(135deg, #203046 0%, #3a4a6b 100%); border: none;"
                                    id="loginButton">
                                <i class="fas fa-sign-in-alt me-2"></i>{{ __('Login') }}
                            </button>
                        </div>

                        <!-- Resend Verification Section -->
                        @if (session('unverified_email'))
                            <div class="text-center mt-4 pt-3 border-top">
                                <p class="text-muted mb-2">Didn't receive the verification email?</p>
                                <form action="{{ route('verification.resend') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ session('unverified_email') }}">
                                    <button type="submit" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-paper-plane me-1"></i>Resend Verification Email
                                    </button>
                                </form>
                            </div>
                        @endif

                        <!-- Registration Link -->
                        {{-- <div class="text-center">
                            <p class="mb-0">Don't have an account? 
                                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: #203046;">
                                    {{ __('Register here') }}
                                </a>
                            </p>
                        </div> --}}
                    </form>
                </div>

                <!-- Card Footer with Help Links -->
                <div class="card-footer text-center py-3 bg-light">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt me-1"></i>Secure Login • 
                        <i class="fas fa-envelope me-1"></i>Email Verification Required
                    </small>
                    <div class="mt-2">
                        <small>
                            <a href="{{ route('verification.help') }}" class="text-decoration-none text-muted">
                                <i class="fas fa-question-circle me-1"></i>Need help with verification?
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-white mb-0">Authenticating...</p>
            </div>
        </div>
    </div>
</div>

<!-- Password Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const loginForm = document.querySelector('#loginForm');
        const loginButton = document.querySelector('#loginButton');
        const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));

        // Password visibility toggle
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
            
            // Visual feedback
            this.classList.toggle('active', type === 'text');
        });

        // Enhanced form submission
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            // Basic validation
            if (!email || !password) {
                e.preventDefault();
                showAlert('Please fill in all required fields.', 'danger');
                return;
            }

            // Email format validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                showAlert('Please enter a valid email address.', 'danger');
                return;
            }

            // Show loading state
            loginButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Signing in...';
            loginButton.disabled = true;
            
            // Show loading modal
            loadingModal.show();
        });

        // Auto-remove alerts after 8 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-dismissible')) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 8000);

        // Helper function to show alerts
        function showAlert(message, type) {
            // Remove existing custom alerts
            document.querySelectorAll('.custom-alert').forEach(alert => alert.remove());

            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show custom-alert`;
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'danger' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            loginForm.insertBefore(alertDiv, loginForm.firstChild);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentElement) {
                    const bsAlert = new bootstrap.Alert(alertDiv);
                    bsAlert.close();
                }
            }, 5000);
        }

        // Enter key submission
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !loginButton.disabled) {
                loginForm.requestSubmit();
            }
        });

        // Focus effects
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    });
</script>

<style>
    .card {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.95);
    }
    
    .form-control:focus {
        border-color: #203046;
        box-shadow: 0 0 0 0.2rem rgba(32, 48, 70, 0.25);
    }
    
    .btn-primary:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(32, 48, 70, 0.3);
        transition: all 0.3s ease;
    }
    
    .input-group-text {
        transition: all 0.3s ease;
    }
    
    .form-control {
        transition: all 0.3s ease;
    }
    
    .card-header {
        border-bottom: none;
    }

    #togglePassword.active {
        background-color: #203046;
        color: white;
        border-color: #203046;
    }

    .input-group.focused {
        box-shadow: 0 0 0 2px rgba(32, 48, 70, 0.1);
        border-radius: 6px;
    }

    /* Loading modal background */
    #loadingModal .modal-content {
        background: rgba(0, 0, 0, 0.7);
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    /* Alert enhancements */
    .alert {
        border-left: 4px solid;
    }

    .alert-success {
        border-left-color: #198754;
    }

    .alert-warning {
        border-left-color: #ffc107;
    }

    .alert-danger {
        border-left-color: #dc3545;
    }

    .alert-info {
        border-left-color: #0dcaf0;
    }
</style>
@endsection