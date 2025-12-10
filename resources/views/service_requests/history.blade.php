@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <h3 class="mb-4">Service History</h3>
    <p class="text-muted mb-4">Track your previous service requests and monitor ongoing repairs.</p>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('service-requests.history') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                <option value="In Progress" {{ request('status')=='In Progress'?'selected':'' }}>In Progress</option>
                <option value="Completed" {{ request('status')=='Completed'?'selected':'' }}>Completed</option>
                <option value="Rejected" {{ request('status')=='Rejected'?'selected':'' }}>Rejected</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="device_id" class="form-select">
                <option value="">All Devices</option>
                @foreach($devices as $device)
                    <option value="{{ $device->id }}" {{ request('device_id')==$device->id?'selected':'' }}>
                        {{ $device->name }} ({{ $device->brand }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>
        <div class="col-md-2">
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- Service Requests Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if($serviceRequests->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Device</th>
                            <th>Status</th>
                            <th>Total Cost</th>
                            <th>Requested On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($serviceRequests as $request)
                        <tr>
                            <td>{{ $loop->iteration + ($serviceRequests->currentPage()-1)*$serviceRequests->perPage() }}</td>
                            <td>{{ $request->device->name ?? '-' }} ({{ $request->device->brand ?? '-' }})</td>
                            <td>
                                <span class="badge 
                                    {{ $request->status=='Pending'?'bg-warning' : 
                                       ($request->status=='In Progress'?'bg-info' :
                                       ($request->status=='Completed'?'bg-success':'bg-danger')) }}">
                                    {{ $request->status }}
                                </span>
                            </td>
                            <td>${{ number_format($request->total_cost, 2) }}</td>
                            <td>{{ $request->created_at->format('F j, Y') }}</td>
                            <td>
                                <a href="{{ route('service-requests.show', $request->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Enhanced Pagination Section -->
            @if($serviceRequests->hasPages())
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <!-- Results Info -->
                    <div class="mb-2">
                        <p class="text-muted small mb-0">
                            Showing 
                            <strong>{{ $serviceRequests->firstItem() ?? 0 }}</strong> 
                            to 
                            <strong>{{ $serviceRequests->lastItem() ?? 0 }}</strong> 
                            of 
                            <strong>{{ $serviceRequests->total() ?? 0 }}</strong> 
                            results
                        </p>
                    </div>

                    <!-- Pagination Links -->
                    <nav aria-label="Service requests pagination">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            <li class="page-item {{ $serviceRequests->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" 
                                   href="{{ $serviceRequests->previousPageUrl() ? $serviceRequests->previousPageUrl() : '#' }}" 
                                   aria-label="Previous"
                                   {{ $serviceRequests->onFirstPage() ? 'tabindex="-1" aria-disabled="true"' : '' }}>
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>

                            {{-- Pagination Elements --}}
                            @php
                                $current = $serviceRequests->currentPage();
                                $last = $serviceRequests->lastPage();
                                $start = max(1, $current - 2);
                                $end = min($last, $current + 2);
                            @endphp

                            {{-- First Page Link --}}
                            @if($start > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $serviceRequests->url(1) }}">1</a>
                                </li>
                                @if($start > 2)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                            @endif

                            {{-- Page Number Links --}}
                            @for ($i = $start; $i <= $end; $i++)
                                <li class="page-item {{ $i == $current ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $serviceRequests->url($i) }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor

                            {{-- Last Page Link --}}
                            @if($end < $last)
                                @if($end < $last - 1)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link" href="{{ $serviceRequests->url($last) }}">{{ $last }}</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            <li class="page-item {{ !$serviceRequests->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link" 
                                   href="{{ $serviceRequests->nextPageUrl() ? $serviceRequests->nextPageUrl() : '#' }}" 
                                   aria-label="Next"
                                   {{ !$serviceRequests->hasMorePages() ? 'tabindex="-1" aria-disabled="true"' : '' }}>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            @endif

            @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No service requests found.</p>
                    @if(auth()->user()->role->name === 'Customer')
                    <a href="{{ route('service-requests.select-device') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-2"></i>Create Your First Request
                    </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

</div>

<style>
/* Enhanced Pagination Styles */
.pagination .page-link {
    border: 1px solid #dee2e6;
    margin: 0 2px;
    border-radius: 4px;
    min-width: 38px;
    text-align: center;
}

.pagination .page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

.pagination .page-item:not(.active):not(.disabled) .page-link:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #f8f9fa;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.875rem;
        min-width: 32px;
    }
}
</style>
@endsection