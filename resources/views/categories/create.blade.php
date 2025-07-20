@extends('layouts.admin')

@section('content')

<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
       
        <div class="container-fluid mt-5">
    <div class="d-flex justify-content-center">
        <div class="card shadow-lg w-100" style="max-width: 1200px;">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Create New Category</h4>
            </div>

            <div class="card-body px-5">
                <form action="{{ route('categories.store') }}" method="POST">
                      
                    @csrf

                    <div class="row mb-4 align-items-start">
                        <label for="name" class="col-md-3 col-form-label fw-semibold">Category Name*</label>
                        <div class="col-md-9">
                               
                            <input 
                                type="text" 
                                id="name" 
                                class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        
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
                                id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                           
                                     @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>


@endsection