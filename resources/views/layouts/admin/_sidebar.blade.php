<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <!-- Logo -->
    <div class="logo d-flex align-items-center" style="padding: 20px; text-align: center;">
        <a href="{{ url('/') }}" class="app-brand-link d-flex align-items-center">
            <span class="app-brand-logo demo"
                  style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; border: 2px solid #ddd; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('/assets/img/icons/brands/BFAR.png') }}" 
                     alt="BFAR Logo" 
                     class="img-fluid" 
                     style="width: 100%; height: 100%; object-fit: cover;"
            </span>
        </a>
    </div>

    <!-- Menu -->
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1" style="margin-top: 20px;">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="{{ route('admin-dashboard') }}" class="menu-link">
                <i class="menu-icon bx bx-home-circle"></i>
                <span data-i18n="Analytics">Dashboard</span>
            </a>
        </li>

        <!-- View All Catches -->
        <li class="menu-item">
            <a href="{{ route('admin.catches') }}" class="menu-link">
                <i class="menu-icon bx bx-list-ul"></i>
                <span>View All Catches</span>
            </a>
        </li>

        <!-- Manage Users -->
        <li class="menu-item">
            <a href="{{ route('admin.users') }}" class="menu-link">
                <i class="menu-icon bx bx-user-circle"></i>
                <span>Manage Users</span>
            </a>
        </li>

        <!-- Reports -->
        <li class="menu-item">
            <a href="{{ route('admin.reports') }}" class="menu-link">
                <i class="menu-icon bx bx-chart"></i>
                <span>Reports & Analytics</span>
            </a>
        </li>

        <!-- Edit Profile -->
        <li class="menu-item">
            <a href="{{ route('admin.profile.edit') }}" class="menu-link" style="background-color: #e0f7fa; border-radius: 8px; margin-top: 10px;">
                <i class="menu-icon bx bx-user-circle"></i>
                <span>Edit Profile</span>
            </a>
        </li>

        <!-- Registration Date -->
        <li class="menu-item">
            <a href="#" class="menu-link">
                <i class="menu-icon bx bx-calendar"></i>
                <span>Registered Since: {{ Auth::user()->created_at->format('M d, Y') }}</span>
            </a>
        </li>

        <!-- Logout -->
        <li class="menu-item">
            <a href="{{ route('logout') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="background-color: #ffebee; border-radius: 8px; margin-top: 10px;">
                <i class="menu-icon bx bx-log-out"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</aside>