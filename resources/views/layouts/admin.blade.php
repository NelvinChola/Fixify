<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Fixify - Service Tracker')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <!-- for site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">


    <style>
        :root {
            --primary-color: #1e1e2d;
            --accent-color: #4e73df;
            --hover-color: #2c2c3a;
            --text-light: #ddd;
            --text-white: #fff;
            --sidebar-width: 250px;
            --topbar-height: 60px;
        }
        
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fc;
        }

        /* Top Navbar */
        .top-navbar {
            background: var(--primary-color);
            height: var(--topbar-height);
            color: var(--text-white);
            z-index: 1030;
            position: fixed;
            width: 100%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .top-navbar .brand {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
            color: var(--text-white);
        }

        /* Center icons (desktop only) */
        .top-navbar .nav-icons {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            height: 100%;
        }

        .top-navbar .nav-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 12px;
            height: 40px;
            width: 40px;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }

        .top-navbar .nav-icons i {
            font-size: 20px;
            color: var(--text-white);
        }

        .top-navbar .nav-icons a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.15);
        }

        /* Sidebar */
        #sidebar-wrapper {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--primary-color);
            transition: all 0.3s ease;
            position: fixed;
            left: calc(-1 * var(--sidebar-width));
            top: var(--topbar-height);
            z-index: 1020;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
        }

        #sidebar-wrapper .list-group-item {
            background: transparent;
            color: var(--text-light);
            border: none;
            border-radius: 0;
            padding: 12px 20px;
            transition: all 0.2s;
        }

        #sidebar-wrapper .list-group-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        #sidebar-wrapper .list-group-item:hover,
        #sidebar-wrapper .list-group-item.active {
            background: var(--hover-color);
            color: var(--text-white);
            border-left: 4px solid var(--accent-color);
        }

        /* Page content */
        #page-content-wrapper {
            padding-top: calc(var(--topbar-height) + 20px);
            padding-left: 20px;
            padding-right: 20px;
            transition: all 0.3s ease;
            width: 100%;
            min-height: 100vh;
        }

        /* Show sidebar when toggled */
        #wrapper.toggled #sidebar-wrapper {
            left: 0;
        }

        /* Content Cards */
        .content-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
        }

        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .content-card h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .stat-card {
            text-align: center;
            padding: 20px;
        }

        .stat-card .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent-color);
            margin: 10px 0;
        }

        .stat-card .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card i {
            font-size: 2rem;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        /* Quick Actions */
        .quick-actions .btn {
            margin: 5px;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        /* Loading states */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .spinner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            z-index: 10;
        }

        /* Status indicators */
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-open {
            background-color: #e8f4fd;
            color: #1a73e8;
        }
        
        .status-in-progress {
            background-color: #fff8e1;
            color: #f9a825;
        }
        
        .status-completed {
            background-color: #e6f4ea;
            color: #34a853;
        }

        /* Toggle button */
        #menu-toggle {
            transition: all 0.3s;
        }

        #menu-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }

        /* Mobile adjustments */
        @media (max-width: 991px) {
            .top-navbar .nav-icons {
                position: static;
                transform: none;
                margin-left: auto;
            }

            .top-navbar .nav-icons a {
                margin: 0 6px;
                height: 36px;
                width: 36px;
            }
            
            #page-content-wrapper {
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        /* Desktop adjustments */
        @media (min-width: 992px) {
            #wrapper.toggled #page-content-wrapper {
                margin-left: var(--sidebar-width);
            }
        }
        
        /* Custom scrollbar for sidebar */
        #sidebar-wrapper::-webkit-scrollbar {
            width: 6px;
        }
        
        #sidebar-wrapper::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-light">

<!-- Top Navbar -->
<nav class="navbar top-navbar d-flex align-items-center px-3 border-bottom">
    <!-- Sidebar toggle button -->
    <div class="d-flex align-items-center">
        <button class="btn btn-sm btn-outline-light me-2" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <span class="brand">Fixify</span>
    </div>

    <!-- Center icons (hidden on mobile) -->
    <div class="nav-icons d-none d-lg-flex">
        <a href="{{ route('dashboard.welcome') }}" title="Dashboard"><i class="fas fa-home"></i></a>
        @auth
        @if(auth()->user()->role->name === 'Admin')
        <a href="{{ route('users.index') }}" title="Users"><i class="fas fa-users"></i></a>
        <a href="{{ route('categories.index') }}" title="Categories"><i class="fas fa-th-list"></i></a>
        @endif
        <a href="{{ route('devices.index') }}" title="Devices"><i class="fas fa-desktop"></i></a>
        <a href="{{ route('device_issues.index') }}" title="Issues"><i class="fas fa-tools"></i></a>
        @endauth
    </div>

    <!-- User dropdown -->
    <div class="dropdown ms-auto">
        <a class="text-white dropdown-toggle text-decoration-none d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            {{-- <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li> --}}
            <li><a class="dropdown-item" href="{{ route('settings.index') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>

