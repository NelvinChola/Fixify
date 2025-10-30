@extends('layouts.admin')

@section('content')

            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1 text-gray-800">Dashboard</h1>
                        <p class="mb-0 text-muted">Welcome back! Here's what's happening today.</p>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary me-2">
                            <i class="fas fa-plus me-1"></i> New Request
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </div>
                
                <!-- Stats Row -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="content-card stat-card">
                            <i class="fas fa-tools"></i>
                            <div class="stat-value">24</div>
                            <div class="stat-label">Open Requests</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="content-card stat-card">
                            <i class="fas fa-clock"></i>
                            <div class="stat-value">12</div>
                            <div class="stat-label">In Progress</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="content-card stat-card">
                            <i class="fas fa-check-circle"></i>
                            <div class="stat-value">48</div>
                            <div class="stat-label">Resolved</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="content-card stat-card">
                            <i class="fas fa-user-friends"></i>
                            <div class="stat-value">8</div>
                            <div class="stat-label">Technicians</div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Recent Activity -->
                    <div class="col-lg-8 mb-4">
                        <div class="content-card">
                            <h3>Recent Service Requests</h3>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Device</th>
                                            <th>Issue</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#REQ-1025</td>
                                            <td>Dell Laptop</td>
                                            <td>Screen flickering</td>
                                            <td><span class="status-badge status-open">Open</span></td>
                                            <td>2 hours ago</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>#REQ-1024</td>
                                            <td>HP Printer</td>
                                            <td>Paper jam</td>
                                            <td><span class="status-badge status-in-progress">In Progress</span></td>
                                            <td>5 hours ago</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>#REQ-1023</td>
                                            <td>MacBook Pro</td>
                                            <td>Battery replacement</td>
                                            <td><span class="status-badge status-completed">Completed</span></td>
                                            <td>1 day ago</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>#REQ-1022</td>
                                            <td>Lenovo Desktop</td>
                                            <td>OS installation</td>
                                            <td><span class="status-badge status-completed">Completed</span></td>
                                            <td>1 day ago</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>#REQ-1021</td>
                                            <td>iPhone 12</td>
                                            <td>Screen replacement</td>
                                            <td><span class="status-badge status-in-progress">In Progress</span></td>
                                            <td>2 days ago</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">View</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <a href="#" class="btn btn-outline-primary">View All Requests</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions & Stats -->
                    <div class="col-lg-4 mb-4">
                        <div class="content-card mb-4">
                            <h3>Quick Actions</h3>
                            <div class="quick-actions d-grid gap-2">
                                <button class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i> New Service Request
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-user-plus me-2"></i> Add Technician
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-desktop me-2"></i> Register Device
                                </button>
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-tools me-2"></i> Add Issue Type
                                </button>
                            </div>
                        </div>
                        
                        <div class="content-card">
                            <h3>System Status</h3>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Storage</span>
                                    <span>65%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Performance</span>
                                    <span>82%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 82%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Uptime</span>
                                    <span>99.9%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 99.9%"></div>
                                </div>
                            </div>
                            <div class="alert alert-success mt-3">
                                <i class="fas fa-check-circle me-2"></i>
                                All systems operational
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection