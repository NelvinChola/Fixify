{{-- select-issues.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Debug Flash Messages -->
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Validation Errors:</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-0">Select Issues for {{ $device->name }}</h3>
                            <p class="mb-0 opacity-8">Choose the issues you're experiencing with your device</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge bg-light text-dark fs-6">{{ $device->brand }}</span>
                            <span class="badge bg-info ms-1">{{ $issuesByCategory->count() }} categories</span>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Device Information Section -->
                        <div class="col-lg-4 col-md-5 mb-4">
                            <div class="sticky-top" style="top: 20px;">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        @if($device->image)
                                            <img src="{{ asset('storage/' . $device->image) }}" 
                                                 alt="{{ $device->name }}" 
                                                 class="img-fluid rounded-3 mb-3"
                                                 style="max-height: 200px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3" 
                                                 style="height: 200px;">
                                                <i class="fas fa-mobile-alt fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                        
                                        <h4 class="text-gradient text-primary">{{ $device->name }}</h4>
                                        <p class="text-sm text-muted mb-2">{{ $device->brand }}</p>
                                        <p class="text-sm">{{ $device->model ?? 'Standard Model' }}</p>
                                        
                                        <!-- Consultation Fee Information -->
                                        <div class="mt-3 p-3 bg-light rounded">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <small class="text-dark fw-bold">Consultation Fee:</small>
                                                <span class="badge bg-warning text-dark">K{{ number_format($consultationFee, 2) }}</span>
                                            </div>
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                This fee covers initial diagnosis and will be applied to your final repair cost.
                                            </small>
                                        </div>

                                        <div class="mt-2">
                                            <a href="{{ route('service-requests.select-device') }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-arrow-left me-1"></i>
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
                               <input type="hidden" name="agree_consultation_fee" id="agreeConsultationFee" value="0">
                                @csrf
                                
                                @if($issuesByCategory->count() > 0)
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="text-dark mb-0">Available Issues by Category</h5>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                            <label class="form-check-label text-sm" for="selectAll">
                                                Select All Issues
                                            </label>
                                        </div>
                                    </div>

                                    @foreach($issuesByCategory as $categoryName => $issues)
                                        <div class="category-section mb-5">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon icon-shape icon-sm bg-gradient-info text-white rounded-circle me-3">
                                                    <i class="fas fa-folder"></i>
                                                </div>
                                                <h6 class="text-dark mb-0 me-3">{{ $categoryName ?? 'General Issues' }}</h6>
                                                <span class="badge bg-primary">{{ $issues->count() }} issues</span>
                                            </div>
                                            
                                            <div class="row">
                                                @foreach($issues as $issue)
                                                    @php
                                                        // Get price from pivot table or issue model
                                                        $price = $issue->pivot->cost ?? $issue->cost ?? $issue->cost ?? 0;
                                                    @endphp
                                                    <div class="col-xl-6 col-lg-12 mb-3">
                                                        <div class="card issue-card h-100 border-hover">
                                                            <div class="card-body p-3">
                                                                <div class="d-flex align-items-start justify-content-between">
                                                                    <div class="form-check mb-0">
                                                                        <input class="form-check-input issue-checkbox" 
                                                                               type="checkbox" 
                                                                               name="issues[]" 
                                                                               value="{{ $issue->id }}" 
                                                                               id="issue{{ $issue->id }}"
                                                                               data-price="{{ $price }}">
                                                                        <label class="form-check-label ms-2" for="issue{{ $issue->id }}">
                                                                            <h6 class="mb-1 text-dark">{{ $issue->issue }}</h6>
                                                                        </label>
                                                                    </div>
                                                                    <div class="text-end">
                                                                        <span class="h6 text-success mb-0">K{{ number_format($price, 2) }}</span>
                                                                        <input type="hidden" name="costs[{{ $issue->id }}]" value="{{ $price }}">
                                                                    </div>
                                                                </div>
                                                                
                                                                @if($issue->description)
                                                                    <p class="text-sm text-muted mt-2 mb-0">{{ $issue->description }}</p>
                                                                @endif
                                                                
                                                                <div class="mt-2 d-flex justify-content-between align-items-center">
                                                                    @if($issue->repair_time)
                                                                        <small class="text-success">
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Summary Section -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="card bg-gradient-dark text-white">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-6">
                                                            <h5 class="text-white mb-1">
                                                                <i class="fas fa-check-circle me-2"></i>
                                                                Selected Issues: <span id="selectedCount">0</span>
                                                            </h5>
                                                            <p class="text-white opacity-8 mb-0">
                                                                <i class="fas fa-dollar-sign me-2"></i>
                                                                Repair Cost: K<span id="totalCost">0.00</span>
                                                            </p>
                                                            <p class="text-white opacity-8 mb-0">
                                                                <i class="fas fa-stethoscope me-2"></i>
                                                                Consultation Fee: K<span id="consultationFeeDisplay">{{ number_format($consultationFee, 2) }}</span>
                                                            </p>
                                                            <p class="text-white fw-bold mt-1 mb-0">
                                                                <i class="fas fa-receipt me-2"></i>
                                                                Total: K<span id="grandTotal">0.00</span>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            <button type="button" class="btn btn-lg bg-gradient-success" id="submitRequestBtn" disabled>
                                                                <i class="fas fa-file-invoice-dollar me-2"></i>
                                                                Submit Request & Pay Consultation Fee
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="icon icon-shape icon-lg bg-gradient-warning text-white rounded-circle mb-4">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                        <h4 class="text-warning">No Issues Configured</h4>
                                        <p class="text-muted">This device doesn't have any predefined issues yet.</p>
                                        <div class="mt-3">
                                            <a href="{{ route('service-requests.select-device') }}" class="btn btn-outline-primary">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                Choose Another Device
                                            </a>
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
<div class="modal fade" id="consultationFeeModal" tabindex="-1" aria-labelledby="consultationFeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="consultationFeeModalLabel">
                    <i class="fas fa-stethoscope me-2"></i>
                    Consultation Fee Agreement
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fas fa-file-contract fa-2x"></i>
                    </div>
                    <h4 class="text-dark">Consultation Fee Required</h4>
                </div>
                
                <div class="alert alert-info">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x me-3 text-info"></i>
                        <div>
                            <strong>Consultation Fee: K{{ number_format($consultationFee, 2) }}</strong>
                            <p class="mb-0 mt-1">This fee covers our initial diagnostic service to properly assess your device issues.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-light rounded p-3 mb-4">
                    <h6 class="text-dark mb-2">What's included:</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1"><i class="fas fa-check text-success me-2"></i> Comprehensive device diagnostics</li>
                        <li class="mb-1"><i class="fas fa-check text-success me-2"></i> Professional technical assessment</li>                       
                        <li class="mb-1"><i class="fas fa-check text-success me-2"></i> Accurate cost estimation</li>
                        <li><i class="fas fa-check text-success me-2"></i> Fee applied to final repair cost</li>
                    </ul>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="modalAgreeCheckbox">
                    <label class="form-check-label fw-bold text-dark" for="modalAgreeCheckbox">
                        I understand and agree to pay the K{{ number_format($consultationFee, 2) }} consultation fee
                    </label>
                </div>

                <div class="mt-3">
                    <small class="text-muted">
                        {{-- <i class="fas fa-shield-alt me-1"></i> --}}
                        <span class="text-danger">Note</span>:The consultation fee will be added to the estimated total cost.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-success" id="confirmAgreementBtn" disabled>
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
.border-hover {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.border-hover:hover {
    border-color: #5e72e4;
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.issue-card .form-check-input:checked ~ label h6 {
    color: #5e72e4 !important;
}

.card-header.bg-gradient-primary {
    background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
}

.bg-gradient-success {
    background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
}

.bg-gradient-dark {
    background: linear-gradient(87deg, #212229 0, #212229 100%) !important;
}

.bg-gradient-info {
    background: linear-gradient(87deg, #11cdef 0, #1171ef 100%) !important;
}

.category-section {
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 1.5rem;
}

.category-section:last-child {
    border-bottom: none;
}

.text-gradient {
    background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.issue-checkbox:checked {
    background-color: #5e72e4;
    border-color: #5e72e4;
}

.icon-shape {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
}

/* Animation for price updates */
.price-update {
    animation: pricePulse 0.5s ease-in-out;
}

@keyframes pricePulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const issuesForm = document.getElementById('issuesForm');
    const checkboxes = document.querySelectorAll('.issue-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    const totalCost = document.getElementById('totalCost');
    const consultationFeeDisplay = document.getElementById('consultationFeeDisplay');
    const grandTotal = document.getElementById('grandTotal');
    const submitRequestBtn = document.getElementById('submitRequestBtn');
    const selectAll = document.getElementById('selectAll');
    const agreeConsultationFeeInput = document.getElementById('agreeConsultationFee');
    
    // Modal elements
    const consultationFeeModal = new bootstrap.Modal(document.getElementById('consultationFeeModal'));
    const modalAgreeCheckbox = document.getElementById('modalAgreeCheckbox');
    const confirmAgreementBtn = document.getElementById('confirmAgreementBtn');
    
    // Consultation fee value
    const consultationFee = parseFloat(consultationFeeDisplay.textContent) || 49.99;
    
    let isSubmitting = false;

    // Update summary function
    function updateSummary() {
        let selectedCountValue = 0;
        let repairCostValue = 0;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCountValue++;
                const price = parseFloat(checkbox.getAttribute('data-price')) || 0;
                repairCostValue += price;
            }
        });

        const totalWithFee = repairCostValue + consultationFee;
        
        selectedCount.textContent = selectedCountValue;
        totalCost.textContent = repairCostValue.toFixed(2);
        grandTotal.textContent = totalWithFee.toFixed(2);
        
        // Update submit button state
        submitRequestBtn.disabled = selectedCountValue === 0;
    }

    // Select all functionality
    selectAll.addEventListener('change', function() {
        const isChecked = this.checked;
        checkboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        updateSummary();
    });

    // Checkbox change events
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSummary);
    });

    // Submit Request Button Click - Show Modal instead of submitting form
    submitRequestBtn.addEventListener('click', function() {
        if (isSubmitting) return;
        
        const selectedCountValue = parseInt(selectedCount.textContent) || 0;
        
        if (selectedCountValue === 0) {
            alert('Please select at least one issue before submitting your request.');
            return;
        }
        
        // Show consultation fee modal
        consultationFeeModal.show();
    });

    // Modal agreement checkbox
    modalAgreeCheckbox.addEventListener('change', function() {
        confirmAgreementBtn.disabled = !this.checked;
    });

    // Confirm agreement button
    confirmAgreementBtn.addEventListener('click', function() {
        if (isSubmitting) return;
        
        // Set submitting flag
        isSubmitting = true;
        submitRequestBtn.disabled = true;
        submitRequestBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
        
        // Set agreement flag
        agreeConsultationFeeInput.value = '1';
        
        // Hide modal
        consultationFeeModal.hide();
        
        // Submit the form
        issuesForm.submit();
    });

    // Modal hidden event - reset modal state
    document.getElementById('consultationFeeModal').addEventListener('hidden.bs.modal', function () {
        modalAgreeCheckbox.checked = false;
        confirmAgreementBtn.disabled = true;
    });

    // Form validation - prevent direct form submission without modal
    issuesForm.addEventListener('submit', function(e) {
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

    // Initialize summary
    updateSummary();
});
</script>
@endpush