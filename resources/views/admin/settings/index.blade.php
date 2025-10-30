@extends('layouts.admin')

@section('content')
<div class="container my-5">
    <h3 class="fw-bold mb-4">System Settings</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" class="card p-4 shadow-sm border-0">
        @csrf
        <div class="mb-3">
            <label for="consultation_fee" class="form-label fw-semibold">Consultation Fee (ZMW)</label>
            <input type="number" step="0.01" name="consultation_fee" id="consultation_fee" 
                   class="form-control @error('consultation_fee') is-invalid @enderror" 
                   value="{{ old('consultation_fee', $consultation_fee) }}" required>

            @error('consultation_fee')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-2"></i> Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
