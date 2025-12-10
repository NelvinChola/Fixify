@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-2 px-sm-3 mt-3">
        <!-- Header - Technical Theme -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <div>
                <h4 class="mb-0 text-dark fw-bold">
                    <i class="fas fa-bug me-2" style="color: #ef4444;"></i>Device Issues
                </h4>
                <p class="text-muted small mb-0 d-none d-md-block">Technical issue tracking and management</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @if (auth()->user()->role->name === 'Admin')
                    <a href="{{ route('issueCategories.index') }}"
                        class="btn btn-tech-info d-flex align-items-center gap-1 shadow-sm">
                        <i class="fas fa-tags"></i>
                        <span class="d-none d-sm-inline">Categories</span>
                        <span class="d-inline d-sm-none">Cats</span>
                    </a>
                @endif
                <a href="{{ route('device_issues.create') }}"
                    class="btn text-white d-flex align-items-center gap-1 shadow-sm"
                    style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);">
                    <i class="fas fa-plus-circle"></i>
                    <span class="d-none d-sm-inline">Add Issue</span>
                    <span class="d-inline d-sm-none">Add</span>
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-tech-success alert-dismissible fade show border-0 shadow-sm mb-3 py-2" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2" style="color: #10b981;"></i>
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
                    <i class="fas fa-list-check text-primary me-2" style="font-size: 1rem;"></i>
                    <h5 class="mb-0 fw-semibold text-dark" style="font-size: 0.95rem;">Issue Registry</h5>
                </div>
                <span class="badge bg-tech-primary text-white" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                    {{ $issues->total() }} Issues
                </span>
            </div>

            <!-- Desktop Table -->
            <div class="d-none d-lg-block">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(to right, #2d3748, #4a5568);">
                            <tr>
                                <th class="text-white py-2 px-3" style="border-top-left-radius: 8px; font-size: 0.875rem;">#
                                </th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i> Issue
                                </th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">
                                    <i class="fas fa-tag me-1"></i> Category
                                </th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">
                                    <i class="fas fa-align-left me-1"></i> Description
                                </th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">
                                    <i class="fas fa-calendar-alt me-1"></i> Created
                                </th>
                                <th class="text-white py-2 px-3 text-end"
                                    style="border-top-right-radius: 8px; font-size: 0.875rem;">
                                    <i class="fas fa-cogs me-1"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($issues as $issue)
                                <tr class="tech-table-row">
                                    <td class="py-2 px-3 fw-semibold text-dark" style="font-size: 0.875rem;">
                                        {{ $loop->iteration }}</td>
                                    <td class="py-2 px-3">
                                        <div class="fw-medium text-dark" style="font-size: 0.875rem;">
                                            <i class="fas fa-bug text-danger fa-xs me-1"></i>
                                            {{ $issue->issue }}
                                        </div>
                                    </td>
                                    <td class="py-2 px-3">
                                        <span class="badge bg-tech-blue text-white" style="font-size: 0.75rem;">
                                            {{ $issue->issueCategory->name }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <div class="issue-description small text-muted" style="max-width: 300px;">
                                            {{ Str::limit($issue->description, 80) }}
                                        </div>
                                    </td>
                                    <td class="py-2 px-3">
                                        <div class="small">
                                            <i class="far fa-calendar text-muted me-1"></i>
                                            {{ $issue->created_at->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="py-2 px-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('device_issues.show', $issue->id) }}"
                                                class="btn btn-sm btn-tech-info shadow-sm py-1 px-2">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-xl-inline ms-1">View</span>
                                            </a>
                                            <a href="{{ route('device_issues.edit', $issue->id) }}"
                                                class="btn btn-sm btn-tech-warning shadow-sm py-1 px-2">
                                                <i class="fas fa-edit"></i>
                                                <span class="d-none d-xl-inline ms-1">Edit</span>
                                            </a>
                                            <form action="{{ route('device_issues.destroy', $issue->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-tech-danger shadow-sm py-1 px-2"
                                                    onclick="return confirm('Are you sure you want to delete this issue?')">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="d-none d-xl-inline ms-1">Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-bug fa-3x mb-3" style="color: #cbd5e0;"></i>
                                            <h6 class="text-muted mb-2">No issues found</h6>
                                            <p class="text-muted small mb-0">Add your first device issue to get started</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tablet View (768px-991px) -->
            <div class="d-none d-md-block d-lg-none">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(to right, #2d3748, #4a5568);">
                            <tr>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">#</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">Issue</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">Category</th>
                                <th class="text-white py-2 px-3 text-end" style="font-size: 0.875rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($issues as $issue)
                                <tr class="tech-table-row">
                                    <td class="py-2 px-3 fw-semibold text-dark" style="font-size: 0.875rem;">
                                        {{ $loop->iteration }}</td>
                                    <td class="py-2 px-3">
                                        <div class="fw-medium text-dark" style="font-size: 0.875rem;">
                                            <i class="fas fa-bug text-danger fa-xs me-1"></i>
                                            {{ Str::limit($issue->issue, 30) }}
                                        </div>
                                        <div class="small text-muted mt-1">
                                            {{ Str::limit($issue->description, 40) }}
                                        </div>
                                        <div class="small text-muted mt-1">
                                            <i class="far fa-calendar fa-xs me-1"></i>
                                            {{ $issue->created_at->format('M d') }}
                                        </div>
                                    </td>
                                    <td class="py-2 px-3">
                                        <span class="badge bg-tech-blue text-white" style="font-size: 0.75rem;">
                                            {{ $issue->issueCategory->name }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('device_issues.show', $issue->id) }}"
                                                class="btn btn-sm btn-tech-info shadow-sm py-1 px-2">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('device_issues.edit', $issue->id) }}"
                                                class="btn btn-sm btn-tech-warning shadow-sm py-1 px-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('device_issues.destroy', $issue->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-tech-danger shadow-sm py-1 px-2"
                                                    onclick="return confirm('Delete this issue?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-bug fa-3x mb-3" style="color: #cbd5e0;"></i>
                                            <h6 class="text-muted mb-2">No issues found</h6>
                                            <p class="text-muted small mb-0">Add your first device issue to get started</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Cards -->
            <div class="d-block d-md-none">
                @forelse($issues as $issue)
                    <div class="border-bottom p-2 tech-mobile-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <span class="badge bg-tech-dark text-white small px-1 py-0" style="font-size: 0.65rem;">
                                    #{{ $loop->iteration }}
                                </span>
                                <h6 class="fw-semibold text-dark mb-0 mt-1" style="font-size: 0.9rem; line-height: 1.2;">
                                    <i class="fas fa-bug text-danger fa-xs me-1"></i>
                                    {{ Str::limit($issue->issue, 35) }}
                                </h6>
                            </div>
                            <span class="badge bg-tech-blue text-white"
                                style="font-size: 0.7rem; padding: 0.15rem 0.4rem;">
                                {{ $issue->issueCategory->name }}
                            </span>
                        </div>

                        <!-- Description -->
                        @if ($issue->description)
                            <div class="mb-2">
                                <div class="small text-muted" style="font-size: 0.8rem; line-height: 1.3;">
                                    {{ Str::limit($issue->description, 60) }}
                                </div>
                            </div>
                        @endif

                        <!-- Created Date -->
                        <div class="mb-3">
                            <div class="small text-muted" style="font-size: 0.75rem;">
                                <i class="far fa-calendar fa-xs me-1"></i>
                                {{ $issue->created_at->format('M d, Y') }}
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-1">
                            <a href="{{ route('device_issues.show', $issue->id) }}"
                                class="btn btn-tech-info shadow-sm flex-fill py-1 px-0"
                                style="font-size: 0.75rem; min-height: 32px;">
                                <i class="fas fa-eye fa-xs"></i>
                                <span class="ms-1">View</span>
                            </a>
                            <a href="{{ route('device_issues.edit', $issue->id) }}"
                                class="btn btn-tech-warning shadow-sm flex-fill py-1 px-0"
                                style="font-size: 0.75rem; min-height: 32px;">
                                <i class="fas fa-edit fa-xs"></i>
                                <span class="ms-1">Edit</span>
                            </a>
                            <form action="{{ route('device_issues.destroy', $issue->id) }}" method="POST"
                                class="d-inline flex-fill">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-tech-danger shadow-sm w-100 py-1 px-0"
                                    onclick="return confirm('Delete this issue?')"
                                    style="font-size: 0.75rem; min-height: 32px;">
                                    <i class="fas fa-trash fa-xs"></i>
                                    <span class="ms-1">Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 px-3">
                        <i class="fas fa-bug fa-3x mb-3" style="color: #cbd5e0;"></i>
                        <h6 class="text-muted mb-2">No issues found</h6>
                        <p class="text-muted small mb-3">Add your first device issue to get started</p>
                        <a href="{{ route('device_issues.create') }}"
                            class="btn text-white fw-medium shadow-sm px-3 py-2"
                            style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%); font-size: 0.875rem;">
                            <i class="fas fa-plus-circle me-1"></i> Add Issue
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($issues->hasPages())
                <div class="card-footer bg-transparent border-top py-2 px-3">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                        <div class="text-muted small text-center text-sm-start" style="font-size: 0.75rem;">
                            Showing {{ $issues->firstItem() ?? 0 }}-{{ $issues->lastItem() ?? 0 }} of
                            {{ $issues->total() }}
                        </div>
                        <div class="pagination-mobile">
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    {{-- Previous Page --}}
                                    @if ($issues->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">‹</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $issues->previousPageUrl() }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true">‹</span>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Current Page --}}
                                    <li class="page-item active">
                                        <span class="page-link">{{ $issues->currentPage() }}</span>
                                    </li>

                                    {{-- Next Page --}}
                                    @if ($issues->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $issues->nextPageUrl() }}" aria-label="Next">
                                                <span aria-hidden="true">›</span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">›</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Technical Color Scheme */
        :root {
            --tech-primary: #2d3748;
            --tech-secondary: #4a5568;
            --tech-accent: #3b82f6;
            --tech-info: #0ea5e9;
            --tech-warning: #f59e0b;
            --tech-danger: #ef4444;
            --tech-success: #10b981;
            --tech-gray: #f1f5f9;
            --tech-light: #f8fafc;
        }

        /* Technical Alert */
        .alert-tech-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-left: 4px solid var(--tech-success);
            color: #065f46;
            font-size: 0.875rem;
        }

        /* Technical Badges */
        .badge.bg-tech-primary {
            background: linear-gradient(135deg, var(--tech-primary) 0%, var(--tech-secondary) 100%);
            color: white;
        }

        .badge.bg-tech-blue {
            background: linear-gradient(135deg, var(--tech-accent) 0%, #60a5fa 100%);
            color: white;
        }

        .badge.bg-tech-dark {
            background-color: var(--tech-primary);
            color: white;
        }

        /* Technical Buttons */
        .btn-tech-info {
            background: linear-gradient(135deg, var(--tech-info) 0%, #38bdf8 100%);
            border: none;
            color: white;
        }

        .btn-tech-info:hover {
            background: linear-gradient(135deg, #0284c7 0%, var(--tech-info) 100%);
            color: white;
        }

        .btn-tech-warning {
            background: linear-gradient(135deg, var(--tech-warning) 0%, #fbbf24 100%);
            border: none;
            color: #78350f;
        }

        .btn-tech-warning:hover {
            background: linear-gradient(135deg, #d97706 0%, var(--tech-warning) 100%);
            color: #78350f;
        }

        .btn-tech-danger {
            background: linear-gradient(135deg, var(--tech-danger) 0%, #f87171 100%);
            border: none;
            color: white;
        }

        .btn-tech-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, var(--tech-danger) 100%);
            color: white;
        }

        /* Table Styling */
        .tech-table-row:hover {
            background: linear-gradient(to right, #f8fafc, #ffffff);
            box-shadow: inset 4px 0 0 0 var(--tech-danger);
        }

        /* Mobile Cards */
        .tech-mobile-card {
            background: white;
            transition: all 0.2s ease;
        }

        .tech-mobile-card:active {
            background-color: var(--tech-light);
        }

        /* Pagination Styling */
        .pagination-mobile .pagination {
            flex-wrap: wrap;
            justify-content: center;
            margin: 0;
        }

        .pagination-mobile .page-link {
            border-radius: 6px;
            margin: 0 2px;
            border: 1px solid #e2e8f0;
            color: var(--tech-primary);
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }

        .pagination-mobile .page-item.active .page-link {
            background: linear-gradient(135deg, var(--tech-primary) 0%, var(--tech-secondary) 100%);
            border-color: var(--tech-secondary);
            color: white;
        }

        .pagination-mobile .page-link:hover {
            background: var(--tech-gray);
            border-color: #cbd5e0;
        }

        /* Responsive Design */
        @media (max-width: 575.98px) {
            .container-fluid {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .tech-mobile-card {
                padding: 0.75rem;
            }

            .btn {
                font-size: 0.75rem !important;
                padding: 0.375rem 0.5rem !important;
            }

            .badge {
                font-size: 0.65rem !important;
            }
        }

        @media (min-width: 576px) and (max-width: 767.98px) {
            .tech-mobile-card {
                padding: 1rem;
            }

            .btn {
                font-size: 0.8125rem !important;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {

            .table th,
            .table td {
                padding: 0.75rem 0.5rem !important;
            }

            .btn-sm {
                padding: 0.25rem 0.375rem !important;
            }
        }

        @media (min-width: 992px) and (max-width: 1199.98px) {

            .table th,
            .table td {
                padding: 0.75rem 0.75rem !important;
            }

            .issue-description {
                max-width: 250px !important;
            }
        }

        @media (min-width: 1200px) {

            .table th,
            .table td {
                padding: 1rem !important;
            }

            .issue-description {
                max-width: 300px !important;
            }
        }

        /* Touch Optimization */
        @media (hover: none) and (pointer: coarse) {

            .btn,
            button {
                min-height: 44px;
            }

            .btn-sm {
                min-height: 36px;
            }

            .tech-table-row:hover {
                background: inherit;
            }
        }
    </style>
@endsection