<div id="wrapper" class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar-wrapper" class="border-end">
        <div class="list-group list-group-flush p-2">
            <a href="{{ route('dashboard.welcome') }}" class="list-group-item active" data-page="dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            @auth
            @if(auth()->user()->role->name === 'Admin')
                <a href="{{ route('users.index') }}" class="list-group-item" data-page="users">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="{{ route('categories.index') }}" class="list-group-item" data-page="categories">
                    <i class="fas fa-th-list"></i> Categories
                </a>
            @endif
            <a href="{{ route('devices.index') }}" class="list-group-item" data-page="devices">
                <i class="fas fa-desktop"></i> Devices
            </a>            
            <a href="{{ route('device_issues.index') }}" class="list-group-item" data-page="issues">
                <i class="fas fa-tools"></i> Device Issues
            </a>
            {{-- <a href="{{ route('service-requests.select-device') }}" class="list-group-item" data-page="requests">
                <i class="fas fa-clipboard-list"></i> Device repair
            </a> --}}
             {{-- <a href="{{ route('settings.index') }}" class="list-group-item" data-page="requests">
                <i class="fas fa-cog"></i> Settings
            </a> --}}
            @endauth   
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="flex-fill">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // DOM Elements
    const toggleButton = document.getElementById('menu-toggle');
    const wrapper = document.getElementById('wrapper');
    const sidebar = document.getElementById('sidebar-wrapper');
    const navItems = document.querySelectorAll('#sidebar-wrapper .list-group-item');

    // Toggle sidebar visibility
    toggleButton.addEventListener('click', () => {
        wrapper.classList.toggle('toggled');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (event) => {
        if (window.innerWidth < 992) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = toggleButton.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickOnToggle && wrapper.classList.contains('toggled')) {
                wrapper.classList.remove('toggled');
            }
        }
    });

    // Add active class to clicked sidebar items and handle smooth transitions
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Update active state
            navItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            
            // Close sidebar on mobile after selection
            if (window.innerWidth < 992) {
                wrapper.classList.remove('toggled');
            }
            
            // Add loading animation for better UX
            const originalContent = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Loading...';
            this.classList.add('loading');
            
            // Reset after navigation (simulated delay)
            setTimeout(() => {
                this.innerHTML = originalContent;
                this.classList.remove('loading');
            }, 500);
        });
    });

    // Auto-close sidebar on mobile when window is resized to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992 && wrapper.classList.contains('toggled')) {
            wrapper.classList.remove('toggled');
        }
    });

    // Highlight current page in sidebar based on URL
    function highlightCurrentPage() {
        const currentPath = window.location.pathname;
        navItems.forEach(item => {
            const href = item.getAttribute('href');
            if (href && currentPath.includes(href.replace(/^\//, '').split('/')[0])) {
                navItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
            }
        });
    }

    // Initialize page highlighting
    document.addEventListener('DOMContentLoaded', highlightCurrentPage);

    // Enhanced dropdown functionality
    document.addEventListener('DOMContentLoaded', function() {
        const dropdowns = document.querySelectorAll('.dropdown');
        dropdowns.forEach(dropdown => {
            dropdown.addEventListener('show.bs.dropdown', function() {
                this.querySelector('.dropdown-toggle').style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
            });
            
            dropdown.addEventListener('hide.bs.dropdown', function() {
                this.querySelector('.dropdown-toggle').style.backgroundColor = '';
            });
        });
    });

    // Keyboard navigation for sidebar
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && wrapper.classList.contains('toggled')) {
            wrapper.classList.remove('toggled');
        }
    });
</script>

<!-- Optional: Add dynamic content loading script -->
<script>
    // This script can be used for AJAX content loading if needed
    function loadContent(url, targetElement) {
        const target = document.querySelector(targetElement);
        if (!target) return;
        
        // Show loading state
        target.innerHTML = `
            <div class="content-card text-center py-5">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h4>Loading Content...</h4>
            </div>
        `;
        
        // Simulate API call (replace with actual fetch)
        setTimeout(() => {
            // This would be replaced with actual content loading
            console.log('Loading content from:', url);
        }, 1000);
    }
</script>

@stack('scripts')
</body>
</html>