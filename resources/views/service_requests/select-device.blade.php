@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center fw-bold">Select a Device You Have Brought for Repair</h2>

    @if($devices->isEmpty())
        <div class="alert alert-info text-center">
            No devices available at the moment.
        </div>
    @else
        <div class="row">
            @foreach($devices as $device)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow-sm h-100 device-card">
                        
                        {{-- Device Image with Overlay --}}
                        <div class="card-image-container position-relative">
                            @if($device->image)
                                <img src="{{ Storage::url($device->image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $device->name }}"
                                     onerror="this.src='https://via.placeholder.com/300x200/6c757d/ffffff?text=No+Image'">
                            @else
                                <img src="https://via.placeholder.com/300x200/6c757d/ffffff?text=No+Image" 
                                     class="card-img-top" 
                                     alt="Default Device Image">
                            @endif
                            
                            {{-- Information Overlay --}}
                            <div class="card-info-overlay">
                                <h6 class="card-title mb-1 text-white fw-bold">
                                    {{ Str::limit($device->name, 20) }}
                                </h6>
                                <div class="device-info text-white">
                                    <small>
                                        <strong>Brand:</strong> {{ $device->brand ?? 'N/A' }} <br>
                                        <strong>Model:</strong> {{ $device->model ?? 'N/A' }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <small class="text-muted">
                                    <strong>Category:</strong> {{ $device->category->name ?? 'N/A' }}
                                </small>
                            </div>

                            {{-- Updated: Redirect to the select issues page --}}
                            <a href="{{ route('service-requests.select-issues', $device->id) }}" 
                               class="btn btn-primary btn-sm mt-auto w-100">
                                <i class="fas fa-check-circle me-1"></i> Select Device
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.device-card {
    transition: transform 0.2s ease-in-out;
    border: none;
    border-radius: 10px;
}

.device-card:hover {
    transform: translateY(-5px);
}

.card-image-container {
    height: 180px;
    overflow: hidden;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.card-image-container img {
    height: 100%;
    width: 100%;
    object-fit: cover;
}

.card-info-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    color: white;
    padding: 15px 15px 10px 15px;
    backdrop-filter: blur(2px);
}

.device-info {
    font-size: 0.75rem;
    line-height: 1.2;
}

.card-body {
    padding: 15px;
}

.card-title {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.btn-sm {
    padding: 0.4rem 0.75rem;
    font-size: 0.875rem;
}
</style>
@endsection
