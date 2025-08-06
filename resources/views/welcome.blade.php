<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BFAR Fish Monitoring System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles -->
        <style>
            :root {
                --bfar-blue: #1e3a8a;
                --bfar-light-blue: #3b82f6;
                --ocean-blue: #0ea5e9;
                --wave-blue: #06b6d4;
                --coral-orange: #f97316;
                --sand-beige: #fef3c7;
                --deep-sea: #0f172a;
            }

            body {
                font-family: 'Figtree', sans-serif;
                background: linear-gradient(135deg, var(--bfar-blue) 0%, var(--ocean-blue) 50%, var(--wave-blue) 100%);
                min-height: 100vh;
                position: relative;
                overflow-x: hidden;
            }

            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="waves" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M0 50 Q25 40 50 50 T100 50 V100 H0 Z" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23waves)"/></svg>');
                opacity: 0.3;
                z-index: 1;
            }

            .main-container {
                position: relative;
                z-index: 2;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .navbar {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }

            .navbar-brand {
                font-weight: 700;
                color: var(--bfar-blue) !important;
                font-size: 1.5rem;
            }

            .nav-link {
                color: var(--bfar-blue) !important;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .nav-link:hover {
                color: var(--coral-orange) !important;
                transform: translateY(-2px);
            }

            .hero-section {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 4rem 0;
                position: relative;
            }

            .hero-content {
                text-align: center;
                color: white;
                max-width: 800px;
                margin: 0 auto;
                padding: 2rem;
            }

            .bfar-logo {
                width: 120px;
                height: 120px;
                background: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 2rem;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
                animation: float 3s ease-in-out infinite;
            }

            .bfar-logo i {
                font-size: 3rem;
                color: var(--bfar-blue);
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }

            .hero-title {
                font-size: 3.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            }

            .hero-subtitle {
                font-size: 1.5rem;
                margin-bottom: 2rem;
                opacity: 0.9;
                font-weight: 400;
            }

            .hero-description {
                font-size: 1.1rem;
                margin-bottom: 3rem;
                opacity: 0.8;
                line-height: 1.6;
            }

            .cta-buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn-primary {
                background: var(--coral-orange);
                border: none;
                padding: 1rem 2rem;
                font-weight: 600;
                border-radius: 50px;
                transition: all 0.3s ease;
                box-shadow: 0 10px 30px rgba(249, 115, 22, 0.4);
            }

            .btn-primary:hover {
                background: #ea580c;
                transform: translateY(-3px);
                box-shadow: 0 15px 40px rgba(249, 115, 22, 0.6);
            }

            .btn-outline-light {
                border: 2px solid white;
                color: white;
                padding: 1rem 2rem;
                font-weight: 600;
                border-radius: 50px;
                transition: all 0.3s ease;
                background: transparent;
            }

            .btn-outline-light:hover {
                background: white;
                color: var(--bfar-blue);
                transform: translateY(-3px);
            }

            .features-section {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                padding: 4rem 0;
                margin-top: 2rem;
            }

            .feature-card {
                background: white;
                border-radius: 20px;
                padding: 2rem;
                text-align: center;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                border: 1px solid rgba(255, 255, 255, 0.2);
                height: 100%;
            }

            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            }

            .feature-icon {
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, var(--bfar-blue), var(--ocean-blue));
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1.5rem;
                color: white;
                font-size: 2rem;
            }

            .feature-title {
                color: var(--bfar-blue);
                font-weight: 700;
                margin-bottom: 1rem;
                font-size: 1.3rem;
            }

            .feature-description {
                color: #64748b;
                line-height: 1.6;
            }

            .footer {
                background: var(--deep-sea);
                color: white;
                text-align: center;
                padding: 2rem 0;
                margin-top: auto;
            }

            .wave-animation {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 100px;
                background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
                animation: wave 3s ease-in-out infinite;
            }

            @keyframes wave {
                0%, 100% { transform: translateX(-100%); }
                50% { transform: translateX(100%); }
            }

            @media (max-width: 768px) {
                .hero-title {
                    font-size: 2.5rem;
                }
                
                .hero-subtitle {
                    font-size: 1.2rem;
                }
                
                .cta-buttons {
                    flex-direction: column;
                    align-items: center;
                }
                
                .btn-primary, .btn-outline-light {
                    width: 100%;
                    max-width: 300px;
                }
            }
        </style>
    </head>
    <body>
        <div class="main-container">
            <!-- Navigation -->
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <i class="fas fa-fish me-2"></i>
                        Fish Catch Monitoring System
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            @if (Route::has('login'))
                                @auth
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('personnel-dashboard') }}">
                                            <i class="fas fa-home me-1"></i>Dashboard
                                        </a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">
                                            <i class="fas fa-sign-in-alt me-1"></i>Login
                                        </a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">
                                                <i class="fas fa-user-plus me-1"></i>Register
                                            </a>
                                        </li>
                                    @endif
                                @endauth
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <section class="hero-section">
                <div class="container">
                    <div class="hero-content">
                                    <div class="bfar-logo">
                <img src="{{ asset('/assets/img/icons/brands/BFAR.png') }}" 
                     alt="BFAR Logo" 
                     class="img-fluid" 
                     style="width: 80%; height: 80%; object-fit: contain;">
            </div>
                        
                        <h1 class="hero-title">
                            Bureau of Fisheries and<br>
                            <span style="color: var(--coral-orange);">Aquatic Resources</span>
                        </h1> 
                        
                        <div class="cta-buttons">
                            @auth
                                <a href="{{ url('/personnel-dashboard') }}" class="btn btn-primary">
                                    <i class="fas fa-tachometer-alt me-2"></i>
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Login to System
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-outline-light">
                                        <i class="fas fa-user-plus me-2"></i>
                                        Create Account
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
                
                <div class="wave-animation"></div>
            </section>

            <!-- Features Section -->
            <section class="features-section">
                <div class="container">
                    <div class="row text-center mb-5">
                        <div class="col-12">
                            <h2 class="display-4 fw-bold text-primary mb-3">System Features</h2>
                            <p class="lead text-muted">Comprehensive tools for fisheries management and monitoring</p>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h3 class="feature-title">Data Analytics</h3>
                                <p class="feature-description">
                                    Advanced analytics and reporting tools for comprehensive fisheries data analysis 
                                    and trend monitoring.
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-database"></i>
                                </div>
                                <h3 class="feature-title">Catch Management</h3>
                                <p class="feature-description">
                                    Efficient recording and management of fish catches with detailed species 
                                    information and location tracking.
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h3 class="feature-title">User Management</h3>
                                <p class="feature-description">
                                    Role-based access control with different permission levels for administrators, 
                                    personnel, and field agents.
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <h3 class="feature-title">Report Generation</h3>
                                <p class="feature-description">
                                    Automated PDF report generation for compliance, analysis, and regulatory 
                                    requirements.
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-map-marked-alt"></i>
                                </div>
                                <h3 class="feature-title">Location Tracking</h3>
                                <p class="feature-description">
                                    GPS-enabled location tracking for accurate catch location recording and 
                                    mapping capabilities.
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h3 class="feature-title">Data Security</h3>
                                <p class="feature-description">
                                    Enterprise-grade security with encrypted data transmission and secure 
                                    authentication protocols.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 text-md-start text-center">
                            <h5 class="mb-3">
                                <i class="fas fa-fish me-2"></i>
                                BFAR Fish Monitoring System
                            </h5>
                            <p class="mb-0 text-muted">
                                Empowering sustainable fisheries management through technology
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end text-center">
                            <p class="mb-0 text-muted">
                                <i class="fas fa-code me-1"></i>
                                Laravel v{{ Illuminate\Foundation\Application::VERSION }} 
                                <span class="mx-2">|</span>
                                <i class="fas fa-server me-1"></i>
                                PHP v{{ PHP_VERSION }}
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
