@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Device Issues</h2>
        <div class="m-0">
        <a href="{{ route('issueCategories.index') }}" class="btn btn-info">View Issue Categories</a>
        <a href="{{ route('device_issues.create') }}" class="btn btn-primary">Add Issue</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Issue Title</th>
                <th>Issue category</th>
                <th>Description</th>
                <th>Created At</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($issues as $issue)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $issue->issue }}</td>
                    <td>{{ $issue->issueCategory->name }}</td>
                    <td>{{ Str::limit($issue->description, 50) }}</td>
                    <td>{{ $issue->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('device_issues.show', $issue->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('device_issues.edit', $issue->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('device_issues.destroy', $issue->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this issue?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No issues found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
