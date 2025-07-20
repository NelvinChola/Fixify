@extends('layouts.admin')

@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
            </ol>
        </nav>
        
        <div class="container-fluid mt-5">
            <div class="d-flex justify-content-center">
                <div class="card shadow-lg w-100" style="max-width: 1200px;">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">User Details</h4>
                            <div class="btn-group">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-light">
                                    <i class="fas fa-edit me-2"></i>Edit
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body px-5">
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="avatar-placeholder bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; margin: 0 auto;">
                                    <span class="display-4 text-muted">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-semibold">ID</div>
                                    <div class="col-md-9">{{ $user->id }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-semibold">Name</div>
                                    <div class="col-md-9">{{ $user->name }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-semibold">Email</div>
                                    <div class="col-md-9">{{ $user->email }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-semibold">Role</div>
                                    <div class="col-md-9">{{ $user->role->name }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 fw-semibold">Registered</div>
                                    <div class="col-md-9">{{ $user->created_at->format('M d, Y H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Edit User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection