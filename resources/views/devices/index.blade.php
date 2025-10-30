@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h4>Devices</h4>
        <a href="{{ route('devices.create') }}" class="btn text-white" style="background:#1e1e2d;">
            <i class="fas fa-plus"></i> Add Device
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Model</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devices as $device)
                        <tr>
                            <td>{{ $device->id }}</td>
                            <td>
                                <img src="{{ asset('storage/'.$device->image) }}" alt="" width="60" class="rounded">
                            </td>
                            <td>{{ $device->name }}</td>
                            <td>{{ $device->brand }}</td>
                            <td>{{ $device->category->name }}</td>
                            <td>{{ $device->model }}</td>
                            <td>
                                <a href="{{ route('devices.show', $device) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('devices.edit', $device) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('devices.destroy', $device) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">No devices found</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $devices->links() }}</div>
        </div>
    </div>
</div>
@endsection
