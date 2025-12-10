@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-2 px-sm-3 mt-3">
        <!-- Breadcrumb Navigation -->
        <nav style="--bs-breadcrumb-divider: '›';" aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="font-size: 0.875rem;">
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}" class="text-decoration-none text-muted">
                        <i class="fas fa-users fa-sm me-1"></i>Users
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.show', $user->id) }}" class="text-decoration-none text-muted">
                        <i class="fas fa-user fa-sm me-1"></i>{{ Str::limit($user->name, 10) }}
                    </a>
                </li>
                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">
                    <i class="fas fa-edit fa-sm me-1"></i>Edit
                </li>
            </ol>
        </nav>

        <!-- Header - Technical Theme -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <div>
                <h4 class="mb-0 text-dark fw-bold" style="font-size: 1.1rem;">
                    <i class="fas fa-user-edit me-2 d-none d-sm-inline" style="color: #2d3748;"></i>
                    <span class="d-none d-sm-inline">Edit User</span>
                    <span class="d-inline d-sm-none">Edit User</span>
                </h4>
                <p class="text-muted small mb-0 d-none d-md-block">Update user account information and permissions</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('users.show', $user->id) }}"
                    class="btn btn-outline-secondary d-flex align-items-center gap-1 shadow-sm px-3 py-2"
                    style="font-size: 0.875rem;">
                    <i class="fas fa-eye"></i>
                    <span class="d-none d-sm-inline">View Profile</span>
                    <span class="d-inline d-sm-none">View</span>
                </a>
                <a href="{{ route('users.index') }}"
                    class="btn btn-outline-secondary d-flex align-items-center gap-1 shadow-sm px-3 py-2"
                    style="font-size: 0.875rem;">
                    <i class="fas fa-arrow-left"></i>
                    <span class="d-none d-sm-inline">All Users</span>
                    <span class="d-inline d-sm-none">Back</span>
                </a>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 10px;">
            <!-- Card Header -->
            <div class="card-header py-2 px-3 border-bottom d-flex justify-content-between align-items-center"
                style="background: linear-gradient(to right, #f8fafc, #ffffff);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-cog text-primary me-2" style="font-size: 1rem;"></i>
                    <h5 class="mb-0 fw-semibold text-dark" style="font-size: 0.95rem;">Update User:
                        {{ Str::limit($user->name, 20) }}</h5>
                </div>
                <div class="d-flex align-items-center gap-2">
                    @php
                        $roleColors = [
                            'Admin' => 'danger',
                            'Technician' => 'warning',
                            'Helpdesk' => 'info',
                            'Customer' => 'secondary',
                        ];
                        $roleColor = $roleColors[$user->role->name] ?? 'secondary';
                    @endphp
                    <span
                        class="badge bg-{{ $roleColor }} bg-opacity-10 text-{{ $roleColor }} border border-{{ $roleColor }} border-opacity-25 d-none d-sm-inline"
                        style="font-size: 0.75rem;">
                        {{ $user->role->name }}
                    </span>
                    <span class="badge bg-tech-dark text-white" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                        ID: {{ $user->id }}
                    </span>
                </div>
            </div>

            <div class="card-body p-3 p-md-4">
                <!-- User Info Summary - Mobile Only -->
                <div class="d-block d-md-none mb-4">
                    <div class="user-summary-card border rounded p-3 shadow-sm"
                        style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px; background-color: #2d3748;">
                                <span class="text-white fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">{{ $user->name }}</h6>
                                <div class="small text-muted">
                                    <i class="fas fa-envelope fa-xs me-1"></i>{{ Str::limit($user->email, 20) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('users.update', $user->id) }}" id="editUserForm" class="tech-form">
                    @csrf
                    @method('PUT')

                    <!-- Personal Information Section -->
                    <div class="section-header mb-3">
                        <h6 class="fw-semibold text-dark mb-0">
                            <i class="fas fa-user-tag fa-sm me-2"></i>Personal Information
                        </h6>
                        <hr class="mt-2 mb-4">
                    </div>

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
                                    name="name" value="{{ old('name', $user->name) }}" required
                                    placeholder="Enter full name">
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
                                    name="email" value="{{ old('email', $user->email) }}" required
                                    placeholder="user@example.com">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <small class="form-text text-muted mt-2 d-block" style="font-size: 0.75rem;">
                                <i class="fas fa-exclamation-circle fa-xs me-1"></i>Changing email requires verification
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
                                    name="contact" value="{{ old('contact', $user->contact) }}" required
                                    placeholder="Phone number">
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
                                    name="nrc" value="{{ old('nrc', $user->nrc) }}"
                                    placeholder="National ID number">
                            </div>
                            @error('nrc')
                                <div class="invalid-feedback d-block mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="row mb-4 mb-md-5">
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
                                    name="address" value="{{ old('address', $user->address) }}"
                                    placeholder="Physical address">
                            </div>
                            @error('address')
                                <div class="invalid-feedback d-block mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="section-header mb-3">
                        <h6 class="fw-semibold text-dark mb-0">
                            <i class="fas fa-key fa-sm me-2"></i>Security Settings
                        </h6>
                        <hr class="mt-2 mb-4">
                    </div>

                    <!-- Password Update Notice -->
                    <div class="row mb-3 mb-md-4">
                        <div class="col-md-9 offset-md-3">
                            <div class="alert alert-tech-info border-0 shadow-sm py-2 px-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle me-2" style="color: #0ea5e9;"></i>
                                    <span style="font-size: 0.85rem;">
                                        <strong>Password Update:</strong> Leave password fields blank to keep current
                                        password
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="row mb-3 mb-md-4">
                        <label for="password" class="col-md-3 col-form-label fw-semibold text-dark mb-2 mb-md-0">
                            <i class="fas fa-lock fa-sm me-1 d-none d-md-inline"></i>
                            New Password
                        </label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" id="password"
                                    class="form-control border-start-0 shadow-sm @error('password') is-invalid @enderror"
                                    name="password" placeholder="Leave blank to keep current">
                                <button class="btn btn-outline-secondary border-start-0" type="button"
                                    id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block mt-1" style="font-size: 0.8rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                </div>
                            @enderror
                            <div class="password-strength mt-2" id="passwordStrength" style="display: none;">
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" id="passwordProgress" role="progressbar"
                                        style="width: 0%"></div>
                                </div>
                                <small class="text-muted" id="passwordHint" style="font-size: 0.75rem;"></small>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="row mb-4 mb-md-5">
                        <label for="password-confirm" class="col-md-3 col-form-label fw-semibold text-dark mb-2 mb-md-0">
                            <i class="fas fa-lock fa-sm me-1 d-none d-md-inline"></i>
                            Confirm Password
                        </label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" id="password-confirm"
                                    class="form-control border-start-0 shadow-sm" name="password_confirmation"
                                    placeholder="Confirm new password">
                                <button class="btn btn-outline-secondary border-start-0" type="button"
                                    id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-match mt-2" id="passwordMatch" style="display: none;">
                                <small class="text-success" style="font-size: 0.75rem;">
                                    <i class="fas fa-check-circle fa-xs me-1"></i>Passwords match
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Role & Permissions Section -->
                    <div class="section-header mb-3">
                        <h6 class="fw-semibold text-dark mb-0">
                            <i class="fas fa-user-tag fa-sm me-2"></i>Role & Permissions
                        </h6>
                        <hr class="mt-2 mb-4">
                    </div>

                    <!-- Role -->
                    <div class="row mb-4 mb-md-5">
                        <label for="role_id" class="col-md-3 col-form-label fw-semibold text-dark mb-2 mb-md-0">
                            <i class="fas fa-user-tag fa-sm me-1 d-none d-md-inline"></i>
                            User Role<span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-user-tag text-muted"></i>
                                </span>
                                <select id="role_id"
                                    class="form-select border-start-0 shadow-sm @error('role_id') is-invalid @enderror"
                                    name="role_id" required>
                                    <option value="">Select User Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
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

                            <!-- Role Quick Selection -->
                            <div class="mt-3">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($roles as $role)
                                        @php
                                            $roleColors = [
                                                'Admin' => 'danger',
                                                'Technician' => 'warning',
                                                'Helpdesk' => 'info',
                                                'Customer' => 'secondary',
                                            ];
                                            $roleColor = $roleColors[$role->name] ?? 'secondary';
                                            $isActive = old('role_id', $user->role_id) == $role->id;
                                        @endphp
                                        <button type="button"
                                            class="btn btn-sm border-0 role-select-btn {{ $isActive ? 'active' : '' }}"
                                            data-role-id="{{ $role->id }}"
                                            style="background: {{ $isActive ? 'linear-gradient(135deg, var(--tech-' . $roleColor . ') 0%, var(--tech-' . $roleColor . '-light) 100%)' : 'var(--tech-gray)' }}; 
                                                   color: {{ $isActive ? (in_array($roleColor, ['warning']) ? '#78350f' : 'white') : 'var(--tech-secondary)' }};">
                                            {{ $role->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="row">
                        <div class="col-md-9 offset-md-3">
                            <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                                <a href="{{ route('users.show', $user->id) }}"
                                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-1 flex-fill flex-sm-auto px-3 py-2 order-2 order-sm-1">
                                    <i class="fas fa-times"></i>
                                    <span class="d-none d-sm-inline">Cancel</span>
                                    <span class="d-inline d-sm-none">Cancel</span>
                                </a>
                                <button type="submit"
                                    class="btn text-white d-flex align-items-center justify-content-center gap-1 flex-fill flex-sm-auto px-3 py-2 order-1 order-sm-2"
                                    style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);" id="submitBtn">
                                    <i class="fas fa-save"></i>
                                    <span class="d-none d-sm-inline">Update User</span>
                                    <span class="d-inline d-sm-none">Update</span>
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
            --tech-info-light: #38bdf8;
            --tech-warning: #f59e0b;
            --tech-warning-light: #fbbf24;
            --tech-danger: #ef4444;
            --tech-danger-light: #f87171;
            --tech-success: #10b981;
            --tech-gray: #f1f5f9;
            --tech-light: #f8fafc;
            --tech-dark: #2d3748;
        }

        /* === MOBILE-FIRST RESPONSIVE DESIGN === */

        /* Base mobile styles */
        .container-fluid {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 0.5rem 0;
            margin-bottom: 0.5rem;
        }

        /* Technical Badges */
        .badge.bg-tech-primary {
            background: linear-gradient(135deg, var(--tech-primary) 0%, var(--tech-secondary) 100%);
            color: white;
        }

        .badge.bg-tech-dark {
            background-color: var(--tech-dark);
            color: white;
        }

        /* User Summary Card */
        .user-summary-card {
            border-radius: 8px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .avatar-placeholder {
            transition: transform 0.3s ease;
        }

        /* Section Headers */
        .section-header h6 {
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .section-header hr {
            border-color: #e2e8f0;
            opacity: 0.5;
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

        /* Password Toggle Button */
        #togglePassword,
        #toggleConfirmPassword {
            border-left: 1px solid #dee2e6 !important;
            border-radius: 0 8px 8px 0 !important;
        }

        /* Role Selection Buttons */
        .role-select-btn {
            border-radius: 20px;
            padding: 0.25rem 1rem;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .role-select-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .role-select-btn.active {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Technical Alerts */
        .alert-tech-info {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            border-left: 4px solid var(--tech-info);
            color: #0c4a6e;
            border-radius: 8px;
        }

        /* Password Strength Indicator */
        .password-strength .progress {
            background-color: #e2e8f0;
        }

        .password-strength .progress-bar {
            transition: width 0.3s ease;
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
                margin-bottom: 0.5rem;
            }

            .tech-form .form-control,
            .tech-form .form-select {
                font-size: 0.85rem;
                padding: 0.5rem 0.75rem;
            }

            .input-group-text {
                padding: 0.5rem 0.75rem;
            }

            .section-header h6 {
                font-size: 0.9rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }

            .role-select-btn {
                font-size: 0.75rem;
                padding: 0.2rem 0.75rem;
            }

            .row.mb-3 {
                margin-bottom: 1.25rem !important;
            }

            .row.mb-4 {
                margin-bottom: 1.5rem !important;
            }

            .section-header hr {
                margin-top: 0.5rem;
                margin-bottom: 1.5rem;
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

            .role-select-btn {
                font-size: 0.8rem;
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

            .section-header h6 {
                font-size: 1rem;
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

            .section-header h6 {
                font-size: 1.1rem;
            }
        }

        /* === TOUCH OPTIMIZATIONS === */

        @media (hover: none) and (pointer: coarse) {

            /* Increase touch targets for mobile */
            .btn,
            button,
            .form-control,
            .form-select,
            .input-group-text,
            .role-select-btn {
                min-height: 44px;
            }

            .role-select-btn {
                min-height: 36px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            /* Remove hover effects on touch devices */
            .btn:hover,
            .role-select-btn:hover {
                transform: none;
            }

            /* Add active states for touch feedback */
            .btn:active,
            button:active,
            .role-select-btn:active {
                opacity: 0.8;
                transform: scale(0.98);
            }

            /* Ensure form controls are touch-friendly */
            .form-control,
            .form-select {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }

            /* Larger touch area for form labels */
            .col-form-label {
                padding-top: 0.875rem;
            }
        }

        /* === ACCESSIBILITY === */

        /* Focus styles */
        .btn:focus,
        button:focus,
        .form-control:focus,
        .form-select:focus,
        .role-select-btn:focus {
            outline: 2px solid var(--tech-accent);
            outline-offset: 2px;
        }

        /* Required field indicator */
        .text-danger {
            color: var(--tech-danger) !important;
        }

        /* High contrast support */
        @media (prefers-contrast: high) {

            .form-control,
            .form-select {
                border: 2px solid currentColor;
            }

            .is-invalid {
                border-color: var(--tech-danger);
            }
        }

        /* === ANIMATIONS === */

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: slideIn 0.3s ease-out;
        }

        /* Form validation animations */
        .invalid-feedback {
            animation: slideIn 0.3s ease;
        }

        /* Responsive typography */
        h4 {
            font-size: clamp(1.1rem, 2vw, 1.5rem);
        }

        h5 {
            font-size: clamp(1rem, 1.8vw, 1.3rem);
        }

        h6 {
            font-size: clamp(0.9rem, 1.5vw, 1.1rem);
        }

        /* Responsive form spacing */
        .row.mb-3 {
            margin-bottom: clamp(1rem, 2vw, 1.5rem);
        }

        .row.mb-4 {
            margin-bottom: clamp(1.25rem, 2.5vw, 2rem);
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('editUserForm');
                const submitBtn = document.getElementById('submitBtn');
                const passwordInput = document.getElementById('password');
                const confirmPasswordInput = document.getElementById('password-confirm');
                const passwordStrength = document.getElementById('passwordStrength');
                const passwordProgress = document.getElementById('passwordProgress');
                const passwordHint = document.getElementById('passwordHint');
                const passwordMatch = document.getElementById('passwordMatch');
                const roleSelect = document.getElementById('role_id');
                const roleSelectBtns = document.querySelectorAll('.role-select-btn');

                // Toggle password visibility
                document.getElementById('togglePassword').addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                        '<i class="fas fa-eye-slash"></i>';
                });

                document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
                    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPasswordInput.setAttribute('type', type);
                    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                        '<i class="fas fa-eye-slash"></i>';
                });

                // Password strength checker
                function checkPasswordStrength(password) {
                    let strength = 0;
                    let hint = '';

                    if (password.length >= 8) strength += 25;
                    if (/[A-Z]/.test(password)) strength += 25;
                    if (/[0-9]/.test(password)) strength += 25;
                    if (/[^A-Za-z0-9]/.test(password)) strength += 25;

                    if (strength === 0) {
                        hint = '';
                        passwordStrength.style.display = 'none';
                    } else if (strength <= 25) {
                        hint = 'Weak password';
                        passwordProgress.style.width = '25%';
                        passwordProgress.className = 'progress-bar bg-danger';
                        passwordStrength.style.display = 'block';
                    } else if (strength <= 50) {
                        hint = 'Fair password';
                        passwordProgress.style.width = '50%';
                        passwordProgress.className = 'progress-bar bg-warning';
                        passwordStrength.style.display = 'block';
                    } else if (strength <= 75) {
                        hint = 'Good password';
                        passwordProgress.style.width = '75%';
                        passwordProgress.className = 'progress-bar bg-info';
                        passwordStrength.style.display = 'block';
                    } else {
                        hint = 'Strong password';
                        passwordProgress.style.width = '100%';
                        passwordProgress.className = 'progress-bar bg-success';
                        passwordStrength.style.display = 'block';
                    }

                    passwordHint.textContent = hint;
                }

                // Password match checker
                function checkPasswordMatch() {
                    const password = passwordInput.value;
                    const confirmPassword = confirmPasswordInput.value;

                    if (password && confirmPassword) {
                        if (password === confirmPassword) {
                            passwordMatch.style.display = 'block';
                            confirmPasswordInput.classList.remove('is-invalid');
                            confirmPasswordInput.classList.add('is-valid');
                        } else {
                            passwordMatch.style.display = 'none';
                            confirmPasswordInput.classList.remove('is-valid');
                            confirmPasswordInput.classList.add('is-invalid');
                        }
                    } else {
                        passwordMatch.style.display = 'none';
                        confirmPasswordInput.classList.remove('is-valid', 'is-invalid');
                    }
                }

                // Event listeners for password validation
                passwordInput.addEventListener('input', function() {
                    checkPasswordStrength(this.value);
                    checkPasswordMatch();
                });

                confirmPasswordInput.addEventListener('input', checkPasswordMatch);

                // Role selection buttons
                roleSelectBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const roleId = this.getAttribute('data-role-id');

                        // Update select dropdown
                        roleSelect.value = roleId;

                        // Update button states
                        roleSelectBtns.forEach(b => {
                            b.classList.remove('active');
                            const btnRoleId = b.getAttribute('data-role-id');
                            if (btnRoleId === roleId) {
                                b.classList.add('active');
                            }
                        });

                        // Visual feedback
                        this.classList.add('active');
                    });
                });

                // Update role button states when select changes
                roleSelect.addEventListener('change', function() {
                    const selectedRoleId = this.value;
                    roleSelectBtns.forEach(btn => {
                        const btnRoleId = btn.getAttribute('data-role-id');
                        if (btnRoleId === selectedRoleId) {
                            btn.classList.add('active');
                        } else {
                            btn.classList.remove('active');
                        }
                    });
                });

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

                    // Check password confirmation if password is entered
                    if (passwordInput.value && passwordInput.value !== confirmPasswordInput.value) {
                        confirmPasswordInput.classList.add('is-invalid');
                        confirmPasswordInput.focus();
                        isValid = false;
                    }

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
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
                    submitBtn.disabled = true;

                    // Re-enable button after 5 seconds (in case submission fails)
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 5000);
                });

                // Touch optimizations for mobile
                if ('ontouchstart' in window) {
                    // Add touch feedback to all interactive elements
                    const interactiveElements = form.querySelectorAll('.btn, .role-select-btn, input, select');
                    interactiveElements.forEach(el => {
                        el.addEventListener('touchstart', function() {
                            this.style.opacity = '0.8';
                        });

                        el.addEventListener('touchend', function() {
                            this.style.opacity = '';
                        });

                        el.addEventListener('touchcancel', function() {
                            this.style.opacity = '';
                        });
                    });

                    // Prevent zoom on form inputs for iOS
                    const inputs = form.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        input.addEventListener('focus', () => {
                            input.style.fontSize = '16px';
                        });

                        input.addEventListener('blur', () => {
                            input.style.fontSize = '';
                        });
                    });
                }

                // Form data auto-save (localStorage)
                if (typeof Storage !== 'undefined') {
                    const formFields = form.querySelectorAll('input, select');
                    const formId = `editUser_${user.id}`;

                    // Load saved data
                    const savedData = JSON.parse(localStorage.getItem(formId) || '{}');
                    formFields.forEach(field => {
                        if (savedData[field.name] && field.value === '') {
                            field.value = savedData[field.name];
                        }
                    });

                    // Save on input
                    formFields.forEach(field => {
                        field.addEventListener('input', () => {
                            const currentData = JSON.parse(localStorage.getItem(formId) || '{}');
                            currentData[field.name] = field.value;
                            localStorage.setItem(formId, JSON.stringify(currentData));
                        });
                    });

                    // Clear saved data on successful submit
                    form.addEventListener('submit', () => {
                        localStorage.removeItem(formId);
                    });
                }
            });
        </script>
    @endpush
@endsection
