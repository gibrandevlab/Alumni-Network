<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ALUMNET - Jaringan Alumni Instansi Pendidikan')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="ALUMNET - Platform yang menghubungkan alumni dengan instansi pendidikan untuk kolaborasi, peluang karir, dan informasi terkini.">
    <meta name="keywords" content="Alumni Network, Pelacak Alumni, Jaringan Alumni, Instansi Pendidikan, Karir, Networking">
    <meta name="author" content="ALUMNET">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'ALUMNET - Jaringan Alumni Instansi Pendidikan')" />
    <meta property="og:description" content="@yield('og_description', 'Platform yang menghubungkan alumni dengan instansi pendidikan untuk kolaborasi, peluang karir, dan networking profesional.')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}" />
    <meta property="og:site_name" content="ALUMNET" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'ALUMNET - Jaringan Alumni Instansi Pendidikan')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Platform yang menghubungkan alumni dengan instansi pendidikan dan sesama alumni.')">
    <meta name="twitter:image" content="{{ asset('images/twitter-card.jpg') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Preload Critical Resources -->
    <link rel="preload" href="{{ asset('images/testing.png') }}" as="image">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- CSS -->
    @vite('resources/css/app.css')

    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-hover: #2563eb;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --border-radius: 0.5rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: var(--bg-primary);
            overflow-x: hidden;
        }

        /* Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .header.scrolled {
            box-shadow: var(--shadow-md);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: var(--transition);
        }

        .logo:hover {
            transform: scale(1.02);
        }

        .logo img {
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        /* Navigation Styles */
        .nav-menu {
            display: none;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }

        .nav-menu.active {
            display: flex;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            position: relative;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: var(--primary-color);
            background-color: rgba(59, 130, 246, 0.1);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: var(--transition);
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        /* Auth Section */
        .auth-section {
            display: none;
            align-items: center;
            gap: 1rem;
        }

        .auth-section.active {
            display: flex;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-button {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            background: none;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }

        .profile-button:hover {
            background-color: var(--bg-secondary);
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
            box-shadow: var(--shadow-sm);
        }

        .profile-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            min-width: 200px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 1000;
        }

        .dropdown-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            width: 100%;
            padding: 0.75rem 1rem;
            color: var(--text-primary);
            text-decoration: none;
            border: none;
            background: none;
            text-align: left;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background-color: var(--bg-secondary);
        }

        .dropdown-item.danger {
            color: var(--error-color);
        }

        .dropdown-item.danger:hover {
            background-color: rgba(239, 68, 68, 0.1);
        }

        /* Mobile Menu */
        .mobile-menu-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: none;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }

        .mobile-menu-button:hover {
            background-color: var(--bg-secondary);
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .mobile-menu.active {
            opacity: 1;
            visibility: visible;
        }

        .mobile-menu-content {
            position: absolute;
            top: 0;
            left: 0;
            width: 80%;
            max-width: 320px;
            height: 100%;
            background: white;
            padding: 2rem;
            transform: translateX(-100%);
            transition: var(--transition);
            overflow-y: auto;
        }

        .mobile-menu.active .mobile-menu-content {
            transform: translateX(0);
        }

        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .mobile-close-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: none;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            color: var(--text-secondary);
            transition: var(--transition);
        }

        .mobile-close-button:hover {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
        }

        .mobile-nav-menu {
            list-style: none;
            margin-bottom: 2rem;
        }

        .mobile-nav-item {
            margin-bottom: 0.5rem;
        }

        .mobile-nav-link {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-weight: 500;
        }

        .mobile-nav-link:hover {
            background-color: var(--bg-secondary);
            color: var(--primary-color);
        }

        /* Footer Styles */
        .footer {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            margin-top: 4rem;
            border-top: 1px solid var(--border-color);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: var(--bg-primary);
            border-radius: 50%;
            color: var(--text-secondary);
            text-decoration: none;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .social-link:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .footer-bottom {
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
            text-align: center;
        }

        .footer-bottom p {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        /* Responsive Design */
        @media (min-width: 768px) {
            .nav-menu {
                display: flex;
            }

            .auth-section {
                display: flex;
            }

            .mobile-menu-button {
                display: none;
            }

            .footer-grid {
                grid-template-columns: 2fr 1fr 1fr;
                gap: 3rem;
            }

            .footer-bottom {
                flex-direction: row;
                justify-content: space-between;
                text-align: left;
            }
        }

        @media (min-width: 1024px) {
            .nav-container {
                padding: 1rem 3rem;
            }

            .logo img {
                height: 48px;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Focus styles */
        *:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>

    <!-- Scripts -->
    @vite('resources/js/Event.js')
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.4/lib/browser.min.js" defer></script>
    @yield('script')
</head>

<body>
    <!-- Header -->
    <header class="header" id="header" role="banner">
        <nav class="nav-container" role="navigation" aria-label="Main navigation">
            <!-- Logo -->
            <a href="/" class="logo" aria-label="ALUMNET Home">
                <img src="{{ asset('images/testing.png') }}" alt="ALUMNET Logo" width="150" height="40">
            </a>

            <!-- Desktop Navigation -->
            <ul class="nav-menu" role="menubar">
                <li role="none"><a href="/" class="nav-link" role="menuitem">Home</a></li>
                <li role="none"><a href="#tentang" class="nav-link" role="menuitem">Tentang</a></li>
                <li role="none"><a href="#panduan" class="nav-link" role="menuitem">Panduan</a></li>
                <li role="none"><a href="#berita" class="nav-link" role="menuitem">Berita</a></li>
                <li role="none"><a href="#footer" class="nav-link" role="menuitem">Kontak</a></li>
                <li role="none"><a href="/event-user" class="nav-link" role="menuitem">Event</a></li>
            </ul>

            <!-- Auth Section -->
            <div class="auth-section">
                @auth
                @php
                $user = auth()->user();
                $foto = $user && $user->foto ? asset('images/profil/' . $user->foto) : asset('images/profil/default.png');
                @endphp
                <div class="profile-dropdown">
                    <button class="profile-button flex flex-row items-center gap-2" id="profileButton" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ $foto }}" alt="Profile picture of {{ $user->nama ?? 'User' }}" class="profile-avatar" />
                        <span class="profile-name">{{ $user->nama ?? 'User' }}</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left:2px;">
                            <polyline points="6,9 12,15 18,9"></polyline>
                        </svg>
                    </button>
                    <div class="dropdown-menu" id="profileDropdown" role="menu">
                        <a href="{{ route('profile.index') }}" class="dropdown-item flex items-center gap-2" role="menuitem">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon-profile">
                                <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4z"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>Profile</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="{{ route('logout') }}" class="dropdown-item danger flex items-center gap-2" role="menuitem">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon-logout">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span>Keluar</span>
                        </a>
                    </div>
                </div>
                @endauth
                @guest
                <a href="/login" class="btn btn-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10,17 15,12 10,7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    Sign In
                </a>
                <a href="/register" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    Sign Up
                </a>
                @endguest
            </div>

            <!-- Mobile Menu Button -->
            <button class="mobile-menu-button" id="mobileMenuButton" aria-label="Open mobile menu" aria-expanded="false">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </nav>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu" role="dialog" aria-modal="true" aria-labelledby="mobile-menu-title">
        <div class="mobile-menu-content">
            <div class="mobile-menu-header">
                <h2 id="mobile-menu-title" class="sr-only">Navigation Menu</h2>
                <a href="/" class="logo">
                    <img src="{{ asset('images/testing.png') }}" alt="ALUMNET Logo" width="120" height="32">
                </a>
                <button class="mobile-close-button" id="mobileCloseButton" aria-label="Close mobile menu">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <ul class="mobile-nav-menu" role="menu">
                <li class="mobile-nav-item" role="none">
                    <a href="/" class="mobile-nav-link" role="menuitem">Home</a>
                </li>
                <li class="mobile-nav-item" role="none">
                    <a href="#tentang" class="mobile-nav-link" role="menuitem">Tentang</a>
                </li>
                <li class="mobile-nav-item" role="none">
                    <a href="#panduan" class="mobile-nav-link" role="menuitem">Panduan</a>
                </li>
                <li class="mobile-nav-item" role="none">
                    <a href="#berita" class="mobile-nav-link" role="menuitem">Berita</a>
                </li>
                <li class="mobile-nav-item" role="none">
                    <a href="#footer" class="mobile-nav-link" role="menuitem">Kontak</a>
                </li>
                <li class="mobile-nav-item" role="none">
                    <a href="/event-user" class="mobile-nav-link" role="menuitem">Event</a>
                </li>
            </ul>

            <!-- Mobile Auth Section -->
            <div class="mobile-auth-section">
                @if (!empty($id) && !empty($role) && !empty($status))
                @php
                $user = \App\Models\User::find($id);
                $foto = $user && $user->foto ? asset('images/profil/' . $user->foto) : asset('images/profil/default.png');
                @endphp
                <div style="padding: 1rem; border-top: 1px solid var(--border-color); margin-top: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                        <img src="{{ $foto }}" alt="Profile picture" class="profile-avatar" style="width: 48px; height: 48px;">
                        <div>
                            <div style="font-weight: 600; color: var(--text-primary);">{{ $user->nama ?? 'User' }}</div>
                            <div style="font-size: 0.875rem; color: var(--text-secondary);">{{ $user->email ?? '' }}</div>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="{{ route('profile.index') }}" class="btn btn-secondary" style="justify-content: center;">Profile</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn" style="width: 100%; justify-content: center; background-color: var(--error-color); color: white;">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div style="display: flex; flex-direction: column; gap: 0.75rem; padding: 1rem; border-top: 1px solid var(--border-color); margin-top: 1rem;">
                    <a href="/login" class="btn btn-secondary" style="justify-content: center;">Sign In</a>
                    <a href="/register" class="btn btn-primary" style="justify-content: center;">Sign Up</a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main id="main-content" role="main">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer" id="footer" role="contentinfo">
        <div class="footer-content">
            <div class="footer-grid">
                <!-- Contact Section -->
                <div class="footer-section">
                    <h3>Hubungi Kami</h3>
                    <div style="margin-bottom: 1rem;">
                        <a href="tel:+6285814791149" style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); text-decoration: none;">
                            +62 858-1479-1149
                        </a>
                    </div>
                    <div style="margin-bottom: 1.5rem; color: var(--text-secondary); font-size: 0.875rem;">
                        <p>Senin hingga Jumat: 10:00 - 17:00</p>
                        <p>Akhir pekan: 10:00 - 15:00</p>
                    </div>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323c-.875.807-2.026 1.297-3.323 1.297z" />
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Services Section -->
                <div class="footer-section">
                    <h3>Layanan</h3>
                    <ul class="footer-links">
                        <li><a href="#">Testimoni & Saran</a></li>
                        <li><a href="#">Lapor Kesalahan</a></li>
                        <li><a href="#">Pusat Bantuan</a></li>
                        <li><a href="#">Bantuan Online</a></li>
                        <li><a href="#">Panduan Penggunaan</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                <!-- Company Section -->
                <div class="footer-section">
                    <h3>Perusahaan</h3>
                    <ul class="footer-links">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Tim Kami</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Review Akun</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div>
                    <ul style="display: flex; flex-wrap: wrap; gap: 1rem; list-style: none; margin-bottom: 1rem;">
                        <li><a href="#" style="color: var(--text-secondary); font-size: 0.875rem; text-decoration: none;">Syarat & Kondisi</a></li>
                        <li><a href="#" style="color: var(--text-secondary); font-size: 0.875rem; text-decoration: none;">Kebijakan Privasi</a></li>
                        <li><a href="#" style="color: var(--text-secondary); font-size: 0.875rem; text-decoration: none;">Cookie</a></li>
                    </ul>
                </div>
                <p>&copy; 2024 ALUMNET. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Enhanced JavaScript with better performance and accessibility
        class AlumnetApp {
            constructor() {
                this.init();
            }

            init() {
                this.setupEventListeners();
                this.setupScrollEffects();
                this.setupDropdowns();
                this.setupMobileMenu();
                this.setupAccessibility();
            }

            setupEventListeners() {
                // Debounced scroll handler
                let scrollTimeout;
                window.addEventListener('scroll', () => {
                    if (scrollTimeout) {
                        window.cancelAnimationFrame(scrollTimeout);
                    }
                    scrollTimeout = window.requestAnimationFrame(() => {
                        this.handleScroll();
                    });
                });

                // Keyboard navigation
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.closeAllDropdowns();
                        this.closeMobileMenu();
                    }
                });

                // Click outside to close dropdowns
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.profile-dropdown')) {
                        this.closeAllDropdowns();
                    }
                    if (!e.target.closest('.mobile-menu') && !e.target.closest('.mobile-menu-button')) {
                        this.closeMobileMenu();
                    }
                });
            }

            setupScrollEffects() {
                const header = document.getElementById('header');
                let lastScrollY = window.scrollY;

                this.handleScroll = () => {
                    const currentScrollY = window.scrollY;

                    // Add scrolled class for styling
                    if (currentScrollY > 50) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }

                    lastScrollY = currentScrollY;
                };
            }

            setupDropdowns() {
                const profileButton = document.getElementById('profileButton');
                const profileDropdown = document.getElementById('profileDropdown');

                if (profileButton && profileDropdown) {
                    let hideTimeout;

                    const showDropdown = () => {
                        clearTimeout(hideTimeout);
                        profileDropdown.classList.add('active');
                        profileButton.setAttribute('aria-expanded', 'true');
                    };

                    const hideDropdown = () => {
                        hideTimeout = setTimeout(() => {
                            profileDropdown.classList.remove('active');
                            profileButton.setAttribute('aria-expanded', 'false');
                        }, 150);
                    };

                    profileButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        if (profileDropdown.classList.contains('active')) {
                            hideDropdown();
                        } else {
                            showDropdown();
                        }
                    });

                    profileButton.addEventListener('mouseenter', showDropdown);
                    profileButton.addEventListener('mouseleave', hideDropdown);
                    profileDropdown.addEventListener('mouseenter', showDropdown);
                    profileDropdown.addEventListener('mouseleave', hideDropdown);

                    // Keyboard navigation for dropdown
                    profileButton.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            showDropdown();
                            // Focus first dropdown item
                            const firstItem = profileDropdown.querySelector('.dropdown-item');
                            if (firstItem) firstItem.focus();
                        }
                    });

                    // Arrow key navigation in dropdown
                    profileDropdown.addEventListener('keydown', (e) => {
                        const items = profileDropdown.querySelectorAll('.dropdown-item');
                        const currentIndex = Array.from(items).indexOf(document.activeElement);

                        if (e.key === 'ArrowDown') {
                            e.preventDefault();
                            const nextIndex = (currentIndex + 1) % items.length;
                            items[nextIndex].focus();
                        } else if (e.key === 'ArrowUp') {
                            e.preventDefault();
                            const prevIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
                            items[prevIndex].focus();
                        }
                    });
                }
            }

            setupMobileMenu() {
                const mobileMenuButton = document.getElementById('mobileMenuButton');
                const mobileMenu = document.getElementById('mobileMenu');
                const mobileCloseButton = document.getElementById('mobileCloseButton');

                if (mobileMenuButton && mobileMenu && mobileCloseButton) {
                    mobileMenuButton.addEventListener('click', () => {
                        this.openMobileMenu();
                    });

                    mobileCloseButton.addEventListener('click', () => {
                        this.closeMobileMenu();
                    });

                    // Close on backdrop click
                    mobileMenu.addEventListener('click', (e) => {
                        if (e.target === mobileMenu) {
                            this.closeMobileMenu();
                        }
                    });

                    // Close mobile menu when clicking nav links
                    const mobileNavLinks = mobileMenu.querySelectorAll('.mobile-nav-link');
                    mobileNavLinks.forEach(link => {
                        link.addEventListener('click', () => {
                            this.closeMobileMenu();
                        });
                    });
                }
            }

            openMobileMenu() {
                const mobileMenu = document.getElementById('mobileMenu');
                const mobileMenuButton = document.getElementById('mobileMenuButton');

                mobileMenu.classList.add('active');
                mobileMenuButton.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';

                // Focus first nav item
                const firstNavItem = mobileMenu.querySelector('.mobile-nav-link');
                if (firstNavItem) {
                    setTimeout(() => firstNavItem.focus(), 100);
                }
            }

            closeMobileMenu() {
                const mobileMenu = document.getElementById('mobileMenu');
                const mobileMenuButton = document.getElementById('mobileMenuButton');

                mobileMenu.classList.remove('active');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            closeAllDropdowns() {
                const dropdowns = document.querySelectorAll('.dropdown-menu');
                dropdowns.forEach(dropdown => {
                    dropdown.classList.remove('active');
                });

                const buttons = document.querySelectorAll('[aria-expanded="true"]');
                buttons.forEach(button => {
                    button.setAttribute('aria-expanded', 'false');
                });
            }

            setupAccessibility() {
                // Skip to main content link
                const skipLink = document.createElement('a');
                skipLink.href = '#main-content';
                skipLink.textContent = 'Skip to main content';
                skipLink.className = 'sr-only';
                skipLink.style.cssText = `
                    position: absolute;
                    top: -40px;
                    left: 6px;
                    background: var(--primary-color);
                    color: white;
                    padding: 8px;
                    text-decoration: none;
                    border-radius: 4px;
                    z-index: 9999;
                    transition: top 0.3s;
                `;

                skipLink.addEventListener('focus', () => {
                    skipLink.style.top = '6px';
                });

                skipLink.addEventListener('blur', () => {
                    skipLink.style.top = '-40px';
                });

                document.body.insertBefore(skipLink, document.body.firstChild);

                // Announce page changes for screen readers
                const announcer = document.createElement('div');
                announcer.setAttribute('aria-live', 'polite');
                announcer.setAttribute('aria-atomic', 'true');
                announcer.className = 'sr-only';
                document.body.appendChild(announcer);

                // Focus management for SPA-like behavior
                window.addEventListener('popstate', () => {
                    const mainContent = document.getElementById('main-content');
                    if (mainContent) {
                        mainContent.focus();
                        announcer.textContent = 'Page content updated';
                    }
                });
            }
        }

        // Initialize app when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                new AlumnetApp();
            });
        } else {
            new AlumnetApp();
        }

        // Performance monitoring
        window.addEventListener('load', () => {
            // Add fade-in animation to elements
            const elements = document.querySelectorAll('main > *');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
                el.classList.add('fade-in');
            });
        });
    </script>

    @yield('additional_scripts')
    @push('script')
    <script>
        (function() {
            const btn = document.getElementById('profileButton');
            const dropdown = document.getElementById('profileDropdown');
            let hideTimeout;
            if (!btn || !dropdown) return;

            function showDropdown() {
                clearTimeout(hideTimeout);
                dropdown.classList.add('active', 'fade-in');
                btn.setAttribute('aria-expanded', 'true');
            }

            function hideDropdown() {
                hideTimeout = setTimeout(() => {
                    dropdown.classList.remove('active', 'fade-in');
                    btn.setAttribute('aria-expanded', 'false');
                }, 180); // delay supaya tidak langsung hilang
            }
            btn.addEventListener('mouseenter', showDropdown);
            btn.addEventListener('focus', showDropdown);
            btn.addEventListener('mouseleave', hideDropdown);
            btn.addEventListener('blur', hideDropdown);
            dropdown.addEventListener('mouseenter', showDropdown);
            dropdown.addEventListener('mouseleave', hideDropdown);
            // Untuk klik di luar dropdown
            document.addEventListener('mousedown', function(e) {
                if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('active', 'fade-in');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
            // Untuk mobile: toggle dengan klik
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (dropdown.classList.contains('active')) {
                    dropdown.classList.remove('active', 'fade-in');
                    btn.setAttribute('aria-expanded', 'false');
                } else {
                    showDropdown();
                }
            });
        })();
    </script>
    @endpush
</body>

</html>