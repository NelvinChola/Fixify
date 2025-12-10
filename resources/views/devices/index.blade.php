@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-2 px-sm-3 mt-3">
        <!-- Header - Responsive -->
        <div class="d-flex flex-column gap-2 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-microchip me-2 d-none d-sm-inline" style="color: #2d3748; font-size: 1.25rem;"></i>
                    <h4 class="mb-0 fw-bold text-dark" style="font-size: 1.1rem;">
                        <span class="d-none d-sm-inline">Device Inventory</span>
                        <span class="d-inline d-sm-none">Devices</span>
                    </h4>
                </div>
                <a href="{{ route('devices.create') }}" class="btn text-white fw-medium shadow-sm px-3 py-2"
                    style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%); font-size: 0.875rem;">
                    <i class="fas fa-plus-circle me-1"></i>
                    <span class="d-none d-sm-inline">Add Device</span>
                    <span class="d-inline d-sm-none">Add</span>
                </a>
            </div>
            <p class="text-muted small mb-0 d-none d-md-block">Manage and monitor technical equipment</p>
        </div>

        @if (session('success'))
            <div class="alert alert-tech-success alert-dismissible fade show border-0 shadow-sm mb-3 py-2" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2" style="color: #10b981; font-size: 1rem;"></i>
                    <span class="flex-grow-1" style="font-size: 0.875rem;">{{ session('success') }}</span>
                    <button type="button" class="btn-close p-2" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        <!-- Main Card -->
        <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 10px;">
            <!-- Card Header -->
            <div class="card-header py-2 px-3 border-bottom d-flex justify-content-between align-items-center"
                style="background: linear-gradient(to right, #f8fafc, #ffffff);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-server me-2" style="color: #3b82f6; font-size: 1rem;"></i>
                    <h5 class="mb-0 fw-semibold text-dark" style="font-size: 0.95rem;">Devices List</h5>
                </div>
                <span class="badge bg-tech-primary text-white" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                    {{ $devices->total() }}
                </span>
            </div>

            <!-- Desktop Table (Hidden on Mobile, Shows on Tablet and Up) -->
            <div class="d-none d-lg-block"> <!-- CHANGED from d-md-block to d-lg-block -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(to right, #2d3748, #4a5568);">
                            <tr>
                                <th class="text-white py-2 px-3" style="border-top-left-radius: 8px; font-size: 0.875rem;">
                                    ID</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">
                                    <i class="fas fa-image me-1"></i> Image
                                </th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">
                                    <i class="fas fa-laptop me-1"></i> Device
                                </th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">
                                    <i class="fas fa-tag me-1"></i> Brand
                                </th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">
                                    <i class="fas fa-folder me-1"></i> Category
                                </th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">
                                    <i class="fas fa-hashtag me-1"></i> Model
                                </th>
                                <th class="text-white py-2 px-3 text-end"
                                    style="border-top-right-radius: 8px; font-size: 0.875rem;">
                                    <i class="fas fa-cogs me-1"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($devices as $device)
                                <tr class="tech-table-row">
                                    <td class="py-2 px-3 fw-semibold text-dark" style="font-size: 0.875rem;">
                                        {{ $device->id }}</td>
                                    <td class="py-2 px-3">
                                        <div class="device-img-container" style="width: 50px; height: 50px;">
                                            <img src="{{ asset('storage/' . $device->image) }}" alt="{{ $device->name }}"
                                                class="tech-device-img">
                                        </div>
                                    </td>
                                    <td class="py-2 px-3">
                                        <div class="fw-medium text-dark" style="font-size: 0.875rem;">{{ $device->name }}
                                        </div>
                                    </td>
                                    <td class="py-2 px-3">
                                        <span class="badge bg-tech-gray text-dark"
                                            style="font-size: 0.75rem;">{{ $device->brand }}</span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <span class="badge bg-tech-blue text-white"
                                            style="font-size: 0.75rem;">{{ $device->category->name }}</span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <code class="text-dark" style="font-size: 0.75rem;">{{ $device->model }}</code>
                                    </td>
                                    <td class="py-2 px-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('devices.show', $device) }}"
                                                class="btn btn-sm btn-tech-info shadow-sm py-1 px-2">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-xl-inline ms-1">View</span> <!-- Changed to xl -->
                                            </a>
                                            <a href="{{ route('devices.edit', $device) }}"
                                                class="btn btn-sm btn-tech-warning shadow-sm py-1 px-2">
                                                <i class="fas fa-edit"></i>
                                                <span class="d-none d-xl-inline ms-1">Edit</span> <!-- Changed to xl -->
                                            </a>
                                            <form action="{{ route('devices.destroy', $device) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-tech-danger shadow-sm py-1 px-2"
                                                    onclick="return confirm('Are you sure you want to delete this device?')">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="d-none d-xl-inline ms-1">Delete</span>
                                                    <!-- Changed to xl -->
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="py-3">
                                            <i class="fas fa-laptop-house fa-2x mb-2" style="color: #cbd5e0;"></i>
                                            <h6 class="text-muted mb-1">No devices found</h6>
                                            <p class="text-muted small mb-0">Add your first device to get started</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tablet View (768px to 991px) - Shows simplified table -->
            <div class="d-none d-md-block d-lg-none"> <!-- ADDED: Shows only on medium screens -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(to right, #2d3748, #4a5568);">
                            <tr>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">ID</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">Device</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">Brand</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">Category</th>
                                <th class="text-white py-2 px-3 text-end" style="font-size: 0.875rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($devices as $device)
                                <tr class="tech-table-row">
                                    <td class="py-2 px-3 fw-semibold text-dark" style="font-size: 0.875rem;">
                                        {{ $device->id }}</td>
                                    <td class="py-2 px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="device-img-container" style="width: 40px; height: 40px;">
                                                <img src="{{ asset('storage/' . $device->image) }}"
                                                    alt="{{ $device->name }}" class="tech-device-img">
                                            </div>
                                            <div>
                                                <div class="fw-medium text-dark" style="font-size: 0.875rem;">
                                                    {{ $device->name }}</div>
                                                <div class="text-muted small">{{ $device->model }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 px-3">
                                        <span class="badge bg-tech-gray text-dark"
                                            style="font-size: 0.75rem;">{{ $device->brand }}</span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <span class="badge bg-tech-blue text-white"
                                            style="font-size: 0.75rem;">{{ $device->category->name }}</span>
                                    </td>
                                    <td class="py-2 px-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('devices.show', $device) }}"
                                                class="btn btn-sm btn-tech-info shadow-sm py-1 px-2">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('devices.edit', $device) }}"
                                                class="btn btn-sm btn-tech-warning shadow-sm py-1 px-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('devices.destroy', $device) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-tech-danger shadow-sm py-1 px-2"
                                                    onclick="return confirm('Are you sure you want to delete this device?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="py-3">
                                            <i class="fas fa-laptop-house fa-2x mb-2" style="color: #cbd5e0;"></i>
                                            <h6 class="text-muted mb-1">No devices found</h6>
                                            <p class="text-muted small mb-0">Add your first device to get started</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Cards (Visible only on Mobile) -->
            <div class="d-block d-md-none"> <!-- CHANGED: Shows only on small screens -->
                @forelse($devices as $device)
                    <div class="border-bottom p-2 tech-mobile-card">
                        <div class="d-flex align-items-start gap-2">
                            <!-- Device Image -->
                            <div class="device-img-mobile">
                                <img src="{{ asset('storage/' . $device->image) }}" alt="{{ $device->name }}"
                                    class="tech-device-img-mobile rounded"
                                    style="width: 70px; height: 70px; object-fit: cover; border: 2px solid #e2e8f0;">
                            </div>

                            <!-- Device Info -->
                            <div class="flex-grow-1">
                                <!-- Header with ID and Name -->
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <div>
                                        <span class="badge bg-tech-dark text-white small px-1 py-0"
                                            style="font-size: 0.65rem;">
                                            #{{ $device->id }}
                                        </span>
                                        <h6 class="fw-semibold text-dark mb-0 mt-1"
                                            style="font-size: 0.9rem; line-height: 1.2;">
                                            {{ Str::limit($device->name, 25) }}
                                        </h6>
                                    </div>
                                </div>

                                <!-- Brand and Category -->
                                <div class="mb-2">
                                    <span class="badge bg-tech-gray text-dark me-1 mb-1"
                                        style="font-size: 0.7rem; padding: 0.15rem 0.4rem;">
                                        {{ $device->brand }}
                                    </span>
                                    <span class="badge bg-tech-blue text-white"
                                        style="font-size: 0.7rem; padding: 0.15rem 0.4rem;">
                                        {{ $device->category->name }}
                                    </span>
                                </div>

                                <!-- Model -->
                                <div class="mb-2">
                                    <div class="text-muted small" style="font-size: 0.8rem;">
                                        <i class="fas fa-hashtag fa-xs me-1"></i>
                                        <code
                                            style="font-size: 0.75rem; background: none; padding: 0;">{{ $device->model }}</code>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-1 mt-2">
                                    <a href="{{ route('devices.show', $device) }}"
                                        class="btn btn-tech-info shadow-sm flex-fill py-1 px-0"
                                        style="font-size: 0.75rem; min-height: 32px;">
                                        <i class="fas fa-eye fa-xs"></i>
                                        <span class="ms-1">View</span>
                                    </a>
                                    <a href="{{ route('devices.edit', $device) }}"
                                        class="btn btn-tech-warning shadow-sm flex-fill py-1 px-0"
                                        style="font-size: 0.75rem; min-height: 32px;">
                                        <i class="fas fa-edit fa-xs"></i>
                                        <span class="ms-1">Edit</span>
                                    </a>
                                    <form action="{{ route('devices.destroy', $device) }}" method="POST"
                                        class="d-inline flex-fill">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-tech-danger shadow-sm w-100 py-1 px-0"
                                            onclick="return confirm('Delete this device?')"
                                            style="font-size: 0.75rem; min-height: 32px;">
                                            <i class="fas fa-trash fa-xs"></i>
                                            <span class="ms-1">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 px-3">
                        <i class="fas fa-laptop-house fa-2x mb-2" style="color: #cbd5e0;"></i>
                        <h6 class="text-muted mb-1">No devices found</h6>
                        <p class="text-muted small mb-3">Add your first device to get started</p>
                        <a href="{{ route('devices.create') }}" class="btn text-white fw-medium shadow-sm px-3 py-2"
                            style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%); font-size: 0.875rem;">
                            <i class="fas fa-plus-circle me-1"></i> Add Device
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($devices->hasPages())
                <div class="card-footer bg-transparent border-top py-2 px-3">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                        <div class="text-muted small text-center text-sm-start" style="font-size: 0.75rem;">
                            Showing {{ $devices->firstItem() ?? 0 }}-{{ $devices->lastItem() ?? 0 }} of
                            {{ $devices->total() }}
                        </div>
                        <div class="pagination-mobile">
                            {{ $devices->onEachSide(0)->links('vendor.pagination.bootstrap-5-sm') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Technical Color Variables */
        :root {
            --tech-primary: #2d3748;
            --tech-secondary: #4a5568;
            --tech-accent: #3b82f6;
            --tech-info: #0ea5e9;
            --tech-warning: #f59e0b;
            --tech-danger: #ef4444;
            --tech-gray: #f1f5f9;
            --tech-light: #f8fafc;
        }

        /* === RESPONSIVE BREAKPOINTS CORRECTED === */

        /* Bootstrap 5 Breakpoints:
               - xs: < 576px (Mobile portrait)
               - sm: ≥ 576px (Mobile landscape / Small phones)
               - md: ≥ 768px (Tablets)
               - lg: ≥ 992px (Laptops / Small desktops)
               - xl: ≥ 1200px (Desktops)
               - xxl: ≥ 1400px (Large desktops)
            */

        /* Mobile (< 576px) */
        @media (max-width: 575.98px) {
            .container-fluid {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .tech-mobile-card {
                padding: 0.75rem;
            }

            .device-img-mobile img {
                width: 60px !important;
                height: 60px !important;
            }
        }

        /* Small (576px - 767px) - Phones landscape / Small tablets */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .tech-mobile-card {
                padding: 1rem;
            }
        }

        /* Medium (768px - 991px) - Tablets */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .container-fluid {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            /* Tablet table optimization */
            .table-responsive {
                overflow-x: auto;
            }

            .table th,
            .table td {
                padding: 0.75rem 0.5rem !important;
                white-space: nowrap;
            }

            .device-img-container {
                width: 40px !important;
                height: 40px !important;
            }

            .btn-sm {
                padding: 0.25rem 0.375rem !important;
            }
        }

        /* Large (992px - 1199px) - Laptops */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .container-fluid {
                padding-left: 2rem;
                padding-right: 2rem;
            }

            /* Laptop table optimization */
            .table th,
            .table td {
                padding: 0.75rem 0.75rem !important;
            }

            .device-img-container {
                width: 50px !important;
                height: 50px !important;
            }

            /* Show button text on laptops */
            .btn-sm span {
                display: inline !important;
            }
        }

        /* Extra Large (≥ 1200px) - Desktops */
        @media (min-width: 1200px) {
            .container-fluid {
                padding-left: 2.5rem;
                padding-right: 2.5rem;
            }

            .table th,
            .table td {
                padding: 1rem !important;
            }

            .device-img-container {
                width: 60px !important;
                height: 60px !important;
            }
        }

        /* Technical styles */
        .alert-tech-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-left: 4px solid #10b981;
            color: #065f46;
        }

        .badge.bg-tech-primary {
            background: linear-gradient(135deg, var(--tech-primary) 0%, var(--tech-secondary) 100%);
            color: white;
        }

        .badge.bg-tech-blue {
            background: linear-gradient(135deg, var(--tech-accent) 0%, #60a5fa 100%);
            color: white;
        }

        .badge.bg-tech-gray {
            background-color: var(--tech-gray);
            color: var(--tech-primary);
            border: 1px solid #e2e8f0;
        }

        .badge.bg-tech-dark {
            background-color: var(--tech-primary);
            color: white;
        }

        .btn-tech-info {
            background: linear-gradient(135deg, var(--tech-info) 0%, #38bdf8 100%);
            border: none;
            color: white;
        }

        .btn-tech-warning {
            background: linear-gradient(135deg, var(--tech-warning) 0%, #fbbf24 100%);
            border: none;
            color: #78350f;
        }

        .btn-tech-danger {
            background: linear-gradient(135deg, var(--tech-danger) 0%, #f87171 100%);
            border: none;
            color: white;
        }

        .tech-table-row:hover {
            background: linear-gradient(to right, #f8fafc, #ffffff);
        }

        /* Image containers */
        .device-img-container,
        .device-img-mobile img {
            overflow: hidden;
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            background: var(--tech-light);
        }

        .tech-device-img,
        .tech-device-img-mobile {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Pagination */
        .pagination-mobile .pagination {
            flex-wrap: wrap;
            justify-content: center;
            gap: 2px;
        }

        .pagination-mobile .page-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            min-width: 32px;
        }
    </style>
@endsection
