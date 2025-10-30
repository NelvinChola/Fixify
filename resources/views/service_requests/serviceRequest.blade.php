{{-- resources/views/service_requests/select-issues.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
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
                                        
                                        <div class="mt-3 p-3 bg-light rounded">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Select the issues that apply to your device. Prices are fixed.
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
                            <form action="{{ route('service-requests.store', $device->id) }}" method="POST" id="issuesForm">
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
                                                        $price = $issue->pivot->cost ?? 0;
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
                                                                        <span class="h6 text-success mb-0">${{ number_format($price, 2) }}</span>
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
                            Total Estimated Cost: $<span id="totalCost">0.00</span>
                        </p>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-lg bg-gradient-success" id="submitBtn" disabled>
                            <i class="fas fa-paper-plane me-2"></i>
                            Submit Request
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
.text-gradient {
    background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>
@endpush

@push('scripts')
<script>
// Simple, direct JavaScript - no dependencies
document.addEventListener('DOMContentLoaded', function() {
    console.log('💰 Starting real-time price calculator...');
    
    // Get the elements
    const selectedCountElement = document.getElementById('selectedCount');
    const totalCostElement = document.getElementById('totalCost');
    const submitButton = document.getElementById('submitBtn');
    const selectAllCheckbox = document.getElementById('selectAll');
    
    // Get all issue checkboxes
    const issueCheckboxes = document.querySelectorAll('input[type="checkbox"].issue-checkbox');
    
    console.log('Found:', {
        checkboxes: issueCheckboxes.length,
        selectedCount: selectedCountElement,
        totalCost: totalCostElement,
        submitBtn: submitButton,
        selectAll: selectAllCheckbox
    });
    
    // Function to calculate and update totals
    function updateTotals() {
        let selectedCount = 0;
        let totalCost = 0;
        
        // Loop through all checkboxes
        issueCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCount++;
                // Get price from data-price attribute
                const price = parseFloat(checkbox.getAttribute('data-price')) || 0;
                totalCost += price;
            }
        });
        
        console.log(`Selected: ${selectedCount}, Total: $${totalCost.toFixed(2)}`);
        
        // Update the display
        if (selectedCountElement) {
            selectedCountElement.textContent = selectedCount;
        }
        
        if (totalCostElement) {
            totalCostElement.textContent = totalCost.toFixed(2);
        }
        
        // Enable/disable submit button
        if (submitButton) {
            submitButton.disabled = selectedCount === 0;
        }
        
        // Update select all checkbox
        if (selectAllCheckbox) {
            if (selectedCount === issueCheckboxes.length) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else if (selectedCount > 0) {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = true;
            } else {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            }
        }
    }
    
    // Add event listeners to all checkboxes
    issueCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotals);
    });
    
    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            issueCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateTotals();
        });
    }
    
// Form validation
const form = document.getElementById('issuesForm');
if (form) {
    form.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('input[type="checkbox"].issue-checkbox:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one issue to submit your request.');
            return false;
        }
    });
}
    // Initial calculation
    updateTotals();
    console.log('✅ Real-time calculator ready!');
});
</script>
@endpush