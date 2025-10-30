@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
<!-- Welcome Header -->
<div class="row mb-4 mb-md-5">
    <div class="col-12">
        <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #0c356e 0%, #3a4a6b 100%);">
            <div class="card-body text-white p-3 p-md-4 p-lg-5">
                <div class="row align-items-center">
                    <div class="col-12 col-md-8 order-2 order-md-1">
                        <h1 class="display-6 display-md-4 fw-bold mb-2 mb-md-3">
                            <i class="fas fa-tools me-2 me-md-3"></i>Welcome to Fixify, {{ auth()->user()->name }}!
                        </h1>
                        <p class="lead mb-3 mb-md-4 opacity-75 fs-6 fs-md-5">
                            {{ auth()->user()->role->name }} Dashboard - Streamlined Service Management
                        </p>
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 gap-sm-3">
                            <div class="badge bg-white text-dark px-2 px-md-3 py-1 py-md-2 rounded-pill fs-6 fs-md-7">
                                <i class="fas fa-user-circle me-1 me-md-2"></i>{{ auth()->user()->role->name }}
                            </div>
                            <div class="badge bg-light bg-opacity-25 text-white px-2 px-md-3 py-1 py-md-2 rounded-pill fs-6 fs-md-7">
                                <i class="fas fa-calendar me-1 me-md-2"></i>{{ now()->format('F j, Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 text-center order-1 order-md-2 mb-3 mb-md-0">
                        <div class="icon-shape bg-white bg-opacity-20 rounded-circle p-3 p-md-4 d-inline-block">
                            <i class="fas fa-tachometer-alt fa-3x fa-md-4x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Quick Actions Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 fw-bold text-dark mb-0">Quick Actions</h2>
                <span class="badge bg-primary px-3 py-2">Choose Your Path</span>
            </div>
        </div>
    </div>

    <!-- Action Cards Grid -->
    <div class="row g-4 justify-content-center" id="actionCardsContainer">
        @if(auth()->user()->role->name === 'Customer')
        <!-- Customer Actions - 3 cards -->
        <div class="col-xl-4 col-md-6">
            <div class="card action-card h-100 border-0 shadow-lg hover-lift">
                <div class="card-body p-4 text-center d-flex flex-column">
                    <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle p-3 mb-4 mx-auto" style="width: 80px; height: 80px;">
                        <i class="fas fa-laptop-medical fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">Request Device Repair</h4>
                    <p class="text-muted mb-4 flex-grow-1">
                        Submit a new service request for your device. Get started with our repair process.
                    </p>
                    <a href="{{ route('service-requests.select-device') }}" class="btn btn-primary btn-lg px-4 py-2">
                        <i class="fas fa-plus-circle me-2"></i>Start Repair Request
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card action-card h-100 border-0 shadow-lg hover-lift">
                <div class="card-body p-4 text-center d-flex flex-column">
                    <div class="icon-shape bg-success bg-opacity-10 text-success rounded-circle p-3 mb-4 mx-auto" style="width: 80px; height: 80px;">
                        <i class="fas fa-history fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">My Service History</h4>
                    <p class="text-muted mb-4 flex-grow-1">
                        View your previous service requests and track current repairs.
                    </p>
                    <a href="#" class="btn btn-success btn-lg px-4 py-2">
                        <i class="fas fa-clipboard-list me-2"></i>View History
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card action-card h-100 border-0 shadow-lg hover-lift">
                <div class="card-body p-4 text-center d-flex flex-column">
                    <div class="icon-shape bg-info bg-opacity-10 text-info rounded-circle p-3 mb-4 mx-auto" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-cog fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">Profile & Settings</h4>
                    <p class="text-muted mb-4 flex-grow-1">
                        Manage your account information and notification preferences.
                    </p>
                    <a href="#" class="btn btn-info btn-lg px-4 py-2">
                        <i class="fas fa-cog me-2"></i>Manage Profile
                    </a>
                </div>
            </div>
        </div>

        @elseif(in_array(auth()->user()->role->name, ['HelpDesk', 'Admin', 'Technician']))
        <!-- Staff Actions - Dynamic based on role -->
        @if(auth()->user()->role->name === 'Technician')
        <div class="col-xl-4 col-md-6 col-sm-8">
            <div class="card action-card h-100 border-0 shadow-lg hover-lift">
                <div class="card-body p-4 text-center d-flex flex-column">
                    <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle p-3 mb-4 mx-auto" style="width: 80px; height: 80px;">
                        <i class="fas fa-list-alt fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">Service Room</h4>
                    <p class="text-muted mb-4 flex-grow-1">
                        Access the job cards dashboard to manage all service requests and repairs.
                    </p>
                    <a href="{{ route('JobCard.index') }}" class="btn btn-primary btn-lg px-4 py-2">
                        <i class="fas fa-tasks me-2"></i>Enter Service Room
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if(in_array(auth()->user()->role->name ,['HelpDesk', 'Admin']))
        <div class="col-xl-4 col-md-6 col-sm-8">
            <div class="card action-card h-100 border-0 shadow-lg hover-lift">
                <div class="card-body p-4 text-center d-flex flex-column">
                    <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-circle p-3 mb-4 mx-auto" style="width: 80px; height: 80px;">
                        <i class="fas fa-headset fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">Support Room</h4>
                    <p class="text-muted mb-4 flex-grow-1">
                        Customer support portal for handling inquiries and assistance requests.
                    </p>
                    <a href="{{ route('JobCard.index') }}" class="btn btn-warning btn-lg px-4 py-2 text-dark">
                        <i class="fas fa-comments me-2"></i>Enter Support Room
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div class="col-xl-4 col-md-6 col-sm-8">
            <div class="card action-card h-100 border-0 shadow-lg hover-lift">
                <div class="card-body p-4 text-center d-flex flex-column">
                    <div class="icon-shape bg-success bg-opacity-10 text-success rounded-circle p-3 mb-4 mx-auto" style="width: 80px; height: 80px;">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">Analytics & Reports</h4>
                    <p class="text-muted mb-4 flex-grow-1">
                        View performance metrics, reports, and service analytics.
                    </p>
                    <a href="#" class="btn btn-success btn-lg px-4 py-2">
                        <i class="fas fa-chart-bar me-2"></i>View Reports
                    </a>
                </div>
            </div>
        </div>

        <!-- Additional Staff Actions -->
        @if(auth()->user()->role->name === 'Admin')
        <div class="col-xl-4 col-md-6 col-sm-8">
            <div class="card action-card h-100 border-0 shadow-lg hover-lift">
                <div class="card-body p-4 text-center d-flex flex-column">
                    <div class="icon-shape bg-danger bg-opacity-10 text-danger rounded-circle p-3 mb-4 mx-auto" style="width: 80px; height: 80px;">
                        <i class="fas fa-users-cog fa-2x"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-3">User Management</h4>
                    <p class="text-muted mb-4 flex-grow-1">
                        Manage system users, roles, and permissions.
                    </p>
                    <a href="{{ route('users.index') }}" class="btn btn-danger btn-lg px-4 py-2">
                        <i class="fas fa-users me-2"></i>Manage Users
                    </a>
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>

    <!-- Recent Activity Section - Only for Staff (HelpDesk, Admin, Technician) -->
    @if(in_array(auth()->user()->role->name, ['HelpDesk', 'Admin', 'Technician']))
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-0 py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-clock me-2 text-primary"></i>Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="p-3 rounded bg-primary bg-opacity-10">
                                <h3 class="fw-bold text-primary mb-1">{{ $todayJobs ?? 0 }}</h3>
                                <p class="text-muted mb-0">Today's Jobs</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 rounded bg-success bg-opacity-10">
                                <h3 class="fw-bold text-success mb-1">{{ $pendingJobs ?? 0 }}</h3>
                                <p class="text-muted mb-0">Pending</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 rounded bg-warning bg-opacity-10">
                                <h3 class="fw-bold text-warning mb-1">{{ $inProgressJobs ?? 0 }}</h3>
                                <p class="text-muted mb-0">In Progress</p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 rounded bg-info bg-opacity-10">
                                <h3 class="fw-bold text-info mb-1">{{ $completedJobs ?? 0 }}</h3>
                                <p class="text-muted mb-0">Completed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.action-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    border: 1px solid rgba(0,0,0,0.05);
}

.action-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}

.icon-shape {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.action-card:hover .icon-shape {
    transform: scale(1.1);
    border-color: rgba(0,0,0,0.1);
}

.btn {
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    border-color: rgba(255,255,255,0.3);
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn:hover::before {
    left: 100%;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

/* Responsive centering for different card counts */
#actionCardsContainer {
    min-height: 300px;
}

/* Specific styling for different card counts */
#actionCardsContainer .col-xl-4 {
    display: flex;
    justify-content: center;
}

/* Animation classes */
.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Card content alignment */
.card-body.d-flex {
    min-height: 350px;
}

/* Gradient borders on hover */
.action-card {
    position: relative;
    background: white;
}

.action-card::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #0c356e, #3a4a6b, #0c356e);
    border-radius: 17px;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.action-card:hover::before {
    opacity: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .action-card {
        margin-bottom: 1.5rem;
    }
    
    .card-body.d-flex {
        min-height: auto;
    }
    
    #actionCardsContainer .col-sm-8 {
        max-width: 400px;
        margin: 0 auto;
    }
}

/* Center single card */
#actionCardsContainer .col-xl-4:only-child {
    flex: 0 0 auto;
    width: 33.333333%;
}

