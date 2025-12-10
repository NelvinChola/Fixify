@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-2 px-sm-3 mt-3">
        <!-- Header - Technical Theme -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <div>
                <h4 class="mb-0 text-dark fw-bold" style="font-size: 1.1rem;">
                    <i class="fas fa-user-plus me-2 d-none d-sm-inline" style="color: #2d3748;"></i>
                    <span class="d-none d-sm-inline">Create New User</span>
                    <span class="d-inline d-sm-none">New User</span>
                </h4>
                <p class="text-muted small mb-0 d-none d-md-block">Add new system user with role assignment</p>
            </div>
            <a href="{{ route('users.index') }}"
                class="btn btn-outline-secondary d-flex align-items-center gap-1 shadow-sm px-3 py-2"
                style="font-size: 0.875rem;">
                <i class="fas fa-arrow-left"></i>
                <span class="d-none d-sm-inline">Back to Users</span>
                <span class="d-inline d-sm-none">Back</span>
            </a>
        </div>

        <!-- Main Card -->
        <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 10px;">
            <!-- Card Header -->
            <div class="card-header py-2 px-3 border-bottom d-flex justify-content-between align-items-center"
                style="background: linear-gradient(to right, #f8fafc, #ffffff);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-circle text-primary me-2" style="font-size: 1rem;"></i>
                    <h5 class="mb-0 fw-semibold text-dark" style="font-size: 0.95rem;">User Registration Form</h5>
                </div>
                <span class="badge bg-tech-primary text-white d-none d-sm-inline"
                    style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                    New Account
                </span>
            </div>

            <div class="card-body p-3 p-md-4">
                <!-- Global Error Alert -->
                @if ($errors->any())
                    <div class="alert alert-tech-danger alert-dismissible fade show border-0 shadow-sm mb-3 py-2"
                        role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2" style="color: #ef4444; font-size: 1rem;"></i>
                            <div class="flex-grow-1">
                                <span style="font-size: 0.875rem; font-weight: 500;">Please fix the following errors:</span>
                                <ul class="mb-0 ps-3 mt-1" style="font-size: 0.8rem;">
                                    @foreach ($errors->all() as $error)
                                        <li><strong>{{ $error }}</strong></li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close p-2" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                @endif

                <!-- Session Messages -->
                @if (session('error'))
                    <div class="alert alert-tech-danger alert-dismissible fade show border-0 shadow-sm mb-3 py-2"
                        role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-times-circle me-2" style="color: #ef4444; font-size: 1rem;"></i>
                            <span class="flex-grow-1" style="font-size: 0.875rem;">
                                <strong>Error:</strong> {{ session('error') }}
                            </span>
                            <button type="button" class="btn-close p-2" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-tech-warning alert-dismissible fade show border-0 shadow-sm mb-3 py-2"
                        role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2" style="color: #f59e0b; font-size: 1rem;"></i>
                            <span class="flex-grow-1" style="font-size: 0.875rem;">
                                <strong>Notice:</strong> {{ session('warning') }}
                            </span>
                            <button type="button" class="btn-close p-2" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-tech-success alert-dismissible fade show border-0 shadow-sm mb-3 py-2"
                        role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2" style="color: #10b981; font-size: 1rem;"></i>
                            <span class="flex-grow-1" style="font-size: 0.875rem;">
                                <strong>Success:</strong> {{ session('success') }}
                            </span>
                            <button type="button" class="btn-close p-2" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                @endif

                <!-- Information Alert -->
                <div class="alert alert-tech-info alert-dismissible fade show border-0 shadow-sm mb-4 py-2" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2" style="color: #0ea5e9; font-size: 1rem;"></i>
                        <span class="flex-grow-1" style="font-size: 0.875rem;">
                            <strong>Important:</strong> User will receive email with verification link and temporary
                            credentials.
                        </span>
                        <button type="button" class="btn-close p-2" data-bs-dismiss="alert"></button>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('users.store') }}" method="POST" id="userForm" class="tech-form">
                    @csrf

                    <!-- Full Name -->
                    <div class="row mb-3 mb-md-4">
                        <label for="name" class="col-md-3 col-form-label fw-semibold text-dark mb-2 mb-md-0">
                            <i class="fas fa-user fa-sm me-1 d-none d-md-inline"></i>
                            Full Name<span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" id="name"
                                    class="form-control border-start-0 shadow-sm @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required placeholder="Enter full name">
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="row mb-3 mb-md-4">
                        <label for="email" class="col-md-3 col-form-label fw-semibold text-dark mb-2 mb-md-0">
                            <i class="fas fa-envelope fa-sm me-1 d-none d-md-inline"></i>
                            Email<span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" id="email"
                                    class="form-control border-start-0 shadow-sm @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required placeholder="user@example.com">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <small class="form-text text-muted mt-2 d-block" style="font-size: 0.75rem;">
                                <i class="fas fa-paper-plane fa-xs me-1"></i>Verification email will be sent to this
                                address
                            </small>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="row mb-3 mb-md-4">
                        <label for="contact" class="col-md-3 col-form-label fw-semibold text-dark mb-2 mb-md-0">
                            <i class="fas fa-phone fa-sm me-1 d-none d-md-inline"></i>
                            Contact<span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-phone text-muted"></i>
                                </span>
                                <input type="text" id="contact"
                                    class="form-control border-start-0 shadow-sm @error('contact') is-invalid @enderror"
                                    name="contact" value="{{ old('contact') }}" required placeholder="Phone number">
                            </div>
                            @error('contact')
                                <div class="invalid-feedback d-block mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- NRC -->
                    <div class="row mb-3 mb-md-4">
                        <label for="nrc" class="col-md-3 col-form-label fw-semibold text-dark mb-2 mb-md-0">
                            <i class="fas fa-id-card fa-sm me-1 d-none d-md-inline"></i>
                            NRC
                        </label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-id-card text-muted"></i>
                                </span>
                                <input type="text" id="nrc"
                                    class="form-control border-start-0 shadow-sm @error('nrc') is-invalid @enderror"
                                    name="nrc" value="{{ old('nrc') }}" placeholder="National ID number">
                            </div>
                            @error('nrc')
                                <div class="invalid-feedback d-block mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="row mb-3 mb-md-4">
                        <label for="address" class="col-md-3 col-form-label fw-semibold text-dark mb-2 mb-md-0">
                            <i class="fas fa-map-marker-alt fa-sm me-1 d-none d-md-inline"></i>
                            Address
                        </label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                </span>
                                <input type="text" id="address"
                                    class="form-control border-start-0 shadow-sm @error('address') is-invalid @enderror"
                                    name="address" value="{{ old('address') }}" placeholder="Physical address">
                            </div>
                            @error('address')
                                <div class="invalid-feedback d-block mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="row mb-3 mb-md-4">
                        <div class="col-md-3">
                            <label class="col-form-label fw-semibold text-dark mb-2 mb-md-0">
                                <i class="fas fa-key fa-sm me-1 d-none d-md-inline"></i>
                                Password
                            </label>
                        </div>
                        <div class="col-md-9">
                            <div class="alert alert-tech-warning border-0 shadow-sm py-2 px-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-key me-2" style="color: #f59e0b;"></i>
                                    <span style="font-size: 0.85rem;">
                                        <strong>Automatic Generation:</strong> Secure temporary password will be generated
                                        and sent via email
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="row mb-4 mb-md-5">
                        <label for="role_id" class="col-md-3 col-form-label fw-semibold text-dark mb-2 mb-md-0">
                            <i class="fas fa-user-tag fa-sm me-1 d-none d-md-inline"></i>
                            Role<span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-user-tag text-muted"></i>
                                </span>
                                <select id="role_id"
                                    class="form-select border-start-0 shadow-sm @error('role_id') is-invalid @enderror"
                                    name="role_id" required>
                                    <option value="">Select User Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('role_id')
                                <div class="invalid-feedback d-block mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <div class="mt-2">
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach ($roles as $role)
                                        @php
                                            $roleColors = [
                                                'Admin' => 'danger',
                                                'Technician' => 'warning',
                                                'Helpdesk' => 'info',
                                                'Customer' => 'secondary',
                                            ];
                                            $roleColor = $roleColors[$role->name] ?? 'secondary';
                                        @endphp
                                        <span
                                            class="badge bg-{{ $roleColor }} bg-opacity-10 text-{{ $roleColor }} border border-{{ $roleColor }} border-opacity-25 small"
                                            style="cursor: pointer;"
                                            onclick="document.getElementById('role_id').value = '{{ $role->id }}'">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-md-9 offset-md-3">
                            <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                                <a href="{{ route('users.index') }}"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-1 flex-fill flex-sm-auto px-3 py-2 order-2 order-sm-1">
                                    <i class="fas fa-times"></i>
                                    <span class="d-none d-sm-inline">Cancel</span>
                                    <span class="d-inline d-sm-none">Cancel</span>
                                </a>
                                <button type="submit"
                                    class="btn text-white d-flex align-items-center justify-content-center gap-1 flex-fill flex-sm-auto px-3 py-2 order-1 order-sm-2"
                                    style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);" id="submitBtn">
                                    <i class="fas fa-user-plus"></i>
                                    <span class="d-none d-sm-inline">Create User</span>
                                    <span class="d-inline d-sm-none">Create</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Technical Color Scheme */
        :root {
            --tech-primary: #2d3748;
            --tech-secondary: #4a5568;
            --tech-accent: #3b82f6;
            --tech-info: #0ea5e9;
            --tech-warning: #f59e0b;
            --tech-danger: #ef4444;
            --tech-success: #10b981;
            --tech-gray: #f1f5f9;
            --tech-light: #f8fafc;
        }

        /* === MOBILE-FIRST RESPONSIVE DESIGN === */

        /* Base mobile styles */
        .container-fluid {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        /* Technical Alerts */
        .alert-tech-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-left: 4px solid var(--tech-danger);
            color: #7f1d1d;
        }

        .alert-tech-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid var(--tech-warning);
            color: #78350f;
        }

        .alert-tech-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-left: 4px solid var(--tech-success);
            color: #065f46;
        }

        .alert-tech-info {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            border-left: 4px solid var(--tech-info);
            color: #0c4a6e;
        }

        /* Form Styles */
        .tech-form label {
            font-size: 0.875rem;
        }

        .tech-form .form-control,
        .tech-form .form-select {
            font-size: 0.875rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .tech-form .form-control:focus,
        .tech-form .form-select:focus {
            border-color: var(--tech-accent);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .tech-form .is-invalid {
            border-color: var(--tech-danger);
            background-image: none;
        }

        .tech-form .is-invalid:focus {
            box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.25);
        }

        /* Input Group Styling */
        .input-group-text {
            border-radius: 8px 0 0 8px !important;
            border-right: none;
        }

        .form-control.border-start-0 {
            border-radius: 0 8px 8px 0 !important;
        }

        /* Badges */
        .badge {
            transition: all 0.2s ease;
        }

        .badge:hover {
            transform: translateY(-1px);
        }

        /* Buttons */
        .btn {
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Required field indicator */
        .text-danger {
            color: var(--tech-danger) !important;
        }

        /* === RESPONSIVE BREAKPOINTS === */

        /* Extra Small (xs): < 576px - Mobile portrait */
        @media (max-width: 575.98px) {
            .container-fluid {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .card-body {
                padding: 1rem !important;
            }

            .tech-form label {
                font-size: 0.85rem;
            }

            .tech-form .form-control,
            .tech-form .form-select {
                font-size: 0.85rem;
                padding: 0.5rem 0.75rem;
            }

            .input-group-text {
                padding: 0.5rem 0.75rem;
            }

            .alert div {
                font-size: 0.8rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }

            .row.mb-3 {
                margin-bottom: 1.25rem !important;
            }
        }

        /* Small (sm): 576px - 767px - Mobile landscape / Small tablets */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .card-body {
                padding: 1.5rem !important;
            }

            .tech-form .form-control,
            .tech-form .form-select {
                font-size: 0.875rem;
            }

            .btn {
                padding: 0.625rem 1.25rem;
            }
        }

        /* Medium (md): 768px - 991px - Tablets */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .container-fluid {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            .card-body {
                padding: 2rem !important;
            }

            .tech-form label {
                padding-top: 0.5rem;
                font-size: 0.9rem;
            }

            .tech-form .form-control,
            .tech-form .form-select {
                font-size: 0.9rem;
                padding: 0.625rem 0.875rem;
            }

            .input-group-text {
                padding: 0.625rem 0.875rem;
            }
        }

        /* Large (lg): 992px - 1199px - Laptops */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .container-fluid {
                padding-left: 2rem;
                padding-right: 2rem;
            }

            .card-body {
                padding: 2.5rem !important;
            }

            .tech-form label {
                font-size: 0.95rem;
            }

            .tech-form .form-control,
            .tech-form .form-select {
                font-size: 0.95rem;
            }
        }

        /* Extra Large (xl): ≥ 1200px - Desktops */
        @media (min-width: 1200px) {
            .container-fluid {
                padding-left: 2.5rem;
                padding-right: 2.5rem;
            }

            .card-body {
                padding: 3rem !important;
            }

            .tech-form label {
                font-size: 1rem;
            }

            .tech-form .form-control,
            .tech-form .form-select {
                font-size: 1rem;
                padding: 0.75rem 1rem;
            }

            .input-group-text {
                padding: 0.75rem 1rem;
            }
        }

        /* === TOUCH OPTIMIZATIONS === */

        @media (hover: none) and (pointer: coarse) {

            /* Increase touch targets for mobile */
            .btn,
            button,
            .form-control,
            .form-select,
            .input-group-text {
                min-height: 44px;
            }

            .badge {
                min-height: 28px;
                min-width: 60px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            /* Remove hover effects on touch devices */
            .btn:hover,
            .badge:hover {
                transform: none;
            }

            /* Add active states for touch feedback */
            .btn:active,
            button:active {
                opacity: 0.8;
                transform: scale(0.98);
            }

            .badge:active {
                opacity: 0.8;
            }

            /* Ensure form controls are touch-friendly */
            .form-control,
            .form-select {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }
        }

        /* === ACCESSIBILITY === */

        /* Focus styles */
        .btn:focus,
        button:focus,
        .form-control:focus,
        .form-select:focus {
            outline: 2px solid var(--tech-accent);
            outline-offset: 2px;
        }

        /* Required field indicator */
        [required] {
            border-left: 3px solid transparent;
        }

        /* === FORM VALIDATION STYLES === */

        .invalid-feedback {
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('userForm');
                const submitBtn = document.getElementById('submitBtn');

                // Real-time validation
                const validateField = (field) => {
                    if (field.validity.valid) {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    } else {
                        field.classList.remove('is-valid');
                        field.classList.add('is-invalid');
                    }
                };

                // Validate all required fields on input
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    field.addEventListener('input', () => validateField(field));
                    field.addEventListener('blur', () => validateField(field));
                });

                // Enhanced form submission
                form.addEventListener('submit', function(e) {
                    // Check all required fields
                    let isValid = true;
                    requiredFields.forEach(field => {
                        validateField(field);
                        if (!field.validity.valid) {
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        // Scroll to first invalid field
                        const firstInvalid = form.querySelector('.is-invalid');
                        if (firstInvalid) {
                            firstInvalid.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            firstInvalid.focus();
                        }
                        return;
                    }

                    // Show loading state
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
                    submitBtn.disabled = true;

                    // Re-enable button after 5 seconds (in case submission fails)
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 5000);
                });

                // Auto-remove alerts after 8 seconds
                setTimeout(() => {
                    const alerts = document.querySelectorAll('.alert:not(.alert-tech-danger)');
                    alerts.forEach(alert => {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    });
                }, 8000);

                // Role badges click functionality
                const roleBadges = document.querySelectorAll('.badge[style*="cursor: pointer"]');
                roleBadges.forEach(badge => {
                    badge.addEventListener('click', function() {
                        const roleSelect = document.getElementById('role_id');
                        const roleName = this.textContent.trim();

                        // Find option with matching text
                        for (let option of roleSelect.options) {
                            if (option.textContent.trim() === roleName) {
                                roleSelect.value = option.value;
                                roleSelect.classList.add('is-valid');
                                break;
                            }
                        }
                    });

                    // Touch feedback for mobile
                    badge.addEventListener('touchstart', function() {
                        this.style.opacity = '0.7';
                    });

                    badge.addEventListener('touchend', function() {
                        this.style.opacity = '';
                    });
                });

                // Mobile form optimization
                if ('ontouchstart' in window) {
                    // Prevent zoom on input focus for iOS
                    const inputs = form.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.addEventListener('focus', () => {
                            input.style.fontSize = '16px'; // Prevents iOS zoom
                        });

                        input.addEventListener('blur', () => {
                            input.style.fontSize = '';
                        });
                    });

                    // Add touch feedback to buttons
                    const buttons = form.querySelectorAll('button, .btn');
                    buttons.forEach(button => {
                        button.addEventListener('touchstart', function() {
                            this.style.opacity = '0.8';
                        });

                        button.addEventListener('touchend', function() {
                            this.style.opacity = '';
                        });
                    });
                }

                // Form field auto-save (localStorage)
                if (typeof Storage !== 'undefined') {
                    const formFields = form.querySelectorAll('input, select, textarea');

                    // Load saved data
                    formFields.forEach(field => {
                        const savedValue = localStorage.getItem(`userForm_${field.name}`);
                        if (savedValue && !field.value) {
                            field.value = savedValue;
                        }
                    });

                    // Save on input
                    formFields.forEach(field => {
                        field.addEventListener('input', () => {
                            localStorage.setItem(`userForm_${field.name}`, field.value);
                        });
                    });

                    // Clear saved data on successful submit
                    form.addEventListener('submit', () => {
                        formFields.forEach(field => {
                            localStorage.removeItem(`userForm_${field.name}`);
                        });
                    });
                }
            });
        </script>
    @endpush
@endsection
