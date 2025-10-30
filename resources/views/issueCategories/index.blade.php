@extends('layouts.admin')

@section('content')
<div class="container-fluid py-5" style="background: #f4f6f9; min-height: 100vh;">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark mb-0">
            <i class="fas fa-layer-group text-primary me-2"></i>Issue Categories
        </h1>
        <a href="{{ route('issueCategories.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus"></i> Create New
        </a>
    </div>

    <!-- Success Alert -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Categories Grid -->
    <div class="row g-4">
        @forelse ($issueCategories as $issueCategory)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-3 hover-shadow transition">
                    <div class="card-body d-flex flex-column">
                        <!-- Title -->
                        <h5 class="card-title fw-bold text-dark">
                            {{ $issueCategory->name }}
                        </h5>
                        <!-- Description -->
                        <p class="card-text text-muted small mb-4">
                            {{ Str::limit($issueCategory->description, 80) }}
                        </p>

                        <!-- Actions -->
                        <div class="mt-auto d-flex justify-content-end gap-2">
                            <a href="{{ route('issueCategories.show', $issueCategory->id) }}" 
                               class="btn btn-sm btn-outline-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('issueCategories.edit', $issueCategory->id) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('issueCategories.destroy', $issueCategory->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">No categories found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $issueCategories->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
@endsection
