@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Device Issue</h2>
    <form action="{{ route('device_issues.update', $device_issue) }}" method="POST">
        @csrf 
        @method('PUT')

        <!-- Issue Title -->
        <div class="mb-3">
            <label class="form-label">Issue Title</label>
            <input 
                type="text" 
                name="issue" 
                class="form-control" 
                value="{{ old('issue', $device_issue->issue) }}" 
                required>
            @error('issue') 
                <div class="text-danger">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea 
                name="description" 
                class="form-control" 
                rows="4">{{ old('description', $device_issue->description) }}</textarea>
            @error('description') 
                <div class="text-danger">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Issue Category -->
        <div class="mb-3">
            <label for="issue_category_id" class="form-label">Issue Category</label>
            <select name="issue_category_id" id="issue_category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach($issueCategories as $issueCategory)
                    <option value="{{ $issueCategory->id }}" 
                        {{ old('issue_category_id', $device_issue->issue_category_id) == $issueCategory->id ? 'selected' : '' }}>
                        {{ $issueCategory->name }}
                    </option>
                @endforeach
            </select>
            @error('issue_category_id') 
                <div class="text-danger">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Actions -->
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('device_issues.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
