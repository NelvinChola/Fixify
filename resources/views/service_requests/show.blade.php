{{-- resources/views/service_requests/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <!-- Header Section -->
                <div class="card-header bg-gradient-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-0">Service Card #{{ $serviceRequest->id }}</h3>
                            <p class="mb-0 opacity-8">Request submitted on {{ $serviceRequest->created_at->format('M j, Y g:i A') }}</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-light text-dark fs-6 text-capitalize">{{ $serviceRequest->status }}</span>
                            <span class="badge bg-info ms-1">${{ number_format($serviceRequest->total_cost, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Left Column - Request Details -->
                        <div class="col-lg-8">
                            <!-- Status Timeline -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Job Card Status</h5>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        @php
                                            $statuses = [
                                                'submitted' => ['icon' => 'fas fa-clock', 'color' => 'warning', 'label' => 'Submitted'],
                                                'Assigned' => ['icon' => 'fas fa-check', 'color' => 'success', 'label' => 'Assigned'],
                                                'diagnosing' => ['icon' => 'fas fa-search', 'color' => 'info', 'label' => 'Diagnosing'],
                                                'repairing' => ['icon' => 'fas fa-tools', 'color' => 'primary', 'label' => 'Repairing'],
                                                'completed' => ['icon' => 'fas fa-check', 'color' => 'success', 'label' => 'Completed'],
                                                'Unrepairable' => ['icon' => 'fas fa-times', 'color' => 'danger', 'label' => 'Unrepairable']
                                            ];
                                        @endphp
                                        
                                        @foreach($statuses as $statusKey => $statusInfo)
                                            <div class="timeline-item {{ $statusKey === $serviceRequest->status ? 'active' : '' }}">
                                                <div class="timeline-icon bg-{{ $statusInfo['color'] }}">
                                                    <i class="{{ $statusInfo['icon'] }} text-white"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <h6 class="mb-1">{{ $statusInfo['label'] }}</h6>
                                                    @if($statusKey === $serviceRequest->status)
                                                        <small class="text-success">Current Status</small>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Issues -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Selected Issues & Costs</h5>
                                        <span class="badge bg-primary">{{ $serviceRequest->issues->count() }} issues</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Issue Description</th>
                                                    <th width="120" class="text-end">Cost</th>
                                                    <th width="100" class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($serviceRequest->issues as $issue)
                                                    <tr>
                                                        <td>
                                                            <h6 class="mb-1">{{ $issue->issue }}</h6>
                                                            @if($issue->description)
                                                                <small class="text-muted">{{ $issue->description }}</small>
                                                            @endif
                                                            <div class="mt-1">
                                                                @if($issue->repair_time)
                                                                    <small class="text-success me-3">
                                                                        <i class="fas fa-clock me-1"></i>
                                                                        {{ $issue->repair_time }}
                                                                    </small>
                                                                @endif
                                                                @if($issue->warranty)
                                                                    <small class="text-info">
                                                                        <i class="fas fa-shield-alt me-1"></i>
                                                                        {{ $issue->warranty }}
                                                                    </small>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <strong class="text-success">${{ number_format($issue->pivot->cost, 2) }}</strong>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-warning">Pending</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-light">
                                                <tr>
                                                    <th class="text-end">Total Cost:</th>
                                                    <th class="text-end text-success">${{ number_format($serviceRequest->total_cost, 2) }}</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Device & Customer Info -->
                        <div class="col-lg-4">
                            <!-- Device Information -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Device Information</h5>
                                </div>
                                <div class="card-body text-center">
                                    @if($serviceRequest->device->image)
                                        <img src="{{ asset('storage/' . $serviceRequest->device->image) }}" 
                                             alt="{{ $serviceRequest->device->name }}" 
                                             class="img-fluid rounded-3 mb-3"
                                             style="max-height: 150px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3" 
                                             style="height: 150px;">
                                            <i class="fas fa-mobile-alt fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    <h5 class="text-gradient text-primary mb-1">{{ $serviceRequest->device->name }}</h5>
                                    <p class="text-sm text-muted mb-1">{{ $serviceRequest->device->brand }}</p>
                                    <p class="text-sm mb-0">{{ $serviceRequest->device->model ?? 'Standard Model' }}</p>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Customer Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar avatar-sm me-3">
                                            <i class="fas fa-user-circle fa-2x text-muted"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $serviceRequest->customer->name }}</h6>
                                            <small class="text-muted">{{ $serviceRequest->customer->email }}</small>
                                        </div>
                                    </div>
                                    <div class="row text-sm">
                                        <div class="col-6">
                                            <small class="text-muted">Service Card ID:</small>
                                            <p class="mb-1"><strong>#{{ $serviceRequest->id }}</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Submitted:</small>
                                            <p class="mb-1"><strong>{{ $serviceRequest->created_at->format('M j, Y') }}</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('service-requests.select-device') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-plus me-2"></i>Create New Request
                                        </a>
                                        <button class="btn btn-outline-info">
                                            <i class="fas fa-print me-2"></i>Print Quote
                                        </button>
                                        <button class="btn btn-outline-secondary">
                                            <i class="fas fa-envelope me-2"></i>Contact Support
                                        </button>
                                        @if($serviceRequest->status === 'pending')
                                            <button class="btn btn-outline-danger">
                                                <i class="fas fa-times me-2"></i>Cancel Request
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="card border-0 shadow-sm mt-4">
                                <div class="card-body text-center">
                                    <div class="row">
                                        <div class="col-6 border-end">
                                            <h4 class="text-primary mb-0">{{ $serviceRequest->issues->count() }}</h4>
                                            <small class="text-muted">Issues</small>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="text-success mb-0">${{ number_format($serviceRequest->total_cost, 2) }}</h4>
                                            <small class="text-muted">Total Cost</small>
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
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item.active .timeline-icon {
    transform: scale(1.1);
    box-shadow: 0 0 0 4px rgba(94, 114, 228, 0.2);
}

.timeline-icon {
    position: absolute;
    left: -30px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.timeline-content {
    padding-bottom: 10px;
}

.bg-gradient-primary {
    background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
}

.text-gradient {
    background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.avatar {
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any interactive functionality here
    console.log('Service Request #{{ $serviceRequest->id }} loaded');
});
</script>
@endpush