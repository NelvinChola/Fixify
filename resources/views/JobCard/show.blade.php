@extends('layouts.admin')

@section('content')
    @php
        // Role detection - moved to top for global access
        $userRole = auth()->user()->role;

        // If role is an object, get the name property
        if (is_object($userRole)) {
            $roleName = strtolower($userRole->name ?? 'admin');
        } else {
            $roleName = strtolower($userRole);
        }

        $isHelpdesk = $roleName === 'helpdesk';
        $isTechnician = $roleName === 'technician';
        $displayRoleName = ucfirst($roleName);

        // Define statuses where helpdesk should not see update status section
        $helpdeskHiddenStatuses = ['assigned', 'diagnosis', 'repairing', 'completed', 'unsuccessful'];
        $shouldHideUpdateStatus = $isHelpdesk && in_array($request->status, $helpdeskHiddenStatuses);

        // Define statuses where assign technician section should be shown
        $assignTechnicianStatuses = ['assessed', 'sent_back'];
        $shouldShowAssignTechnician = !$isTechnician && in_array($request->status, $assignTechnicianStatuses);
    @endphp

    <div class="container my-5">

        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('JobCard.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Job Cards
            </a>
        </div>

        {{-- Job Card Details --}}
        <div class="card p-4 mb-4 border-0 text-white position-relative overflow-hidden"
            style="background: linear-gradient(135deg, #03045e 0%, #023e8a 50%, #0077b6 100%); 
            box-shadow: 0 8px 32px rgba(2, 62, 138, 0.3); 
            border-radius: 16px;">

            {{-- Background Pattern --}}
            <div class="position-absolute top-0 end-0 w-50 h-100 opacity-10">
                <div class="w-100 h-100"
                    style="background: radial-gradient(circle, rgba(255,255,255,0.3) 1px, transparent 1px);
                background-size: 20px 20px;">
                </div>
            </div>

            <div class="row align-items-center position-relative">

                {{-- Device Image --}}
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <div class="position-relative">
                        @if ($request->device->image ?? false)
                            <div class="bg-white rounded-3 p-2 shadow-lg"
                                style="border: 3px solid rgba(255,255,255,0.3); 
                                display: inline-block;">
                                <img src="{{ asset('storage/' . $request->device->image) }}"
                                    alt="{{ $request->device->name ?? 'Device Image' }}" class="img-fluid rounded-2"
                                    style="max-height: 90px; max-width: 130px; object-fit: contain;">
                            </div>
                        @else
                            <div class="bg-white rounded-3 p-3 shadow-lg d-flex align-items-center justify-content-center mx-auto"
                                style="height: 100px; width: 140px; border: 3px solid rgba(255,255,255,0.3);">
                                <i class="fas fa-laptop fa-2x text-primary"></i>
                            </div>
                        @endif

                        {{-- Job Card Badge --}}
                        <div class="position-absolute top-0 start-100 translate-middle mt-1">
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 shadow-sm">
                                <i class="fas fa-hashtag me-1"></i>#{{ $request->id }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Device Information --}}
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="ps-0 ps-md-3">
                        <h4 class="fw-bold mb-3 text-white">
                            <i class="fas fa-laptop me-2 text-warning"></i>{{ $request->device->name ?? 'N/A' }}
                        </h4>

                        <div class="bg-dark bg-opacity-25 rounded-3 p-3 border border-light border-opacity-10">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-tag text-info me-2" style="width: 20px;"></i>
                                        <span class="text-light"><strong class="text-warning">Brand:</strong>
                                            {{ $request->device->brand ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                @if ($request->device->model ?? false)
                                    <div class="col-12">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-microchip text-info me-2" style="width: 20px;"></i>
                                            <span class="text-light"><strong class="text-warning">Model:</strong>
                                                {{ $request->device->model }}</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($request->device->serial_number ?? false)
                                    <div class="col-12">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-barcode text-info me-2" style="width: 20px;"></i>
                                            <span class="text-light"><strong class="text-warning">Serial:</strong>
                                                {{ $request->device->serial_number }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Customer Information --}}
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="bg-dark bg-opacity-25 rounded-3 p-3 border border-light border-opacity-10 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-user text-warning" style="width: 20px;"></i>
                            </div>
                            <div>
                                <div class="text-light opacity-75 small">Customer</div>
                                <div class="text-white fw-bold h5 mb-0">{{ $request->customer->name ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-20 rounded-circle p-2 me-3">
                                <i class="fas fa-calendar text-warning" style="width: 20px;"></i>
                            </div>
                            <div>
                                <div class="text-light opacity-75 small">Created</div>
                                <div class="text-white fw-bold small">
                                    {{ $request->created_at->format('M j, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status Information --}}
                <div class="col-md-3">
                    <div class="text-center text-md-end">
                        {{-- Status Badge --}}
                        <div class="mb-3">
                            <div class="text-light opacity-75 small mb-1">Current Status</div>
                            <span
                                class="badge fs-6 px-3 py-2 rounded-pill shadow-sm
                        @if ($request->status == 'completed') bg-success
                        @elseif($request->status == 'unsuccessful') bg-danger
                        @elseif($request->status == 'sent_back') bg-warning text-dark
                        @elseif($request->status == 'assessed' && !$request->technician_id) bg-warning text-dark
                        @else bg-primary @endif">
                                <i
                                    class="fas 
                            @if ($request->status == 'completed') fa-check-circle
                            @elseif($request->status == 'unsuccessful') fa-times-circle
                            @elseif($request->status == 'sent_back') fa-undo
                            @elseif($request->status == 'assessed') fa-clipboard-check
                            @else fa-paper-plane @endif me-2">
                                </i>
                                {{ ucfirst($request->status) }}
                                @if ($request->status == 'assessed' && !$request->technician_id)
                                    <small class="ms-1">(Awaiting)</small>
                                @endif
                            </span>
                        </div>

                        {{-- Technician Info --}}
                        @if (auth()->user()->role->name != 'Technician')
                            <div>
                                <div class="text-light opacity-75 small mb-1">Assigned Technician</div>
                                <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                                    <div class="bg-info bg-opacity-20 rounded-circle p-2 me-2">
                                        <i class="fas fa-user-cog text-warning"></i>
                                    </div>
                                    <span class="text-white fw-bold small">
                                        {{ $request->technician->name ?? 'Not Assigned' }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- Notes Buttons Section --}}
        <div class="d-flex gap-2 mb-3">

            {{-- Unsuccessful Notes Button --}}
            @if ($request->status == 'unsuccessful' && $request->unsuccessful_notes && $userRole !== 'customer')
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#unsuccessfulNotesModal">
                    <i class="fas fa-times-circle me-2"></i>View Unsuccessful Notes
                </button>
            @endif

            {{-- Assessment Notes Button --}}
            @if (!empty($request->assessment_notes) && $userRole !== 'customer')
                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                    data-bs-target="#assessmentNotesModal">
                    <i class="fas fa-sticky-note me-2"></i>View Assessment Notes
                </button>
            @endif

            {{-- Sent Back Notes Button --}}
            @if (!empty($request->sent_back_notes) && $userRole !== 'customer')
                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                    data-bs-target="#sentBackNotesModal">
                    <i class="fas fa-undo-alt me-2"></i>View Sent Back Notes
                </button>
            @endif

        </div>



        {{-- Selected Device Issues - Border Style --}}
        @if (!$isHelpdesk && $request->issues->count() > 0)
            <div class="card p-4 mb-4 shadow-sm border-0 border-start border-4 border-primary">
                <h6 class="fw-bold mb-3 text-uppercase small text-primary">
                    <i class="fas fa-bug me-2"></i>Reported Issues
                    <span class="badge bg-primary ms-2">{{ $request->issues->count() }}</span>
                </h6>

                <div class="d-flex flex-column gap-2">
                    @foreach ($request->issues as $issue)
                        <div class="d-flex align-items-center py-2 px-3 bg-light rounded">
                            <i class="fas fa-chevron-right text-primary me-3" style="font-size: 0.7rem;"></i>
                            <span class="text-dark">{{ $issue->issue }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif



        {{-- Payment Management Section --}}
        @if ($request->status == 'completed' && $request->final_cost && !$isTechnician)
            <div
                class="card p-4 mb-4 shadow-sm border-0 
    @if ($request->payment_status === 'paid') border-success
    @elseif($request->payment_status === 'partial') border-warning
    @else border-danger @endif">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5
                        class="fw-semibold mb-0 
            @if ($request->payment_status === 'paid') text-success
            @elseif($request->payment_status === 'partial') text-warning
            @else text-danger @endif">
                        <i
                            class="fas 
                @if ($request->payment_status === 'paid') fa-check-circle
                @elseif($request->payment_status === 'partial') fa-money-check
                @else fa-money-bill-wave @endif me-2">
                        </i>
                        Payment Status
                    </h5>

                    @if ($request->payment_status !== 'paid')
                        <button type="button"
                            class="btn 
            @if ($request->payment_status === 'partial') btn-warning
            @else btn-success @endif btn-sm"
                            data-bs-toggle="modal" data-bs-target="#paymentManagementModal">
                            <i class="fas fa-edit me-1"></i>Manage Payment
                        </button>
                    @else
                        <span class="badge bg-success">
                            <i class="fas fa-check me-1"></i>Payment Completed
                        </span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Payment Summary</h6>

                                <div class="mb-3">
                                    <label class="form-label text-muted small">Final Repair Cost</label>
                                    <div
                                        class="form-control bg-white border-0 fw-bold fs-5 
                            @if ($request->payment_status !== 'paid') text-danger @else text-success @endif">
                                        K{{ number_format($request->final_cost, 2) }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted small">Amount Paid</label>
                                    <div class="form-control bg-white border-0 fw-bold fs-5 text-success">
                                        K{{ number_format($request->amount_paid ?? 0, 2) }}
                                    </div>
                                </div>

                                @if ($request->payment_status === 'partial')
                                    <div class="mb-3">
                                        <label class="form-label text-muted small">Balance Due</label>
                                        <div class="form-control bg-white border-0 fw-bold fs-5 text-danger">
                                            K{{ number_format($request->final_cost - $request->amount_paid, 2) }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div
                            class="card border-0 
                @if ($request->payment_status === 'paid') bg-success bg-opacity-10
                @elseif($request->payment_status === 'partial') bg-warning bg-opacity-10
                @else bg-danger bg-opacity-10 @endif h-100">
                            <div class="card-body">
                                <h6
                                    class="fw-bold mb-3 
                        @if ($request->payment_status === 'paid') text-success
                        @elseif($request->payment_status === 'partial') text-warning
                        @else text-danger @endif">
                                    <i
                                        class="fas 
                            @if ($request->payment_status === 'paid') fa-check-circle
                            @elseif($request->payment_status === 'partial') fa-exclamation-triangle
                            @else fa-clock @endif me-2">
                                    </i>
                                    Status: {{ strtoupper($request->payment_status) }}
                                </h6>

                                @if ($request->payment_status === 'paid')
                                    <div class="alert alert-success border-0 mb-0">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle fa-2x me-3"></i>
                                            <div>
                                                <strong>Payment Completed</strong>
                                                <p class="mb-0 small">Full payment received. Customer can collect the
                                                    device.</p>
                                                @if ($request->paid_at)
                                                    <small class="text-muted">
                                                        Paid on: {{ $request->paid_at->format('M j, Y g:i A') }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @elseif($request->payment_status === 'partial')
                                    <div class="alert alert-warning border-0 mb-0">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                            <div>
                                                <strong>Partial Payment Received</strong>
                                                <p class="mb-0 small">Balance of
                                                    K{{ number_format($request->final_cost - $request->amount_paid, 2) }}
                                                    still due.</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-danger border-0 mb-0">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock fa-2x me-3"></i>
                                            <div>
                                                <strong>Awaiting Payment</strong>
                                                <p class="mb-0 small">Customer needs to pay
                                                    K{{ number_format($request->final_cost, 2) }} to collect device.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Sent Back Actions - Only show to Helpdesk and Admin --}}
        @if (!$isTechnician && $request->status == 'sent_back')
            <div class="card p-4 mb-4 shadow-sm border-0 bg-warning bg-opacity-10">
                <h5 class="fw-semibold mb-3 text-warning">
                    <i class="fas fa-undo me-2"></i>Sent Back Job Card - Action Required
                </h5>
                <p class="text-muted mb-3">
                    This job card was sent back by the technician. You can either assign it to another technician or archive
                    it if no further action is needed.
                </p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-user-check fa-2x text-primary mb-3"></i>
                                <h6 class="fw-bold text-primary mb-2">Assign to Another Technician</h6>
                                <p class="text-muted small mb-3">
                                    Reassign this job card to a different technician for further diagnosis and repair.
                                </p>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#reassignTechnicianModal">
                                    <i class="fas fa-user-check me-2"></i>Reassign Technician
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-archive fa-2x text-secondary mb-3"></i>
                                <h6 class="fw-bold text-secondary mb-2">Archive Job Card</h6>
                                <p class="text-muted small mb-3">
                                    Archive this job card if no further repair attempts are needed or possible.
                                </p>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#archiveJobCardModal">
                                    <i class="fas fa-archive me-2"></i>Archive Job Card
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Update Status Section - Hide for helpdesk in technician stages --}}
        @if (!$shouldHideUpdateStatus)
            <div class="card p-4 mb-4 shadow-sm border-0">
                <h5 class="fw-semibold mb-3">
                    Update Status
                    @if (
                        $isHelpdesk &&
                            in_array($request->status, ['assigned', 'diagnosis', 'repairing', 'completed', 'unsuccessful', 'sent_back']))
                        <span class="badge bg-secondary ms-2">Technician's Responsibility</span>
                    @elseif($isTechnician && in_array($request->status, ['submitted', 'assessed']))
                        <span class="badge bg-secondary ms-2">Helpdesk's Responsibility</span>
                    @endif
                </h5>

                @php
                    $isDisabled = false;
                    $disabledReason = '';

                    if ($request->status == 'completed' || $request->status == 'unsuccessful') {
                        $isDisabled = true;
                        $disabledReason = 'Job card already finalized';
                    } elseif ($request->status == 'assessed' && !$request->technician_id) {
                        $isDisabled = true;
                        $disabledReason = 'Assign technician first to continue';
                    } elseif (
                        $isHelpdesk &&
                        in_array($request->status, [
                            'assigned',
                            'diagnosis',
                            'repairing',
                            'completed',
                            'unsuccessful',
                            'sent_back',
                        ])
                    ) {
                        $isDisabled = true;
                        $disabledReason = 'Technician\'s responsibility from this point';
                    } elseif ($isTechnician && in_array($request->status, ['submitted', 'assessed'])) {
                        $isDisabled = true;
                        $disabledReason = 'Helpdesk\'s responsibility for initial statuses';
                    }

                    $statusFlow = ['submitted', 'assessed', 'assigned', 'diagnosis', 'repairing'];
                    $finalStatuses = ['completed', 'unsuccessful'];
                    $currentStatus = $request->status;

                    // Determine available next statuses based on role and current status
                    $nextStatuses = [];

                    if (!$isDisabled) {
                        // Enforce sequential workflow - only allow immediate next status
                        if (in_array($currentStatus, $statusFlow)) {
                            $currentIndex = array_search($currentStatus, $statusFlow);

                            // Only allow the immediate next status in the sequence
                            if ($currentIndex !== false && isset($statusFlow[$currentIndex + 1])) {
                                $nextStatuses = [$statusFlow[$currentIndex + 1]];
                            }

                            // Special case: from repairing, allow final outcomes
                            if ($currentStatus == 'repairing') {
                                $nextStatuses = $finalStatuses;
                            }
                        }

                        // Handle sent_back status - can go back to assessed
                        if ($currentStatus == 'sent_back') {
                            $nextStatuses = ['assessed'];
                        }

                        // Special handling for assessed status
                        if ($currentStatus == 'assessed' && $request->technician_id) {
                            $nextStatuses = ['assigned'];
                        } elseif ($currentStatus == 'assessed' && !$request->technician_id) {
                            $nextStatuses = [];
                        }

                        // Filter statuses based on role permissions
                        if ($isHelpdesk) {
                            $nextStatuses = array_filter($nextStatuses, function ($status) {
                                return in_array($status, ['assessed', 'assigned']);
                            });
                        } elseif ($isTechnician) {
                            $nextStatuses = array_filter($nextStatuses, function ($status) {
                                return in_array($status, ['diagnosis', 'repairing', 'completed', 'unsuccessful']);
                            });
                        }
                    }
                @endphp

                {{-- Current Status Display --}}
                <div class="alert alert-info border-0 mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-3 text-info"></i>
                        <div>
                            <strong>Current Status:</strong>
                            <span
                                class="badge 
                        @if ($request->status == 'completed') bg-success
                        @elseif($request->status == 'unsuccessful') bg-danger
                        @elseif($request->status == 'sent_back') bg-warning text-dark
                        @elseif($request->status == 'assessed' && !$request->technician_id) bg-warning text-dark
                        @else bg-primary @endif ms-2">
                                {{ ucfirst($request->status) }}
                                @if ($request->status == 'assessed' && !$request->technician_id)
                                    <small class="ms-1">(Awaiting Assignment)</small>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Status Buttons --}}
                @if ($isDisabled)
                    <div
                        class="alert 
                @if ($request->status == 'completed' || $request->status == 'unsuccessful') alert-success
                @elseif($request->status == 'assessed' && !$request->technician_id) alert-warning
                @else alert-info @endif mb-0">
                        <div class="d-flex align-items-center">
                            <i
                                class="fas 
                        @if ($request->status == 'completed' || $request->status == 'unsuccessful') fa-check-circle
                        @elseif($request->status == 'assessed' && !$request->technician_id) fa-exclamation-triangle
                        @else fa-info-circle @endif me-2">
                            </i>
                            <span>{{ $disabledReason }}</span>
                        </div>
                    </div>
                @elseif(!empty($nextStatuses))
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($nextStatuses as $status)
                            @php
                                $requiresNotes =
                                    ($isHelpdesk && $status == 'assessed') ||
                                    ($isTechnician && $status == 'unsuccessful');
                                $modalId =
                                    $isHelpdesk && $status == 'assessed'
                                        ? 'assessmentModal'
                                        : ($isTechnician && $status == 'unsuccessful'
                                            ? 'unsuccessfulModal'
                                            : '');

                                // Button styling based on status
                                $buttonClass = 'btn-primary';
                                $buttonIcon = 'fa-arrow-right';
                                $buttonText = 'Update to ' . ucfirst($status);

                                if (in_array($status, $finalStatuses)) {
                                    $buttonClass = $status == 'completed' ? 'btn-success' : 'btn-danger';
                                    $buttonIcon = $status == 'completed' ? 'fa-check-circle' : 'fa-times-circle';
                                    $buttonText = $status == 'completed' ? 'Mark as Completed' : 'Mark as Unsuccessful';
                                } elseif ($status == 'sent_back') {
                                    $buttonClass = 'btn-warning';
                                    $buttonIcon = 'fa-undo';
                                    $buttonText = 'Send Back';
                                }
                            @endphp

                            @if ($requiresNotes)
                                <button type="button" class="btn {{ $buttonClass }} btn-sm status-btn"
                                    data-requires-notes="true" data-modal-id="{{ $modalId }}"
                                    data-status="{{ $status }}">
                                    <i class="fas {{ $buttonIcon }} me-1"></i>
                                    {{ $buttonText }}
                                </button>
                            @else
                                <form action="{{ route('JobCard.update-status', $request->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $status }}">
                                    <button type="submit" class="btn {{ $buttonClass }} btn-sm status-btn">
                                        <i class="fas {{ $buttonIcon }} me-1"></i>
                                        {{ $buttonText }}
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    </div>

                    {{-- Help Text --}}
                    {{-- <div class="mt-3">
                <small class="text-muted">
                    @if ($isHelpdesk)
                        You can update up to <strong>Assigned</strong> status
                    @elseif($isTechnician)
                        You can update from <strong>Assigned</strong> to final outcome
                    @else
                        Full administrative access to all status updates
                    @endif
                </small>
            </div> --}}
                @else
                    {{-- <div class="alert alert-warning mb-0">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div>
                        <strong>No available status updates</strong>
                        <p class="mb-0 small">Follow the sequential workflow: Submitted → Assessed → Assigned → Diagnosis → Repairing → Final Outcome</p>
                    </div>
                </div>
            </div> --}}
                @endif
            </div>
        @endif


        {{-- Display Additional Fees if they exist --}}
        @if ($request->additional_fees > 0)
            <div class="card p-4 mb-4 shadow-sm border-0 border-success">
                <h5 class="fw-semibold mb-3 text-success">
                    <i class="fas fa-receipt me-2"></i>Additional Fees Applied
                </h5>
                <div class="alert alert-success">
                    <div class="d-flex">
                        <i class="fas fa-money-bill-wave fa-2x me-3 mt-1"></i>
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="alert-heading mb-2">Additional Repair Costs</h6>
                                    <p class="mb-1"><strong>Additional Amount:</strong>
                                        K{{ number_format($request->additional_fees, 2) }}</p>
                                    <p class="mb-1"><strong>Initial Cost:</strong>
                                        K{{ number_format($request->total_cost, 2) }}</p>
                                    <p class="mb-0"><strong>Final Cost:</strong>
                                        K{{ number_format($request->final_cost ?? $request->total_cost + $request->additional_fees, 2) }}
                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success">Updated</span>
                                </div>
                            </div>

                            @if ($request->additional_fees_notes)
                                <div class="mt-3 p-3 bg-white rounded">
                                    <strong class="text-dark">Explanation:</strong>
                                    <p class="mb-0 mt-1">{{ $request->additional_fees_notes }}</p>
                                </div>
                            @endif

                            @if ($request->additional_fees_added_at)
                                <small class="text-muted mt-2 d-block">
                                    Fees added on: {{ $request->additional_fees_added_at->format('M j, Y g:i A') }}
                                    by {{ $request->additionalFeesAddedBy->name ?? 'Technician' }}
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif



        {{-- Send Back Section (Technician Only) --}}
        @if ($isTechnician && $request->status == 'diagnosis')
            <div class="card p-4 mb-4 shadow-sm border-0 bg-warning bg-opacity-10">
                <h5 class="fw-semibold mb-3 text-warning">
                    <i class="fas fa-undo me-2"></i>Send Back to Helpdesk
                </h5>
                <p class="text-muted mb-3">
                    If you cannot proceed with repairing this product, you can send it back to the helpdesk with additional
                    notes.
                </p>
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                    data-bs-target="#sentBackModal">
                    <i class="fas fa-undo me-2"></i>Send Back to Helpdesk
                </button>
            </div>
        @endif

        {{-- Assign Technician Section - Only show when status is assessed or sent back --}}
        @if ($shouldShowAssignTechnician)
            <div class="card p-4 mb-4 shadow-sm border-0">
                <h5 class="fw-semibold mb-3">
                    Assign Technician
                </h5>
                <form action="{{ route('JobCard.assign-technician', $request->id) }}" method="POST">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <label class="form-label">Technician</label>
                            <select name="technician_id" class="form-select"
                                @if ($request->technician_id) disabled @endif required>
                                <option value="">-- Select Technician --</option>
                                @foreach ($technicians as $tech)
                                    <option value="{{ $tech->id }}" @selected($request->technician_id == $tech->id)>
                                        {{ $tech->name }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($request->technician_id)
                                <small class="text-muted">
                                    Technician already assigned. Status can now be updated to "Assigned".
                                </small>
                            @else
                                <small class="text-muted">
                                    Assign a technician to enable status progression to "Assigned".
                                </small>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <button type="submit"
                                class="btn 
                        @if ($request->technician_id) btn-success
                        @else btn-primary @endif w-100 mt-3 mt-md-0"
                                @if ($request->technician_id) disabled @endif>
                                <i class="fas fa-user-check me-2"></i>
                                @if ($request->technician_id)
                                    Assigned
                                @else
                                    Assign
                                @endif
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        {{-- Status Progress Section - Hidden for Technicians --}}
        @if (!$isTechnician)
            <div class="card p-4 shadow-sm border-0">
                <h5 class="fw-semibold mb-3">Repair Progress</h5>
                <div class="status-progress">
                    @php
                        $statusFlow = ['submitted', 'assessed', 'assigned', 'diagnosis', 'repairing'];
                        $finalStatuses = ['completed', 'unsuccessful'];
                        $currentStatus = $request->status;
                        $isFinalized = in_array($currentStatus, $finalStatuses);
                        $isSentBack = $currentStatus == 'sent_back';
                        $isBlocked = ($currentStatus == 'assessed' && !$request->technician_id) || $isSentBack;

                        // Calculate progress width
                        $progressWidth = 0;
                        if ($isFinalized) {
                            $progressWidth = 100;
                        } elseif ($isSentBack) {
                            $progressWidth = 60;
                        } else {
                            $currentIndex = array_search($currentStatus, $statusFlow);
                            if ($currentIndex !== false) {
                                $progressWidth = (($currentIndex + 1) / count($statusFlow)) * 100;
                            }
                        }
                    @endphp

                    <!-- Role Responsibility Indicators -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="text-center p-3 border rounded bg-light">
                                <i class="fas fa-headset fa-2x text-info mb-2"></i>
                                <h6 class="mb-1">Helpdesk Responsibility</h6>
                                <small class="text-muted">Submitted → Assessed → Assigned</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center p-3 border rounded bg-light">
                                <i class="fas fa-tools fa-2x text-warning mb-2"></i>
                                <h6 class="mb-1">Technician Responsibility</h6>
                                <small class="text-muted">Assigned → Diagnosis → Repairing → Final Outcome<br>
                                    <span class="text-warning">Can send back during diagnosis</span>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Main Repair Steps -->
                    <div class="d-flex justify-content-between align-items-center position-relative mb-4">
                        <!-- Progress Line -->
                        <div class="position-absolute top-50 start-0 end-0"
                            style="height: 3px; background: #e9ecef; z-index: 1;"></div>
                        <div class="position-absolute top-50 start-0"
                            style="height: 3px; background: 
                        @if ($isBlocked) #ffc107
                        @elseif($isFinalized) #28a745
                        @else #28a745 @endif; 
                     z-index: 2; 
                     width: {{ $progressWidth }}%;">
                        </div>

                        @foreach ($statusFlow as $index => $status)
                            @php
                                $isCompleted = false;
                                $isBlockedStep = false;

                                if (
                                    $isFinalized ||
                                    $index <= array_search($currentStatus, $statusFlow) ||
                                    ($isSentBack && $index <= 2)
                                ) {
                                    if (
                                        ($status == 'assessed' &&
                                            $index == array_search($currentStatus, $statusFlow) &&
                                            !$request->technician_id) ||
                                        $isSentBack
                                    ) {
                                        $isBlockedStep = true;
                                    } else {
                                        $isCompleted = true;
                                    }
                                }
                            @endphp
                            <div class="d-flex flex-column align-items-center position-relative" style="z-index: 3;">
                                <div
                                    class="status-circle 
                            @if ($isCompleted) status-completed
                            @elseif($isBlockedStep) status-blocked
                            @else status-pending @endif">
                                    <i
                                        class="fas 
                                @if ($status == 'submitted') fa-paper-plane
                                @elseif($status == 'assessed') fa-clipboard-check
                                @elseif($status == 'assigned') fa-user-check
                                @elseif($status == 'diagnosis') fa-stethoscope
                                @elseif($status == 'repairing') fa-tools @endif">
                                    </i>
                                    @if ($isBlockedStep)
                                        <div class="blocked-overlay">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    @endif
                                </div>
                                <span
                                    class="mt-2 small text-center 
                            @if ($isCompleted) text-success fw-bold
                            @elseif($isBlockedStep) text-warning fw-bold
                            @else text-muted @endif">
                                    {{ ucfirst($status) }}
                                    @if ($status == 'assessed' && $index == array_search($currentStatus, $statusFlow) && !$request->technician_id)
                                        <br><small class="text-warning">(Awaiting Assignment)</small>
                                    @endif
                                </span>
                                <!-- Role Indicator -->
                                <div
                                    class="role-indicator 
                            @if (in_array($status, ['submitted', 'assessed', 'assigned'])) helpdesk-role
                            @else technician-role @endif">
                                    @if (in_array($status, ['submitted', 'assessed', 'assigned']))
                                        <i class="fas fa-headset"></i>
                                    @else
                                        <i class="fas fa-tools"></i>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Sent Back Indicator -->
                    @if ($isSentBack)
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="text-center">
                                    <div class="sent-back-indicator">
                                        <i class="fas fa-undo fa-2x text-warning mb-2"></i>
                                        <h5 class="text-warning">Sent Back to Helpdesk</h5>
                                        <p class="text-muted">This job card requires additional assessment from the
                                            helpdesk team.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Final Outcome Section -->
                    <div class="text-center mt-4">
                        <div class="final-outcome">
                            @if ($isFinalized)
                                <div
                                    class="status-circle status-final 
                            @if ($currentStatus == 'completed') status-completed-final 
                            @else status-unsuccessful-final @endif">
                                    <i
                                        class="fas 
                                @if ($currentStatus == 'completed') fa-check-circle 
                                @else fa-times-circle @endif fa-2x">
                                    </i>
                                </div>
                                <h5
                                    class="mt-3 
                            @if ($currentStatus == 'completed') text-success 
                            @else text-danger @endif">
                                    Job Card {{ ucfirst($currentStatus) }}
                                </h5>
                                <p class="text-muted">
                                    @if ($currentStatus == 'completed')
                                        The device has been successfully repaired and the customer can collect upon making a
                                        payment.
                                    @else
                                        The repair was unsuccessful, the device cannot be repaired by <span
                                            class="text-primary">{{ $request->technician->name }}</span>.
                                    @endif
                                </p>
                            @else
                                <div
                                    class="status-circle status-final 
                            @if ($isSentBack) status-blocked
                            @elseif($isBlocked) status-blocked
                            @else status-pending-final @endif">
                                    <i
                                        class="fas 
                                @if ($isSentBack) fa-undo
                                @else fa-flag-checkered @endif fa-2x">
                                    </i>
                                </div>
                                <h5
                                    class="mt-3 
                            @if ($isSentBack) text-warning
                            @elseif($isBlocked) text-warning
                            @else text-muted @endif">
                                    @if ($isSentBack)
                                        Sent Back to Helpdesk
                                    @elseif($isBlocked)
                                        Awaiting Technician Assignment
                                    @else
                                        Ready for Finalization
                                    @endif
                                </h5>
                                <p class="text-muted">
                                    @if ($isSentBack)
                                        <i class="fas fa-undo me-1"></i>
                                        This job card has been sent back to helpdesk for further assessment.
                                    @elseif($isBlocked)
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Assign a technician to continue the repair process.
                                    @else
                                        Final outcome decision pending
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    {{-- section for modals --}}

    {{-- Assessment Modal for Helpdesk --}}
    @if ($isHelpdesk)
        <div class="modal fade" id="assessmentModal" tabindex="-1" aria-labelledby="assessmentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="assessmentModalLabel">
                            <i class="fas fa-clipboard-check me-2"></i>Assessment Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('JobCard.update-status', $request->id) }}" method="POST"
                        id="assessmentForm">
                        @csrf
                        <input type="hidden" name="status" value="assessed">

                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Please provide assessment notes before updating the status to "Assessed".
                            </div>

                            <div class="mb-3">
                                <label for="assessment_notes" class="form-label fw-bold">
                                    Assessment Notes <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="assessment_notes" name="assessment_notes" rows="4"
                                    placeholder="Enter assessment details, findings, and initial recommendations..." required>{{ old('assessment_notes') }}</textarea>
                                <small class="text-muted">Describe the initial assessment of the device and issues.</small>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-info">
                                <i class="fas fa-check-circle me-2"></i>Update to Assessed
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Payment Management Modal --}}
    @if ($request->status == 'completed' && $request->final_cost && !$isTechnician)
        <div class="modal fade" id="paymentManagementModal" tabindex="-1" aria-labelledby="paymentManagementModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div
                        class="modal-header 
                @if ($request->payment_status === 'partial') bg-warning text-dark
                @else bg-success text-white @endif">
                        <h5 class="modal-title" id="paymentManagementModalLabel">
                            <i class="fas fa-money-check me-2"></i>
                            @if ($request->payment_status === 'partial')
                                Update Payment
                            @else
                                Record Payment
                            @endif
                        </h5>
                        <button type="button"
                            class="btn-close 
                    @if ($request->payment_status === 'partial') @else btn-close-white @endif"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('JobCard.update-payment', $request->id) }}" method="POST"
                        id="paymentManagementForm">
                        @csrf
                        <div class="modal-body">
                            <div
                                class="alert 
                        @if ($request->payment_status === 'partial') alert-warning
                        @else alert-info @endif">
                                <i
                                    class="fas 
                            @if ($request->payment_status === 'partial') fa-exclamation-triangle
                            @else fa-info-circle @endif me-2">
                                </i>
                                @if ($request->payment_status === 'partial')
                                    <strong>Update payment amount received from customer.</strong>
                                @else
                                    <strong>Record payment received from customer.</strong>
                                @endif
                            </div>

                            <!-- Cost Summary Card -->
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-3 text-dark">Cost Summary</h6>

                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted small">Final Repair Cost:</span>
                                            <strong
                                                class="text-dark">K{{ number_format($request->final_cost, 2) }}</strong>
                                        </div>
                                    </div>

                                    @if ($request->payment_status === 'partial')
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Already Paid:</span>
                                                <strong
                                                    class="text-success">K{{ number_format($request->amount_paid, 2) }}</strong>
                                            </div>
                                        </div>

                                        <div class="mb-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Balance Due:</span>
                                                <strong
                                                    class="text-danger">K{{ number_format($request->final_cost - $request->amount_paid, 2) }}</strong>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Amount Input -->
                            <div class="mb-4">
                                <label for="paymentAmount" class="form-label fw-bold">
                                    Amount Received <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-primary text-white border-primary fw-bold">K</span>
                                    <input type="number" class="form-control border-primary py-2" id="paymentAmount"
                                        name="amount_paid" min="0" max="{{ $request->final_cost + 1000 }}"
                                        step="0.01" value="{{ old('amount_paid', $request->amount_paid ?? 0) }}"
                                        placeholder="0.00" style="font-size: 1.1rem; font-weight: 600;" required>
                                </div>
                                <small class="text-muted mt-1">
                                    Enter the exact amount received from the customer
                                </small>
                            </div>

                            <!-- Auto-updating Payment Status -->
                            <div class="card border-0 mb-4" id="paymentStatusCard">
                                <div class="card-body p-3 text-center">
                                    <label class="form-label fw-bold mb-2">Payment Status</label>
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <div id="paymentStatusDisplay" class="p-3 rounded" style="min-width: 200px;">
                                            <div class="fw-bold fs-5 mb-1" id="statusText">Pending</div>
                                            <span id="statusBadge" class="badge fs-6 px-3 py-2">UNPAID</span>
                                        </div>
                                    </div>
                                    <small class="text-muted mt-2 d-block">
                                        Status updates automatically based on amount paid
                                    </small>
                                </div>
                            </div>

                            <!-- Payment Progress Bar -->
                            <div class="mb-4" id="paymentProgressContainer" style="display: none;">
                                <label class="form-label fw-bold mb-2">Payment Progress</label>
                                <div class="progress" style="height: 20px;">
                                    <div id="paymentProgressBar" class="progress-bar" role="progressbar"
                                        style="width: 0%; transition: width 0.3s ease;">
                                        <span id="progressText" class="fw-bold">0%</span>
                                    </div>
                                </div>
                                <small class="text-muted mt-1">
                                    <span id="progressAmount">K0.00</span> of
                                    K{{ number_format($request->final_cost, 2) }}
                                </small>
                            </div>

                            <!-- Payment Method (Optional) -->
                            <div class="mb-3">
                                <label for="paymentMethod" class="form-label fw-bold">
                                    Payment Method (Optional)
                                </label>
                                <select class="form-select" id="paymentMethod" name="payment_method">
                                    <option value="">-- Select Payment Method --</option>
                                    <option value="cash"
                                        {{ old('payment_method', $request->payment_method ?? '') == 'cash' ? 'selected' : '' }}>
                                        Cash</option>
                                    <option value="mobile_money"
                                        {{ old('payment_method', $request->payment_method ?? '') == 'mobile_money' ? 'selected' : '' }}>
                                        Mobile Money</option>
                                    <option value="bank_transfer"
                                        {{ old('payment_method', $request->payment_method ?? '') == 'bank_transfer' ? 'selected' : '' }}>
                                        Bank Transfer</option>
                                    <option value="card"
                                        {{ old('payment_method', $request->payment_method ?? '') == 'card' ? 'selected' : '' }}>
                                        Card Payment</option>
                                    <option value="other"
                                        {{ old('payment_method', $request->payment_method ?? '') == 'other' ? 'selected' : '' }}>
                                        Other</option>
                                </select>
                            </div>

                            <!-- Transaction Reference (Optional) -->
                            <div class="mb-3">
                                <label for="transactionReference" class="form-label fw-bold">
                                    Transaction Reference (Optional)
                                </label>
                                <input type="text" class="form-control" id="transactionReference"
                                    name="transaction_reference"
                                    value="{{ old('transaction_reference', $request->transaction_reference ?? '') }}"
                                    placeholder="e.g., MTN123456, Ref #789">
                                <small class="text-muted">
                                    Transaction ID, reference number, or receipt number
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-success btn-lg px-4" id="submitPaymentBtn">
                                <i class="fas fa-check-circle me-2"></i>
                                <span id="submitButtonText">
                                    @if ($request->payment_status === 'partial')
                                        Update Payment
                                    @else
                                        Save Payment
                                    @endif
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
            #paymentStatusDisplay {
                transition: all 0.3s ease;
                border: 2px solid transparent;
            }

            .payment-status-pending {
                background: linear-gradient(135deg, #fee, #fdd);
                border-color: #dc3545 !important;
                color: #721c24;
            }

            .payment-status-partial {
                background: linear-gradient(135deg, #fff3cd, #ffeaa7);
                border-color: #ffc107 !important;
                color: #856404;
            }

            .payment-status-paid {
                background: linear-gradient(135deg, #d4edda, #c3e6cb);
                border-color: #28a745 !important;
                color: #155724;
            }

            .progress-bar {
                transition: width 0.5s ease-in-out;
            }

            .input-group-lg .form-control {
                font-weight: 600;
            }

            #paymentStatusCard {
                background: rgba(248, 249, 250, 0.8);
                border: 1px solid #e9ecef;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const paymentAmount = document.getElementById('paymentAmount');
                const paymentStatusDisplay = document.getElementById('paymentStatusDisplay');
                const statusText = document.getElementById('statusText');
                const statusBadge = document.getElementById('statusBadge');
                const submitPaymentBtn = document.getElementById('submitPaymentBtn');
                const submitButtonText = document.getElementById('submitButtonText');
                const paymentProgressContainer = document.getElementById('paymentProgressContainer');
                const paymentProgressBar = document.getElementById('paymentProgressBar');
                const progressText = document.getElementById('progressText');
                const progressAmount = document.getElementById('progressAmount');

                const finalCost = {{ $request->final_cost ?? 0 }};
                const currentPaid = {{ $request->amount_paid ?? 0 }};

                function updatePaymentStatus() {
                    const amount = parseFloat(paymentAmount?.value) || 0;
                    const totalPaid = currentPaid + amount;
                    const percentage = Math.min((totalPaid / finalCost) * 100, 100);

                    let status, badgeClass, text, buttonClass, displayClass;

                    if (totalPaid >= finalCost) {
                        status = 'paid';
                        badgeClass = 'bg-success';
                        text = 'Fully Paid';
                        buttonClass = 'btn-success';
                        displayClass = 'payment-status-paid';
                    } else if (totalPaid > 0) {
                        status = 'partial';
                        badgeClass = 'bg-warning text-dark';
                        text = 'Partial Payment';
                        buttonClass = 'btn-warning';
                        displayClass = 'payment-status-partial';
                    } else {
                        status = 'pending';
                        badgeClass = 'bg-danger';
                        text = 'Pending';
                        buttonClass = 'btn-success';
                        displayClass = 'payment-status-pending';
                    }

                    // Update status display
                    if (statusText && statusBadge && paymentStatusDisplay) {
                        statusText.textContent = text;
                        statusBadge.textContent = status.toUpperCase();
                        statusBadge.className = `badge ${badgeClass} fs-6 px-3 py-2`;
                        paymentStatusDisplay.className = `p-3 rounded ${displayClass}`;
                    }

                    // Update button
                    if (submitPaymentBtn && submitButtonText) {
                        submitPaymentBtn.className = `btn ${buttonClass} btn-lg px-4`;

                        if (status === 'paid') {
                            submitButtonText.textContent = 'Mark as Paid';
                            submitPaymentBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Mark as Paid';
                        } else if (status === 'partial') {
                            submitButtonText.textContent = 'Update Payment';
                            submitPaymentBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Payment';
                        } else {
                            submitButtonText.textContent = 'Save Payment';
                            submitPaymentBtn.innerHTML = '<i class="fas fa-save me-2"></i>Save Payment';
                        }
                    }

                    // Update progress bar
                    if (paymentProgressContainer && paymentProgressBar && progressText && progressAmount) {
                        if (amount > 0) {
                            paymentProgressContainer.style.display = 'block';
                            paymentProgressBar.style.width = percentage + '%';
                            progressText.textContent = Math.round(percentage) + '%';
                            progressAmount.textContent = 'K' + totalPaid.toFixed(2);

                            // Progress bar color based on status
                            if (status === 'paid') {
                                paymentProgressBar.className = 'progress-bar bg-success';
                            } else if (status === 'partial') {
                                paymentProgressBar.className = 'progress-bar bg-warning';
                            } else {
                                paymentProgressBar.className = 'progress-bar bg-danger';
                            }
                        } else {
                            paymentProgressContainer.style.display = 'none';
                        }
                    }

                    return status;
                }

                // Update status when amount changes
                if (paymentAmount) {
                    paymentAmount.addEventListener('input', updatePaymentStatus);
                    paymentAmount.addEventListener('change', updatePaymentStatus);

                    // Initial update
                    updatePaymentStatus();
                }

                // Payment form submission
                const paymentForm = document.getElementById('paymentManagementForm');
                if (paymentForm) {
                    paymentForm.addEventListener('submit', function(e) {
                        const amount = parseFloat(paymentAmount?.value) || 0;
                        const status = updatePaymentStatus();

                        // Add hidden input for payment_status
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'payment_status';
                        hiddenInput.value = status;
                        this.appendChild(hiddenInput);

                        // Validation
                        if (status === 'paid' && (currentPaid + amount) < finalCost) {
                            e.preventDefault();
                            alert(
                                'Amount must be equal to or greater than the remaining balance to mark as fully paid.');
                            paymentAmount.focus();
                            return false;
                        }

                        if (amount < 0) {
                            e.preventDefault();
                            alert('Payment amount cannot be negative.');
                            paymentAmount.focus();
                            return false;
                        }

                        // Show loading state
                        const submitBtn = this.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                            submitBtn.disabled = true;
                        }
                    });
                }

                // Auto-focus on amount input when modal opens
                const paymentModal = document.getElementById('paymentManagementModal');
                if (paymentModal) {
                    paymentModal.addEventListener('shown.bs.modal', function() {
                        paymentAmount.focus();
                        paymentAmount.select();
                    });
                }
            });
        </script>
    @endif

    {{-- Diagnosis Notes Modal for Technicians --}}
    @if ($isTechnician)
        <div class="modal fade" id="diagnosisModal" tabindex="-1" aria-labelledby="diagnosisModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="diagnosisModalLabel">
                            <i class="fas fa-stethoscope me-2"></i>Diagnosis Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('JobCard.update-status', $request->id) }}" method="POST" id="diagnosisForm">
                        @csrf
                        <input type="hidden" name="status" value="diagnosis">

                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Please provide diagnosis findings before updating the status to "Diagnosis".
                            </div>

                            <div class="mb-3">
                                <label for="diagnosis_notes" class="form-label fw-bold">
                                    Diagnosis Findings <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="diagnosis_notes" name="diagnosis_notes" rows="4"
                                    placeholder="Enter detailed diagnosis findings, identified issues, and repair recommendations..." required>{{ old('diagnosis_notes') }}</textarea>
                                <small class="text-muted">Describe what you've found during the diagnosis process.</small>
                            </div>

                            <div class="mb-3">
                                <label for="estimated_repair_time" class="form-label fw-bold">
                                    Estimated Repair Time (Optional)
                                </label>
                                <input type="text" class="form-control" id="estimated_repair_time"
                                    name="estimated_repair_time" placeholder="e.g., 2-3 days, 1 week, etc."
                                    value="{{ old('estimated_repair_time') }}">
                                <small class="text-muted">Provide an estimate for how long the repair might take.</small>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle me-2"></i>Update to Diagnosis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Unsuccessful Repair Modal for Technicians --}}
    @if ($isTechnician)
        <div class="modal fade" id="unsuccessfulModal" tabindex="-1" aria-labelledby="unsuccessfulModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="unsuccessfulModalLabel">
                            <i class="fas fa-times-circle me-2"></i>Unsuccessful Repair Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('JobCard.update-status', $request->id) }}" method="POST"
                        id="unsuccessfulForm">
                        @csrf
                        <input type="hidden" name="status" value="unsuccessful">

                        <div class="modal-body">
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Important:</strong> Please provide detailed explanation why the repair was
                                unsuccessful.
                            </div>

                            <div class="mb-4">
                                <label for="unsuccessful_notes" class="form-label fw-bold">
                                    Reason for Unsuccessful Repair <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="unsuccessful_notes" name="unsuccessful_notes" rows="4"
                                    placeholder="Explain why the repair could not be completed successfully. Include technical challenges, part availability issues, or other factors..."
                                    required>{{ old('unsuccessful_notes') }}</textarea>
                                <small class="text-muted">This information will be shared with the customer.</small>
                            </div>

                            {{-- <div class="mb-3">
                        <label for="unsuccessful_reason" class="form-label fw-bold">
                            Primary Reason <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="unsuccessful_reason" name="unsuccessful_reason" required>
                            <option value="">-- Select Primary Reason --</option>
                            <option value="parts_unavailable">Parts Not Available</option>
                            <option value="technical_complexity">Technical Complexity Beyond Capability</option>
                            <option value="cost_prohibitive">Repair Cost Prohibitive</option>
                            <option value="further_damage">Risk of Further Damage</option>
                            <option value="obsolete_device">Device Obsolete/Discontinued</option>
                            <option value="other">Other Reason</option>
                        </select>
                    </div> --}}

                            {{-- <div class="mb-3">
                        <label for="recommendation" class="form-label fw-bold">
                            Recommendation to Customer
                        </label>
                        <textarea class="form-control" id="recommendation" name="recommendation" 
                                  rows="2" placeholder="Suggest next steps for the customer (e.g., consider replacement, try another service center, etc.)">{{ old('recommendation') }}</textarea>
                    </div> --}}

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times-circle me-2"></i>Mark as Unsuccessful
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Completed Repair Modal for Technicians --}}
    @if ($isTechnician)
        <div class="modal fade" id="completedModal" tabindex="-1" aria-labelledby="completedModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="completedModalLabel">
                            <i class="fas fa-check-circle me-2"></i>Complete Repair Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('JobCard.update-status', $request->id) }}" method="POST" id="completedForm">
                        @csrf
                        <input type="hidden" name="status" value="completed">

                        <div class="modal-body">
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Great job!</strong> Please provide repair completion details.
                            </div>

                            <div class="mb-4">
                                <label for="repair_summary" class="form-label fw-bold">
                                    Repair Summary <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="repair_summary" name="repair_summary" rows="4"
                                    placeholder="Describe the repair work completed, parts replaced, and final testing results..." required>{{ old('repair_summary') }}</textarea>
                                <small class="text-muted">This summary will help the customer understand what was
                                    done.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="total_cost" class="form-label fw-bold">
                                        Total Repair Cost (K) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">K</span>
                                        <input type="number" class="form-control" id="total_cost" name="total_cost"
                                            step="0.01" min="0"
                                            value="{{ old('total_cost', $request->total_cost ?? 0) }}" placeholder="0.00"
                                            required>
                                    </div>
                                    <small class="text-muted">Total cost of the repair including parts and labor.</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="repair_duration" class="form-label fw-bold">
                                        Actual Repair Time
                                    </label>
                                    <input type="text" class="form-control" id="repair_duration"
                                        name="repair_duration" placeholder="e.g., 3 hours, 2 days"
                                        value="{{ old('repair_duration') }}">
                                    <small class="text-muted">Actual time taken to complete the repair.</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="parts_used" class="form-label fw-bold">
                                    Parts Used (Optional)
                                </label>
                                <textarea class="form-control" id="parts_used" name="parts_used" rows="2"
                                    placeholder="List any parts that were replaced during the repair...">{{ old('parts_used') }}</textarea>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="quality_check" name="quality_check"
                                    value="1" required>
                                <label class="form-check-label fw-bold" for="quality_check">
                                    <i class="fas fa-check-double text-success me-1"></i>
                                    I confirm that quality testing has been completed and the device is functioning properly
                                </label>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-2"></i>Mark as Completed
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Sent Back Modal for Technicians --}}
    @if ($isTechnician)
        <div class="modal fade" id="sentBackModal" tabindex="-1" aria-labelledby="sentBackModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="sentBackModalLabel">
                            <i class="fas fa-undo me-2"></i>Send Back to Helpdesk
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('JobCard.sent-back', $request->id) }}" method="POST" id="sentBackForm">
                        @csrf
                        <input type="hidden" name="status" value="sent_back">

                        <div class="modal-body">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Note:</strong> This will send the job card back to the helpdesk for further
                                assessment.
                            </div>

                            <div class="mb-4">
                                <label for="sent_back_notes" class="form-label fw-bold">
                                    Reason for Sending Back <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="sent_back_notes" name="sent_back_notes" rows="4"
                                    placeholder="Explain why you need to send this job card back to helpdesk. Include any issues, clarifications needed, or additional information required..."
                                    required>{{ old('sent_back_notes') }}</textarea>
                                <small class="text-muted">This information will help the helpdesk team understand what
                                    additional support is needed.</small>
                            </div>

                            {{-- <div class="mb-3">
                        <label for="sent_back_reason" class="form-label fw-bold">
                            Primary Issue <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="sent_back_reason" name="sent_back_reason" required>
                            <option value="">-- Select Primary Issue --</option>
                            <option value="additional_info_needed">Additional Information Needed from Customer</option>
                            <option value="technical_assistance">Requires Technical Assistance</option>
                            <option value="parts_approval">Parts Cost Approval Required</option>
                            <option value="device_condition">Unexpected Device Condition</option>
                            <option value="scope_change">Repair Scope Changed</option>
                            <option value="other">Other Reason</option>
                        </select>
                    </div> --}}

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-undo me-2"></i>Send Back to Helpdesk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Reassign Technician Modal --}}
    @if (!$isTechnician && $request->status == 'sent_back')
        <div class="modal fade" id="reassignTechnicianModal" tabindex="-1"
            aria-labelledby="reassignTechnicianModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="reassignTechnicianModalLabel">
                            <i class="fas fa-user-check me-2"></i>Reassign to Another Technician
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('JobCard.reassign-technician', $request->id) }}" method="POST"
                        id="reassignTechnicianForm">
                        @csrf
                        @method('POST')

                        <div class="modal-body">
                            <div class="alert alert-info">
                                <div class="d-flex">
                                    <i class="fas fa-info-circle fa-2x me-3 mt-1"></i>
                                    <div>
                                        <h6 class="alert-heading mb-2">Reassign Sent Back Job Card</h6>
                                        <p class="mb-0">This job card was sent back by
                                            <strong>{{ $request->technician->name ?? 'Previous Technician' }}</strong>.
                                            Assign it to another technician for further diagnosis and repair.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="new_technician_id" class="form-label fw-bold">
                                    Select New Technician <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="new_technician_id" name="technician_id" required>
                                    <option value="">-- Select a Technician --</option>
                                    @foreach ($technicians as $tech)
                                        @if ($tech->id != $request->technician_id)
                                            {{-- Exclude current technician --}}
                                            <option value="{{ $tech->id }}"
                                                {{ old('technician_id') == $tech->id ? 'selected' : '' }}>
                                                {{ $tech->name }}
                                                @if ($tech->specialization)
                                                    - {{ $tech->specialization }}
                                                @endif
                                                @if ($tech->active_jobs_count ?? false)
                                                    <small class="text-muted">({{ $tech->active_jobs_count }} active
                                                        jobs)</small>
                                                @endif
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <small class="text-muted">Choose a technician with appropriate skills for this
                                    repair.</small>
                            </div>

                            <div class="mb-3">
                                <label for="reassignment_notes" class="form-label fw-bold">
                                    Reassignment Notes (Optional)
                                </label>
                                <textarea class="form-control" id="reassignment_notes" name="reassignment_notes" rows="3"
                                    placeholder="Add any specific instructions or context for the new technician...">{{ old('reassignment_notes') }}</textarea>
                                <small class="text-muted">These notes will help the new technician understand the
                                    situation.</small>
                            </div>

                            {{-- Display sent back reason if available --}}
                            @if ($request->sent_back_notes)
                                <div class="card border-warning mb-3">
                                    <div class="card-header bg-warning bg-opacity-10 text-warning fw-bold">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Sent Back Reason
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0 small">{{ $request->sent_back_notes }}</p>
                                        @if ($request->sent_back_at)
                                            <small class="text-muted">
                                                Sent back on: {{ $request->sent_back_at->format('M j, Y g:i A') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-check me-2"></i>Reassign Technician
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Archive Job Card Modal --}}
    @if (!$isTechnician && $request->status == 'sent_back')
        <div class="modal fade" id="archiveJobCardModal" tabindex="-1" aria-labelledby="archiveJobCardModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title" id="archiveJobCardModalLabel">
                            <i class="fas fa-archive me-2"></i>Archive Job Card
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('JobCard.archive', $request->id) }}" method="POST" id="archiveJobCardForm">
                        @csrf
                        @method('POST')

                        <div class="modal-body">
                            <div class="alert alert-warning">
                                <div class="d-flex">
                                    <i class="fas fa-exclamation-triangle fa-2x me-3 mt-1"></i>
                                    <div>
                                        <h6 class="alert-heading mb-2">Archive Job Card</h6>
                                        <p class="mb-0">Archiving will move this job card to archived records. This
                                            action should only be taken if no further repair attempts are needed or
                                            possible.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="archive_reason" class="form-label fw-bold">
                                    Archive Reason <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="archive_reason" name="archive_reason" required>
                                    <option value="">-- Select Archive Reason --</option>
                                    <option value="beyond_repair">Device Beyond Repair</option>
                                    <option value="customer_collected">Customer Collected Without Repair</option>
                                    <option value="parts_unavailable">Critical Parts Unavailable</option>
                                    <option value="cost_prohibitive">Repair Cost Prohibitive</option>
                                    <option value="customer_unreachable">Customer Unreachable</option>
                                    <option value="duplicate_request">Duplicate Job Card</option>
                                    <option value="other">Other Reason</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="archive_notes" class="form-label fw-bold">
                                    Archive Notes <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="archive_notes" name="archive_notes" rows="4"
                                    placeholder="Provide detailed explanation for archiving this job card..." required>{{ old('archive_notes') }}</textarea>
                                <small class="text-muted">These notes will be permanently recorded in the archive.</small>
                            </div>

                            {{-- Job Card Summary --}}
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">Job Card Summary</h6>
                                    <div class="row small">
                                        <div class="col-md-6">
                                            <strong>Device:</strong> {{ $request->device->name ?? 'N/A' }}<br>
                                            <strong>Customer:</strong> {{ $request->customer->name ?? 'N/A' }}<br>
                                            <strong>Current Status:</strong>
                                            <span
                                                class="badge bg-warning text-dark">{{ ucfirst($request->status) }}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Created:</strong> {{ $request->created_at->format('M j, Y') }}<br>
                                            <strong>Technician:</strong>
                                            {{ $request->technician->name ?? 'Not Assigned' }}<br>
                                            <strong>Issues Reported:</strong> {{ $request->issues->count() }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Warning Confirmation --}}
                            <div class="alert alert-danger mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="archive_confirmation"
                                        name="archive_confirmation" value="1" required>
                                    <label class="form-check-label fw-bold" for="archive_confirmation">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        I understand that archiving this job card will move it to permanent records and no
                                        further repairs will be attempted.
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-secondary" id="archiveSubmitBtn" disabled>
                                <i class="fas fa-archive me-2"></i>Archive Job Card
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif


    {{-- Additional Modals for Parts Used and Recommendations --}}

    {{-- Parts Used Modal --}}
    @if ($request->parts_used)
        <div class="modal fade" id="partsUsedModal" tabindex="-1" aria-labelledby="partsUsedModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="partsUsedModalLabel">
                            <i class="fas fa-cogs me-2"></i>Parts Used/Replaced
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3">Parts Details</h6>
                            <div class="bg-light p-4 rounded border">
                                <p class="mb-0" style="white-space: pre-line;">{{ $request->parts_used }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Recommendation Modal --}}
    @if ($request->recommendation)
        <div class="modal fade" id="recommendationModal" tabindex="-1" aria-labelledby="recommendationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="recommendationModalLabel">
                            <i class="fas fa-lightbulb me-2"></i>Customer Recommendations
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <h6 class="fw-bold text-info mb-3">Recommendations to Customer</h6>
                            <div class="bg-light p-4 rounded border">
                                <p class="mb-0" style="white-space: pre-line;">{{ $request->recommendation }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif



    {{-- Unsuccessful Notes Modal --}}
    @if ($request->status == 'unsuccessful' && $request->unsuccessful_notes && $userRole !== 'customer')
        <div class="modal fade" id="unsuccessfulNotesModal" tabindex="-1" aria-labelledby="unsuccessfulNotesModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="unsuccessfulNotesModalLabel">
                            <i class="fas fa-times-circle me-2"></i>Unsuccessful Repair Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <div class="d-flex">
                                <i class="fas fa-exclamation-triangle fa-2x me-3 mt-1"></i>
                                <div>
                                    <h6 class="alert-heading mb-2">Repair Unsuccessful - Complete Details</h6>
                                    <p class="mb-0">This repair could not be completed successfully. Below are the
                                        detailed reasons.</p>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 bg-light mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold text-danger mb-3">
                                    <i class="fas fa-clipboard-list me-2"></i>Reason for Unsuccessful Repair
                                </h6>
                                <div class="bg-white p-3 rounded border">
                                    <p class="mb-0" style="white-space: pre-line;">{{ $request->unsuccessful_notes }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if ($request->unsuccessful_reason)
                            <div class="card border-0 bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold text-danger mb-3">
                                        <i class="fas fa-tag me-2"></i>Primary Issue Category
                                    </h6>
                                    <div class="bg-white p-3 rounded border">
                                        <span class="badge bg-danger fs-6 px-3 py-2">
                                            @php
                                                $reasonLabels = [
                                                    'parts_unavailable' => 'Parts Not Available',
                                                    'technical_complexity' => 'Technical Complexity',
                                                    'cost_prohibitive' => 'Cost Prohibitive',
                                                    'further_damage' => 'Risk of Further Damage',
                                                    'obsolete_device' => 'Device Obsolete',
                                                    'other' => 'Other Reason',
                                                ];
                                            @endphp
                                            {{ $reasonLabels[$request->unsuccessful_reason] ?? $request->unsuccessful_reason }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($request->recommendation)
                            <div class="card border-0 bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold text-info mb-3">
                                        <i class="fas fa-lightbulb me-2"></i>Recommendations to Customer
                                    </h6>
                                    <div class="bg-white p-3 rounded border">
                                        <p class="mb-0" style="white-space: pre-line;">{{ $request->recommendation }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-muted mb-3">
                                            <i class="fas fa-user-cog me-2"></i>Technician Information
                                        </h6>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-user text-danger"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small">Marked as Unsuccessful by</div>
                                                <div class="fw-bold">{{ $request->technician->name ?? 'Technician' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-muted mb-3">
                                            <i class="fas fa-calendar me-2"></i>Timeline
                                        </h6>
                                        @if ($request->unsuccessful_at)
                                            <div class="d-flex align-items-center">
                                                <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="fas fa-clock text-danger"></i>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Marked Unsuccessful</div>
                                                    <div class="fw-bold small">
                                                        {{ $request->unsuccessful_at->format('M j, Y g:i A') }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Close
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Print Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Assessment Notes Modal --}}
    @if (!empty($request->assessment_notes) && $userRole !== 'customer')
        <div class="modal fade" id="assessmentNotesModal" tabindex="-1" aria-labelledby="assessmentNotesModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="assessmentNotesModalLabel">
                            <i class="fas fa-sticky-note me-2"></i>Assessment Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-info">
                            <div class="d-flex">
                                <i class="fas fa-info-circle fa-2x me-3 mt-1"></i>
                                <div>
                                    <h6 class="alert-heading mb-2">Assessment Notes Available</h6>
                                    <p class="mb-0">Below are the detailed assessment notes for this job card.</p>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 bg-light mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold text-info mb-3">
                                    <i class="fas fa-clipboard-list me-2"></i>Assessment Notes
                                </h6>
                                <div class="bg-white p-3 rounded border">
                                    <p class="mb-0" style="white-space: pre-line;">{{ $request->assessment_notes }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if (!empty($request->recommendation))
                            <div class="card border-0 bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold text-info mb-3">
                                        <i class="fas fa-lightbulb me-2"></i>Recommendations
                                    </h6>
                                    <div class="bg-white p-3 rounded border">
                                        <p class="mb-0" style="white-space: pre-line;">{{ $request->recommendation }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-muted mb-3">
                                            <i class="fas fa-user-cog me-2"></i>Technician Information
                                        </h6>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-user text-info"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small">Assessment made by</div>
                                                <div class="fw-bold">{{ $request->helpDesk->name ?? 'Helpdesk Team' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-muted mb-3">
                                            <i class="fas fa-calendar me-2"></i>Timeline
                                        </h6>
                                        @if ($request->assessed_at)
                                            <div class="d-flex align-items-center">
                                                <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="fas fa-clock text-info"></i>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Assessment Date</div>
                                                    <div class="fw-bold small">
                                                        {{ $request->assessed_at->format('M j, Y g:i A') }}</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Close
                        </button>
                        <button type="button" class="btn btn-outline-info" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Print Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Sent Back Notes Modal --}}
    @if (!empty($request->sent_back_notes) && $userRole !== 'customer')
        <div class="modal fade" id="sentBackNotesModal" tabindex="-1" aria-labelledby="sentBackNotesModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="sentBackNotesModalLabel">
                            <i class="fas fa-undo-alt me-2"></i>Sent Back Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-warning border-0">
                            <div class="d-flex">
                                <i class="fas fa-info-circle fa-2x me-3 mt-1"></i>
                                <div>
                                    <h6 class="alert-heading mb-2">This request was sent back for revision or
                                        clarification.</h6>
                                    <p class="mb-0">Below are the details and notes from the sender.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Notes Content --}}
                        <div class="card border-0 bg-light mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold text-warning mb-3">
                                    <i class="fas fa-comment-dots me-2"></i>Sent Back Notes
                                </h6>
                                <div class="bg-white p-3 rounded border">
                                    <p class="mb-0" style="white-space: pre-line;">{{ $request->sent_back_notes }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Optional Recommendation --}}
                        @if ($request->sent_back_reason)
                            <div class="card border-0 bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold text-warning mb-3">
                                        <i class="fas fa-tag me-2"></i>Reason for Sent Back
                                    </h6>
                                    <div class="bg-white p-3 rounded border">
                                        <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                            {{ ucfirst(str_replace('_', ' ', $request->sent_back_reason)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Technician + Timeline --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-muted mb-3">
                                            <i class="fas fa-user-edit me-2"></i>Sent Back By
                                        </h6>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-user text-warning"></i>
                                            </div>
                                            <div>
                                                <div class="text-muted small">Marked as Sent Back by</div>
                                                <div class="fw-bold">{{ $request->technician->name ?? 'Technician' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($request->sent_back_at)
                                <div class="col-md-6">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body">
                                            <h6 class="fw-bold text-muted mb-3">
                                                <i class="fas fa-calendar me-2"></i>Timeline
                                            </h6>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="fas fa-clock text-warning"></i>
                                                </div>
                                                <div>
                                                    <div class="text-muted small">Sent Back On</div>
                                                    <div class="fw-bold small">
                                                        {{ $request->sent_back_at->format('M j, Y g:i A') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Close
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Print Notes
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('statusSelect');
            const updateStatusBtn = document.getElementById('updateStatusBtn');
            const statusForm = document.getElementById('statusForm');

            updateStatusBtn.addEventListener('click', function() {
                const selectedOption = statusSelect.options[statusSelect.selectedIndex];
                const requiresNotes = selectedOption.getAttribute('data-requires-notes') === 'true';
                const modalId = selectedOption.getAttribute('data-modal-id');

                if (requiresNotes && modalId) {
                    const modal = new bootstrap.Modal(document.getElementById(modalId));
                    modal.show();
                } else {
                    statusForm.submit();
                }
            });
        });


        // Additional Fees Modal Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const additionalFeesAmount = document.getElementById('additionalFeesAmount');
            const finalCostDisplay = document.getElementById('finalCostDisplay');

            // Calculate initial cost
            const initialCost = {{ $request->total_cost ?? 0 }};

            // Update final cost display when additional fees change
            if (additionalFeesAmount && finalCostDisplay) {
                additionalFeesAmount.addEventListener('input', function() {
                    const additionalFees = parseFloat(this.value) || 0;
                    const finalCost = initialCost + additionalFees;
                    finalCostDisplay.textContent = 'K' + finalCost.toFixed(2);
                });

                // Trigger initial calculation
                additionalFeesAmount.dispatchEvent(new Event('input'));
            }
        });

        // Payment management
        function markAsPaid(jobCardId, finalCost) {
            document.getElementById('paymentJobCardId').value = jobCardId;
            document.getElementById('paymentFinalCost').textContent = finalCost.toLocaleString();

            const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();
        }

        // Payment Management - Auto-update status
        document.addEventListener('DOMContentLoaded', function() {
            const paymentAmount = document.getElementById('paymentAmount');
            const paymentStatusDisplay = document.getElementById('paymentStatusDisplay');
            const statusText = document.getElementById('statusText');
            const statusBadge = document.getElementById('statusBadge');
            const submitPaymentBtn = document.getElementById('submitPaymentBtn');
            const finalCost = {{ $request->final_cost ?? 0 }};

            function updatePaymentStatus() {
                const amount = parseFloat(paymentAmount?.value) || 0;

                let status, badgeClass, text, buttonClass;

                if (amount >= finalCost) {
                    status = 'paid';
                    badgeClass = 'bg-success';
                    text = 'Fully Paid';
                    buttonClass = 'btn-success';
                } else if (amount > 0) {
                    status = 'partial';
                    badgeClass = 'bg-warning text-dark';
                    text = 'Partial Payment';
                    buttonClass = 'btn-warning';
                } else {
                    status = 'pending';
                    badgeClass = 'bg-danger';
                    text = 'Pending';
                    buttonClass = 'btn-success';
                }

                // Update display
                if (statusText && statusBadge) {
                    statusText.textContent = text;
                    statusBadge.textContent = status.toUpperCase();
                    statusBadge.className = `badge ${badgeClass} ms-2`;
                }

                // Update button
                if (submitPaymentBtn) {
                    submitPaymentBtn.className = `btn ${buttonClass}`;

                    if (status === 'paid') {
                        submitPaymentBtn.innerHTML = '<i class="fas fa-check me-2"></i>Mark as Paid';
                    } else if (status === 'partial') {
                        submitPaymentBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Payment';
                    } else {
                        submitPaymentBtn.innerHTML = '<i class="fas fa-save me-2"></i>Save Payment';
                    }
                }

                // Update payment status display background
                if (paymentStatusDisplay) {
                    if (status === 'paid') {
                        paymentStatusDisplay.style.background = 'rgba(40, 167, 69, 0.1)';
                        paymentStatusDisplay.style.border = '1px solid #28a745';
                    } else if (status === 'partial') {
                        paymentStatusDisplay.style.background = 'rgba(255, 193, 7, 0.1)';
                        paymentStatusDisplay.style.border = '1px solid #ffc107';
                    } else {
                        paymentStatusDisplay.style.background = 'rgba(220, 53, 69, 0.1)';
                        paymentStatusDisplay.style.border = '1px solid #dc3545';
                    }
                }

                return status;
            }

            // Update status when amount changes
            if (paymentAmount) {
                paymentAmount.addEventListener('input', updatePaymentStatus);

                // Initial update
                updatePaymentStatus();
            }

            // Payment form submission
            const paymentForm = document.getElementById('paymentManagementForm');
            if (paymentForm) {
                paymentForm.addEventListener('submit', function(e) {
                    const amount = parseFloat(paymentAmount?.value) || 0;
                    const status = updatePaymentStatus();

                    // Add hidden input for payment_status
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'payment_status';
                    hiddenInput.value = status;
                    this.appendChild(hiddenInput);

                    // Validation
                    if (status === 'paid' && amount < finalCost) {
                        e.preventDefault();
                        alert('Amount must be equal to or greater than final cost to mark as paid.');
                        return false;
                    }

                    // Show loading state
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                        submitBtn.disabled = true;
                    }
                });
            }
        });

        {{-- Additional JavaScript for Button Functionality --}}
        document.addEventListener('DOMContentLoaded', function() {
            // Handle status buttons that require notes (open modals)
            const statusButtons = document.querySelectorAll('.status-btn[data-requires-notes="true"]');

            statusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal-id');
                    const status = this.getAttribute('data-status');

                    // Set the status value in the modal form
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        const statusInput = modal.querySelector('input[name="status"]');
                        if (statusInput) {
                            statusInput.value = status;
                        }

                        // Show the modal
                        const bootstrapModal = new bootstrap.Modal(modal);
                        bootstrapModal.show();
                    }
                });
            });
        });


        // Archive confirmation toggle
        document.addEventListener('DOMContentLoaded', function() {
            const archiveConfirmation = document.getElementById('archive_confirmation');
            const archiveSubmitBtn = document.getElementById('archiveSubmitBtn');

            if (archiveConfirmation && archiveSubmitBtn) {
                archiveConfirmation.addEventListener('change', function() {
                    archiveSubmitBtn.disabled = !this.checked;
                });
            }

            // Technician reassignment - load technician workload if needed
            const technicianSelect = document.getElementById('new_technician_id');
            if (technicianSelect) {
                // You can add AJAX here to load technician workload in real-time
                technicianSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    // You can add additional logic here to show technician details
                });
            }
        });
    </script>

    <style>
        .card[style*="03045e"] {
            border-radius: 12px;
            transition: transform 0.2s ease-in-out;
        }

        .card[style*="03045e"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(3, 4, 94, 0.3);
        }

        .card[style*="03045e"] strong {
            color: #ffffff;
            font-weight: 600;
        }

        .card[style*="03045e"] span:not(.badge) {
            color: #e0e0e0;
        }

        .card[style*="03045e"] .badge {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }

        /* Status Progress Styles */
        .status-progress {
            padding: 20px 0;
        }

        .status-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            border: 3px solid #e9ecef;
            background: white;
            transition: all 0.3s ease;
            position: relative;
        }

        .status-completed {
            border-color: #28a745;
            background: #28a745;
            color: white;
        }

        .status-blocked {
            border-color: #ffc107;
            background: #ffc107;
            color: white;
            animation: pulse-warning 2s infinite;
        }

        .status-pending {
            border-color: #e9ecef;
            background: white;
            color: #6c757d;
        }

        .blocked-overlay {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            color: white;
        }

        /* Role Indicators */
        .role-indicator {
            position: absolute;
            top: -10px;
            right: -10px;
            background: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            border: 2px solid;
        }

        .helpdesk-role {
            border-color: #17a2b8;
            color: #17a2b8;
        }

        .technician-role {
            border-color: #ffc107;
            color: #ffc107;
        }

        /* Final Outcome Styles */
        .status-final {
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }

        .status-completed-final {
            border-color: #28a745;
            background: #28a745;
            color: white;
            animation: pulse 2s infinite;
        }

        .status-unsuccessful-final {
            border-color: #dc3545;
            background: #dc3545;
            color: white;
            animation: pulse 2s infinite;
        }

        .status-pending-final {
            border-color: #6c757d;
            background: #6c757d;
            color: white;
        }

        /* Sent Back Styles */
        .sent-back-indicator {
            padding: 20px;
            border: 2px dashed #ffc107;
            border-radius: 12px;
            background: #fffbf0;
        }

        .border-warning {
            border-left: 4px solid #ffc107 !important;
        }

        .border-info {
            border-left: 4px solid #17a2b8 !important;
        }

        .border-danger {
            border-left: 4px solid #dc3545 !important;
        }

        @keyframes pulse {
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

        @keyframes pulse-warning {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.03);
            }

            100% {
                transform: scale(1);
            }
        }

        .final-outcome {
            padding: 20px;
            border-radius: 12px;
            background: #f8f9fa;
        }

        .alert-warning {
            border-left: 4px solid #ffc107;
        }

        .bg-warning.bg-opacity-10 {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }


        /* Payment status animations */
        #paymentStatusDisplay {
            transition: all 0.3s ease;
        }

        .payment-status-paid {
            background: rgba(40, 167, 69, 0.1) !important;
            border: 1px solid #28a745 !important;
            color: #155724;
        }

        .payment-status-partial {
            background: rgba(255, 193, 7, 0.1) !important;
            border: 1px solid #ffc107 !important;
            color: #856404;
        }

        .payment-status-pending {
            background: rgba(220, 53, 69, 0.1) !important;
            border: 1px solid #dc3545 !important;
            color: #721c24;
        }

        /* Smooth transitions for payment form */
        #paymentAmount:focus {
            border-color: #2196f3;
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
        }

        /* Status button styles */
        .status-btn {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            transition: all 0.2s ease-in-out;
        }

        .status-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
