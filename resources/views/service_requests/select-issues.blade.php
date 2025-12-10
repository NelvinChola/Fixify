{{-- select-issues.blade.php --}}
@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-3 py-md-4">
        <!-- Debug Flash Messages -->
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-3 fa-lg"></i>
                            <div class="flex-grow-1">
                                <strong class="fw-bold">Success!</strong> {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-3 fa-lg"></i>
                            <div class="flex-grow-1">
                                <strong class="fw-bold">Error!</strong> {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                            <div class="flex-grow-1">
                                <strong class="fw-bold">Validation Errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li class="small">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Progress Indicator -->
                {{-- <div class="progress-container mb-4 mb-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="step-item completed">
                            <div class="step-circle">1</div>
                            <span class="step-label fw-semibold">Select Device</span>
                        </div>
                        <div class="step-connector"></div>
                        <div class="step-item active">
                            <div class="step-circle">2</div>
                            <span class="step-label fw-semibold">Describe Issues</span>
                        </div>
                        <div class="step-connector"></div>
                        <div class="step-item">
                            <div class="step-circle">3</div>
                            <span class="step-label text-muted">Confirm & Pay</span>
                        </div>
                    </div>
                </div> --}}

                <!-- Main Content Card -->
                <div class="card border-0 shadow-lg">
                    <!-- Card Header -->
                    <div class="card-header bg-white border-bottom py-3 py-md-4">
                        <div class="row align-items-center">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <h3 class="h4 h2-md fw-bold mb-2 text-gradient-primary">Describe Device Issues</h3>
                                <p class="text-muted mb-0 small">Select all issues you're experiencing with <strong
                                        class="text-dark">{{ $device->name }}</strong></p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                                    <span class="badge bg-light text-dark px-3 py-2 shadow-sm">
                                        <i class="fas fa-mobile-alt me-2"></i>{{ $device->brand }}
                                    </span>
                                    <span class="badge bg-primary px-3 py-2">
                                        <i class="fas fa-layer-group me-2"></i>{{ $issuesByCategory->count() }} Categories
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-3 p-md-4">
                        <div class="row g-4">
                            <!-- Device Information Sidebar -->
                            <div class="col-lg-4 col-md-5">
                                <div class="sticky-sidebar mb-4 mb-md-0">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3 p-md-4">
                                            <!-- Device Image -->
                                            <div class="device-preview mb-4">
                                                @if ($device->image)
                                                    <img src="{{ asset('storage/' . $device->image) }}"
                                                        alt="{{ $device->name }}" class="img-fluid rounded-3 shadow-sm mb-3"
                                                        style="max-height: 200px; object-fit: cover; width: 100%;">
                                                @else
                                                    <div class="bg-gradient-light rounded-3 d-flex align-items-center justify-content-center mb-3 shadow-sm"
                                                        style="height: 200px;">
                                                        <i class="fas fa-mobile-alt fa-4x text-muted"></i>
                                                    </div>
                                                @endif

                                                <h4 class="fw-bold text-center mb-2 h5">{{ $device->name }}</h4>
                                                <div class="text-center text-muted mb-3">
                                                    <div class="d-flex justify-content-center flex-wrap gap-2 gap-md-3">
                                                        <span class="small">
                                                            <i class="fas fa-tag me-1"></i>{{ $device->brand }}
                                                        </span>
                                                        <span class="small">
                                                            <i
                                                                class="fas fa-microchip me-1"></i>{{ $device->model ?? 'Standard' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Consultation Fee Card -->
                                            <div
                                                class="consultation-card bg-light rounded-3 p-3 mb-4 border-start border-4 border-warning">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div>
                                                        <h6 class="fw-bold text-dark mb-0 small">Consultation Fee</h6>
                                                        <small class="text-muted">Required for diagnosis</small>
                                                    </div>
                                                    <span class="badge bg-warning text-dark py-2 px-3">
                                                        K{{ number_format($consultationFee, 2) }}
                                                    </span>
                                                </div>
                                                <small class="text-muted d-block mt-2">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    This fee covers initial diagnosis and will be deducted from final repair
                                                    cost.
                                                </small>
                                            </div>

                                            <!-- Quick Stats -->
                                            <div class="quick-stats bg-gradient-primary text-white rounded-3 p-3 mb-4">
                                                <h6 class="fw-bold mb-3 text-white small">
                                                    <i class="fas fa-chart-bar me-2"></i>Quick Stats
                                                </h6>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <div class="text-center p-2">
                                                            <div class="fw-bold">{{ $issuesByCategory->count() }}
                                                            </div>
                                                            <small class="opacity-75">Categories</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-center p-2">
                                                            <div class="fw-bold">
                                                                {{ $issuesByCategory->flatten()->count() }}</div>
                                                            <small class="opacity-75">Total Issues</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Navigation -->
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('service-requests.select-device') }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-arrow-left me-2"></i>
                                                    Choose Different Device
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Issues Selection Section -->
                            <div class="col-lg-8 col-md-7">
                                <form action="{{ route('service-requests.store') }}" method="POST" id="issuesForm">
                                    <input type="hidden" name="device_id" value="{{ $device->id }}">
                                    <input type="hidden" name="agree_consultation_fee" id="agreeConsultationFee"
                                        value="0">
                                    @csrf

                                    @if ($issuesByCategory->count() > 0)
                                        <!-- Mobile Header & Selection Bar -->
                                        <div class="d-lg-none mb-3">
                                            <!-- Mobile Quick Stats -->
                                            <div class="bg-light rounded-3 p-3 mb-3">
                                                <div class="row text-center">
                                                    <div class="col-4 border-end">
                                                        <div class="fw-bold text-primary">{{ $issuesByCategory->count() }}
                                                        </div>
                                                        <small class="text-muted">Categories</small>
                                                    </div>
                                                    <div class="col-4 border-end">
                                                        <div class="fw-bold text-primary">
                                                            {{ $issuesByCategory->flatten()->count() }}</div>
                                                        <small class="text-muted">Total Issues</small>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="fw-bold text-success" id="mobileSelectedPreview">0
                                                        </div>
                                                        <small class="text-muted">Selected</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Mobile Control Bar -->
                                            <div
                                                class="d-flex justify-content-between align-items-center bg-white rounded-3 p-3 shadow-sm">
                                                <div>
                                                    <h6 class="fw-bold text-dark mb-0">Select Issues</h6>
                                                    <small class="text-muted">Tap to select</small>
                                                </div>
                                                <div class="form-check form-switch mb-0">
                                                    <input class="form-check-input" type="checkbox" id="mobileSelectAll">
                                                    <label class="form-check-label small fw-semibold"
                                                        for="mobileSelectAll">
                                                        Select All
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Desktop Header -->
                                        <div class="d-none d-lg-block mb-4">
                                            <div class="selection-header bg-white rounded-3 p-3 shadow-sm">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h5 class="fw-bold text-dark mb-0">
                                                            <i class="fas fa-list-check me-2 text-primary"></i>
                                                            Select Issues (<span id="desktopSelectedCount">0</span>
                                                            selected)
                                                        </h5>
                                                        <small class="text-muted">Check the issues affecting your
                                                            device</small>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="desktopSelectAll">
                                                        <label class="form-check-label fw-semibold ms-2"
                                                            for="desktopSelectAll">
                                                            Select All Issues
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mobile Category Accordion -->
                                        <div class="d-lg-none mb-4">
                                            <div class="accordion mobile-category-accordion" id="mobileCategoryAccordion">
                                                @foreach ($issuesByCategory as $categoryName => $issues)
                                                    <div class="accordion-item border-0 mb-3 shadow-sm">
                                                        <div class="accordion-header">
                                                            <button
                                                                class="accordion-button collapsed bg-white text-dark fw-bold py-3"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ $loop->index }}"
                                                                aria-expanded="false">
                                                                <div class="d-flex align-items-center w-100">
                                                                    <div class="category-icon me-3">
                                                                        <div class="bg-primary rounded-circle p-2">
                                                                            <i class="fas fa-folder text-white fa-sm"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 text-start">
                                                                        <h6 class="mb-0 fw-bold">
                                                                            {{ $categoryName ?? 'General Issues' }}</h6>
                                                                        <small class="text-muted">{{ $issues->count() }}
                                                                            issues</small>
                                                                    </div>
                                                                    <div class="badge bg-primary rounded-pill ms-2">
                                                                        {{ $issues->count() }}</div>
                                                                    <i class="fas fa-chevron-down ms-2 text-muted"></i>
                                                                </div>
                                                            </button>
                                                        </div>
                                                        <div id="collapse{{ $loop->index }}"
                                                            class="accordion-collapse collapse"
                                                            data-bs-parent="#mobileCategoryAccordion">
                                                            <div class="accordion-body p-3">
                                                                <div class="issues-grid-mobile">
                                                                    @foreach ($issues as $issue)
                                                                        @php
                                                                            $price =
                                                                                $issue->pivot->cost ??
                                                                                ($issue->cost ?? ($issue->cost ?? 0));
                                                                        @endphp
                                                                        <div class="issue-item-mobile mb-3">
                                                                            <div class="card border h-100">
                                                                                <div class="card-body p-3">
                                                                                    <div class="d-flex align-items-start">
                                                                                        <div
                                                                                            class="form-check mb-0 me-3 pt-1">
                                                                                            <input
                                                                                                class="form-check-input mobile-issue-checkbox"
                                                                                                type="checkbox"
                                                                                                name="issues[]"
                                                                                                value="{{ $issue->id }}"
                                                                                                id="mobile_issue{{ $issue->id }}"
                                                                                                data-price="{{ $price }}">
                                                                                        </div>
                                                                                        <div class="flex-grow-1">
                                                                                            <label
                                                                                                class="form-check-label w-100"
                                                                                                for="mobile_issue{{ $issue->id }}">
                                                                                                <div
                                                                                                    class="d-flex justify-content-between align-items-start mb-2">
                                                                                                    <h6
                                                                                                        class="fw-semibold text-dark mb-0 me-2">
                                                                                                        {{ $issue->issue }}
                                                                                                    </h6>
                                                                                                    <span
                                                                                                        class="price-tag fw-bold text-success">K{{ number_format($price, 2) }}</span>
                                                                                                </div>

                                                                                                @if ($issue->description)
                                                                                                    <p
                                                                                                        class="text-sm text-muted mb-2">
                                                                                                        {{ $issue->description }}
                                                                                                    </p>
                                                                                                @endif

                                                                                                <div
                                                                                                    class="issue-meta d-flex justify-content-between align-items-center">
                                                                                                    @if ($issue->repair_time)
                                                                                                        <small
                                                                                                            class="text-dark">
                                                                                                            <i
                                                                                                                class="fas fa-clock me-1"></i>
                                                                                                            {{ $issue->repair_time }}
                                                                                                        </small>
                                                                                                    @endif
                                                                                                    @if ($issue->warranty)
                                                                                                        <small
                                                                                                            class="text-primary">
                                                                                                            <i
                                                                                                                class="fas fa-shield-alt me-1"></i>
                                                                                                            {{ $issue->warranty }}
                                                                                                        </small>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input type="hidden"
                                                                                        name="costs[{{ $issue->id }}]"
                                                                                        value="{{ $price }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Desktop Category Grid -->
                                        <div class="d-none d-lg-block">
                                            <div class="issues-container">
                                                @foreach ($issuesByCategory as $categoryName => $issues)
                                                    <div class="category-card card border-0 shadow-sm mb-4">
                                                        <div class="card-header bg-white border-0 py-3">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="category-icon">
                                                                    <div
                                                                        class="icon-wrapper bg-primary text-white rounded-2 p-2">
                                                                        <i class="fas fa-folder"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h6 class="fw-bold text-dark mb-1">
                                                                        {{ $categoryName ?? 'General Issues' }}</h6>
                                                                    <small class="text-muted">{{ $issues->count() }}
                                                                        issues
                                                                        available</small>
                                                                </div>
                                                                <span
                                                                    class="badge bg-primary px-3 py-2">{{ $issues->count() }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="card-body p-3">
                                                            <div class="row g-3">
                                                                @foreach ($issues as $issue)
                                                                    @php
                                                                        $price =
                                                                            $issue->pivot->cost ??
                                                                            ($issue->cost ?? ($issue->cost ?? 0));
                                                                    @endphp
                                                                    <div class="col-xl-6 col-lg-12">
                                                                        <div class="issue-card card border h-100">
                                                                            <div class="card-body p-3">
                                                                                <div
                                                                                    class="d-flex align-items-start justify-content-between mb-2">
                                                                                    <div
                                                                                        class="form-check mb-0 flex-grow-1">
                                                                                        <input
                                                                                            class="form-check-input issue-checkbox"
                                                                                            type="checkbox"
                                                                                            name="issues[]"
                                                                                            value="{{ $issue->id }}"
                                                                                            id="issue{{ $issue->id }}"
                                                                                            data-price="{{ $price }}">
                                                                                        <label
                                                                                            class="form-check-label ms-3"
                                                                                            for="issue{{ $issue->id }}">
                                                                                            <h6
                                                                                                class="mb-1 fw-semibold text-dark">
                                                                                                {{ $issue->issue }}</h6>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="text-end ms-2">
                                                                                        <span
                                                                                            class="price-tag h6 fw-bold text-success mb-0">K{{ number_format($price, 2) }}</span>
                                                                                        <input type="hidden"
                                                                                            name="costs[{{ $issue->id }}]"
                                                                                            value="{{ $price }}">
                                                                                    </div>
                                                                                </div>

                                                                                @if ($issue->description)
                                                                                    <p class="text-sm text-muted mb-2">
                                                                                        {{ $issue->description }}</p>
                                                                                @endif

                                                                                <div
                                                                                    class="issue-meta d-flex justify-content-between align-items-center">
                                                                                    @if ($issue->repair_time)
                                                                                        <small class="text-dark">
                                                                                            <i
                                                                                                class="fas fa-clock me-1"></i>
                                                                                            {{ $issue->repair_time }}
                                                                                        </small>
                                                                                    @endif
                                                                                    @if ($issue->warranty)
                                                                                        <small class="text-primary">
                                                                                            <i
                                                                                                class="fas fa-shield-alt me-1"></i>
                                                                                            {{ $issue->warranty }}
                                                                                        </small>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Summary Card - Now visible on all devices -->
                                        <div class="summary-card card border-0 shadow-lg bg-gradient-dark text-white mt-4">
                                            <div class="card-body p-3 p-md-4">
                                                <div class="row align-items-center">
                                                    <div class="col-md-7 mb-4 mb-md-0">
                                                        <h5 class="text-white mb-3 h6 h5-md">
                                                            <i class="fas fa-clipboard-check me-2"></i>
                                                            Request Summary
                                                        </h5>
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-6">
                                                                <div class="text-center p-2 bg-dark rounded-3">
                                                                    <div class="fw-bold fs-4" id="selectedCount">0</div>
                                                                    <small class="opacity-75">Selected Issues</small>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-center p-2 bg-dark rounded-3">
                                                                    <div class="fw-bold fs-4">K<span
                                                                            id="totalCost">0.00</span></div>
                                                                    <small class="opacity-75">Repair Estimate</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-1">
                                                                <span class="opacity-75">Consultation Fee:</span>
                                                                <span class="fw-bold">K<span
                                                                        id="consultationFeeDisplay">{{ number_format($consultationFee, 2) }}</span></span>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="opacity-75">Total Amount:</span>
                                                                <span class="fw-bold fs-5">K<span
                                                                        id="grandTotal">0.00</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 text-center text-md-end">
                                                        <!-- Mobile Floating Submit Button -->
                                                        <div class="d-lg-none mb-3">
                                                            <button type="button" class="btn btn-success w-100 py-3"
                                                                id="mobileSubmitBtn" disabled>
                                                                <i class="fas fa-paper-plane me-2"></i>
                                                                Submit Request
                                                                <small class="d-block mt-1 opacity-75">Pay consultation fee
                                                                    to proceed</small>
                                                            </button>
                                                        </div>

                                                        <!-- Desktop Submit Button -->
                                                        <div class="d-none d-lg-block">
                                                            <button type="button"
                                                                class="btn btn-lg bg-success border-0 px-4 py-3"
                                                                id="desktopSubmitBtn" disabled>
                                                                <i class="fas fa-paper-plane me-2"></i>
                                                                Submit Request
                                                                <small class="d-block mt-1 opacity-75">Pay consultation fee
                                                                    to proceed</small>
                                                            </button>
                                                        </div>

                                                        <p class="small opacity-75 mt-3">
                                                            <i class="fas fa-lock me-1"></i>Secure payment process
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Empty State -->
                                        <div class="empty-state text-center py-5">
                                            <div class="empty-state-icon mb-4">
                                                <i class="fas fa-exclamation-circle fa-4x text-warning"></i>
                                            </div>
                                            <h4 class="fw-bold text-dark mb-3">No Issues Configured</h4>
                                            <p class="text-muted mb-4">This device doesn't have any predefined issues
                                                available for selection.</p>
                                            <div class="d-flex justify-content-center gap-3">
                                                <a href="{{ route('service-requests.select-device') }}"
                                                    class="btn btn-outline-primary">
                                                    <i class="fas fa-arrow-left me-2"></i>
                                                    Choose Another Device
                                                </a>
                                                <button class="btn btn-primary" disabled>
                                                    <i class="fas fa-plus me-2"></i>
                                                    Request Custom Issue
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Consultation Fee Agreement Modal -->
    <div class="modal fade" id="consultationFeeModal" tabindex="-1" aria-labelledby="consultationFeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-warning text-white border-0">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon me-3">
                            <i class="fas fa-file-contract fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="consultationFeeModalLabel">Consultation Fee Agreement</h5>
                            <small class="opacity-75">Required for device diagnosis</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 p-md-4">
                    <!-- Fee Overview -->
                    <div class="fee-overview mb-4">
                        <div class="d-flex align-items-center justify-content-between bg-light rounded-3 p-3 mb-3">
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Diagnostic Consultation</h6>
                                <small class="text-muted">One-time fee for professional assessment</small>
                            </div>
                            <span class="fee-amount badge bg-warning text-dark py-2 px-3">
                                K{{ number_format($consultationFee, 2) }}
                            </span>
                        </div>

                        <div class="alert alert-info border-0 shadow-sm">
                            <div class="d-flex">
                                <i class="fas fa-info-circle fa-2x me-3 text-info mt-1"></i>
                                <div>
                                    <strong class="d-block mb-1">Fee Application</strong>
                                    <p class="mb-0">This fee will be fully credited towards your final repair cost once
                                        you proceed with the service.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div class="benefits-section mb-4">
                        <h6 class="fw-bold text-dark mb-3">What's Included:</h6>
                        <div class="row g-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="benefit-item d-flex p-3 bg-light rounded-3 h-100">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-search text-primary fa-lg"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block">Comprehensive Diagnostics</strong>
                                        <small class="text-muted">Thorough device examination</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="benefit-item d-flex p-3 bg-light rounded-3 h-100">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-chart-line text-success fa-lg"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block">Accurate Cost Estimation</strong>
                                        <small class="text-muted">Transparent repair pricing</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="benefit-item d-flex p-3 bg-light rounded-3 h-100">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-user-check text-info fa-lg"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block">Expert Assessment</strong>
                                        <small class="text-muted">Professional technical evaluation</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="benefit-item d-flex p-3 bg-light rounded-3 h-100">
                                    <div class="benefit-icon me-3">
                                        <i class="fas fa-credit-card text-warning fa-lg"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block">Fee Credit</strong>
                                        <small class="text-muted">Applied to final repair cost</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Agreement -->
                    <div class="agreement-section bg-light rounded-3 p-3">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="modalAgreeCheckbox">
                            <label class="form-check-label fw-bold text-dark" for="modalAgreeCheckbox">
                                I understand and agree to pay the K{{ number_format($consultationFee, 2) }} consultation
                                fee for professional diagnosis.
                            </label>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                By agreeing, you authorize the consultation fee charge and understand it will be added to
                                your total estimate.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        Cancel
                    </button>
                    <button type="button" class="btn btn-success px-4" id="confirmAgreementBtn" disabled>
                        <i class="fas fa-check me-2"></i>
                        Agree & Continue
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --primary-color: #1e3a8a;
            --primary-hover: #2563eb;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --card-border: 1px solid #e5e7eb;
        }

        .text-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Progress Indicator */
        .progress-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .step-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #e5e7eb;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .step-item.active .step-circle {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }

        .step-item.completed .step-circle {
            background: #10b981;
            color: white;
        }

        .step-label {
            font-size: 0.8rem;
            color: #6b7280;
            text-align: center;
        }

        .step-item.active .step-label {
            color: var(--primary-color);
            font-weight: 600;
        }

        .step-connector {
            flex: 1;
            height: 2px;
            background: #e5e7eb;
            margin: 0 8px;
            margin-top: 18px;
        }

        /* Sticky Sidebar */
        .sticky-sidebar {
            position: sticky;
            top: 20px;
        }

        /* Device Preview */
        .device-preview {
            text-align: center;
        }

        /* Consultation Card */
        .consultation-card {
            border-left-color: #f59e0b !important;
        }

        /* Quick Stats */
        .quick-stats {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        }

        /* Category Card */
        .category-card {
            border-radius: 12px;
            overflow: hidden;
        }

        .category-card .card-header {
            border-bottom: 2px solid #f3f4f6;
        }

        .icon-wrapper {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Issue Card */
        .issue-card {
            border-radius: 8px;
            border: var(--card-border);
            transition: all 0.3s ease;
            background: white;
        }

        .issue-card:hover {
            border-color: var(--primary-color);
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-2px);
        }

        .issue-card .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .issue-card .form-check-input:checked~label h6 {
            color: var(--primary-color) !important;
        }

        .price-tag {
            white-space: nowrap;
        }

        .issue-meta {
            padding-top: 8px;
            border-top: 1px solid #f3f4f6;
            margin-top: 8px;
        }

        /* Summary Card - Now always visible */
        .summary-card {
            background: linear-gradient(135deg, #1f2937, #374151);
            border-radius: 12px;
            margin-bottom: 20px;
            /* Add space for mobile */
        }

        .summary-card .bg-dark {
            background-color: rgba(0, 0, 0, 0.3) !important;
            backdrop-filter: blur(10px);
        }

        /* Selection Header */
        .selection-header {
            background: linear-gradient(to right, #ffffff, #f8fafc);
        }

        /* Empty State */
        .empty-state {
            padding: 4rem 2rem;
            background: #f9fafb;
            border-radius: 12px;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 12px;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706) !important;
        }

        .benefit-item {
            transition: all 0.3s ease;
        }

        .benefit-item:hover {
            background: #ffffff !important;
            box-shadow: var(--card-shadow);
        }

        /* Form Switch */
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Mobile-Specific Styles */
        .mobile-category-accordion .accordion-button:not(.collapsed) {
            background-color: #f8fafc;
            box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .125);
        }

        .mobile-category-accordion .accordion-button:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.1);
        }

        .issue-item-mobile .card {
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }

        .issue-item-mobile .form-check-input:checked~.card {
            border-left-color: var(--primary-color);
            background-color: #f8fafc;
        }

        .issue-item-mobile .card:hover {
            border-color: var(--primary-color);
        }

        /* Ensure submit button is visible on mobile */
        #mobileSubmitBtn,
        #desktopSubmitBtn {
            position: relative;
            z-index: 10;
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

        .category-card {
            animation: fadeInUp 0.4s ease forwards;
            animation-delay: calc(var(--category-index) * 0.1s);
            opacity: 0;
        }

        @keyframes pricePulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .price-update {
            animation: pricePulse 0.5s ease-in-out;
        }

        /* Responsive Design - Mobile First */
        @media (max-width: 576px) {
            .container-fluid {
                padding-left: 12px;
                padding-right: 12px;
            }

            .card-body {
                padding: 1rem !important;
            }

            .step-circle {
                width: 32px;
                height: 32px;
                font-size: 0.875rem;
            }

            .step-connector {
                margin: 0 4px;
                margin-top: 16px;
            }

            .step-label {
                font-size: 0.7rem;
            }

            .summary-card .fs-4 {
                font-size: 1.5rem !important;
            }

            .summary-card .fs-5 {
                font-size: 1.25rem !important;
            }

            .modal-dialog {
                margin: 0.5rem;
            }
        }

        @media (max-width: 768px) {
            .progress-container {
                padding: 0 0.5rem;
            }

            .step-item {
                min-width: 70px;
            }

            .category-card .row>div {
                margin-bottom: 12px;
            }

            .sticky-sidebar {
                position: relative;
                top: 0;
                margin-bottom: 20px;
            }

            .device-preview img {
                max-height: 150px;
            }

            .summary-card {
                margin-bottom: 80px;
                /* Extra space for mobile */
            }

            /* Ensure mobile submit button is visible */
            #mobileSubmitBtn {
                width: 100%;
                padding: 12px;
                font-size: 1rem;
                margin-top: 1rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }
        }

        @media (min-width: 768px) and (max-width: 992px) {
            .step-item {
                min-width: 90px;
            }

            .sticky-sidebar {
                position: sticky;
                top: 20px;
            }
        }

        @media (min-width: 992px) {
            .sticky-sidebar {
                position: sticky;
                top: 20px;
            }

            .step-item {
                min-width: 100px;
            }

            .step-circle {
                width: 40px;
                height: 40px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all checkboxes
            const desktopCheckboxes = document.querySelectorAll('.issue-checkbox');
            const mobileCheckboxes = document.querySelectorAll('.mobile-issue-checkbox');
            const allCheckboxes = [...desktopCheckboxes, ...mobileCheckboxes];

            // Summary elements
            const selectedCount = document.getElementById('selectedCount');
            const totalCost = document.getElementById('totalCost');
            const consultationFeeDisplay = document.getElementById('consultationFeeDisplay');
            const grandTotal = document.getElementById('grandTotal');
            const mobileSelectedPreview = document.getElementById('mobileSelectedPreview');
            const desktopSelectedCount = document.getElementById('desktopSelectedCount');

            // Submit buttons
            const mobileSubmitBtn = document.getElementById('mobileSubmitBtn');
            const desktopSubmitBtn = document.getElementById('desktopSubmitBtn');

            // Select all buttons
            const mobileSelectAll = document.getElementById('mobileSelectAll');
            const desktopSelectAll = document.getElementById('desktopSelectAll');

            // Modal elements
            const agreeConsultationFeeInput = document.getElementById('agreeConsultationFee');
            const consultationFeeModal = new bootstrap.Modal(document.getElementById('consultationFeeModal'));
            const modalAgreeCheckbox = document.getElementById('modalAgreeCheckbox');
            const confirmAgreementBtn = document.getElementById('confirmAgreementBtn');

            // Consultation fee value
            const consultationFee = parseFloat(consultationFeeDisplay.textContent.replace(/,/g, '')) || 0;

            let isSubmitting = false;

            // Update summary function
            function updateSummary() {
                let selectedCountValue = 0;
                let repairCostValue = 0;

                allCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedCountValue++;
                        const price = parseFloat(checkbox.getAttribute('data-price')) || 0;
                        repairCostValue += price;
                    }
                });

                const totalWithFee = repairCostValue + consultationFee;

                // Update all summary displays
                selectedCount.textContent = selectedCountValue;
                desktopSelectedCount.textContent = selectedCountValue;
                mobileSelectedPreview.textContent = selectedCountValue;

                totalCost.textContent = repairCostValue.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                grandTotal.textContent = totalWithFee.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                // Update submit buttons state
                const isAnySelected = selectedCountValue > 0;
                if (mobileSubmitBtn) mobileSubmitBtn.disabled = !isAnySelected;
                if (desktopSubmitBtn) desktopSubmitBtn.disabled = !isAnySelected;

                // Sync select all checkboxes
                const allChecked = allCheckboxes.length > 0 && selectedCountValue === allCheckboxes.length;
                if (mobileSelectAll) mobileSelectAll.checked = allChecked;
                if (desktopSelectAll) desktopSelectAll.checked = allChecked;
            }

            // Sync checkboxes between mobile and desktop
            function syncCheckboxes(sourceCheckbox, targetSelector) {
                const targetCheckboxes = document.querySelectorAll(targetSelector);
                targetCheckboxes.forEach(targetCheckbox => {
                    if (targetCheckbox.value === sourceCheckbox.value) {
                        targetCheckbox.checked = sourceCheckbox.checked;
                    }
                });
            }

            // Checkbox change events
            allCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Sync with corresponding checkbox
                    const isMobile = this.classList.contains('mobile-issue-checkbox');
                    const targetSelector = isMobile ?
                        `.issue-checkbox[value="${this.value}"]` :
                        `.mobile-issue-checkbox[value="${this.value}"]`;
                    syncCheckboxes(this, targetSelector);
                    updateSummary();
                });
            });

            // Select all functionality
            function setupSelectAll(selectAllCheckbox, checkboxes) {
                if (selectAllCheckbox) {
                    selectAllCheckbox.addEventListener('change', function() {
                        const isChecked = this.checked;
                        checkboxes.forEach(checkbox => {
                            checkbox.checked = isChecked;
                        });

                        // Sync with other platform
                        if (this.id === 'mobileSelectAll' && desktopSelectAll) {
                            desktopSelectAll.checked = isChecked;
                        } else if (this.id === 'desktopSelectAll' && mobileSelectAll) {
                            mobileSelectAll.checked = isChecked;
                        }

                        // Sync all individual checkboxes
                        allCheckboxes.forEach(cb => {
                            cb.checked = isChecked;
                        });

                        updateSummary();
                    });
                }
            }

            setupSelectAll(mobileSelectAll, mobileCheckboxes);
            setupSelectAll(desktopSelectAll, desktopCheckboxes);

            // Show consultation modal
            function showConsultationModal() {
                if (isSubmitting) return;

                const selectedCountValue = parseInt(selectedCount.textContent) || 0;

                if (selectedCountValue === 0) {
                    // Show notification
                    const alert = document.createElement('div');
                    alert.className =
                        'alert alert-warning alert-dismissible fade show position-fixed top-0 end-0 m-3';
                    alert.style.zIndex = '9999';
                    alert.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>Please select at least one issue before submitting your request.</div>
                            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                    document.body.appendChild(alert);

                    // Auto remove after 5 seconds
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 5000);
                    return;
                }

                // Show consultation fee modal
                consultationFeeModal.show();
            }

            // Event listeners for submit buttons
            if (mobileSubmitBtn) {
                mobileSubmitBtn.addEventListener('click', showConsultationModal);
            }

            if (desktopSubmitBtn) {
                desktopSubmitBtn.addEventListener('click', showConsultationModal);
            }

            // Modal agreement checkbox
            modalAgreeCheckbox.addEventListener('change', function() {
                confirmAgreementBtn.disabled = !this.checked;
                confirmAgreementBtn.innerHTML = this.checked ?
                    '<i class="fas fa-check me-2"></i>Agree & Continue' :
                    '<i class="fas fa-check me-2"></i>Agree & Continue';
            });

            // Confirm agreement button
            confirmAgreementBtn.addEventListener('click', function() {
                if (isSubmitting) return;

                // Set submitting flag
                isSubmitting = true;
                if (mobileSubmitBtn) {
                    mobileSubmitBtn.disabled = true;
                    mobileSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                }
                if (desktopSubmitBtn) {
                    desktopSubmitBtn.disabled = true;
                    desktopSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                }

                // Set agreement flag
                agreeConsultationFeeInput.value = '1';

                // Hide modal
                consultationFeeModal.hide();

                // Submit the form
                setTimeout(() => {
                    document.getElementById('issuesForm').submit();
                }, 500);
            });

            // Modal hidden event - reset modal state
            document.getElementById('consultationFeeModal').addEventListener('hidden.bs.modal', function() {
                modalAgreeCheckbox.checked = false;
                confirmAgreementBtn.disabled = true;
                confirmAgreementBtn.innerHTML = '<i class="fas fa-check me-2"></i>Agree & Continue';
            });

            // Form validation - prevent direct form submission without modal
            document.getElementById('issuesForm').addEventListener('submit', function(e) {
                const hasAgreed = agreeConsultationFeeInput.value === '1';

                if (!hasAgreed) {
                    e.preventDefault();
                    consultationFeeModal.show();
                    return false;
                }

                // Prevent double submission
                if (isSubmitting) {
                    e.preventDefault();
                    return false;
                }

                isSubmitting = true;
            });

            // Set category animation delays
            const categoryCards = document.querySelectorAll('.category-card');
            categoryCards.forEach((card, index) => {
                card.style.setProperty('--category-index', index);
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                updateSummary();
            });

            // Initialize summary
            updateSummary();

            // Ensure mobile view is properly displayed on load
            setTimeout(() => {
                if (window.innerWidth < 992) {
                    // Force mobile layout adjustments
                    updateSummary();
                }
            }, 100);
        });
    </script>
@endpush
