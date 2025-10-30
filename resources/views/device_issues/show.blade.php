@extends('layouts.admin')

@section('content')
<div class="container mt-5">

    <!-- Page Title -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Issue Details</h2>
        <p class="text-muted">Details of the selected issue</p>
    </div>

    <!-- Issue Card -->
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <h4 class="fw-bold text-dark mb-3">{{ $device_issue->issue }}</h4>
            
            <p class="text-muted mb-3">
                {{ $device_issue->description ?? 'No description provided.' }}
            </p>
            
            <p class="mb-1">
                <span class="fw-semibold text-secondary">Created At:</span> 
                <span class="text-dark">{{ $device_issue->created_at->format('Y-m-d H:i') }}</span>
            </p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <a href="{{ route('device_issues.index') }}" class="btn btn-outline-secondary px-4">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <div>
            <a href="{{ route('device_issues.edit', $device_issue) }}" class="btn btn-warning px-4 me-2">
                <i class="bi bi-pencil-square me-1"></i> Edit
            </a>
            <form action="{{ route('device_issues.destroy', $device_issue) }}" method="POST" class="d-inline" 
                  onsubmit="return confirm('Are you sure you want to delete this issue?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger px-4">
                    <i class="bi bi-trash3 me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
