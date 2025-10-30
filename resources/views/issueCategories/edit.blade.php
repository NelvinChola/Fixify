@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Category</h2>

    <form method="POST" action="{{ route('issueCategories.update', $issueCategory->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Issue Category Name <span class="text-danger">*</span></label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name', $issueCategory->name) }}" 
                required
            >
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea 
                id="description" 
                name="description" 
                class="form-control @error('description') is-invalid @enderror" 
                rows="4">{{ old('description', $issueCategory->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i> Update
        </button>
        <a href="{{ route('issueCategories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
