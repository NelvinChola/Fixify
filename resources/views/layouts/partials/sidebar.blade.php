<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <i class="fas fa-cash-register"></i>
        </div>
        <div class="sidebar-brand-text mx-3">POS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard (Visible to All) -->
    <li class="nav-item active">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @auth
        <!-- ADMIN-ONLY SECTIONS (Hidden from Manager) -->
        @if(auth()->user()->role->name === 'admin')
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWaste">
                    <i class="fas fa-file"></i>
                    <span>Category</span>
                </a>
                <div id="collapseWaste" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('categories.create') }}">
                            <i class="fas fa-plus mx-1"></i><span>Add Category</span>
                        </a>
                        <a class="collapse-item" href="{{ route('categories.index') }}">
                            <i class="fas fa-list mx-1"></i><span>Category List</span>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsuser">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <div id="collapsuser" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('users.index')}}">
                            <i class="fas fa-list mx-1"></i><span>User List</span>
                        </a>
                    </div>
                </div>
            </li>
        @endif

        <!-- PRODUCTS SECTION (Visible to BOTH Admin & Manager) -->
        @if(in_array(auth()->user()->role->name, ['admin', 'manager']))
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsproduct">
                    <i class="fas fa-edit"></i>
                    <span>Product</span>
                </a>
                <div id="collapsproduct" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('products.create') }}">
                            <i class="fas fa-plus mx-1"></i><span>Add Product</span>
                        </a>
                        <a class="collapse-item" href="{{ route('products.index') }}">
                            <i class="fas fa-list mx-1"></i><span>Product List</span>
                        </a>
                    </div>
                </div>
            </li>
        @endif

        <!-- POS SECTION (Visible to ALL ROLES) -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapspos">
                <i class="fas fa-store-slash"></i>
                <span>POS</span>
            </a>
            <div id="collapspos" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="#">
                        <i class="fas fa-cart-arrow-down mx-1"></i><span>Sales</span>
                    </a>
                    <!-- Sales Report (Admin-Only) -->
                    @if(auth()->user()->role->name === 'admin')
                        <a class="collapse-item" href="#">
                            <i class="fas fa-warehouse mx-1"></i><span>Sales Report</span>
                        </a>
                    @endif
                </div>
            </div>
        </li>
    @endauth

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>