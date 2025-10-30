@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Device</h2>

    <form action="{{ route('devices.update', $device->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Device Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Device Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $device->name) }}" required>
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $device->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Device Issues -->
        <div class="mb-3">
            <label for="issues" class="form-label">Device Issues</label>
            <select name="issues[]" class="form-control" multiple>
                @foreach ($issues as $issue)
                    <option value="{{ $issue->id }}" 
                        {{ in_array($issue->id, $device->issues->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $issue->issue }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Device Image</label>
            <input type="file" name="image" class="form-control">
            @if($device->image)
                <img src="{{ asset('storage/' . $device->image) }}" alt="Device Image" width="120" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn text-white" style="background:#1e1e2d;">Update</button>
        <a href="{{ route('devices.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
