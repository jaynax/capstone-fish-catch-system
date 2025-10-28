<style>
    /* Responsive sidebar styles */
    .logo-container {
        display: flex;
        justify-content: center;
        padding: 1.5rem 1rem;
        transition: all 0.3s ease;
    }
    
    .logo-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #ddd;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .logo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    @media (max-width: 1199.98px) {
        .logo-wrapper {
            width: 60px;
            height: 60px;
        }
    }
    
    @media (max-width: 767.98px) {
        .logo-wrapper {
            width: 50px;
            height: 50px;
        }
        
        .menu-inner {
            margin-top: 90px !important;
        }
    }
    
    /* Hover effects */
    .menu-link {
        transition: all 0.2s ease;
        margin: 4px 0;
    }
    
    .menu-link:hover {
        transform: translateX(5px);
    }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="logo-container">
        <a href="{{ url('/') }}" class="app-brand-link">
            <div class="logo-wrapper">
                <img src="{{ asset('/assets/img/icons/brands/BFAR.png') }}" 
                     alt="BFAR Logo" 
                     class="img-fluid">
            </div>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1" style="margin-top: 1.5rem; padding: 0 1rem;">
        <!-- Dashboard -->
        <li class="menu-item">
            <a href="{{ route('personnel-dashboard') }}" class="menu-link">
                <i class="menu-icon bx bx-home-circle"></i>
                <span data-i18n="Analytics">Dashboard</span>
            </a>
        </li>

        <!-- Fish Catch -->
        <li class="menu-item">
            <a href="{{ route('catch.create') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-circle"></i>
                <div data-i18n="Record Fish Catch">Record Fish Catch</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('catches.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="View My Catches">View Reports</div>
            </a>
        </li>

        <!-- Edit Profile -->
        <li class="menu-item">
            <a href="{{ route('profile.edit') }}" class="menu-link" style="background-color: #e0f7fa; border-radius: 8px; margin-top: 10px;">
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