/* Center two cards */
#actionCardsContainer .col-xl-4:nth-last-child(2):first-child,
#actionCardsContainer .col-xl-4:nth-last-child(2):first-child ~ .col-xl-4 {
    flex: 0 0 auto;
    width: 50%;
    max-width: 400px;
}

/* Button styling enhancements */
.btn-primary {
    background: linear-gradient(135deg, #0c356e 0%, #3a4a6b 100%);
    border: none;
}

.btn-success {
    background: linear-gradient(135deg, #198754 0%, #20c997 100%);
    border: none;
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    border: none;
}

.btn-info {
    background: linear-gradient(135deg, #0dcaf0 0%, #0b5ed7 100%);
    border: none;
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%);
    border: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations to cards
    const cards = document.querySelectorAll('.action-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.2}s`;
        card.classList.add('fade-in-up');
    });

    // Add click effects to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s linear;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
            `;
            
            this.appendChild(ripple);
            
            // Remove ripple after animation
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Auto-center cards based on count
    function centerCards() {
        const container = document.getElementById('actionCardsContainer');
        const cards = container.querySelectorAll('.col-xl-4');
        const cardCount = cards.length;
        
        cards.forEach(card => {
            card.classList.remove('col-sm-8', 'col-md-6');
        });
        
        if (cardCount === 1) {
            cards[0].classList.add('col-sm-8', 'col-md-6');
        } else if (cardCount === 2) {
            cards.forEach(card => {
                card.classList.add('col-sm-8', 'col-md-6');
            });
        }
    }
    
    // Run on load and resize
    centerCards();
    window.addEventListener('resize', centerCards);
});

// Add ripple animation
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection