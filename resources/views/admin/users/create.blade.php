@extends('layouts.admin')

@section('content')
<div id="content">
    <div class="container-fluid mt-5">
        <div class="d-flex justify-content-center">
            <div class="card shadow-lg w-100 border-0" style="max-width: 1200px;">
                <!-- Header with Fixify dark color -->
                <div class="card-header" style="background: #1e1e2d; color: white;">
                    <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Create New User</h4>
                </div>

                <div class="card-body px-5 py-4 bg-light">
                    <!-- Global Error Alert -->
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <h5 class="alert-heading">
                                <i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:
                            </h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li><strong>{{ $error }}</strong></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Session Messages -->
                    @if(session('error'))
                        <div class="alert alert-danger mb-4">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Error:</strong> {{ session('error') }}
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Notice:</strong> {{ session('warning') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Success:</strong> {{ session('success') }}
                        </div>
                    @endif

                    <!-- Information Alert -->
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Important:</strong> The user will receive an email with verification link and temporary login credentials.
                    </div>

                    <form action="{{ route('users.store') }}" method="POST" id="userForm">
                        @csrf

                        <!-- Full Name -->
                        <div class="row mb-4 align-items-start">
                            <label for="name" class="col-md-3 col-form-label fw-semibold text-dark">Full Name*</label>
                            <div class="col-md-9">
                                <input type="text" id="name" class="form-control shadow-sm @error('name') is-invalid @enderror" 
                                    name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="row mb-4 align-items-start">
                            <label for="email" class="col-md-3 col-form-label fw-semibold text-dark">Email*</label>
                            <div class="col-md-9">
                                <input type="email" id="email" class="form-control shadow-sm @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                                <small class="form-text text-muted mt-1">
                                    <i class="fas fa-envelope me-1"></i>Verification email will be sent to this address
                                </small>
                            </div>
                        </div>

                        <!-- Contact -->
                        <div class="row mb-4 align-items-start">
                            <label for="contact" class="col-md-3 col-form-label fw-semibold text-dark">Contact*</label>
                            <div class="col-md-9">
                                <input type="text" id="contact" class="form-control shadow-sm @error('contact') is-invalid @enderror" 
                                    name="contact" value="{{ old('contact') }}" required>
                                @error('contact')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- NRC -->
                        <div class="row mb-4 align-items-start">
                            <label for="nrc" class="col-md-3 col-form-label fw-semibold text-dark">NRC</label>
                            <div class="col-md-9">
                                <input type="text" id="nrc" class="form-control shadow-sm @error('nrc') is-invalid @enderror" 
                                    name="nrc" value="{{ old('nrc') }}">
                                @error('nrc')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="row mb-4 align-items-start">
                            <label for="address" class="col-md-3 col-form-label fw-semibold text-dark">Address</label>
                            <div class="col-md-9">
                                <input type="text" id="address" class="form-control shadow-sm @error('address') is-invalid @enderror" 
                                    name="address" value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="row mb-4 align-items-start">
                            <div class="col-md-3">
                                <label class="col-form-label fw-semibold text-dark">Password Setup</label>
                            </div>
                            <div class="col-md-9">
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-key me-2"></i>
                                    <strong>Automatic Password Generation:</strong> A secure temporary password will be automatically generated and sent to the user via email.
                                </div>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="row mb-4 align-items-start">
                            <label for="role_id" class="col-md-3 col-form-label fw-semibold text-dark">Role*</label>
                            <div class="col-md-9">
                                <select id="role_id" class="form-select shadow-sm @error('role_id') is-invalid @enderror" 
                                    name="role_id" required>
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i><strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn text-white" style="background:#1e1e2d;" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Error Details Modal (for debugging) -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel">
                    <i class="fas fa-bug me-2"></i>Error Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <pre id="errorDetails" class="bg-dark text-light p-3 rounded" style="font-size: 12px; max-height: 400px; overflow-y: auto;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.form-check-input:checked {
    background-color: #1e1e2d;
    border-color: #1e1e2d;
}

.alert {
    border-left: 4px solid;
}

.alert-info {
    border-left-color: #0dcaf0;
}

.alert-warning {
    border-left-color: #ffc107;
}

.alert-danger {
    border-left-color: #dc3545;
}

.alert-success {
    border-left-color: #198754;
}

.invalid-feedback {
    display: block;
    font-weight: 500;
}

/* Make error states more visible */
.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('userForm');
    const submitBtn = document.getElementById('submitBtn');

    // Enhanced form submission
    form.addEventListener('submit', function(e) {
        // Basic validation
        const email = document.getElementById('email').value;
        const role = document.getElementById('role_id').value;
        const name = document.getElementById('name').value;
        const contact = document.getElementById('contact').value;
        
        if (!email || !role || !name || !contact) {
            e.preventDefault();
            alert('Please fill in all required fields (marked with *).');
            return;
        }
        
        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating User...';
        submitBtn.disabled = true;
        
        // Add a small delay to ensure the button state is visible
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Create User';
        }, 5000);
    });

    // Check for console errors and display them
    window.addEventListener('error', function(e) {
        console.error('Page error:', e.error);
        document.getElementById('errorDetails').textContent = 
            'Error: ' + e.error.toString() + '\n' +
            'URL: ' + e.filename + '\n' +
            'Line: ' + e.lineno + '\n' +
            'Column: ' + e.colno;
        new bootstrap.Modal(document.getElementById('errorModal')).show();
    });

    // Log form data for debugging
    form.addEventListener('submit', function(e) {
        const formData = new FormData(form);
        console.log('Form data being submitted:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
    });

    // Auto-remove alerts after 10 seconds
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (!alert.classList.contains('alert-danger')) {
                const fade = new bootstrap.Alert(alert);
                fade.close();
            }
        });
    }, 10000);
});
</script>

<!-- Debug script to catch PHP errors -->
<script>
// Try to catch any initialization errors
try {
    console.log('Page loaded successfully');
    console.log('Roles count: {{ $roles->count() }}');
    console.log('Form action: {{ route('users.store') }}');
} catch (error) {
    console.error('Initialization error:', error);
    document.getElementById('errorDetails').textContent = error.toString();
    new bootstrap.Modal(document.getElementById('errorModal')).show();
}
</script>
@endsection