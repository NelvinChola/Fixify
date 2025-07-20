@extends('layouts.admin')

@section('content')

    <div id="content">
        {{-- <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
            </ol>
        </nav> --}}
        
        <div class="container-fluid mt-5">
            <div class="d-flex justify-content-center">
                <div class="card shadow-lg w-100" style="max-width: 1200px;">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Category: {{ $category->name }}</h4>
                    </div>

                    <div class="card-body px-5">
                        <form method="POST" action="{{ route('categories.update', $category->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4 align-items-start">
                                <label for="name" class="col-md-3 col-form-label fw-semibold">Category Name*</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        id="name" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        name="name" 
                                        value="{{ old('name', $category->name) }}" 
                                        required 
                                        autocomplete="name" 
                                        autofocus>
                                    
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4 align-items-start">
                                <label for="description" class="col-md-3 col-form-label fw-semibold">Description</label>
                                <div class="col-md-9">
                                    <textarea 
                                        id="description" 
                                        class="form-control @error('description') is-invalid @enderror" 
                                        name="description"
                                        rows="4">{{ old('description', $category->description) }}</textarea>
                                    
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection