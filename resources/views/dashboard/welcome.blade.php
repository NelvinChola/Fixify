@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4">
        <!-- Modern Header with Stats -->
        <div class="row mb-4 mb-md-5">
            <div class="col-12">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div>
                        <h1 class="h2 h1-md fw-bold mb-2 text-gradient-primary">Welcome back, {{ auth()->user()->name }}! 👋
                        </h1>
                        <p class="text-muted mb-0">Here's what's happening with your service requests today</p>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2 gap-md-3">
                        <div class="badge bg-light text-dark px-3 py-2 shadow-sm">
                            <i class="fas fa-user-shield me-2 text-primary"></i>{{ auth()->user()->role->name }}
                        </div>
                        <div class="text-muted d-none d-md-block">
                            <i class="fas fa-calendar me-2"></i>{{ now()->format('F j, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Row - Optimized for All Devices -->
        @if (in_array(auth()->user()->role->name, ['HelpDesk', 'Admin', 'Technician']))
            <div class="row mb-4 mb-md-5">
                <div class="col-12">
                    <div class="row g-3 g-md-4">
                        <!-- Today's/Incoming Jobs -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div class="card stat-card border-0 shadow-sm h-100">
                                <div class="card-body p-3 p-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="icon-shape bg-primary text-white rounded-3 p-3">
                                                <i class="fas fa-inbox fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3 ms-md-4">
                                            <h3 class="fw-bold text-dark mb-1">{{ $todayJobs ?? 0 }}</h3>
                                            <p class="text-muted mb-0">
                                                @if (auth()->user()->role->name === 'Technician')
                                                    Incoming Jobs
                                                @else
                                                    Today's Jobs
                                                @endif
                                            </p>
                                            <small class="text-success fw-semibold">
                                                <i class="fas fa-arrow-up me-1"></i>
                                                @if (auth()->user()->role->name === 'Technician')
                                                    Your assigned jobs
                                                @else
                                                    Customer submitted today
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Jobs -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div class="card stat-card border-0 shadow-sm h-100">
                                <div class="card-body p-3 p-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="icon-shape bg-warning text-white rounded-3 p-3">
                                                <i class="fas fa-clock fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3 ms-md-4">
                                            <h3 class="fw-bold text-dark mb-1">{{ $submittedJobs ?? 0 }}</h3>
                                            <p class="text-muted mb-0">Pending</p>
                                            <small class="text-warning fw-semibold">
                                                <i class="fas fa-exclamation-circle me-1"></i>
                                                @if (auth()->user()->role->name === 'Technician')
                                                    Awaiting your action
                                                @else
                                                    Needs attention
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- In Progress -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div class="card stat-card border-0 shadow-sm h-100">
                                <div class="card-body p-3 p-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="icon-shape bg-info text-white rounded-3 p-3">
                                                <i class="fas fa-sync-alt fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3 ms-md-4">
                                            <h3 class="fw-bold text-dark mb-1">{{ $inProgressJobs ?? 0 }}</h3>
                                            <p class="text-muted mb-0">In Progress</p>
                                            <small class="text-info fw-semibold">
                                                <i class="fas fa-play-circle me-1"></i>
                                                @if (auth()->user()->role->name === 'Technician')
                                                    Currently working
                                                @else
                                                    Active work
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Completed -->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div class="card stat-card border-0 shadow-sm h-100">
                                <div class="card-body p-3 p-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="icon-shape bg-success text-white rounded-3 p-3">
                                                <i class="fas fa-check-circle fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3 ms-md-4">
                                            <h3 class="fw-bold text-dark mb-1">{{ $completedJobs ?? 0 }}</h3>
                                            <p class="text-muted mb-0">
                                                @if (auth()->user()->role->name === 'Technician')
                                                    My Completed
                                                @else
                                                    Today's Completed
                                                @endif
                                            </p>
                                            <small class="text-success fw-semibold">
                                                <i class="fas fa-trophy me-1"></i>
                                                @if (auth()->user()->role->name === 'Technician')
                                                    Completed today
                                                @else
                                                    All completed today
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Actions Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
                    <div>
                        <h3 class="h4 fw-bold text-primary mb-1">Quick Actions</h3>
                        <p class="text-muted small mb-0">Access your most important tasks quickly</p>
                    </div>
                    <span class="badge bg-primary px-3 py-2 d-none d-md-inline">
                        <i class="fas fa-bolt me-2"></i>Fast Access
                    </span>
                </div>
            </div>
        </div>

        <!-- Action Cards Grid - Fully Responsive -->
        <div class="row g-3 g-md-4" id="actionCardsContainer">
            @if (auth()->user()->role->name === 'Customer')
                <!-- Customer Actions -->
                <div class="col-xxl-4 col-lg-6 col-md-6 col-12">
                    <div class="card modern-card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-wrapper bg-primary text-white rounded-3 p-3 me-3">
                                    <i class="fas fa-laptop-medical fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Request Repair</h5>
                                    <p class="text-muted small mb-0">New service request</p>
                                </div>
                            </div>
                            <p class="text-muted mb-4 flex-grow-1">
                                Submit a new service request for your device and get started with our repair process.
                            </p>
                            <a href="{{ route('service-requests.select-device') }}" class="btn btn-primary btn-hover w-100">
                                <i class="fas fa-plus-circle me-2"></i>Start Request
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-lg-6 col-md-6 col-12">
                    <div class="card modern-card h-100 border-0 shadow-sm">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-wrapper bg-success text-white rounded-3 p-3 me-3">
                                    <i class="fas fa-history fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Service History</h5>
                                    <p class="text-muted small mb-0">Track your requests</p>
                                </div>
                            </div>
                            <p class="text-muted mb-4 flex-grow-1">
                                View your previous service requests and track the progress of current repairs.
                            </p>
                            <a href="{{ route('service-requests.history') }}" class="btn btn-success btn-hover w-100">
                                <i class="fas fa-clipboard-list me-2"></i>View History
                            </a>
                        </div>
                    </div>
                </div>
            @elseif(in_array(auth()->user()->role->name, ['HelpDesk', 'Admin', 'Technician']))
                <!-- Staff Actions -->
                @if (auth()->user()->role->name === 'Technician')
                    <div class="col-xxl-4 col-lg-6 col-md-6 col-12">
                        <div class="card modern-card h-100 border-0 shadow-sm">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-wrapper bg-primary text-white rounded-3 p-3 me-3">
                                        <i class="fas fa-tools fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1">Service Room</h5>
                                        <p class="text-muted small mb-0">Job management</p>
                                    </div>
                                </div>
                                <p class="text-muted mb-4 flex-grow-1">
                                    Access your assigned job cards and manage service requests in the repair workshop.
                                </p>
                                <a href="{{ route('JobCard.index') }}" class="btn btn-primary btn-hover w-100">
                                    <i class="fas fa-tasks me-2"></i>Enter Workshop
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                @if (in_array(auth()->user()->role->name, ['HelpDesk', 'Admin']))
                    <div class="col-xxl-4 col-lg-6 col-md-6 col-12">
                        <div class="card modern-card h-100 border-0 shadow-sm">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-wrapper bg-warning text-white rounded-3 p-3 me-3">
                                        <i class="fas fa-headset fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1">Support Center</h5>
                                        <p class="text-muted small mb-0">Customer support</p>
                                    </div>
                                </div>
                                <p class="text-muted mb-4 flex-grow-1">
                                    Handle customer inquiries, support tickets, and service coordination.
                                </p>
                                <a href="{{ route('JobCard.index') }}" class="btn btn-warning btn-hover w-100">
                                    <i class="fas fa-comments me-2"></i>Open Support
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->role->name === 'Admin')
                    <div class="col-xxl-4 col-lg-6 col-md-6 col-12">
                        <div class="card modern-card h-100 border-0 shadow-sm">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-wrapper bg-danger text-white rounded-3 p-3 me-3">
                                        <i class="fas fa-users-cog fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-dark mb-1">User Management</h5>
                                        <p class="text-muted small mb-0">Team administration</p>
                                    </div>
                                </div>
                                <p class="text-muted mb-4 flex-grow-1">
                                    Manage system users, roles, permissions, and team member access.
                                </p>
                                <a href="{{ route('users.index') }}" class="btn btn-danger btn-hover w-100">
                                    <i class="fas fa-users me-2"></i>Manage Team
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <!-- Overdue Jobs Section - Responsive -->
        @if (in_array(auth()->user()->role->name, ['HelpDesk', 'Admin', 'Technician']))
            <div class="row mt-4 mt-md-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3 py-md-4">
                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                                <div>
                                    <h5 class="fw-bold text-primary mb-1">
                                        <i class="fas fa-clock-exclamation me-2 text-danger"></i>
                                        @if (auth()->user()->role->name === 'Technician')
                                            My Overdue Jobs
                                        @else
                                            All Overdue Jobs
                                        @endif
                                    </h5>
                                    <p class="text-muted small mb-0">Jobs requiring urgent attention</p>
                                </div>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-sync-alt me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <!-- Overdue jobs list would go here -->
                            <div class="empty-state text-center py-4 py-md-5">
                                <div class="empty-icon mb-3">
                                    <i class="fas fa-clock-exclamation fa-3x text-danger opacity-50"></i>
                                </div>
                                <p class="text-muted mb-2">
                                    @if (auth()->user()->role->name === 'Technician')
                                        Your jobs exceeding repair time will appear here
                                    @else
                                        All jobs exceeding maximum repair hours will appear here
                                    @endif
                                </p>
                                <small class="text-muted">Monitor jobs that need urgent attention</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        :root {
            --primary-color: #1e3a8a;
            --primary-hover: #2563eb;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .text-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Stat Cards */
        .stat-card {
            border-radius: 12px;
            transition: all 0.3s ease;
            background: white;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        .icon-shape {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover .icon-shape {
            transform: scale(1.1);
        }

        /* Modern Cards */
        .modern-card {
            border-radius: 12px;
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
            background: white;
        }

        .modern-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        .icon-wrapper {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Buttons */
        .btn-hover {
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover), var(--primary-color));
        }

        /* Empty State */
        .empty-state {
            background: #f8fafc;
            border-radius: 8px;
        }

        .empty-icon {
            opacity: 0.7;
        }

        /* Badges */
        .badge {
            border-radius: 20px;
            font-weight: 500;
        }

        /* Typography */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 12px;
                padding-right: 12px;
            }

            .h1-md {
                font-size: 1.75rem;
            }

            .h2-md {
                font-size: 1.5rem;
            }

            .icon-shape {
                width: 48px;
                height: 48px;
            }

            .card-body {
                padding: 1rem !important;
            }

            .btn {
                padding: 8px 16px;
                font-size: 0.875rem;
            }

            .stat-card h3 {
                font-size: 1.5rem;
            }

            .modern-card h5 {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            .stat-card .ms-md-4 {
                margin-left: 1rem !important;
            }

            .icon-wrapper {
                width: 40px;
                height: 40px;
                font-size: 0.875rem;
            }

            .modern-card .me-3 {
                margin-right: 0.75rem !important;
            }

            .card-header {
                padding: 1rem !important;
            }
        }

        @media (max-width: 992px) {
            .row.g-4 {
                row-gap: 1rem !important;
            }

            .col-md-6,
            .col-lg-6,
            .col-xl-3 {
                margin-bottom: 0.5rem;
            }
        }

        @media (min-width: 1200px) {
            .container-fluid {
                max-width: 1400px;
                margin: 0 auto;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card,
        .modern-card {
            animation: fadeInUp 0.4s ease forwards;
            animation-delay: calc(var(--card-index) * 0.1s);
            opacity: 0;
        }

        /* Mobile-specific adjustments */
        @media (max-width: 360px) {
            .badge {
                font-size: 0.75rem;
                padding: 4px 8px;
            }

            .text-gradient-primary {
                font-size: 1.5rem;
            }

            .stat-card .d-flex {
                flex-direction: column;
                text-align: center;
            }

            .stat-card .ms-3 {
                margin-left: 0 !important;
                margin-top: 1rem;
            }
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {

            .stat-card:hover,
            .modern-card:hover {
                transform: none;
            }

            .btn-hover:hover {
                transform: none;
            }

            /* Increase touch targets for mobile */
            .btn,
            .card {
                min-height: 44px;
            }

            input,
            select,
            textarea,
            button {
                font-size: 16px;
                /* Prevents iOS zoom on focus */
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {

            .stat-card,
            .modern-card {
                background: #1f2937;
                border-color: #374151;
            }

            .text-dark {
                color: #f9fafb !important;
            }

            .text-muted {
                color: #9ca3af !important;
            }

            .bg-light {
                background-color: #374151 !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation delays to cards
            const statCards = document.querySelectorAll('.stat-card');
            const modernCards = document.querySelectorAll('.modern-card');

            statCards.forEach((card, index) => {
                card.style.setProperty('--card-index', index);
            });

            modernCards.forEach((card, index) => {
                card.style.setProperty('--card-index', index + statCards.length);
            });

            // Refresh button functionality
            const refreshBtn = document.querySelector('.btn-outline-danger');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function() {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Refreshing...';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                        // In real implementation, this would fetch fresh data
                        console.log('Dashboard refreshed');
                    }, 1000);
                });
            }

            // Add ripple effect to buttons
            const buttons = document.querySelectorAll('.btn-hover');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const x = e.clientX - e.target.getBoundingClientRect().left;
                    const y = e.clientY - e.target.getBoundingClientRect().top;

                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple-effect');
                    ripple.style.left = `${x}px`;
                    ripple.style.top = `${y}px`;

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Add CSS for ripple effect
            const rippleStyle = document.createElement('style');
            rippleStyle.textContent = `
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.7);
            transform: scale(0);
            animation: ripple 0.6s linear;
            width: 100px;
            height: 100px;
            margin-left: -50px;
            margin-top: -50px;
            pointer-events: none;
        }
        
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .btn-hover {
            position: relative;
            overflow: hidden;
        }
    `;
            document.head.appendChild(rippleStyle);

            // Handle window resize for better mobile experience
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Adjust layout on resize
                    const container = document.querySelector('.container-fluid');
                    if (window.innerWidth < 768) {
                        container.classList.add('mobile-view');
                    } else {
                        container.classList.remove('mobile-view');
                    }
                }, 250);
            });

            // Initialize mobile view check
            if (window.innerWidth < 768) {
                document.querySelector('.container-fluid').classList.add('mobile-view');
            }

            // Add mobile menu toggle for future enhancements
            const mobileMenuBtn = document.createElement('button');
            mobileMenuBtn.className = 'btn btn-primary d-md-none position-fixed bottom-3 end-3 rounded-circle p-3';
            mobileMenuBtn.style.zIndex = '1000';
            mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
            mobileMenuBtn.setAttribute('aria-label', 'Open menu');
            document.body.appendChild(mobileMenuBtn);

            mobileMenuBtn.addEventListener('click', function() {
                // This would toggle a mobile menu in a real implementation
                console.log('Mobile menu clicked');
            });
        });
    </script>
@endsection
