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
                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">
                    <i class="fas fa-user fa-sm me-1"></i>{{ Str::limit($user->name, 15) }}
                </li>
            </ol>
        </nav>

        <!-- Header - Technical Theme -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <div>
                <h4 class="mb-0 text-dark fw-bold" style="font-size: 1.1rem;">
                    <i class="fas fa-user-circle me-2 d-none d-sm-inline" style="color: #2d3748;"></i>
                    <span class="d-none d-sm-inline">User Profile</span>
                    <span class="d-inline d-sm-none">Profile</span>
                </h4>
                <p class="text-muted small mb-0 d-none d-md-block">View and manage user account details</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('users.index') }}"
                    class="btn btn-outline-secondary d-flex align-items-center gap-1 shadow-sm px-3 py-2"
                    style="font-size: 0.875rem;">
                    <i class="fas fa-arrow-left"></i>
                    <span class="d-none d-sm-inline">Back to Users</span>
                    <span class="d-inline d-sm-none">Back</span>
                </a>
                <a href="{{ route('users.edit', $user->id) }}"
                    class="btn text-white d-flex align-items-center gap-1 shadow-sm px-3 py-2"
                    style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%); font-size: 0.875rem;">
                    <i class="fas fa-edit"></i>
                    <span class="d-none d-sm-inline">Edit User</span>
                    <span class="d-inline d-sm-none">Edit</span>
                </a>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 10px;">
            <!-- Card Header -->
            <div class="card-header py-2 px-3 border-bottom d-flex justify-content-between align-items-center"
                style="background: linear-gradient(to right, #f8fafc, #ffffff);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-id-card text-primary me-2" style="font-size: 1rem;"></i>
                    <h5 class="mb-0 fw-semibold text-dark" style="font-size: 0.95rem;">Account Details</h5>
                </div>
                <span class="badge bg-tech-primary text-white" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                    ID: {{ $user->id }}
                </span>
            </div>

            <div class="card-body p-3 p-md-4">
                <!-- User Profile Section -->
                <div class="row">
                    <!-- Left Column: User Avatar & Stats (Mobile: Top) -->
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <div class="user-profile-card border rounded p-3 shadow-sm"
                            style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                            <!-- Avatar -->
                            <div class="text-center mb-3">
                                @php
                                    $roleColors = [
                                        'Admin' => '#ef4444',
                                        'Technician' => '#f59e0b',
                                        'Helpdesk' => '#0ea5e9',
                                        'Customer' => '#6b7280',
                                    ];
                                    $avatarColor = $roleColors[$user->role->name] ?? '#6b7280';
                                    $initials = strtoupper(substr($user->name, 0, 1));
                                @endphp
                                <div class="avatar-container mx-auto mb-3" style="width: 120px; height: 120px;">
                                    <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                        style="background-color: {{ $avatarColor }}; width: 100%; height: 100%;">
                                        <span class="display-4 text-white fw-bold">{{ $initials }}</span>
                                    </div>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                                <div class="mb-3">
                                    @php
                                        $roleBadgeColors = [
                                            'Admin' => 'danger',
                                            'Technician' => 'warning',
                                            'Helpdesk' => 'info',
                                            'Customer' => 'secondary',
                                        ];
                                        $roleBadgeColor = $roleBadgeColors[$user->role->name] ?? 'secondary';
                                    @endphp
                                    <span
                                        class="badge bg-{{ $roleBadgeColor }} bg-opacity-10 text-{{ $roleBadgeColor }} border border-{{ $roleBadgeColor }} border-opacity-25">
                                        {{ $user->role->name }}
                                    </span>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="user-stats">
                                <div class="stat-item d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <span class="text-muted small">
                                        <i class="fas fa-calendar-plus fa-xs me-1"></i>Member Since
                                    </span>
                                    <span class="fw-semibold small">{{ $user->created_at->format('M Y') }}</span>
                                </div>
                                @if ($user->last_login_at)
                                    <div
                                        class="stat-item d-flex justify-content-between align-items-center py-2 border-bottom">
                                        <span class="text-muted small">
                                            <i class="fas fa-sign-in-alt fa-xs me-1"></i>Last Login
                                        </span>
                                        <span
                                            class="fw-semibold small">{{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}</span>
                                    </div>
                                @endif
                                <div class="stat-item d-flex justify-content-between align-items-center py-2">
                                    <span class="text-muted small">
                                        <i class="fas fa-envelope fa-xs me-1"></i>Status
                                    </span>
                                    <span class="badge bg-success bg-opacity-10 text-success small">Active</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions - Mobile Only -->
                        <div class="d-block d-lg-none mt-3">
                            <div class="d-grid gap-2">
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="btn btn-tech-warning shadow-sm d-flex align-items-center justify-content-center gap-1 py-2">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit Profile</span>
                                </a>
                                <button
                                    class="btn btn-outline-secondary shadow-sm d-flex align-items-center justify-content-center gap-1 py-2"
                                    onclick="window.history.back()">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>Go Back</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: User Details -->
                    <div class="col-lg-8">
                        <!-- Personal Information Section -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-transparent border-bottom py-2 px-3">
                                <h6 class="mb-0 fw-semibold text-dark">
                                    <i class="fas fa-user-tag fa-sm me-2"></i>Personal Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- Desktop View: Grid Layout -->
                                <div class="d-none d-md-block">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="detail-item">
                                                <div class="detail-label text-muted small mb-1">
                                                    <i class="fas fa-id-badge fa-xs me-1"></i>Full Name
                                                </div>
                                                <div class="detail-value fw-medium text-dark">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="detail-item">
                                                <div class="detail-label text-muted small mb-1">
                                                    <i class="fas fa-envelope fa-xs me-1"></i>Email Address
                                                </div>
                                                <div class="detail-value fw-medium text-dark">{{ $user->email }}</div>
                                                <a href="mailto:{{ $user->email }}" class="small text-decoration-none">
                                                    <i class="fas fa-paper-plane fa-xs me-1"></i>Send Email
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="detail-item">
                                                <div class="detail-label text-muted small mb-1">
                                                    <i class="fas fa-phone fa-xs me-1"></i>Contact Number
                                                </div>
                                                <div class="detail-value fw-medium text-dark">
                                                    {{ $user->contact ?? 'Not provided' }}</div>
                                                @if ($user->contact)
                                                    <a href="tel:{{ $user->contact }}"
                                                        class="small text-decoration-none">
                                                        <i class="fas fa-phone-alt fa-xs me-1"></i>Call
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="detail-item">
                                                <div class="detail-label text-muted small mb-1">
                                                    <i class="fas fa-id-card fa-xs me-1"></i>NRC Number
                                                </div>
                                                <div class="detail-value fw-medium text-dark">
                                                    {{ $user->nrc ?? 'Not provided' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="detail-item">
                                                <div class="detail-label text-muted small mb-1">
                                                    <i class="fas fa-map-marker-alt fa-xs me-1"></i>Address
                                                </div>
                                                <div class="detail-value fw-medium text-dark">
                                                    {{ $user->address ?? 'Not provided' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mobile View: List Layout -->
                                <div class="d-block d-md-none">
                                    <div class="detail-list">
                                        <div class="detail-item border-bottom py-2">
                                            <div class="detail-label text-muted small mb-1">
                                                <i class="fas fa-user fa-xs me-1"></i>Full Name
                                            </div>
                                            <div class="detail-value fw-medium text-dark">{{ $user->name }}</div>
                                        </div>
                                        <div class="detail-item border-bottom py-2">
                                            <div class="detail-label text-muted small mb-1">
                                                <i class="fas fa-envelope fa-xs me-1"></i>Email
                                            </div>
                                            <div class="detail-value fw-medium text-dark">{{ $user->email }}</div>
                                        </div>
                                        <div class="detail-item border-bottom py-2">
                                            <div class="detail-label text-muted small mb-1">
                                                <i class="fas fa-phone fa-xs me-1"></i>Contact
                                            </div>
                                            <div class="detail-value fw-medium text-dark">
                                                {{ $user->contact ?? 'Not provided' }}</div>
                                        </div>
                                        <div class="detail-item border-bottom py-2">
                                            <div class="detail-label text-muted small mb-1">
                                                <i class="fas fa-id-card fa-xs me-1"></i>NRC
                                            </div>
                                            <div class="detail-value fw-medium text-dark">
                                                {{ $user->nrc ?? 'Not provided' }}</div>
                                        </div>
                                        <div class="detail-item py-2">
                                            <div class="detail-label text-muted small mb-1">
                                                <i class="fas fa-map-marker-alt fa-xs me-1"></i>Address
                                            </div>
                                            <div class="detail-value fw-medium text-dark">
                                                {{ $user->address ?? 'Not provided' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information Section -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-transparent border-bottom py-2 px-3">
                                <h6 class="mb-0 fw-semibold text-dark">
                                    <i class="fas fa-cogs fa-sm me-2"></i>Account Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="detail-item">
                                            <div class="detail-label text-muted small mb-1">
                                                <i class="fas fa-user-tag fa-xs me-1"></i>User Role
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="badge bg-{{ $roleBadgeColor }} bg-opacity-10 text-{{ $roleBadgeColor }} border border-{{ $roleBadgeColor }} border-opacity-25">
                                                    {{ $user->role->name }}
                                                </span>
                                                <small class="text-muted">
                                                    @php
                                                        $roleDescriptions = [
                                                            'Admin' => 'Full system access',
                                                            'Technician' => 'Device and issue management',
                                                            'Helpdesk' => 'Customer support',
                                                            'Customer' => 'Service requests only',
                                                        ];
                                                        echo $roleDescriptions[$user->role->name] ?? 'User role';
                                                    @endphp
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="detail-item">
                                            <div class="detail-label text-muted small mb-1">
                                                <i class="fas fa-calendar-alt fa-xs me-1"></i>Registration Date
                                            </div>
                                            <div class="detail-value fw-medium text-dark">
                                                {{ $user->created_at->format('F d, Y') }}</div>
                                            <small class="text-muted">
                                                {{ $user->created_at->format('h:i A') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="detail-item">
                                            <div class="detail-label text-muted small mb-1">
                                                <i class="fas fa-clock fa-xs me-1"></i>Last Updated
                                            </div>
                                            <div class="detail-value fw-medium text-dark">
                                                {{ $user->updated_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="detail-item">
                                            <div class="detail-label text-muted small mb-1">
                                                <i class="fas fa-key fa-xs me-1"></i>Account Status
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-success bg-opacity-10 text-success">
                                                    <i class="fas fa-check-circle fa-xs me-1"></i>Active
                                                </span>
                                                <small class="text-muted">
                                                    Verified Account
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons - Desktop Only -->
                        <div class="d-none d-lg-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('users.index') }}"
                                class="btn btn-outline-secondary d-flex align-items-center gap-2 shadow-sm px-4 py-2">
                                <i class="fas fa-arrow-left"></i>
                                <span>Back to Users</span>
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}"
                                class="btn text-white d-flex align-items-center gap-2 shadow-sm px-4 py-2"
                                style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);">
                                <i class="fas fa-edit"></i>
                                <span>Edit User Details</span>
                            </a>
                        </div>
                    </div>
                </div>
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

        /* User Profile Card */
        .user-profile-card {
            border-radius: 10px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .avatar-container {
            width: 100px;
            height: 100px;
        }

        .avatar-placeholder {
            transition: transform 0.3s ease;
        }

        .avatar-placeholder:hover {
            transform: scale(1.05);
        }

        /* Detail Items */
        .detail-item {
            margin-bottom: 1rem;
        }

        .detail-label {
            color: #6b7280;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }

        .detail-value {
            font-size: 0.95rem;
            line-height: 1.4;
        }

        /* User Stats */
        .user-stats .stat-item {
            font-size: 0.875rem;
        }

        /* Buttons */
        .btn-tech-warning {
            background: linear-gradient(135deg, var(--tech-warning) 0%, #fbbf24 100%);
            border: none;
            color: #78350f;
        }

        .btn-tech-warning:hover {
            background: linear-gradient(135deg, #d97706 0%, var(--tech-warning) 100%);
            color: #78350f;
        }

        /* === RESPONSIVE BREAKPOINTS === */

        /* Extra Small (xs): < 576px - Mobile portrait */
        @media (max-width: 575.98px) {
            .container-fluid {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .breadcrumb {
                font-size: 0.8rem;
            }

            .user-profile-card {
                padding: 1rem !important;
            }

            .avatar-container {
                width: 80px;
                height: 80px;
            }

            .avatar-placeholder span {
                font-size: 2rem;
            }

            .detail-value {
                font-size: 0.9rem;
            }

            .btn {
                font-size: 0.85rem;
                padding: 0.5rem 1rem;
            }
        }

        /* Small (sm): 576px - 767px - Mobile landscape / Small tablets */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .avatar-container {
                width: 100px;
                height: 100px;
            }

            .avatar-placeholder span {
                font-size: 2.5rem;
            }
        }

        /* Medium (md): 768px - 991px - Tablets */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .container-fluid {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            .avatar-container {
                width: 110px;
                height: 110px;
            }

            .avatar-placeholder span {
                font-size: 3rem;
            }
        }

        /* Large (lg): 992px - 1199px - Laptops */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .container-fluid {
                padding-left: 2rem;
                padding-right: 2rem;
            }

            .avatar-container {
                width: 120px;
                height: 120px;
            }

            .avatar-placeholder span {
                font-size: 3.5rem;
            }
        }

        /* Extra Large (xl): ≥ 1200px - Desktops */
        @media (min-width: 1200px) {
            .container-fluid {
                padding-left: 2.5rem;
                padding-right: 2.5rem;
            }

            .avatar-container {
                width: 140px;
                height: 140px;
            }

            .avatar-placeholder span {
                font-size: 4rem;
            }
        }

        /* === TOUCH OPTIMIZATIONS === */

        @media (hover: none) and (pointer: coarse) {

            /* Increase touch targets for mobile */
            .btn,
            button,
            .badge {
                min-height: 44px;
            }

            .badge {
                min-height: 24px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            /* Remove hover effects on touch devices */
            .avatar-placeholder:hover {
                transform: none;
            }

            /* Add active states for touch feedback */
            .btn:active,
            button:active,
            .badge:active {
                opacity: 0.8;
                transform: scale(0.98);
            }

            /* Ensure links are touch-friendly */
            a:not(.btn):not(.badge) {
                min-height: 44px;
                display: inline-flex;
                align-items: center;
            }
        }

        /* === ACCESSIBILITY === */

        /* Focus styles */
        .btn:focus,
        button:focus,
        a:focus {
            outline: 2px solid var(--tech-accent);
            outline-offset: 2px;
        }

        /* High contrast support */
        @media (prefers-contrast: high) {
            .detail-label {
                font-weight: bold;
            }

            .badge {
                border: 2px solid currentColor;
            }
        }

        /* === ANIMATIONS === */

        .avatar-placeholder {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Card hover effects for desktop */
        @media (hover: hover) {
            .card:hover {
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }
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

        /* Responsive avatar sizing */
        .avatar-container {
            width: clamp(80px, 20vw, 140px);
            height: clamp(80px, 20vw, 140px);
        }

        .avatar-placeholder span {
            font-size: clamp(2rem, 6vw, 4rem);
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Touch optimizations for mobile
                if ('ontouchstart' in window) {
                    // Add touch feedback to all interactive elements
                    const interactiveElements = document.querySelectorAll('.btn, .badge, a[href]');
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
                    const inputs = document.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        input.addEventListener('focus', () => {
                            input.style.fontSize = '16px';
                        });

                        input.addEventListener('blur', () => {
                            input.style.fontSize = '';
                        });
                    });
                }

                // Copy email to clipboard functionality
                const emailElement = document.querySelector('.detail-item a[href^="mailto"]');
                if (emailElement) {
                    const email = '{{ $user->email }}';
                    emailElement.addEventListener('click', function(e) {
                        if (!e.target.closest('.copy-email')) {
                            const copyBtn = document.createElement('button');
                            copyBtn.className = 'btn btn-sm btn-outline-primary copy-email ms-2';
                            copyBtn.innerHTML = '<i class="fas fa-copy fa-xs"></i>';
                            copyBtn.title = 'Copy email to clipboard';
                            copyBtn.onclick = function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                navigator.clipboard.writeText(email).then(() => {
                                    copyBtn.innerHTML = '<i class="fas fa-check fa-xs"></i>';
                                    copyBtn.className =
                                        'btn btn-sm btn-outline-success copy-email ms-2';
                                    setTimeout(() => {
                                        copyBtn.innerHTML =
                                            '<i class="fas fa-copy fa-xs"></i>';
                                        copyBtn.className =
                                            'btn btn-sm btn-outline-primary copy-email ms-2';
                                    }, 2000);
                                });
                            };
                            this.parentNode.appendChild(copyBtn);
                        }
                    });
                }

                // Responsive avatar color animation
                const avatar = document.querySelector('.avatar-placeholder');
                if (avatar) {
                    avatar.addEventListener('click', function() {
                        this.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 300);
                    });
                }

                // Role badge info tooltip
                const roleBadge = document.querySelector('.badge[class*="bg-"]');
                if (roleBadge && !roleBadge.hasAttribute('data-bs-toggle')) {
                    roleBadge.setAttribute('data-bs-toggle', 'tooltip');
                    roleBadge.setAttribute('data-bs-placement', 'top');
                    roleBadge.setAttribute('title', 'User role and permissions');
                    new bootstrap.Tooltip(roleBadge);
                }

                // Mobile back button functionality
                const mobileBackBtn = document.querySelector('button[onclick*="history.back"]');
                if (mobileBackBtn) {
                    mobileBackBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        window.history.back();
                    });
                }

                // Page loading animation
                document.body.style.opacity = '0';
                document.body.style.transition = 'opacity 0.3s ease';
                setTimeout(() => {
                    document.body.style.opacity = '1';
                }, 100);
            });
        </script>
    @endpush
@endsection
