@extends('layouts.admin')

@section('content')
{{-- <div id="content-wrapper" class="d-flex flex-column"> --}}
    <div id="content">
        {{-- <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav> --}}
        
        <div class="container-fluid mt-5">
            <div class="d-flex justify-content-center">
                <div class="card shadow-lg w-100" style="max-width: 1200px;">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Product Details</h4>
                            <div class="btn-group">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-light">
                                    <i class="fas fa-edit me-2"></i>Edit
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-5">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <span class="text-muted">No image available</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-semibold">ID</div>
                                    <div class="col-md-9">{{ $product->id }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-semibold">Name</div>
                                    <div class="col-md-9">{{ $product->name }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-semibold">Category</div>
                                    <div class="col-md-9">{{ $product->category->name }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-semibold">Price</div>
                                    <div class="col-md-9">${{ number_format($product->price, 2) }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-semibold">In Stock</div>
                                    <div class="col-md-9">{{ $product->quantity }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="fw-semibold">Description</h5>
                                <div class="border-top pt-3">
                                    {{ $product->description ?? 'No description provided' }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Edit Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection