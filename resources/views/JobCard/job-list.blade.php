@extends('layouts.admin')

@section('content')
<div class="container-fluid py-3">
    <!-- Header Section with Search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 fw-bold text-dark mb-0">JOB CARDS LIST</h1>
            {{-- <p class="text-muted small mb-0 d-none d-sm-block">Filtered Job Cards with Search</p> --}}
        </div>
        <div class="d-flex align-items-center">
            <!-- Search Form -->
            <form method="GET" action="{{ route('job.list') }}" class="me-2">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search jobs..." 
                           value="{{ $search }}"
                           style="border-radius: 6px 0 0 6px;">
                    <input type="hidden" name="filter" value="{{ $filter }}">
                    <input type="hidden" name="time_filter" value="{{ $timeFilter ?? 'latest' }}">
                    <button class="btn btn-primary" type="submit" style="border-radius: 0 6px 6px 0;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            <a href="{{ route('JobCard.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <!-- Active Filter and Search Info -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bg-light rounded p-2">
                <div>
                    @if($filter !== 'all')
                        <span class="badge bg-primary me-2">
                            {{ ucfirst(str_replace('_', ' ', $filter)) }} Jobs
                        </span>
                    @endif
                    @if(isset($timeFilter) && $timeFilter !== 'latest')
                        <span class="badge bg-success me-2">
                            @if($timeFilter === 'month')
                                This Month
                            @else
                                {{ ucfirst($timeFilter) }}
                            @endif
                        </span>
                    @endif
                    @if(!empty($search))
                        <span class="badge bg-info me-2">
                            Search: "{{ $search }}"
                        </span>
                    @endif
                    <small class="text-muted">
                        Showing {{ $requests->total() }} job card(s)
                        @if($filter !== 'all')
                            with status: {{ $filter }}
                        @endif
                        @if(isset($timeFilter) && $timeFilter !== 'latest')
                            from {{ $timeFilter === 'month' ? 'this month' : 'all time' }}
                        @endif
                        @if(!empty($search))
                            matching "{{ $search }}"
                        @endif
                    </small>
                </div>
                @if($filter !== 'all' || !empty($search) || (isset($timeFilter) && $timeFilter !== 'latest'))
                    <a href="{{ route('job.list') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Clear All
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Filter Section with Dropdown -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-dark mb-2">Filter by Time Period</h6>
                            <div class="d-flex align-items-center gap-3">
                                <!-- Latest Filter Button -->
                                <div class="filter-option">
                                    <a href="{{ route('job.list', ['filter' => $filter, 'time_filter' => 'latest', 'search' => $search]) }}" 
                                       class="btn btn-time-filter {{ ($timeFilter ?? 'latest') == 'latest' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm">
                                        <i class="fas fa-clock me-2"></i>
                                        Latest Jobs
                                    </a>
                                </div>
                                
                                <!-- Month Filter Dropdown -->
                                <div class="filter-option">
                                    <div class="dropdown">
                                        <button class="btn btn-time-filter {{ ($timeFilter ?? 'latest') == 'month' ? 'btn-success' : 'btn-outline-success' }} btn-sm dropdown-toggle" 
                                                type="button" 
                                                id="monthDropdown" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            @if(($timeFilter ?? 'latest') == 'month')
                                                This Month
                                            @else
                                                Select Month
                                            @endif
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="monthDropdown">
                                            <li>
                                                <a class="dropdown-item {{ ($timeFilter ?? 'latest') == 'month' ? 'active' : '' }}" 
                                                   href="{{ route('job.list', ['filter' => $filter, 'time_filter' => 'month', 'search' => $search]) }}">
                                                    <i class="fas fa-calendar me-2"></i>
                                                    This Month
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" 
                                                   href="{{ route('job.list', ['filter' => $filter, 'time_filter' => 'last_month', 'search' => $search]) }}">
                                                    <i class="fas fa-calendar-minus me-2"></i>
                                                    Last Month
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" 
                                                   href="{{ route('job.list', ['filter' => $filter, 'time_filter' => 'last_3_months', 'search' => $search]) }}">
                                                    <i class="fas fa-calendar-week me-2"></i>
                                                    Last 3 Months
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 text-md-end">
                            <div class="filter-stats">
                                <small class="text-muted">
                                    <i class="fas fa-filter me-1"></i>
                                    Active Filters: 
                                    <span class="fw-semibold text-dark">
                                        @if(($timeFilter ?? 'latest') == 'latest')
                                            Latest Jobs
                                        @elseif(($timeFilter ?? 'latest') == 'month')
                                            This Month
                                        @elseif(($timeFilter ?? 'latest') == 'last_month')
                                            Last Month
                                        @elseif(($timeFilter ?? 'latest') == 'last_3_months')
                                            Last 3 Months
                                        @endif
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--job cards display -->
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
/* Add these new styles for the filter section */
.filter-option {
    display: inline-block;
}

.btn-time-filter {
    border-radius: 8px;
    font-weight: 600;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    border-width: 2px;
}

.btn-time-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-time-filter.btn-primary {
    background: linear-gradient(135deg, #2196f3, #1976d2);
    border-color: #2196f3;
    box-shadow: 0 2px 8px rgba(33, 150, 243, 0.3);
}

.btn-time-filter.btn-success {
    background: linear-gradient(135deg, #28a745, #218838);
    border-color: #28a745;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
}

.filter-stats {
    background: rgba(0,0,0,0.03);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    border-left: 3px solid #2196f3;
}

/* Dropdown styles */
.dropdown-menu {
    border-radius: 8px;
    border: 1px solid #e3f2fd;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.dropdown-item {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    margin: 0.1rem 0.5rem;
    width: auto;
}

.dropdown-item.active {
    background: linear-gradient(135deg, #28a745, #218838);
    color: white;
}

.dropdown-item:hover {
    background-color: #e3f2fd;
    color: #2196f3;
}

/* Card styling for filter section */
.card {
    border-radius: 12px;
}

/* Responsive design */
@media (max-width: 768px) {
    .filter-option {
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .btn-time-filter {
        width: 100%;
        justify-content: center;
    }
    
    .filter-stats {
        margin-top: 1rem;
        text-align: center !important;
    }
}

/* Your existing CSS styles remain the same */
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

/* ... rest of your existing CSS ... */
</style>

<script>
// Add any JavaScript needed for dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    // Update dropdown button text based on selection
    const monthDropdown = document.getElementById('monthDropdown');
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    
    dropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            const text = this.textContent.trim();
            monthDropdown.innerHTML = `<i class="fas fa-calendar-alt me-2"></i>${text}`;
        });
    });
});
</script>
@endsection