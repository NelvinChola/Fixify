@extends('layouts.admin')

@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">
        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit {{ $user->name }}</li>
            </ol>
        </nav>
        
        <div class="container-fluid mt-5">
            <div class="d-flex justify-content-center">
                <div class="card shadow-lg w-100" style="max-width: 1200px;">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit User: {{ $user->name }}</h4>
                    </div>

                    <div class="card-body px-5">
                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4 align-items-start">
                                <label for="name" class="col-md-3 col-form-label fw-semibold">Full Name*</label>
                                <div class="col-md-9">
                                    <input 
                                        type="text" 
                                        id="name" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        name="name" 
                                        value="{{ old('name', $user->name) }}" 
                                        required>
                                    
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4 align-items-start">
                                <label for="email" class="col-md-3 col-form-label fw-semibold">Email*</label>
                                <div class="col-md-9">
                                    <input 
                                        type="email" 
                                        id="email" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        name="email" 
                                        value="{{ old('email', $user->email) }}" 
                                        required>
                                    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4 align-items-start">
                                <label for="password" class="col-md-3 col-form-label fw-semibold">Password</label>
                                <div class="col-md-9">
                                    <input 
                                        type="password" 
                                        id="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        name="password">
                                    <small class="text-muted">Leave blank to keep current password</small>
                                    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4 align-items-start">
                                <label for="password-confirm" class="col-md-3 col-form-label fw-semibold">Confirm Password</label>
                                <div class="col-md-9">
                                    <input 
                                        type="password" 
                                        id="password-confirm" 
                                        class="form-control" 
                                        name="password_confirmation">
                                </div>
                            </div>

                            <div class="row mb-4 align-items-start">
                                <label for="role_id" class="col-md-3 col-form-label fw-semibold">Role*</label>
                                <div class="col-md-9">
                                    <select 
                                        id="role_id" 
                                        class="form-control @error('role_id') is-invalid @enderror" 
                                        name="role_id" 
                                        required>
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection