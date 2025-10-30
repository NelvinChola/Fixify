@extends('layouts.admin')

@section('content')
<div class="container-fluid py-3">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 fw-bold text-dark mb-0">JOB CARDS</h1>
            <p class="text-muted small mb-0 d-none d-sm-block">Job Cards Management</p>
        </div>
        {{-- <button class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>
            <span class="d-none d-sm-inline">New Job Card</span>
            <span class="d-sm-none">New</span>
        </button> --}}
    </div>

    <!-- Stats Overview - Role Based -->
    <div class="row g-2 mb-3">
        @if(auth()->user()->role->name === 'Technician')
            <!-- TECHNICIAN VIEW -->
            <!-- My Jobs (All assigned to technician) -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 bg-primary bg-opacity-10 h-100 cursor-pointer active" 
                     onclick="filterRequests('all')" id="filter-all">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold text-primary mb-0" style="font-size: 0.75rem;">{{ $requests->total() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">My Jobs</p>
                            </div>
                            <div class="icon-shape-sm bg-primary text-white rounded-circle" style="width: 28px; height: 28px;">
                                <i class="fas fa-tasks" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Diagnosis -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(5, 102, 141, 0.1);" 
                     onclick="filterRequests('diagnosis')" id="filter-diagnosis">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #05668d; font-size: 0.75rem;">{{ $diagnosisCount ?? $requests->where('status', 'diagnosis')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Diagnosis</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-white" style="background-color: #05668d; width: 28px; height: 28px;">
                                <i class="fas fa-stethoscope" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Repairing -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(245, 245, 245, 0.5); border: 1px solid #e9ecef;" 
                     onclick="filterRequests('repairing')" id="filter-repairing">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #6c757d; font-size: 0.75rem;">{{ $repairingCount ?? $requests->where('status', 'repairing')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Repair</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-dark" style="background-color: #f5f5f5; border: 1px solid #dee2e6; width: 28px; height: 28px;">
                                <i class="fas fa-tools" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(9, 61, 158, 0.1);" 
                     onclick="filterRequests('completed')" id="filter-completed">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #093d9e; font-size: 0.75rem;">{{ $completedCount ?? $requests->where('status', 'completed')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Completed</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-white" style="background-color: #093d9e; width: 28px; height: 28px;">
                                <i class="fas fa-check-circle" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sent Back -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(255, 193, 7, 0.1);" 
                     onclick="filterRequests('sent_back')" id="filter-sent_back">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #ffc107; font-size: 0.75rem;">{{ $sentBackCount ?? $requests->where('status', 'sent_back')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Sent Back</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-white" style="background-color: #ffc107; width: 28px; height: 28px;">
                                <i class="fas fa-undo" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unsuccessful -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(235, 45, 47, 0.1);" 
                     onclick="filterRequests('unsuccessful')" id="filter-unsuccessful">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #eb2d2f; font-size: 0.75rem;">{{ $unsuccessfulCount ?? $requests->where('status', 'unsuccessful')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Unsuccessful</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-white" style="background-color: #eb2d2f; width: 28px; height: 28px;">
                                <i class="fas fa-times-circle" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- HELPDESK/ADMIN VIEW -->
            <!-- All Jobs -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 bg-primary bg-opacity-10 h-100 cursor-pointer active" 
                     onclick="filterRequests('all')" id="filter-all">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold text-primary mb-0" style="font-size: 0.75rem;">{{ $requests->total() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">All Jobs</p>
                            </div>
                            <div class="icon-shape-sm bg-primary text-white rounded-circle" style="width: 28px; height: 28px;">
                                <i class="fas fa-tasks" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Diagnosis -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(5, 102, 141, 0.1);" 
                     onclick="filterRequests('diagnosis')" id="filter-diagnosis">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #05668d; font-size: 0.75rem;">{{ $diagnosisCount ?? $requests->where('status', 'diagnosis')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Diagnosis</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-white" style="background-color: #05668d; width: 28px; height: 28px;">
                                <i class="fas fa-stethoscope" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Repairing -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(245, 245, 245, 0.5); border: 1px solid #e9ecef;" 
                     onclick="filterRequests('repairing')" id="filter-repairing">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #6c757d; font-size: 0.75rem;">{{ $repairingCount ?? $requests->where('status', 'repairing')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Repairing</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-dark" style="background-color: #f5f5f5; border: 1px solid #dee2e6; width: 28px; height: 28px;">
                                <i class="fas fa-tools" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(9, 61, 158, 0.1);" 
                     onclick="filterRequests('completed')" id="filter-completed">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #093d9e; font-size: 0.75rem;">{{ $completedCount ?? $requests->where('status', 'completed')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Completed</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-white" style="background-color: #093d9e; width: 28px; height: 28px;">
                                <i class="fas fa-check-circle" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assessed -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(102, 51, 153, 0.1);" 
                     onclick="filterRequests('assessed')" id="filter-assessed">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #663399; font-size: 0.75rem;">{{ $assessedCount ?? $requests->where('status', 'assessed')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Assessed</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-white" style="background-color: #663399; width: 28px; height: 28px;">
                                <i class="fas fa-clipboard-check" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(51, 153, 137, 0.1);" 
                     onclick="filterRequests('assigned')" id="filter-assigned">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #339989; font-size: 0.75rem;">{{ $assignedCount ?? $requests->where('status', 'assigned')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Assigned</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-white" style="background-color: #339989; width: 28px; height: 28px;">
                                <i class="fas fa-user-check" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sent Back -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(255, 193, 7, 0.1);" 
                     onclick="filterRequests('sent_back')" id="filter-sent_back">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #ffc107; font-size: 0.75rem;">{{ $sentBackCount ?? $requests->where('status', 'sent_back')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Sent Back</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-white" style="background-color: #ffc107; width: 28px; height: 28px;">
                                <i class="fas fa-undo" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unsuccessful -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(235, 45, 47, 0.1);" 
                     onclick="filterRequests('unsuccessful')" id="filter-unsuccessful">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #eb2d2f; font-size: 0.75rem;">{{ $unsuccessfulCount ?? $requests->where('status', 'unsuccessful')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Unsuccessful</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-white" style="background-color: #eb2d2f; width: 28px; height: 28px;">
                                <i class="fas fa-times-circle" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Archived -->
            <div class="col-6 col-sm-4 col-lg-3">
                <div class="card stat-card border-0 h-100 cursor-pointer" 
                     style="background-color: rgba(108, 117, 125, 0.1);" 
                     onclick="filterRequests('archived')" id="filter-archived">
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: #6c757d; font-size: 0.75rem;">{{ $archivedCount ?? $requests->where('status', 'archived')->count() }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.6rem;">Archived</p>
                            </div>
                            <div class="icon-shape-sm rounded-circle text-white" style="background-color: #6c757d; width: 28px; height: 28px;">
                                <i class="fas fa-archive" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Active Filter Indicator -->
    <div class="row mb-2" id="filter-indicator" style="display: none;">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bg-light rounded p-2">
                <div>
                    <span class="badge bg-primary me-2" id="active-filter-badge">
                        @if(auth()->user()->role->name === 'Technician')
                            My Jobs
                        @else
                            All Jobs
                        @endif
                    </span>
                    <small class="text-muted" id="filter-count-text">
                        @if(auth()->user()->role->name === 'Technician')
                            Showing all my job cards
                        @else
                            Showing all job cards
                        @endif
                    </small>
                </div>
                <button class="btn btn-sm btn-outline-secondary" onclick="clearFilter()">
                    <i class="fas fa-times me-1"></i>Clear Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Separator Section with Action Button -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <hr class="my-1">
                </div>
                <div class="px-3">
                    <a href="{{ route('JobCard.index') }}" class="btn btn-outline-primary btn-sm fw-bold">
                        <i class="fas fa-external-link-alt me-2"></i>
                        Go to page
                    </a>
                </div>
                <div class="flex-grow-1">
                    <hr class="my-1">
                </div>
            </div>
        </div>
    </div>

    <!-- Rest of the job cards display code remains exactly the same -->
    <div class="row g-3" id="requests-container">
        @foreach($requests as $req)
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
                        'icon' => 'paper-plane'
                    ],
                    'assigned' => [
                        'card_bg' => 'rgba(51, 153, 137, 0.05)',
                        'header_bg' => 'rgba(51, 153, 137, 0.15)',
                        'border' => '2px solid rgba(51, 153, 137, 0.3)',
                        'accent' => '#339989',
                        'badge_bg' => '#339989',
                        'badge_text' => 'white',
                        'icon' => 'user-check'
                    ],
                    'diagnosis' => [
                        'card_bg' => 'rgba(5, 102, 141, 0.05)',
                        'header_bg' => 'rgba(5, 102, 141, 0.15)',
                        'border' => '2px solid rgba(5, 102, 141, 0.3)',
                        'accent' => '#05668d',
                        'badge_bg' => '#05668d',
                        'badge_text' => 'white',
                        'icon' => 'stethoscope'
                    ],
                    'assessed' => [
                        'card_bg' => 'rgba(102, 51, 153, 0.05)',
                        'header_bg' => 'rgba(102, 51, 153, 0.15)',
                        'border' => '2px solid rgba(102, 51, 153, 0.3)',
                        'accent' => '#663399',
                        'badge_bg' => '#663399',
                        'badge_text' => 'white',
                        'icon' => 'clipboard-check'
                    ],
                    'repairing' => [
                        'card_bg' => 'rgba(245, 245, 245, 0.8)',
                        'header_bg' => 'rgba(108, 117, 125, 0.15)',
                        'border' => '2px solid rgba(108, 117, 125, 0.3)',
                        'accent' => '#6c757d',
                        'badge_bg' => '#f5f5f5',
                        'badge_text' => '#6c757d',
                        'icon' => 'tools'
                    ],
                    'completed' => [
                        'card_bg' => 'rgba(9, 61, 158, 0.05)',
                        'header_bg' => 'rgba(9, 61, 158, 0.15)',
                        'border' => '2px solid rgba(9, 61, 158, 0.3)',
                        'accent' => '#093d9e',
                        'badge_bg' => '#093d9e',
                        'badge_text' => 'white',
                        'icon' => 'check-circle'
                    ],
                    'unsuccessful' => [
                        'card_bg' => 'rgba(235, 45, 47, 0.05)',
                        'header_bg' => 'rgba(235, 45, 47, 0.15)',
                        'border' => '2px solid rgba(235, 45, 47, 0.3)',
                        'accent' => '#eb2d2f',
                        'badge_bg' => '#eb2d2f',
                        'badge_text' => 'white',
                        'icon' => 'times-circle'
                    ],
                    'sent_back' => [
                        'card_bg' => 'rgba(255, 193, 7, 0.05)',
                        'header_bg' => 'rgba(255, 193, 7, 0.15)',
                        'border' => '2px solid rgba(255, 193, 7, 0.3)',
                        'accent' => '#ffc107',
                        'badge_bg' => '#ffc107',
                        'badge_text' => 'white',
                        'icon' => 'undo'
                    ],
                    'archived' => [
                        'card_bg' => 'rgba(108, 117, 125, 0.05)',
                        'header_bg' => 'rgba(108, 117, 125, 0.15)',
                        'border' => '2px solid rgba(108, 117, 125, 0.3)',
                        'accent' => '#6c757d',
                        'badge_bg' => '#6c757d',
                        'badge_text' => 'white',
                        'icon' => 'archive'
                    ]
                ];
                $colors = $statusColors[$req->status] ?? $statusColors['submitted'];
                
                // Calculate payment details (only for helpdesk/admin)
                $totalAmount = $req->final_cost ?? $req->total_cost ?? 0;
                $paidAmount = $req->amount_paid ?? 0;
                $balance = $totalAmount - $paidAmount;
                $paymentStatus = $req->payment_status ?? 'pending';
            @endphp
            
            <div class="card job-card h-100 status-card mb-0" 
                 style="background: {{ $colors['card_bg'] }}; border: {{ $colors['border'] }}; border-radius: 12px;">
                <!-- Compact Header -->
                <div class="card-header border-0 py-2 px-3" style="background: {{ $colors['header_bg'] }}; border-radius: 12px 12px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-white text-dark fw-semibold" style="font-size: 0.65rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">#{{ $req->id }}</span>
                        <span class="badge rounded-pill fw-semibold" 
                              style="background: {{ $colors['badge_bg'] }}; color: {{ $colors['badge_text'] }}; font-size: 0.65rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                            <i class="fas fa-{{ $colors['icon'] }} me-1"></i>
                            <span class="d-none d-sm-inline">{{ ucfirst($req->status) }}</span>
                            <span class="d-sm-none">{{ substr(ucfirst($req->status), 0, 3) }}</span>
                        </span>
                    </div>
                </div>

                <div class="card-body p-3">
                    <!-- Device & Customer Info -->
                    <div class="mb-3">
                        <!-- Device -->
                        <div class="d-flex align-items-center mb-2">
                            <div class="device-icon rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" 
                                 style="width: 32px; height: 32px; background: {{ $colors['header_bg'] }}; color: {{ $colors['accent'] }}; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <i class="fas fa-laptop" style="font-size: 0.8rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.8rem; line-height: 1.2;">{{ $req->device->name ?? 'N/A' }}</h6>
                                <small class="text-muted" style="font-size: 0.65rem;">Device</small>
                            </div>
                        </div>
                        
                        <!-- Customer -->
                        <div class="d-flex align-items-center">
                            <div class="device-icon rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" 
                                 style="width: 32px; height: 32px; background: {{ $colors['header_bg'] }}; color: {{ $colors['accent'] }}; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <i class="fas fa-user" style="font-size: 0.8rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.8rem; line-height: 1.2;">{{ $req->customer->name ?? 'N/A' }}</h6>
                                <small class="text-muted" style="font-size: 0.65rem;">Customer</small>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Information Row - Different for Technician vs Helpdesk/Admin -->
                    @if(auth()->user()->role->name === 'Technician')
                        <!-- Technician View: Only Priority -->
                        <div class="d-flex justify-content-center align-items-center mb-3 p-2 rounded" style="background: rgba(0,0,0,0.03);">
                            @if($req->priority)
                            <div class="text-center">
                                <small class="text-muted d-block" style="font-size: 0.6rem;">Priority</small>
                                <small class="fw-semibold @if($req->priority === 'high') text-danger @elseif($req->priority === 'medium') text-warning @else text-success @endif" style="font-size: 0.7rem;">
                                    <i class="fas fa-flag me-1"></i>
                                    {{ ucfirst($req->priority) }}
                                </small>
                            </div>
                            @endif
                        </div>
                    @else
                        <!-- Helpdesk/Admin View: Full Meta Information -->
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded" style="background: rgba(0,0,0,0.03);">
                            <!-- Date -->
                            <div class="text-center">
                                <small class="text-muted d-block" style="font-size: 0.6rem;">Created</small>
                                <small class="fw-semibold text-dark" style="font-size: 0.7rem;">
                                    <i class="fas fa-calendar me-1 text-muted"></i>
                                    {{ $req->created_at->format('M d') }}
                                </small>
                            </div>
                            
                            <!-- Priority -->
                            @if($req->priority)
                            <div class="text-center">
                                <small class="text-muted d-block" style="font-size: 0.6rem;">Priority</small>
                                <small class="fw-semibold @if($req->priority === 'high') text-danger @elseif($req->priority === 'medium') text-warning @else text-success @endif" style="font-size: 0.7rem;">
                                    <i class="fas fa-flag me-1"></i>
                                    {{ substr(ucfirst($req->priority), 0, 1) }}
                                </small>
                            </div>
                            @endif

                            <!-- Technician (if assigned) -->
                            @if($req->technician)
                            <div class="text-center">
                                <small class="text-muted d-block" style="font-size: 0.6rem;">Tech</small>
                                <small class="fw-semibold text-dark" style="font-size: 0.7rem;">
                                    <i class="fas fa-user-cog me-1 text-muted"></i>
                                    {{ substr($req->technician->name, 0, 1) }}
                                </small>
                            </div>
                            @endif
                        </div>
                    @endif

                    <!-- Payment Information - Only for Helpdesk/Admin -->
                    @if(auth()->user()->role->name !== 'Technician')
                        @if($totalAmount > 0)
                        <div class="cost-display mb-3 p-2 rounded @if($balance > 0) unpaid @endif" 
                             style="background: rgba(0,0,0,0.02); border-left: 3px solid {{ $colors['accent'] }};">
                            @if($paymentStatus === 'paid' || $balance <= 0)
                                {{-- Fully paid --}}
                                <div class="text-center">
                                    <small class="text-muted d-block" style="font-size: 0.6rem;">Total Amount</small>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-check-circle text-success me-1" style="font-size: 0.7rem;"></i>
                                        <span class="fw-bold text-success" style="font-size: 0.8rem;">K{{ number_format($totalAmount, 0) }}</span>
                                        <span class="badge payment-status-badge payment-paid ms-2">PAID</span>
                                    </div>
                                </div>
                            @elseif($paymentStatus === 'partial' && $paidAmount > 0)
                                {{-- Partial payment --}}
                                <div class="text-center">
                                    <small class="text-muted d-block" style="font-size: 0.6rem;">Payment Status</small>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <i class="fas fa-money-bill-wave text-warning me-1" style="font-size: 0.7rem;"></i>
                                        <span class="fw-bold text-warning" style="font-size: 0.8rem;">K{{ number_format($totalAmount, 0) }}</span>
                                        <span class="badge payment-status-badge payment-partial ms-2">PARTIAL</span>
                                    </div>
                                    <div class="row g-1 text-muted" style="font-size: 0.55rem;">
                                        <div class="col-6">
                                            <small>Paid: K{{ number_format($paidAmount, 0) }}</small>
                                        </div>
                                        <div class="col-6">
                                            <small class="fw-semibold text-danger">Due: K{{ number_format($balance, 0) }}</small>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Unpaid or pending --}}
                                <div class="text-center">
                                    <small class="text-muted d-block" style="font-size: 0.6rem;">Total Amount</small>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <i class="fas fa-money-bill-wave text-danger me-1" style="font-size: 0.7rem;"></i>
                                        <span class="fw-bold text-danger" style="font-size: 0.8rem;">K{{ number_format($totalAmount, 0) }}</span>
                                        <span class="badge payment-status-badge payment-pending ms-2">
                                            {{ $paymentStatus === 'pending' ? 'UNPAID' : strtoupper($paymentStatus) }}
                                        </span>
                                    </div>
                                    @if($paidAmount > 0)
                                    <div class="row g-1 text-muted" style="font-size: 0.55rem;">
                                        <div class="col-6">
                                            <small>Paid: K{{ number_format($paidAmount, 0) }}</small>
                                        </div>
                                        <div class="col-6">
                                            <small class="fw-semibold text-danger">Due: K{{ number_format($balance, 0) }}</small>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @elseif($req->total_cost)
                        {{-- Show total cost for non-completed jobs --}}
                        <div class="cost-display mb-3 p-2 rounded text-center" style="background: rgba(0,0,0,0.02);">
                            <small class="text-muted d-block" style="font-size: 0.6rem;">Estimated Cost</small>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-money-sign text-success me-1" style="font-size: 0.7rem;"></i>
                                <span class="fw-bold text-success" style="font-size: 0.8rem;">K{{ number_format($req->total_cost, 0) }}</span>
                            </div>
                        </div>
                        @else
                        {{-- No cost set --}}
                        <div class="cost-display mb-3 p-2 rounded text-center" style="background: rgba(0,0,0,0.02);">
                            <small class="text-muted" style="font-size: 0.65rem;">
                                <i class="fas fa-money-bill-wave me-1"></i>
                                No cost set
                            </small>
                        </div>
                        @endif
                    @endif

                    <!-- Actions -->
                    <div class="d-grid">
                        <a href="{{ route('JobCard.show', $req->id) }}" class="btn btn-outline-primary btn-sm py-2 fw-semibold" 
                           style="font-size: 0.75rem; border-width: 1.5px; border-radius: 8px; transition: all 0.3s ease;">
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
    <div class="text-center py-4" id="no-requests-message" style="display: none;">
        <div class="icon-shape-sm bg-primary bg-opacity-10 text-primary rounded-circle mb-3 mx-auto" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-search"></i>
        </div>
        <h5 class="text-dark mb-2">No job cards found</h5>
        <p class="text-muted mb-3 small" id="no-requests-text">There are no job cards matching your filter.</p>
        <button class="btn btn-primary btn-sm" onclick="clearFilter()">
            <i class="fas fa-times me-1"></i>Clear Filter
        </button>
    </div>

    <!-- Original Empty State -->
    @if($requests->isEmpty())
    <div class="text-center py-4" id="original-empty-state">
        <div class="icon-shape-sm bg-primary bg-opacity-10 text-primary rounded-circle mb-3 mx-auto" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-tasks"></i>
        </div>
        <h5 class="text-dark mb-2">No job cards</h5>
        <p class="text-muted mb-3 small">
            @if(auth()->user()->role->name === 'Technician')
                There are no job cards assigned to you.
            @else
                There are no job cards to display.
            @endif
        </p>
        {{-- <button class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Create Job Card
        </button> --}}
    </div>
    @endif

    <!-- Pagination - Mobile Optimized -->
    @if($requests->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted" style="font-size: 0.75rem;">
            <span class="d-none d-sm-inline">Showing {{ $requests->firstItem() }} to {{ $requests->lastItem() }} of {{ $requests->total() }}</span>
            <span class="d-sm-none">{{ $requests->currentPage() }}/{{ $requests->lastPage() }}</span>
        </div>
        <nav>
            <ul class="pagination mb-0 pagination-sm">
                <!-- Previous Page Link -->
                @if($requests->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link" style="font-size: 0.75rem;">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $requests->previousPageUrl() }}" rel="prev" style="font-size: 0.75rem;">&laquo;</a>
                    </li>
                @endif

                <!-- Mobile: Show current page, Desktop: Show all pages -->
                <li class="page-item active d-sm-none">
                    <span class="page-link" style="font-size: 0.75rem;">{{ $requests->currentPage() }}</span>
                </li>

                @foreach($requests->getUrlRange(1, $requests->lastPage()) as $page => $url)
                    @if($page == $requests->currentPage())
                        <li class="page-item active d-none d-sm-block">
                            <span class="page-link" style="font-size: 0.75rem;">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item d-none d-sm-block">
                            <a class="page-link" href="{{ $url }}" style="font-size: 0.75rem;">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                <!-- Next Page Link -->
                @if($requests->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $requests->nextPageUrl() }}" rel="next" style="font-size: 0.75rem;">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link" style="font-size: 0.75rem;">&raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>

<style>
.stat-card {
    transition: transform 0.2s ease-in-out;
    min-height: 50px;
    border: 2px solid transparent;
}

.stat-card:hover {
    transform: translateY(-1px);
}

.stat-card.active {
    border: 2px solid #2196f3 !important;
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2) !important;
}

.status-card {
    transition: all 0.3s ease;
    border-radius: 8px;
}

.status-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

.job-card .card-header {
    border-radius: 6px 6px 0 0 !important;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.device-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.icon-shape-sm {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
}

/* Clickable stat cards */
.cursor-pointer {
    cursor: pointer;
}

/* Filter indicator */
#filter-indicator {
    animation: slideDown 0.3s ease-out;
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

/* Job card animations */
.request-card-item {
    transition: all 0.3s ease;
}

.request-card-item.hidden {
    display: none;
}

/* Modern Blue Color Scheme */
.bg-primary {
    background-color: #2196f3 !important;
}

.bg-primary.bg-opacity-10 {
    background-color: rgba(33, 150, 243, 0.1) !important;
}

.text-primary {
    color: #2196f3 !important;
}

.btn-primary {
    background-color: #2196f3;
    border-color: #2196f3;
    font-size: 0.8rem;
}

.btn-primary:hover {
    background-color: #1976d2;
    border-color: #1976d2;
}

.btn-outline-primary {
    color: #2196f3;
    border-color: #2196f3;
    font-size: 0.7rem;
}

.btn-outline-primary:hover {
    background-color: #2196f3;
    border-color: #2196f3;
    color: white;
}

/* Compact styling */
.job-card .card-body {
    padding: 0.5rem;
}

.badge {
    font-weight: 500;
    border: none;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}

.page-link {
    border-radius: 4px;
    margin: 0 1px;
    border: 1px solid #e3f2fd;
    padding: 0.25rem 0.5rem;
}

.page-item.active .page-link {
    background-color: #2196f3;
    border-color: #2196f3;
}

.page-link:hover {
    border-color: #2196f3;
    color: #2196f3;
}

/* Mobile optimizations */
@media (max-width: 576px) {
    .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    .stat-card .card-body {
        padding: 0.5rem;
    }
    
    .job-card {
        font-size: 0.8rem;
    }
    
    .stat-card {
        min-height: 45px;
    }
}

/* Ensure text remains readable on colored backgrounds */
.status-card .text-dark {
    color: #2d3748 !important;
}

.status-card .text-muted {
    color: #718096 !important;
}

/* Hover effects for status cards */
.status-card:hover .device-icon {
    transform: scale(1.05);
}

/* Enhanced Card Styling */
.job-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.job-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.job-card .card-header {
    border-radius: 12px 12px 0 0 !important;
    border-bottom: 1px solid rgba(0,0,0,0.08);
    padding: 0.75rem 1rem;
}

.job-card .card-body {
    padding: 1rem;
}

/* Enhanced Device Icons */
.device-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border-radius: 50%;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.device-icon:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Improved Payment Status */
.cost-display {
    transition: all 0.3s ease;
    border-left: 3px solid #2196f3;
}

.cost-display.unpaid {
    border-left-color: #dc3545;
    background: rgba(220, 53, 69, 0.03) !important;
}

.cost-display:hover {
    transform: translateX(2px);
}

/* Enhanced Badges */
.badge {
    font-weight: 600;
    border: none;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
}

/* Improved Buttons */
.btn-outline-primary {
    border-width: 1.5px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(33, 150, 243, 0.3);
}

/* Payment status styles */
.payment-status-badge {
    font-size: 0.55rem;
    padding: 0.15rem 0.4rem;
    border-radius: 4px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.payment-pending {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.payment-paid {
    background: linear-gradient(135deg, #28a745, #218838);
    color: white;
}

.payment-partial {
    background: linear-gradient(135deg, #ffc107, #e0a800);
    color: black;
}

/* Meta information grid */
.meta-grid {
    background: rgba(0,0,0,0.02);
    border-radius: 8px;
    padding: 0.5rem;
}

/* Enhanced responsive design */
@media (max-width: 576px) {
    .job-card .card-body {
        padding: 0.75rem;
    }
    
    .device-icon {
        width: 28px !important;
        height: 28px !important;
    }
    
    .device-icon i {
        font-size: 0.7rem !important;
    }
}

/* Smooth animations */
.status-card {
    animation: fadeInUp 0.5s ease-out;
}

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

/* Improved text hierarchy */
.job-card .text-dark {
    color: #2d3748 !important;
    font-weight: 700;
}

.job-card .text-muted {
    color: #718096 !important;
    font-weight: 500;
}

/* Enhanced hover effects */
.status-card:hover .device-icon {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Compact payment info */
.cost-display .text-muted {
    line-height: 1.2;
}

/* Enhanced active state for filter cards */
.stat-card.active::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    border: 2px solid #2196f3;
    border-radius: inherit;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(33, 150, 243, 0.4);
    }
    70% {
        box-shadow: 0 0 0 6px rgba(33, 150, 243, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(33, 150, 243, 0);
    }
}
</style>

<script>
let currentFilter = 'all';

document.addEventListener('DOMContentLoaded', function() {
    // Add click handlers to all stat cards
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove active class from all stat cards
            statCards.forEach(c => c.classList.remove('active'));
            // Add active class to clicked card
            this.classList.add('active');
        });
    });

    // Add smooth hover effects to cards
    const jobCards = document.querySelectorAll('.status-card');
    
    jobCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Add hover effects to stat cards
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(-1px)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateY(0)';
            }
        });
    });
});

