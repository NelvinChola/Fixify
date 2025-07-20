@extends('layouts.admin')

@section('content')

    <div id="content">
        {{-- <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Product</li>
            </ol>
        </nav> --}}
        
        <div class="container-fluid mt-5">
            <div class="d-flex justify-content-center">
                <div class="card shadow-lg w-100" style="max-width: 1200px;">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Create New Product</h4>
                    </div>

                    <div class="card-body px-5">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-4 align-items-start">
                                <label for="name" class="col-md-3 col-form-label fw-semibold">Product Name*</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        id="name" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        name="name" 
                                        value="{{ old('name') }}" 
                                        required>
                                    
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
                                        name="description">{{ old('description') }}</textarea>
                                    
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4 align-items-start">
                                <label for="price" class="col-md-3 col-form-label fw-semibold">Price*</label>
                                <div class="col-md-9">
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        min="0" 
                                        id="price" 
                                        class="form-control @error('price') is-invalid @enderror" 
                                        name="price" 
                                        value="{{ old('price') }}" 
                                        required>
                                    
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4 align-items-start">
                                <label for="quantity" class="col-md-3 col-form-label fw-semibold">Quantity*</label>
                                <div class="col-md-9">
                                    <input 
                                        type="number" 
                                        min="0" 
                                        id="quantity" 
                                        class="form-control @error('quantity') is-invalid @enderror" 
                                        name="quantity" 
                                        value="{{ old('quantity', 0) }}" 
                                        required>
                                    
                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4 align-items-start">
                                <label for="category_id" class="col-md-3 col-form-label fw-semibold">Category*</label>
                                <div class="col-md-9">
                                    <select 
                                        id="category_id" 
                                        class="form-control @error('category_id') is-invalid @enderror" 
                                        name="category_id" 
                                        required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4 align-items-start">
                                <label for="image" class="col-md-3 col-form-label fw-semibold">Product Image</label>
                                <div class="col-md-9">
                                    <input 
                                        type="file" 
                                        id="image" 
                                        class="form-control @error('image') is-invalid @enderror" 
                                        name="image">
                                    
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection