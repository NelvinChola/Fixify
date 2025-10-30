@extends('layouts.admin')

@section('content')
    <div id="content">
        
        <div class="container-fluid mt-5">
            <div class="d-flex justify-content-center">
                <div class="card shadow-lg w-100" style="max-width: 1200px;">
                    <div class="card-header text-white" style="background:#1e1e2d;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Users Management</h4>
                            <a href="{{ route('users.create') }}" class="btn btn-light">
                                <i class="fas fa-plus me-2"></i>Add User
                            </a>
                        </div>
                    </div>

                    <div class="card-body px-5">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                    
                                                </a>
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection