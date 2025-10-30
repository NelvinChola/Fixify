@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <!-- Header -->
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $device->name }} Details</h4>
            <a href="{{ route('devices.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Devices
            </a>
        </div>

        <div class="card-body">
            <!-- Device Info -->
            <div class="row mb-4">
                <div class="col-md-4 text-center">
                    <img src="{{ asset('storage/' . $device->image) }}" 
                         alt="{{ $device->name }}" 
                         class="img-fluid rounded shadow mb-2" 
                         style="max-width: 250px;">
                    <p class="text-muted">Device Image</p>
                </div>
                <div class="col-md-8">
                    <h5 class="mb-3">Device Information</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Category:</strong> {{ $device->category->name }}</li>
                        <li class="list-group-item"><strong>Brand:</strong> {{ $device->brand ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Model:</strong> {{ $device->model ?? 'N/A' }}</li>
                    </ul>
                </div>
            </div>

            <!-- Assigned Issues -->
            <div class="mt-4">
                <h5>Assigned Issues</h5>
                @if($device->issues->isEmpty())
                    <p class="text-muted">No issues assigned to this device.</p>
                @else
                    <div class="row row-cols-1 row-cols-md-2 g-3">
                        @foreach($device->issues as $issue)
                            <div class="col">
                                <div class="card border-primary h-100 shadow-sm">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <span>{{ $issue->issue }}</span>
                                        <span class="badge bg-primary rounded-pill">
                                            ZMW {{ number_format($issue->pivot->cost, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Assign Issues Button -->
            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('devices.assign-issues', $device->id) }}" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i> Assign Issues
                </a>
                <a href="{{ route('devices.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Devices
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
