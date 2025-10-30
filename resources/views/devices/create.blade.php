@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Add Device</h2>

    <form action="{{ route('devices.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Category -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Device Name <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Brand -->
        <div class="mb-3">
            <label for="brand" class="form-label">Brand <span class="text-danger">*</span></label>
            <input type="text" id="brand" name="brand" class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand') }}" required>
            @error('brand')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Model -->
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" id="model" name="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model') }}">
            @error('model')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Device Image <span class="text-danger">*</span></label>
            <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" required>
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Actions -->
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('devices.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
