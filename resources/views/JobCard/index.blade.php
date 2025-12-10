@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-3 px-md-4 py-4">
        <!-- Header Section -->
        <div class="header-section mb-4 mb-md-5">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                <div>
                    <h1 class="display-6 fw-bold mb-2 text-gradient-primary">Job Cards Management</h1>
                    <p class="text-muted mb-0">
                        @if (auth()->user()->role->name === 'Technician')
                            Manage your assigned service jobs efficiently
                        @else
                            Oversee and manage all service requests across the system
                        @endif
                    </p>
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

        <!-- Stats Cards - Fully Responsive -->
        <div class="row g-2 g-sm-3 g-md-4 mb-3 mb-md-4">
            @if (auth()->user()->role->name === 'Technician')
                <!-- TECHNICIAN VIEW - Responsive Layout -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
                    <a href="?filter=all" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'all' ? 'active' : '' }}"
                            id="filter-all">
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $assignedCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Jobs</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">My Jobs</p>
                                <small class="stat-trend text-success d-none d-sm-inline d-md-block">
                                    <i class="fas fa-arrow-up me-1"></i>Assigned to you
                                </small>
                                <small class="stat-trend text-success d-inline d-sm-none">
                                    <i class="fas fa-arrow-up me-1"></i>Assigned
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
                    <a href="?filter=diagnosis" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'diagnosis' ? 'active' : '' }}"
                            id="filter-diagnosis">
                            <div class="stat-icon bg-info">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $diagnosisCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Dx</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Diagnosis</p>
                                <small class="stat-trend text-info d-none d-sm-inline d-md-block">
                                    <i class="fas fa-clock me-1"></i>Professional check up
                                </small>
                                <small class="stat-trend text-info d-inline d-sm-none">
                                    <i class="fas fa-clock me-1"></i>Check up
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
                    <a href="?filter=repairing" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'repairing' ? 'active' : '' }}"
                            id="filter-repairing">
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $repairingCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Repair</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Repair</p>
                                <small class="stat-trend text-warning d-none d-sm-inline d-md-block">
                                    <i class="fas fa-play-circle me-1"></i>Being worked on
                                </small>
                                <small class="stat-trend text-warning d-inline d-sm-none">
                                    <i class="fas fa-play me-1"></i>In progress
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
                    <a href="?filter=completed" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'completed' ? 'active' : '' }}"
                            id="filter-completed">
                            <div class="stat-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $completedCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Done</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Completed</p>
                                <small class="stat-trend text-success d-none d-sm-inline d-md-block">
                                    <i class="fas fa-trophy me-1"></i>Done jobs
                                </small>
                                <small class="stat-trend text-success d-inline d-sm-none">
                                    <i class="fas fa-check me-1"></i>Done
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
                    <a href="?filter=sent_back" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'sent_back' ? 'active' : '' }}"
                            id="filter-sent_back">
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-undo"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $sentBackCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Return</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Sent Back</p>
                                <small class="stat-trend text-warning d-none d-sm-inline d-md-block">
                                    <i class="fas fa-undo me-1"></i>Requires attention
                                </small>
                                <small class="stat-trend text-warning d-inline d-sm-none">
                                    <i class="fas fa-undo me-1"></i>Review
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl">
                    <a href="?filter=unsuccessful" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'unsuccessful' ? 'active' : '' }}"
                            id="filter-unsuccessful">
                            <div class="stat-icon bg-danger">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $unsuccessfulCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Failed</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Unsuccessful</p>
                                <small class="stat-trend text-danger d-none d-sm-inline d-md-block">
                                    <i class="fas fa-times me-1"></i>Failed to repair
                                </small>
                                <small class="stat-trend text-danger d-inline d-sm-none">
                                    <i class="fas fa-times me-1"></i>Failed
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            @else
                <!-- HELPDESK/ADMIN VIEW - Responsive Layout -->
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-auto">
                    <a href="?filter=all" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'all' ? 'active' : '' }}"
                            id="filter-all">
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $requests->total() }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">All</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">All Jobs</p>
                                <small class="stat-trend text-primary d-none d-sm-inline d-md-block">
                                    <i class="fas fa-chart-line me-1"></i>Total active
                                </small>
                                <small class="stat-trend text-primary d-inline d-sm-none">
                                    <i class="fas fa-chart-line me-1"></i>Total
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-auto">
                    <a href="?filter=diagnosis" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'diagnosis' ? 'active' : '' }}"
                            id="filter-diagnosis">
                            <div class="stat-icon bg-info">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $diagnosisCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Dx</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Diagnosis</p>
                                <small class="stat-trend text-info d-none d-sm-inline d-md-block">
                                    <i class="fas fa-search me-1"></i>Under assessment
                                </small>
                                <small class="stat-trend text-info d-inline d-sm-none">
                                    <i class="fas fa-search me-1"></i>Assessment
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-auto">
                    <a href="?filter=repairing" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'repairing' ? 'active' : '' }}"
                            id="filter-repairing">
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $repairingCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Repair</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Repairing</p>
                                <small class="stat-trend text-warning d-none d-sm-inline d-md-block">
                                    <i class="fas fa-hammer me-1"></i>Active work
                                </small>
                                <small class="stat-trend text-warning d-inline d-sm-none">
                                    <i class="fas fa-hammer me-1"></i>Active
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-auto">
                    <a href="?filter=completed" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'completed' ? 'active' : '' }}"
                            id="filter-completed">
                            <div class="stat-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $completedCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Done</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Completed</p>
                                <small class="stat-trend text-success d-none d-sm-inline d-md-block">
                                    <i class="fas fa-trophy me-1"></i>Ready for collection
                                </small>
                                <small class="stat-trend text-success d-inline d-sm-none">
                                    <i class="fas fa-trophy me-1"></i>Ready
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-auto">
                    <a href="?filter=assessed" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'assessed' ? 'active' : '' }}"
                            id="filter-assessed">
                            <div class="stat-icon bg-purple">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $assessedCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Assessed</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Assessed</p>
                                <small class="stat-trend text-purple d-none d-sm-inline d-md-block">
                                    <i class="fas fa-check me-1"></i>Evaluation complete
                                </small>
                                <small class="stat-trend text-purple d-inline d-sm-none">
                                    <i class="fas fa-check me-1"></i>Evaluated
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-auto">
                    <a href="?filter=assigned" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'assigned' ? 'active' : '' }}"
                            id="filter-assigned">
                            <div class="stat-icon bg-teal">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $assignedCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Assigned</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Assigned</p>
                                <small class="stat-trend text-teal d-none d-sm-inline d-md-block">
                                    <i class="fas fa-users me-1"></i>With technicians
                                </small>
                                <small class="stat-trend text-teal d-inline d-sm-none">
                                    <i class="fas fa-users me-1"></i>With Tech
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-auto">
                    <a href="?filter=sent_back" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'sent_back' ? 'active' : '' }}"
                            id="filter-sent_back">
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-undo"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $sentBackCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Return</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Sent Back</p>
                                <small class="stat-trend text-warning d-none d-sm-inline d-md-block">
                                    <i class="fas fa-undo me-1"></i>Requires attention
                                </small>
                                <small class="stat-trend text-warning d-inline d-sm-none">
                                    <i class="fas fa-undo me-1"></i>Review
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-auto">
                    <a href="?filter=unsuccessful" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'unsuccessful' ? 'active' : '' }}"
                            id="filter-unsuccessful">
                            <div class="stat-icon bg-danger">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $unsuccessfulCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Failed</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Unsuccessful</p>
                                <small class="stat-trend text-danger d-none d-sm-inline d-md-block">
                                    <i class="fas fa-times me-1"></i>Cannot be repaired
                                </small>
                                <small class="stat-trend text-danger d-inline d-sm-none">
                                    <i class="fas fa-times me-1"></i>Cannot repair
                                </small>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-auto">
                    <a href="?filter=archived" class="text-decoration-none d-block h-100">
                        <div class="stat-card border-0 h-100 cursor-pointer {{ $filter == 'archived' ? 'active' : '' }}"
                            id="filter-archived">
                            <div class="stat-icon bg-secondary">
                                <i class="fas fa-archive"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number mb-0 mb-sm-1">{{ $archivedCount }}</h3>
                                <p class="stat-label mb-0 mb-sm-1 small d-md-none">Archive</p>
                                <p class="stat-label mb-0 mb-sm-1 d-none d-md-block">Archived</p>
                                <small class="stat-trend text-secondary d-none d-sm-inline d-md-block">
                                    <i class="fas fa-history me-1"></i>Completed history
                                </small>
                                <small class="stat-trend text-secondary d-inline d-sm-none">
                                    <i class="fas fa-history me-1"></i>History
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>
        <!-- Active Filter Indicator -->
        @if ($filter !== 'all')
            <div class="row mb-4" id="filter-indicator">
                <div class="col-12">
                    <div class="active-filter-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="filter-badge">
                                    <i class="fas fa-filter me-2"></i>
                                    {{ ucfirst(str_replace('_', ' ', $filter)) }} Jobs
                                </span>
                                <small class="text-muted ms-3">
                                    Showing {{ $requests->total() }} {{ str_replace('_', ' ', $filter) }} job
                                    card{{ $requests->total() !== 1 ? 's' : '' }}
                                </small>
                            </div>
                            <a href="?filter=all" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Clear Filter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Separator Section with Action Button -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="separator-section">
                    <div class="separator-line"></div>
                    <div class="separator-content">
                        <button onclick="goToJobList()" class="btn btn-outline-primary btn-hover">
                            <i class="fas fa-external-link-alt me-2"></i>
                            Go to Job List Page
                        </button>
                    </div>
                    <div class="separator-line"></div>
                </div>
            </div>
        </div>

        <!-- Job cards display - Maintaining all original functionality -->
        <div class="row g-4" id="requests-container">
            @foreach ($requests as $req)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 request-card-item" data-status="{{ $req->status }}">
                    @php
                        $statusColors = [
                            'submitted' => [
                                'card_bg' => 'rgba(255, 166, 43, 0.05)',
                                'header_bg' => 'rgba(255, 166, 43, 0.15)',
                                'border' => '2px solid rgba(255, 166, 43, 0.3)',
                                'accent' => '#ffa62b',
                                'badge_bg' => '#ffa62b',
                                'badge_text' => 'white',
                                'icon' => 'paper-plane',
                            ],
                            'assigned' => [
                                'card_bg' => 'rgba(51, 153, 137, 0.05)',
                                'header_bg' => 'rgba(51, 153, 137, 0.15)',
                                'border' => '2px solid rgba(51, 153, 137, 0.3)',
                                'accent' => '#339989',
                                'badge_bg' => '#339989',
                                'badge_text' => 'white',
                                'icon' => 'user-check',
                            ],
                            'diagnosis' => [
                                'card_bg' => 'rgba(5, 102, 141, 0.05)',
                                'header_bg' => 'rgba(5, 102, 141, 0.15)',
                                'border' => '2px solid rgba(5, 102, 141, 0.3)',
                                'accent' => '#05668d',
                                'badge_bg' => '#05668d',
                                'badge_text' => 'white',
                                'icon' => 'stethoscope',
                            ],
                            'assessed' => [
                                'card_bg' => 'rgba(102, 51, 153, 0.05)',
                                'header_bg' => 'rgba(102, 51, 153, 0.15)',
                                'border' => '2px solid rgba(102, 51, 153, 0.3)',
                                'accent' => '#663399',
                                'badge_bg' => '#663399',
                                'badge_text' => 'white',
                                'icon' => 'clipboard-check',
                            ],
                            'repairing' => [
                                'card_bg' => 'rgba(245, 245, 245, 0.8)',
                                'header_bg' => 'rgba(108, 117, 125, 0.15)',
                                'border' => '2px solid rgba(108, 117, 125, 0.3)',
                                'accent' => '#6c757d',
                                'badge_bg' => '#f5f5f5',
                                'badge_text' => '#6c757d',
                                'icon' => 'tools',
                            ],
                            'completed' => [
                                'card_bg' => 'rgba(9, 61, 158, 0.05)',
                                'header_bg' => 'rgba(9, 61, 158, 0.15)',
                                'border' => '2px solid rgba(9, 61, 158, 0.3)',
                                'accent' => '#093d9e',
                                'badge_bg' => '#093d9e',
                                'badge_text' => 'white',
                                'icon' => 'check-circle',
                            ],
                            'unsuccessful' => [
                                'card_bg' => 'rgba(235, 45, 47, 0.05)',
                                'header_bg' => 'rgba(235, 45, 47, 0.15)',
                                'border' => '2px solid rgba(235, 45, 47, 0.3)',
                                'accent' => '#eb2d2f',
                                'badge_bg' => '#eb2d2f',
                                'badge_text' => 'white',
                                'icon' => 'times-circle',
                            ],
                            'sent_back' => [
                                'card_bg' => 'rgba(255, 193, 7, 0.05)',
                                'header_bg' => 'rgba(255, 193, 7, 0.15)',
                                'border' => '2px solid rgba(255, 193, 7, 0.3)',
                                'accent' => '#ffc107',
                                'badge_bg' => '#ffc107',
                                'badge_text' => 'white',
                                'icon' => 'undo',
                            ],
                            'archived' => [
                                'card_bg' => 'rgba(108, 117, 125, 0.05)',
                                'header_bg' => 'rgba(108, 117, 125, 0.15)',
                                'border' => '2px solid rgba(108, 117, 125, 0.3)',
                                'accent' => '#6c757d',
                                'badge_bg' => '#6c757d',
                                'badge_text' => 'white',
                                'icon' => 'archive',
                            ],
                        ];
                        $colors = $statusColors[$req->status] ?? $statusColors['submitted'];

                        // Calculate payment details (only for helpdesk/admin)
                        $totalAmount = $req->final_cost ?? ($req->total_cost ?? 0);
                        $paidAmount = $req->amount_paid ?? 0;
                        $balance = $totalAmount - $paidAmount;
                        $paymentStatus = $req->payment_status ?? 'pending';
                    @endphp

                    <div class="job-card"
                        style="background: {{ $colors['card_bg'] }}; border: {{ $colors['border'] }};">
                        <!-- Header -->
                        <div class="job-card-header" style="background: {{ $colors['header_bg'] }};">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="job-id">#{{ $req->id }}</span>
                                <span class="status-badge"
                                    style="background: {{ $colors['badge_bg'] }}; color: {{ $colors['badge_text'] }};">
                                    <i class="fas fa-{{ $colors['icon'] }} me-1"></i>
                                    <span class="d-none d-sm-inline">{{ ucfirst($req->status) }}</span>
                                    <span class="d-sm-none">{{ substr(ucfirst($req->status), 0, 3) }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="job-card-body">
                            <!-- Device & Customer Info -->
                            <div class="info-section">
                                <!-- Device -->
                                <div class="info-item mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="info-icon me-3"
                                            style="background: {{ $colors['header_bg'] }}; color: {{ $colors['accent'] }};">
                                            <i class="fas fa-laptop"></i>
                                        </div>
                                        <div>
                                            <h6 class="info-title">{{ $req->device->name ?? 'N/A' }}</h6>
                                            <small class="info-subtitle">Device</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Customer -->
                                <div class="info-item">
                                    <div class="d-flex align-items-center">
                                        <div class="info-icon me-3"
                                            style="background: {{ $colors['header_bg'] }}; color: {{ $colors['accent'] }};">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <h6 class="info-title">{{ $req->customer->name ?? 'N/A' }}</h6>
                                            <small class="info-subtitle">Customer</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Meta Information -->
                            @if (auth()->user()->role->name === 'Technician')
                                <!-- Technician View: Only Priority -->
                                <div class="meta-section" style="background: rgba(0,0,0,0.03);">
                                    @if ($req->priority)
                                        <div class="meta-item text-center">
                                            <small class="meta-label">Priority</small>
                                            <small
                                                class="meta-value @if ($req->priority === 'high') text-danger @elseif($req->priority === 'medium') text-warning @else text-success @endif">
                                                <i class="fas fa-flag me-1"></i>
                                                {{ ucfirst($req->priority) }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Helpdesk/Admin View: Full Meta Information -->
                                <div class="meta-section" style="background: rgba(0,0,0,0.03);">
                                    <div class="row g-2">
                                        <!-- Date -->
                                        <div class="col-4">
                                            <div class="meta-item text-center">
                                                <small class="meta-label">Created</small>
                                                <small class="meta-value">
                                                    <i class="fas fa-calendar me-1 text-muted"></i>
                                                    {{ $req->created_at->format('M d') }}
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Priority -->
                                        @if ($req->priority)
                                            <div class="col-4">
                                                <div class="meta-item text-center">
                                                    <small class="meta-label">Priority</small>
                                                    <small
                                                        class="meta-value @if ($req->priority === 'high') text-danger @elseif($req->priority === 'medium') text-warning @else text-success @endif">
                                                        <i class="fas fa-flag me-1"></i>
                                                        {{ substr(ucfirst($req->priority), 0, 1) }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Technician (if assigned) -->
                                        @if ($req->technician)
                                            <div class="col-4">
                                                <div class="meta-item text-center">
                                                    <small class="meta-label">Tech</small>
                                                    <small class="meta-value">
                                                        <i class="fas fa-user-cog me-1 text-muted"></i>
                                                        {{ substr($req->technician->name, 0, 1) }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Payment Information - Only for Helpdesk/Admin -->
                            @if (auth()->user()->role->name !== 'Technician')
                                @if ($totalAmount > 0)
                                    <div class="payment-section @if ($balance > 0) unpaid @endif"
                                        style="border-left: 3px solid {{ $colors['accent'] }};">
                                        @if ($paymentStatus === 'paid' || $balance <= 0)
                                            {{-- Fully paid --}}
                                            <div class="text-center">
                                                <small class="payment-label">Total Amount</small>
                                                <div class="d-flex align-items-center justify-content-center mb-1">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span
                                                        class="payment-amount text-success">K{{ number_format($totalAmount, 0) }}</span>
                                                    <span class="payment-badge paid ms-2">PAID</span>
                                                </div>
                                            </div>
                                        @elseif($paymentStatus === 'partial' && $paidAmount > 0)
                                            {{-- Partial payment --}}
                                            <div class="text-center">
                                                <small class="payment-label">Payment Status</small>
                                                <div class="d-flex align-items-center justify-content-center mb-1">
                                                    <i class="fas fa-money-bill-wave text-warning me-2"></i>
                                                    <span
                                                        class="payment-amount text-warning">K{{ number_format($totalAmount, 0) }}</span>
                                                    <span class="payment-badge partial ms-2">PARTIAL</span>
                                                </div>
                                                <div class="row g-1">
                                                    <div class="col-6">
                                                        <small>Paid: K{{ number_format($paidAmount, 0) }}</small>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="text-danger fw-semibold">Due:
                                                            K{{ number_format($balance, 0) }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{-- Unpaid or pending --}}
                                            <div class="text-center">
                                                <small class="payment-label">Total Amount</small>
                                                <div class="d-flex align-items-center justify-content-center mb-1">
                                                    <i class="fas fa-money-bill-wave text-danger me-2"></i>
                                                    <span
                                                        class="payment-amount text-danger">K{{ number_format($totalAmount, 0) }}</span>
                                                    <span class="payment-badge pending ms-2">
                                                        {{ $paymentStatus === 'pending' ? 'UNPAID' : strtoupper($paymentStatus) }}
                                                    </span>
                                                </div>
                                                @if ($paidAmount > 0)
                                                    <div class="row g-1">
                                                        <div class="col-6">
                                                            <small>Paid: K{{ number_format($paidAmount, 0) }}</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-danger fw-semibold">Due:
                                                                K{{ number_format($balance, 0) }}</small>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @elseif($req->total_cost)
                                    {{-- Show total cost for non-completed jobs --}}
                                    <div class="payment-section text-center">
                                        <small class="payment-label">Estimated Cost</small>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <i class="fas fa-money-sign text-success me-2"></i>
                                            <span
                                                class="payment-amount text-success">K{{ number_format($req->total_cost, 0) }}</span>
                                        </div>
                                    </div>
                                @else
                                    {{-- No cost set --}}
                                    <div class="payment-section text-center">
                                        <small class="text-muted">
                                            <i class="fas fa-money-bill-wave me-1"></i>
                                            No cost set
                                        </small>
                                    </div>
                                @endif
                            @endif

                            <!-- Actions -->
                            <div class="action-section">
                                <a href="{{ route('JobCard.show', $req->id) }}" class="btn btn-outline-primary btn-view">
                                    <i class="fas fa-eye me-1"></i>
                                    <span class="d-none d-sm-inline">View Details</span>
                                    <span class="d-sm-none">View</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if ($requests->isEmpty())
            <div class="empty-state text-center py-5" id="original-empty-state">
                <div class="empty-icon mb-4">
                    <i class="fas fa-tasks fa-3x text-muted opacity-50"></i>
                </div>
                <h4 class="empty-title">No job cards</h4>
                <p class="empty-text mb-4">
                    @if (auth()->user()->role->name === 'Technician')
                        There are no job cards assigned to you.
                    @else
                        @if ($filter !== 'all')
                            There are no {{ str_replace('_', ' ', $filter) }} job cards to display.
                        @else
                            There are no job cards to display.
                        @endif
                    @endif
                </p>
                @if ($filter !== 'all')
                    <a href="?filter=all" class="btn btn-primary">
                        <i class="fas fa-times me-1"></i>Clear Filter
                    </a>
                @endif
            </div>
        @endif

        <!-- Pagination -->
        @if ($requests->hasPages())
            <div class="pagination-section">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="pagination-info text-muted">
                        <span class="d-none d-sm-inline">Showing {{ $requests->firstItem() }} to
                            {{ $requests->lastItem() }} of {{ $requests->total() }}</span>
                        <span class="d-sm-none">{{ $requests->currentPage() }}/{{ $requests->lastPage() }}</span>
                    </div>
                    <nav>
                        <ul class="pagination mb-0">
                            <!-- Previous Page Link -->
                            @if ($requests->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $requests->previousPageUrl() }}"
                                        rel="prev">&laquo;</a>
                                </li>
                            @endif

                            <!-- Mobile: Show current page, Desktop: Show all pages -->
                            <li class="page-item active d-sm-none">
                                <span class="page-link">{{ $requests->currentPage() }}</span>
                            </li>

                            @foreach ($requests->getUrlRange(1, $requests->lastPage()) as $page => $url)
                                @if ($page == $requests->currentPage())
                                    <li class="page-item active d-none d-sm-block">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item d-none d-sm-block">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            <!-- Next Page Link -->
                            @if ($requests->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $requests->nextPageUrl() }}"
                                        rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
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
            background: white;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
            box-shadow: var(--card-shadow);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        .stat-card.active {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, #f8fafc, #ffffff);
        }

        .stat-card.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .bg-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        }

        .bg-success {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .bg-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .bg-info {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
        }

        .bg-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .bg-purple {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        }

        .bg-teal {
            background: linear-gradient(135deg, #14b8a6, #0d9488);
        }

        .bg-secondary {
            background: linear-gradient(135deg, #6b7280, #4b5563);
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: bold;
            margin: 0;
            color: #1f2937;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 4px 0;
        }

        .stat-trend {
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Job Cards */
        .job-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: var(--card-shadow);
            height: 100%;
            border: 2px solid transparent;
        }

        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        .job-card-header {
            padding: 16px 20px;
            position: relative;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .job-id {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-transform: capitalize;
        }

        .job-card-body {
            padding: 20px;
        }

        /* Info Items */
        .info-section {
            margin-bottom: 20px;
        }

        .info-item {
            padding: 12px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .info-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
            line-height: 1.3;
        }

        .info-subtitle {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Meta Section */
        .meta-section {
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
        }

        .meta-item {
            padding: 4px 0;
        }

        .meta-label {
            display: block;
            font-size: 0.7rem;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .meta-value {
            font-size: 0.8rem;
            font-weight: 600;
            color: #1f2937;
        }

        /* Payment Section */
        .payment-section {
            background: rgba(0, 0, 0, 0.02);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .payment-section.unpaid {
            background: rgba(220, 53, 69, 0.03);
            border-left-color: #dc3545 !important;
        }

        .payment-label {
            font-size: 0.75rem;
            color: #6b7280;
            display: block;
            margin-bottom: 8px;
        }

        .payment-amount {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .payment-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .payment-badge.paid {
            background: #dcfce7;
            color: #166534;
        }

        .payment-badge.pending {
            background: #fee2e2;
            color: #991b1b;
        }

        .payment-badge.partial {
            background: #fef3c7;
            color: #92400e;
        }

        /* Action Section */
        .action-section {
            margin-top: 20px;
        }

        .btn-view {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            border-width: 1.5px;
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
        }

        /* Active Filter */
        .active-filter-card {
            background: white;
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: var(--card-shadow);
            border-left: 4px solid var(--primary-color);
        }

        .filter-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            box-shadow: 0 2px 4px rgba(30, 58, 138, 0.2);
        }

        /* Separator Section */
        .separator-section {
            display: flex;
            align-items: center;
        }

        .separator-line {
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .separator-content {
            padding: 0 20px;
        }

        .btn-hover {
            transition: all 0.3s ease;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Empty State */
        .empty-state {
            background: white;
            border-radius: 12px;
            padding: 60px 20px;
            box-shadow: var(--card-shadow);
        }

        .empty-icon {
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 12px;
        }

        .empty-text {
            color: #6b7280;
            max-width: 400px;
            margin: 0 auto;
        }

        /* Pagination */
        .pagination-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            margin-top: 30px;
        }

        .pagination {
            margin: 0;
        }

        .page-link {
            border: 1px solid #e5e7eb;
            color: #6b7280;
            padding: 8px 14px;
            margin: 0 2px;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }

        .page-link:hover {
            background: #f3f4f6;
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border-color: var(--primary-color);
            color: white;
        }

        /* Animations */
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

        .job-card,
        .stat-card {
            animation: fadeInUp 0.4s ease forwards;
            animation-delay: calc(var(--card-index) * 0.1s);
            opacity: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .stat-card {
                padding: 15px;
            }

            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 1rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .job-card-header {
                padding: 12px 16px;
            }

            .job-card-body {
                padding: 16px;
            }

            .info-icon {
                width: 36px;
                height: 36px;
            }

            .info-title {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .stat-card {
                padding: 12px;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 0.875rem;
            }

            .stat-number {
                font-size: 1.25rem;
            }

            .stat-label {
                font-size: 0.75rem;
            }

            .job-card {
                margin-bottom: 15px;
            }

            .payment-amount {
                font-size: 1rem;
            }

            .btn-view {
                padding: 8px;
                font-size: 0.875rem;
            }
        }

        /* Hover Effects */
        .stat-card:hover .stat-icon {
            transform: scale(1.1);
        }

        .job-card:hover .info-icon {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
    </style>

    <script>
        function goToJobList() {
            // Get the current active filter from URL parameter or default to 'all'
            const urlParams = new URLSearchParams(window.location.search);
            const activeFilter = urlParams.get('filter') || 'all';

            // Navigate to job list page with the current filter
            window.location.href = `/job-list?filter=${activeFilter}`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add animation delays to cards
            const statCards = document.querySelectorAll('.stat-card');
            const jobCards = document.querySelectorAll('.job-card');

            statCards.forEach((card, index) => {
                card.style.setProperty('--card-index', index);
            });

            jobCards.forEach((card, index) => {
                card.style.setProperty('--card-index', index + statCards.length);
            });

            // Add active state to filter cards on click
            const filterLinks = document.querySelectorAll('.stat-card');
            filterLinks.forEach(card => {
                card.addEventListener('click', function() {
                    // Remove active class from all stat cards
                    filterLinks.forEach(c => c.classList.remove('active'));
                    // Add active class to clicked card
                    this.classList.add('active');
                });
            });

            // Add hover effect to job cards
            jobCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Auto-refresh for technicians (every 30 seconds)
            if ('{{ auth()->user()->role->name }}' === 'Technician') {
                setInterval(() => {
                    // Check if user is actively using the page
                    if (!document.hidden) {
                        // Only refresh if no modals are open and user is not interacting with forms
                        if (!document.querySelector('.modal.show')) {
                            window.location.reload();
                        }
                    }
                }, 30000); // 30 seconds
            }
        });
    </script>
@endsection
