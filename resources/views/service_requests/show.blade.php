{{-- resources/views/service_requests/show.blade.php --}}
@extends('layouts.admin')

@section('content')
    @php
        $statuses = [
            'submitted' => ['icon' => 'fas fa-paper-plane', 'color' => 'warning', 'label' => 'Submitted'],
            'Assigned' => ['icon' => 'fas fa-user-check', 'color' => 'info', 'label' => 'Assigned'],
            'diagnosing' => ['icon' => 'fas fa-search', 'color' => 'primary', 'label' => 'Diagnosing'],
            'repairing' => ['icon' => 'fas fa-tools', 'color' => 'primary', 'label' => 'Repairing'],
            'completed' => ['icon' => 'fas fa-check-circle', 'color' => 'success', 'label' => 'Completed'],
            'Unrepairable' => ['icon' => 'fas fa-times-circle', 'color' => 'danger', 'label' => 'Unrepairable'],
        ];

        // Calculate current status index
        $statusKeys = array_keys($statuses);
        $currentStatusIndex = array_search($serviceRequest->status, $statusKeys);
        $currentStatusIndex = $currentStatusIndex !== false ? $currentStatusIndex : 0;
        $progressPercentage = (($currentStatusIndex + 1) / count($statuses)) * 100;
    @endphp

    <div class="container-fluid py-4">
        {{-- <!-- Progress Indicator -->
        <div class="progress-container mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="step-item completed">
                    <div class="step-circle">1</div>
                    <span class="step-label fw-semibold">Select Device</span>
                </div>
                <div class="step-connector"></div>
                <div class="step-item completed">
                    <div class="step-circle">2</div>
                    <span class="step-label fw-semibold">Describe Issues</span>
                </div>
                <div class="step-connector"></div>
                <div class="step-item active">
                    <div class="step-circle">3</div>
                    <span class="step-label fw-semibold">Service Details</span>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg">
                    <!-- Header Section -->
                    <div class="card-header bg-white border-bottom py-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="display-6 fw-bold mb-2 text-gradient-primary">Service Request Details</h3>
                                <p class="text-muted mb-0">
                                    Request ID: <strong>#{{ $serviceRequest->id }}</strong> • Submitted on
                                    {{ $serviceRequest->created_at->format('F j, Y \a\t g:i A') }}
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div
                                    class="d-flex flex-column flex-md-row gap-2 justify-content-md-end align-items-md-center">
                                    <span class="badge status-badge bg-light text-dark fs-6 px-3 py-2 shadow-sm">
                                        <i
                                            class="fas fa-circle me-2 status-dot text-{{ $statuses[$serviceRequest->status]['color'] ?? 'warning' }}"></i>
                                        {{ ucfirst($serviceRequest->status) }}
                                    </span>
                                    <span class="badge bg-primary fs-6 px-3 py-2">
                                        <i class="fas fa-dollar-sign me-2"></i>
                                        K{{ number_format($serviceRequest->total_cost, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Left Column - Main Content -->
                            <div class="col-lg-8">
                                <!-- Status Timeline Card -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-white border-0 py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="fw-bold text-dark mb-0">
                                                <i class="fas fa-stream me-2 text-primary"></i>
                                                Service Journey
                                            </h5>
                                            <span class="badge bg-light text-dark">Step {{ $currentStatusIndex + 1 }} of
                                                {{ count($statuses) }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-3 p-md-4">
                                        <div class="timeline">
                                            <div class="timeline-track">
                                                <div class="timeline-progress" style="width: {{ $progressPercentage }}%">
                                                </div>
                                            </div>

                                            @foreach ($statuses as $statusKey => $statusInfo)
                                                @php
                                                    $itemIndex = array_search($statusKey, array_keys($statuses));
                                                    $isActive = $statusKey === $serviceRequest->status;
                                                    $isCompleted = $itemIndex < $currentStatusIndex;
                                                    $isCurrent = $isActive;
                                                @endphp

                                                <div
                                                    class="timeline-item {{ $isCurrent ? 'active' : ($isCompleted ? 'completed' : '') }}">
                                                    <div class="timeline-icon">
                                                        <div
                                                            class="icon-wrapper bg-{{ $statusInfo['color'] }} text-white rounded-circle">
                                                            <i class="{{ $statusInfo['icon'] }}"></i>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6 class="fw-semibold mb-1">{{ $statusInfo['label'] }}</h6>
                                                        @if ($isCurrent)
                                                            <small class="text-{{ $statusInfo['color'] }} fw-bold">
                                                                <i class="fas fa-circle me-1"></i>Current Status
                                                            </small>
                                                        @elseif($isCompleted)
                                                            <small class="text-success">
                                                                <i class="fas fa-check me-1"></i>Completed
                                                            </small>
                                                        @else
                                                            <small class="text-muted">Pending</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Issues & Costs Card -->
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white border-0 py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="fw-bold text-dark mb-0">
                                                <i class="fas fa-list-check me-2 text-primary"></i>
                                                Issues & Cost Breakdown
                                            </h5>
                                            <span class="badge bg-primary px-3 py-2">{{ $serviceRequest->issues->count() }}
                                                Issues</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="ps-4">Issue Description</th>
                                                        <th width="120" class="text-end pe-4">Repair Cost</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($serviceRequest->issues as $issue)
                                                        <tr class="issue-row">
                                                            <td class="ps-4">
                                                                <div class="d-flex">
                                                                    <div class="form-check me-3">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            checked disabled>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="fw-semibold text-dark mb-1">
                                                                            {{ $issue->issue }}</h6>
                                                                        @if ($issue->description)
                                                                            <p class="text-sm text-muted mb-2">
                                                                                {{ $issue->description }}</p>
                                                                        @endif
                                                                        <div class="issue-meta d-flex flex-wrap gap-3">
                                                                            @if ($issue->repair_time)
                                                                                <small class="text-dark">
                                                                                    <i class="fas fa-clock me-1"></i>
                                                                                    {{ $issue->repair_time }}
                                                                                </small>
                                                                            @endif
                                                                            @if ($issue->warranty)
                                                                                <small class="text-primary">
                                                                                    <i class="fas fa-shield-alt me-1"></i>
                                                                                    {{ $issue->warranty }}
                                                                                </small>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-end pe-4">
                                                                <span
                                                                    class="price-tag fw-bold text-success">K{{ number_format($issue->pivot->cost, 2) }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="bg-light">
                                                    <tr>
                                                        <td class="ps-4">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <h6 class="fw-bold text-dark mb-0">Total Repair Cost
                                                                    </h6>
                                                                    <small class="text-muted">Includes all selected
                                                                        issues</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-end pe-4">
                                                            <h4 class="fw-bold text-success mb-0">
                                                                K{{ number_format($serviceRequest->total_cost, 2) }}</h4>
                                                        </td>
                                                    </tr>
                                                    @if ($serviceRequest->consultation_fee)
                                                        <tr>
                                                            <td class="ps-4">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <h6 class="fw-bold text-dark mb-0">Consultation Fee
                                                                        </h6>
                                                                        <small class="text-muted">Already paid</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-end pe-4">
                                                                <h6 class="fw-bold text-warning mb-0">
                                                                    K{{ number_format($serviceRequest->consultation_fee, 2) }}
                                                                </h6>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Sidebar -->
                            <div class="col-lg-4">
                                <!-- Device Information Card -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-white border-0 py-3">
                                        <h5 class="fw-bold text-dark mb-0">
                                            <i class="fas fa-mobile-alt me-2 text-primary"></i>
                                            Device Information
                                        </h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="device-preview text-center mb-3">
                                            @if ($serviceRequest->device->image)
                                                <img src="{{ asset('storage/' . $serviceRequest->device->image) }}"
                                                    alt="{{ $serviceRequest->device->name }}"
                                                    class="img-fluid rounded-3 shadow-sm mb-3"
                                                    style="max-height: 180px; object-fit: cover; width: 100%;">
                                            @else
                                                <div class="bg-gradient-light rounded-3 d-flex align-items-center justify-content-center mb-3 shadow-sm"
                                                    style="height: 180px;">
                                                    <i class="fas fa-mobile-alt fa-4x text-muted"></i>
                                                </div>
                                            @endif

                                            <h5 class="fw-bold text-dark mb-2">{{ $serviceRequest->device->name }}</h5>
                                            <div class="d-flex justify-content-center gap-3 mb-3">
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-tag me-1"></i>{{ $serviceRequest->device->brand }}
                                                </span>
                                                <span class="badge bg-light text-dark">
                                                    <i
                                                        class="fas fa-microchip me-1"></i>{{ $serviceRequest->device->model ?? 'Standard' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Customer Information Card -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-white border-0 py-3">
                                        <h5 class="fw-bold text-dark mb-0">
                                            <i class="fas fa-user me-2 text-primary"></i>
                                            Customer Information
                                        </h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="customer-avatar me-3">
                                                <div class="bg-primary text-white rounded-circle p-3">
                                                    <i class="fas fa-user fa-lg"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">{{ $serviceRequest->customer->name }}
                                                </h6>
                                                <p class="text-muted small mb-2">{{ $serviceRequest->customer->email }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="customer-details">
                                            <div
                                                class="detail-item d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted small">Service Card ID</span>
                                                <span class="fw-semibold">#{{ $serviceRequest->id }}</span>
                                            </div>
                                            <div
                                                class="detail-item d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted small">Submitted Date</span>
                                                <span
                                                    class="fw-semibold">{{ $serviceRequest->created_at->format('M j, Y') }}</span>
                                            </div>
                                            <div class="detail-item d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Last Updated</span>
                                                <span
                                                    class="fw-semibold">{{ $serviceRequest->updated_at->format('M j, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions Card -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-white border-0 py-3">
                                        <h5 class="fw-bold text-dark mb-0">
                                            <i class="fas fa-bolt me-2 text-primary"></i>
                                            Quick Actions
                                        </h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('service-requests.select-device') }}"
                                                class="btn btn-primary">
                                                <i class="fas fa-plus-circle me-2"></i>
                                                Create New Request
                                            </a>
                                            <button class="btn btn-outline-primary" onclick="window.print()">
                                                <i class="fas fa-print me-2"></i>
                                                Print Details
                                            </button>
                                            {{-- <a href="mailto:{{ $serviceRequest->customer->email }}"
                                                class="btn btn-outline-secondary">
                                                <i class="fas fa-envelope me-2"></i>
                                                Contact Customer
                                            </a>
                                            @if ($serviceRequest->status === 'pending' || $serviceRequest->status === 'submitted')
                                                <button class="btn btn-outline-danger" data-bs-toggle="modal"
                                                    data-bs-target="#cancelModal">
                                                    <i class="fas fa-times-circle me-2"></i>
                                                    Cancel Request
                                                </button>
                                            @endif --}}
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Stats Card -->
                                <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                                    <div class="card-body p-4 text-center">
                                        <h5 class="text-white mb-3">
                                            <i class="fas fa-chart-pie me-2"></i>
                                            Service Summary
                                        </h5>
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="bg-white-10 rounded-3 p-3">
                                                    <div class="fw-bold fs-3">{{ $serviceRequest->issues->count() }}</div>
                                                    <small class="opacity-75">Issues</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-white-10 rounded-3 p-3">
                                                    <div class="fw-bold fs-3">
                                                        K{{ number_format($serviceRequest->total_cost, 2) }}</div>
                                                    <small class="opacity-75">Total Cost</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <small class="opacity-75">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Estimated completion time: 3-5 business days
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Request Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title" id="cancelModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Cancel Service Request
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-times fa-2x"></i>
                        </div>
                        <h4 class="text-dark">Cancel Request #{{ $serviceRequest->id }}?</h4>
                        <p class="text-muted">Are you sure you want to cancel this service request? This action cannot be
                            undone.</p>
                    </div>

                    <div class="alert alert-warning">
                        <div class="d-flex">
                            <i class="fas fa-exclamation-circle fa-2x me-3 text-warning mt-1"></i>
                            <div>
                                <strong>Important Note:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Consultation fee may not be refundable</li>
                                    <li>Service progress will be lost</li>
                                    <li>Customer will be notified</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        Keep Request
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmCancelBtn">
                        <i class="fas fa-trash me-2"></i>
                        Cancel Request
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
            width: 40px;
            height: 40px;
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
            font-size: 0.875rem;
            color: #6b7280;
        }

        .step-item.active .step-label {
            color: var(--primary-color);
            font-weight: 600;
        }

        .step-item.completed .step-label {
            color: #10b981;
            font-weight: 600;
        }

        .step-connector {
            flex: 1;
            height: 2px;
            background: #e5e7eb;
            margin: 0 10px;
            margin-top: 20px;
        }

        /* Status Badge */
        .status-badge {
            border-left: 3px solid;
        }

        .status-dot {
            font-size: 0.6rem;
            vertical-align: middle;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 40px;
        }

        .timeline-track {
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
        }

        .timeline-progress {
            height: 100%;
            background: var(--primary-color);
            transition: width 0.5s ease;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 24px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-icon {
            position: absolute;
            left: -40px;
            top: 0;
        }

        .icon-wrapper {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .timeline-item.active .icon-wrapper {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }

        .timeline-item.completed .icon-wrapper {
            background: #10b981 !important;
        }

        .timeline-content {
            padding-bottom: 4px;
        }

        /* Table Styles */
        .issue-row {
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }

        .issue-row:hover {
            background-color: #f8fafc;
        }

        .issue-row:last-child {
            border-bottom: none;
        }

        .issue-meta {
            font-size: 0.75rem;
        }

        .price-tag {
            font-size: 1rem;
        }

        /* Customer Avatar */
        .customer-avatar .rounded-circle {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Quick Stats */
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)) !important;
        }

        .bg-white-10 {
            background-color: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
        }

        /* Card Hover Effects */
        .card {
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover), var(--primary-color));
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .progress-container {
                padding: 0 1rem;
            }

            .step-item {
                min-width: 80px;
            }

            .step-connector {
                margin: 0 5px;
                margin-top: 20px;
            }

            .timeline {
                padding-left: 30px;
            }

            .timeline-track {
                left: 15px;
            }

            .timeline-icon {
                left: -30px;
            }

            .icon-wrapper {
                width: 30px;
                height: 30px;
                font-size: 0.875rem;
            }

            .card-body {
                padding: 1rem !important;
            }

            .customer-avatar .rounded-circle {
                width: 40px;
                height: 40px;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 576px) {
            .step-circle {
                width: 32px;
                height: 32px;
                font-size: 0.875rem;
            }

            .step-label {
                font-size: 0.75rem;
            }

            .timeline-content h6 {
                font-size: 0.875rem;
            }

            .issue-meta {
                flex-direction: column;
                gap: 8px !important;
            }

            .btn {
                padding: 8px 16px;
                font-size: 0.875rem;
            }
        }

        /* Print Styles */
        @media print {
            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }

            .btn,
            .modal,
            .progress-container {
                display: none !important;
            }

            .text-gradient-primary {
                background: none !important;
                -webkit-text-fill-color: #1e3a8a !important;
                color: #1e3a8a !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cancel Request Modal Handler
            const confirmCancelBtn = document.getElementById('confirmCancelBtn');
            if (confirmCancelBtn) {
                confirmCancelBtn.addEventListener('click', function() {
                    // Show loading state
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Cancelling...';
                    this.disabled = true;

                    // In a real application, you would make an AJAX request here
                    // For now, we'll simulate a delay and show a message
                    setTimeout(() => {
                        alert('Request cancelled successfully!');
                        window.location.href = "{{ route('service-requests.select-device') }}";
                    }, 1500);
                });
            }

            // Print button functionality
            const printButtons = document.querySelectorAll('[onclick*="window.print"]');
            printButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Add print-specific class to body
                    document.body.classList.add('printing');

                    // After print, remove the class
                    window.onafterprint = function() {
                        document.body.classList.remove('printing');
                    };
                });
            });

            // Status update simulation (for demo purposes)
            const statusBadge = document.querySelector('.status-badge');
            const statusDot = document.querySelector('.status-dot');

            if (statusBadge && statusDot) {
                // Animate status dot
                setInterval(() => {
                    if (statusDot.classList.contains('text-warning')) {
                        statusDot.style.animation = 'pulse 1.5s infinite';
                    }
                }, 1000);
            }

            // Add animation for timeline progress
            const timelineProgress = document.querySelector('.timeline-progress');
            if (timelineProgress) {
                // Trigger reflow to enable transition
                timelineProgress.style.width = '0%';
                setTimeout(() => {
                    timelineProgress.style.width = timelineProgress.getAttribute('style').split('width: ')[
                        1] || '0%';
                }, 10);
            }
        });

        // CSS Animation for status dot
        const style = document.createElement('style');
        style.textContent = `
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
`;
        document.head.appendChild(style);
    </script>
@endpush
