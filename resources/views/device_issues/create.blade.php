@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Add Device Issue</h2>
    <form action="{{ route('device_issues.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Issue Title</label>
            <input type="text" name="issue" class="form-control" value="{{ old('issue') }}" required>
            @error('title') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            @error('description') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
        <label for="issue_category_id" class="form-label">Issue Category</label>
        <select name="issue_category_id" id="issue_category_id" class="form-select" required>
        <option value="">-- Select Category --</option>
        @foreach($issueCategories as $IssueCategory)
          <option value="{{ $IssueCategory->issue_category_id }}" 
          {{ isset($device_issue) && $device_issue->issue_category_id == $IssueCategory->id ? 'selected' : '' }}>
          {{ $IssueCategory->name }}
      </option>

         @endforeach
        </select>
         </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('device_issues.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