function filterRequests(status) {
    currentFilter = status;
    
    // Update active stat card
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => card.classList.remove('active'));
    
    // Activate the clicked stat card
    const activeCard = document.getElementById(`filter-${status}`);
    if (activeCard) activeCard.classList.add('active');
    
    // Filter job cards
    const jobCards = document.querySelectorAll('.request-card-item');
    let visibleCount = 0;
    
    jobCards.forEach(card => {
        if (status === 'all' || card.getAttribute('data-status') === status) {
            card.classList.remove('hidden');
            visibleCount++;
        } else {
            card.classList.add('hidden');
        }
    });
    
    // Update filter indicator
    const filterIndicator = document.getElementById('filter-indicator');
    const activeFilterBadge = document.getElementById('active-filter-badge');
    const filterCountText = document.getElementById('filter-count-text');
    
    if (status === 'all') {
        filterIndicator.style.display = 'none';
    } else {
        filterIndicator.style.display = 'block';
        const statusText = status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        activeFilterBadge.textContent = `${statusText} Job Cards`;
        filterCountText.textContent = `Showing ${visibleCount} ${statusText.toLowerCase()} job card${visibleCount !== 1 ? 's' : ''}`;
    }
    
    // Show/hide empty state messages
    const noRequestsMessage = document.getElementById('no-requests-message');
    const originalEmptyState = document.getElementById('original-empty-state');
    const noRequestsText = document.getElementById('no-requests-text');
    
    if (visibleCount === 0 && status !== 'all') {
        noRequestsMessage.style.display = 'block';
        if (originalEmptyState) originalEmptyState.style.display = 'none';
        const statusText = status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        noRequestsText.textContent = `There are no ${statusText.toLowerCase()} job cards.`;
    } else {
        noRequestsMessage.style.display = 'none';
        if (originalEmptyState) originalEmptyState.style.display = 'block';
    }
}

function clearFilter() {
    filterRequests('all');
    
    // Remove active class from all stat cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => card.classList.remove('active'));
    
    // Activate the "My Jobs" card by default
    const myJobsCard = document.getElementById('filter-all');
    if (myJobsCard) myJobsCard.classList.add('active');
    
    // Hide filter indicator
    document.getElementById('filter-indicator').style.display = 'none';
}
</script>
@endsection