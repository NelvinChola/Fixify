@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-3">
                <!-- Header -->
                <div class="card-header text-center text-white fw-bold" style="background:#1e1e2d; font-size:1.2rem;">
                    Category Details
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <!-- Title + Icon -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width:50px; height:50px; font-size:1.2rem;">
                            <i class="bi bi-folder-fill"></i>
                        </div>
                        <h4 class="mb-0">{{ $category->name }}</h4>
                    </div>

                    <!-- Details list -->
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-semibold">ID:</span>
                            <span>{{ $category->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-semibold">Name:</span>
                            <span>{{ $category->name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-semibold">Description:</span>
                            <span>{{ $category->description ?? 'No description provided' }}</span>
                        </li>
                    </ul>

                    <!-- Buttons -->
                    <div class="text-end">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary me-2">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
