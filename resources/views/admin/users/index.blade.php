@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-2 px-sm-3 mt-3">
        <!-- Header - Responsive -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
            <div>
                <h4 class="mb-0 text-dark fw-bold" style="font-size: 1.1rem;">
                    <i class="fas fa-user-shield me-2 d-none d-sm-inline" style="color: #2d3748;"></i>
                    <span class="d-none d-sm-inline">User Management</span>
                    <span class="d-inline d-sm-none">Users</span>
                </h4>
                <p class="text-muted small mb-0 d-none d-md-block">Administrative user control and permissions</p>
            </div>
            <a href="{{ route('users.create') }}" class="btn text-white d-flex align-items-center gap-1 shadow-sm px-3 py-2"
                style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%); font-size: 0.875rem;">
                <i class="fas fa-user-plus"></i>
                <span class="d-none d-sm-inline">Add User</span>
                <span class="d-inline d-sm-none">Add</span>
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-tech-success alert-dismissible fade show border-0 shadow-sm mb-3 py-2" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2" style="color: #10b981; font-size: 1rem;"></i>
                    <span class="flex-grow-1" style="font-size: 0.875rem;">{{ session('success') }}</span>
                    <button type="button" class="btn-close p-2" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        <!-- Stats Cards - Responsive Grid -->
        <div class="row g-2 g-sm-3 mb-3 mb-md-4">
            <div class="col-6 col-sm-4 col-md-3 col-lg">
                <div class="stat-card admin-card bg-admin-gradient">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $users->total() }}</h3>
                        <p class="stat-label">Total</p>
                        <small class="stat-trend">All Users</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg">
                <div class="stat-card admin-card bg-admin-primary">
                    <div class="stat-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $users->where('role.name', 'Admin')->count() }}</h3>
                        <p class="stat-label">Admins</p>
                        <small class="stat-trend">System admins</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg">
                <div class="stat-card admin-card bg-admin-warning">
                    <div class="stat-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $users->where('role.name', 'Technician')->count() }}</h3>
                        <p class="stat-label">Techs</p>
                        <small class="stat-trend">Technical staff</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg">
                <div class="stat-card admin-card bg-admin-info">
                    <div class="stat-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $users->where('role.name', 'HelpDesk')->count() }}</h3>
                        <p class="stat-label">Helpdesk</p>
                        <small class="stat-trend">Support staff</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-3 col-lg">
                <div class="stat-card admin-card bg-admin-secondary">
                    <div class="stat-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $users->where('role.name', 'Customer')->count() }}</h3>
                        <p class="stat-label">Customers</p>
                        <small class="stat-trend">Clients</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 10px;">
            <!-- Card Header -->
            <div class="card-header py-2 px-3 border-bottom d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2"
                style="background: linear-gradient(to right, #f8fafc, #ffffff);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-users-cog text-primary me-2" style="font-size: 1rem;"></i>
                    <h5 class="mb-0 fw-semibold text-dark" style="font-size: 0.95rem;">User Directory</h5>
                </div>
                <div class="d-flex align-items-center gap-2 w-100 w-sm-auto">
                    <div class="input-group input-group-sm flex-grow-1 flex-sm-grow-0" style="max-width: 250px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search users..."
                            id="searchUsers">
                    </div>
                    <span class="badge bg-tech-primary text-white d-none d-sm-inline"
                        style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                        {{ $users->total() }}
                    </span>
                </div>
            </div>

            <!-- Desktop Table (Large screens) -->
            <div class="d-none d-lg-block">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(to right, #2d3748, #4a5568);">
                            <tr>
                                <th class="text-white py-2 px-3" style="border-top-left-radius: 8px; font-size: 0.875rem;">
                                    ID</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">User</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">Email</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">Role</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">Created</th>
                                <th class="text-white py-2 px-3 text-end"
                                    style="border-top-right-radius: 8px; font-size: 0.875rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    $roleColors = [
                                        'Admin' => 'danger',
                                        'Technician' => 'warning',
                                        'Helpdesk' => 'info',
                                        'Customer' => 'secondary',
                                    ];
                                    $roleColor = $roleColors[$user->role->name] ?? 'secondary';
                                    $avatarColors = [
                                        'Admin' => '#ef4444',
                                        'Technician' => '#f59e0b',
                                        'Helpdesk' => '#0ea5e9',
                                        'Customer' => '#6b7280',
                                    ];
                                    $avatarColor = $avatarColors[$user->role->name] ?? '#6b7280';
                                @endphp
                                <tr class="admin-table-row">
                                    <td class="py-2 px-3 fw-semibold text-dark" style="font-size: 0.875rem;">
                                        {{ $user->id }}</td>
                                    <td class="py-2 px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar">
                                                <div class="avatar-placeholder"
                                                    style="background-color: {{ $avatarColor }};">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-medium text-dark" style="font-size: 0.875rem;">
                                                    {{ $user->name }}</div>
                                                @if ($user->last_login_at)
                                                    <small class="text-muted">
                                                        <i class="fas fa-sign-in-alt fa-xs me-1"></i>
                                                        {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 px-3">
                                        <div class="small text-truncate" style="max-width: 200px;">
                                            <i class="fas fa-envelope fa-xs text-muted me-1"></i>
                                            {{ $user->email }}
                                        </div>
                                    </td>
                                    <td class="py-2 px-3">
                                        <span
                                            class="badge bg-{{ $roleColor }} bg-opacity-10 text-{{ $roleColor }} border border-{{ $roleColor }} border-opacity-25">
                                            {{ $user->role->name }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <div class="small">
                                            <i class="far fa-calendar text-muted me-1"></i>
                                            {{ $user->created_at->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="py-2 px-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('users.show', $user->id) }}"
                                                class="btn btn-sm btn-tech-info shadow-sm py-1 px-2">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-xl-inline ms-1">View</span>
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-sm btn-tech-warning shadow-sm py-1 px-2">
                                                <i class="fas fa-edit"></i>
                                                <span class="d-none d-xl-inline ms-1">Edit</span>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-tech-danger shadow-sm py-1 px-2"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="d-none d-xl-inline ms-1">Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tablet View (Medium screens: 768px-991px) -->
            <div class="d-none d-md-block d-lg-none">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(to right, #2d3748, #4a5568);">
                            <tr>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">User</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">Role</th>
                                <th class="text-white py-2 px-3" style="font-size: 0.875rem;">Email</th>
                                <th class="text-white py-2 px-3 text-end" style="font-size: 0.875rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    $roleColors = [
                                        'Admin' => 'danger',
                                        'Technician' => 'warning',
                                        'Helpdesk' => 'info',
                                        'Customer' => 'secondary',
                                    ];
                                    $roleColor = $roleColors[$user->role->name] ?? 'secondary';
                                    $avatarColors = [
                                        'Admin' => '#ef4444',
                                        'Technician' => '#f59e0b',
                                        'Helpdesk' => '#0ea5e9',
                                        'Customer' => '#6b7280',
                                    ];
                                    $avatarColor = $avatarColors[$user->role->name] ?? '#6b7280';
                                @endphp
                                <tr class="admin-table-row">
                                    <td class="py-2 px-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="user-avatar">
                                                <div class="avatar-placeholder"
                                                    style="background-color: {{ $avatarColor }};">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-medium text-dark" style="font-size: 0.875rem;">
                                                    {{ $user->name }}</div>
                                                <div class="small text-muted">
                                                    <i class="fas fa-id-badge fa-xs me-1"></i>ID: {{ $user->id }}
                                                </div>
                                                <div class="small text-muted">
                                                    <i class="fas fa-calendar fa-xs me-1"></i>
                                                    {{ $user->created_at->format('M d') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 px-3">
                                        <span
                                            class="badge bg-{{ $roleColor }} bg-opacity-10 text-{{ $roleColor }} border border-{{ $roleColor }} border-opacity-25">
                                            {{ $user->role->name }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <div class="small text-truncate" style="max-width: 150px;">
                                            {{ Str::limit($user->email, 20) }}
                                        </div>
                                    </td>
                                    <td class="py-2 px-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('users.show', $user->id) }}"
                                                class="btn btn-sm btn-tech-info shadow-sm py-1 px-2">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-sm btn-tech-warning shadow-sm py-1 px-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-tech-danger shadow-sm py-1 px-2"
                                                    onclick="return confirm('Delete this user?')">
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
            </div>

            <!-- Mobile Cards (Small screens: < 768px) -->
            <div class="d-block d-md-none">
                @foreach ($users as $user)
                    @php
                        $roleColors = [
                            'Admin' => 'danger',
                            'Technician' => 'warning',
                            'Helpdesk' => 'info',
                            'Customer' => 'secondary',
                        ];
                        $roleColor = $roleColors[$user->role->name] ?? 'secondary';
                        $avatarColors = [
                            'Admin' => '#ef4444',
                            'Technician' => '#f59e0b',
                            'Helpdesk' => '#0ea5e9',
                            'Customer' => '#6b7280',
                        ];
                        $avatarColor = $avatarColors[$user->role->name] ?? '#6b7280';
                    @endphp
                    <div class="border-bottom p-2 admin-mobile-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-start gap-2 flex-grow-1">
                                <div class="user-avatar-mobile">
                                    <div class="avatar-placeholder" style="background-color: {{ $avatarColor }};">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <h6 class="fw-semibold text-dark mb-0"
                                            style="font-size: 0.9rem; line-height: 1.2;">
                                            {{ Str::limit($user->name, 20) }}
                                        </h6>
                                        <span class="badge bg-tech-dark text-white small px-1 py-0"
                                            style="font-size: 0.65rem;">
                                            #{{ $user->id }}
                                        </span>
                                    </div>
                                    <div class="small text-muted mb-1">
                                        <i class="fas fa-envelope fa-xs me-1"></i>
                                        {{ Str::limit($user->email, 25) }}
                                    </div>
                                    <div class="small text-muted mb-2">
                                        <i class="fas fa-calendar fa-xs me-1"></i>
                                        {{ $user->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Role and Last Login -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span
                                class="badge bg-{{ $roleColor }} bg-opacity-10 text-{{ $roleColor }} border border-{{ $roleColor }} border-opacity-25"
                                style="font-size: 0.7rem; padding: 0.15rem 0.4rem;">
                                {{ $user->role->name }}
                            </span>
                            @if ($user->last_login_at)
                                <div class="small text-muted" style="font-size: 0.65rem;">
                                    <i class="fas fa-sign-in-alt fa-xs me-1"></i>
                                    {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans(['short' => true]) }}
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-1">
                            <a href="{{ route('users.show', $user->id) }}"
                                class="btn btn-tech-info shadow-sm flex-fill py-1 px-0"
                                style="font-size: 0.75rem; min-height: 36px;">
                                <i class="fas fa-eye fa-xs"></i>
                                <span class="ms-1">View</span>
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}"
                                class="btn btn-tech-warning shadow-sm flex-fill py-1 px-0"
                                style="font-size: 0.75rem; min-height: 36px;">
                                <i class="fas fa-edit fa-xs"></i>
                                <span class="ms-1">Edit</span>
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                class="d-inline flex-fill">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-tech-danger shadow-sm w-100 py-1 px-0"
                                    onclick="return confirm('Delete this user?')"
                                    style="font-size: 0.75rem; min-height: 36px;">
                                    <i class="fas fa-trash fa-xs"></i>
                                    <span class="ms-1">Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination - Responsive -->
            @if ($users->hasPages())
                <div class="card-footer bg-transparent border-top py-2 px-3">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                        <div class="text-muted small text-center text-sm-start" style="font-size: 0.75rem;">
                            Showing {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
                        </div>
                        <div class="pagination-mobile">
                            {{ $users->onEachSide(0)->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Technical Color Scheme */
        :root {
            --tech-primary: #2d3748;
            --tech-secondary: #4a5568;
            --tech-accent: #3b82f6;
            --tech-info: #0ea5e9;
            --tech-warning: #f59e0b;
            --tech-danger: #ef4444;
            --tech-success: #10b981;
            --tech-gray: #f1f5f9;
            --tech-light: #f8fafc;
        }

        /* Admin Specific Gradients */
        .bg-admin-gradient {
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        }

        .bg-admin-primary {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        }

        .bg-admin-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            color: #212529;
        }

        .bg-admin-info {
            background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
        }

        .bg-admin-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%);
        }

        /* === MOBILE-FIRST RESPONSIVE DESIGN === */

        /* Base mobile styles */
        .container-fluid {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        /* Stats Cards */
        .admin-card {
            border-radius: 10px;
            padding: 0.75rem;
            color: white;
            height: 100%;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .stat-number {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            opacity: 0.9;
            margin: 0.25rem 0 0 0;
        }

        .stat-trend {
            font-size: 0.65rem;
            opacity: 0.8;
            display: block;
            margin-top: 0.125rem;
        }

        /* Technical Alert */
        .alert-tech-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-left: 4px solid var(--tech-success);
            color: #065f46;
            font-size: 0.875rem;
            padding: 0.75rem 1rem;
        }

        /* Technical Badges */
        .badge.bg-tech-primary {
            background: linear-gradient(135deg, var(--tech-primary) 0%, var(--tech-secondary) 100%);
            color: white;
        }

        /* Technical Buttons */
        .btn-tech-info {
            background: linear-gradient(135deg, var(--tech-info) 0%, #38bdf8 100%);
            border: none;
            color: white;
        }

        .btn-tech-warning {
            background: linear-gradient(135deg, var(--tech-warning) 0%, #fbbf24 100%);
            border: none;
            color: #78350f;
        }

        .btn-tech-danger {
            background: linear-gradient(135deg, var(--tech-danger) 0%, #f87171 100%);
            border: none;
            color: white;
        }

        /* User Avatars */
        .user-avatar .avatar-placeholder {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .user-avatar-mobile .avatar-placeholder {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        /* Table Styling */
        .admin-table-row:hover {
            background: linear-gradient(to right, #f8fafc, #ffffff);
        }

        /* Mobile Cards */
        .admin-mobile-card {
            background: white;
            transition: background-color 0.2s ease;
        }

        .admin-mobile-card:active {
            background-color: var(--tech-light);
        }

        /* Pagination */
        .pagination-mobile .pagination {
            flex-wrap: wrap;
            justify-content: center;
            margin: 0;
            gap: 2px;
        }

        .pagination-mobile .page-link {
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            color: var(--tech-primary);
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            min-width: 30px;
            text-align: center;
        }

        /* === RESPONSIVE BREAKPOINTS === */

        /* Extra Small (xs): < 576px - Mobile portrait */
        @media (max-width: 575.98px) {
            .container-fluid {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .admin-card {
                padding: 0.625rem;
                gap: 0.375rem;
            }

            .stat-icon {
                width: 32px;
                height: 32px;
                font-size: 0.75rem;
            }

            .stat-number {
                font-size: 1rem;
            }

            .stat-label {
                font-size: 0.7rem;
            }

            .stat-trend {
                font-size: 0.6rem;
            }

            .admin-mobile-card {
                padding: 0.75rem;
            }

            .btn {
                font-size: 0.75rem !important;
                padding: 0.375rem 0.5rem !important;
            }

            .badge {
                font-size: 0.65rem !important;
            }
        }

        /* Small (sm): 576px - 767px - Mobile landscape / Small tablets */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .admin-card {
                padding: 0.875rem;
            }

            .stat-icon {
                width: 36px;
                height: 36px;
            }

            .stat-number {
                font-size: 1.1rem;
            }

            .admin-mobile-card {
                padding: 0.875rem;
            }

            .user-avatar-mobile .avatar-placeholder {
                width: 36px;
                height: 36px;
                font-size: 0.875rem;
            }
        }

        /* Medium (md): 768px - 991px - Tablets */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .container-fluid {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            .admin-card {
                padding: 1rem;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .stat-number {
                font-size: 1.25rem;
            }

            .table th,
            .table td {
                padding: 0.75rem 0.5rem !important;
            }

            .btn-sm {
                padding: 0.25rem 0.375rem !important;
            }

            .user-avatar .avatar-placeholder {
                width: 40px;
                height: 40px;
            }
        }

        /* Large (lg): 992px - 1199px - Laptops */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .container-fluid {
                padding-left: 2rem;
                padding-right: 2rem;
            }

            .admin-card {
                padding: 1.25rem;
            }

            .stat-icon {
                width: 44px;
                height: 44px;
                font-size: 1.125rem;
            }

            .stat-number {
                font-size: 1.4rem;
            }

            .stat-label {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 0.75rem 0.75rem !important;
            }

            .user-avatar .avatar-placeholder {
                width: 44px;
                height: 44px;
                font-size: 1rem;
            }
        }

        /* Extra Large (xl): ≥ 1200px - Desktops */
        @media (min-width: 1200px) {
            .container-fluid {
                padding-left: 2.5rem;
                padding-right: 2.5rem;
            }

            .admin-card {
                padding: 1.5rem;
            }

            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 1.25rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .table th,
            .table td {
                padding: 1rem !important;
            }

            .user-avatar .avatar-placeholder {
                width: 48px;
                height: 48px;
                font-size: 1.125rem;
            }
        }

        /* === TOUCH OPTIMIZATIONS === */

        @media (hover: none) and (pointer: coarse) {

            /* Increase touch targets for mobile */
            .btn,
            button,
            .form-check-input,
            .page-link {
                min-height: 44px;
            }

            .btn-sm {
                min-height: 36px;
            }

            /* Remove hover effects on touch devices */
            .admin-table-row:hover {
                background: inherit;
            }

            /* Add active states for touch feedback */
            .btn:active,
            button:active {
                opacity: 0.8;
                transform: scale(0.98);
            }

            .admin-mobile-card:active {
                background-color: var(--tech-light);
            }

            /* Ensure form buttons are touch-friendly */
            form.flex-fill {
                flex: 1;
                min-width: 0;
            }
        }

        /* === ACCESSIBILITY === */

        /* Focus styles */
        .btn:focus,
        button:focus,
        a:focus {
            outline: 2px solid var(--tech-accent);
            outline-offset: 2px;
        }

        /* === PERFORMANCE OPTIMIZATIONS === */

        /* Prevent layout shifts */
        .user-avatar .avatar-placeholder,
        .user-avatar-mobile .avatar-placeholder {
            aspect-ratio: 1;
        }

        /* Optimize text rendering */
        body {
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Search functionality
                const searchInput = document.getElementById('searchUsers');
                if (searchInput) {
                    let searchTimeout;
                    searchInput.addEventListener('input', function(e) {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            const searchTerm = e.target.value.toLowerCase().trim();

                            // Desktop rows
                            const desktopRows = document.querySelectorAll('.admin-table-row');
                            desktopRows.forEach(row => {
                                const text = row.textContent.toLowerCase();
                                row.style.display = text.includes(searchTerm) ? '' : 'none';
                            });

                            // Mobile cards
                            const mobileCards = document.querySelectorAll('.admin-mobile-card');
                            mobileCards.forEach(card => {
                                const text = card.textContent.toLowerCase();
                                card.style.display = text.includes(searchTerm) ? '' : 'none';
                            });
                        }, 300);
                    });
                }

                // Mobile touch optimizations
                if ('ontouchstart' in window) {
                    // Add touch feedback to buttons
                    const buttons = document.querySelectorAll('.btn, button[type="submit"]');
                    buttons.forEach(button => {
                        button.addEventListener('touchstart', function() {
                            this.style.opacity = '0.8';
                        });

                        button.addEventListener('touchend', function() {
                            this.style.opacity = '';
                        });
                    });
                }
            });
        </script>
    @endpush
@endsection
