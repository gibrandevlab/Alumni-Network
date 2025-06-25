<div class="flex ">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed flex flex-col top-0 left-0 w-14 hover:w-64 md:w-64 bg-blue-800 h-full text-white transition-all duration-300 z-10 sidebar">
        <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
            <div class="flex flex-col py-4 space-y-1">
                <!-- Logo and Title -->
                <div class="px-5 hidden md:block">
                    <div class="flex items-center h-16 mb-4 border-b border-blue-600 border-t-0 border-x-0 border-thin">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/screencapture-127-0-0-1-8000-dashboard-member-setting-2025-01-16-13_36_51-KZjxpYL66biHRq0kVGXX7G7OpzJbLj.png" alt="Logo" class="w-8 h-8 mr-3">
                        <div>
                            <div class="text-lg font-semibold">Panel Admin</div>
                            <div class="text-xs text-blue-200">Dashboard</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <ul class="flex flex-col py-4 space-y-1">
                    <!-- Main Section Header -->
                    <li class="px-5 hidden md:block">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-blue-100 uppercase">Main</div>
                        </div>
                    </li>

                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard.dashboard') }}"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-700 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-300 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Dashboard</span>
                        </a>
                    </li>

                    <!-- Manage Account Dropdown -->
                    <li>
                        <button id="manage-account-toggle" type="button"
                            class="w-full text-left relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-700 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-300 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Manage Account</span>
                            <svg id="manage-account-arrow" class="w-4 h-4 ml-auto transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <ul id="manage-account-submenu" class="ml-8 mt-1 hidden">
                            <li>
                                <a href="{{ route('dashboard.member.alumni.index') }}" class="flex items-center h-9 px-2 rounded hover:bg-blue-700">
                                    <span class="text-sm">Alumni</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard.member.admin.index') }}" class="flex items-center h-9 px-2 rounded hover:bg-blue-700">
                                    <span class="text-sm">Admin</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Manage Workshop -->
                    <li>
                        <a href="{{ route('dashboard.workshop.index') }}"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-700 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-300 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Manage Workshop</span>
                        </a>
                    </li>

                    <!-- Manage Kuesioner -->
                    <li>
                        <a href="{{ route('dashboard.kuesioner.index') }}"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-700 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-300 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Manage Kuesioner</span>
                        </a>
                    </li>

                    <!-- Download Data Kuesioner -->
                    <li>
                        <a href="{{ url('/export-excel') }}"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-700 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-300 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Download Data Kuesioner</span>
                        </a>
                    </li>

                    <!-- User Section Header -->
                    <li class="px-5 hidden md:block">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-blue-100 uppercase">User</div>
                        </div>
                    </li>

                    <!-- Profile (Changed from Settings) -->
                    <li>
                        <a href="{{ route('profile.index') }}"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-700 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-300 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Profile</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- User Profile Footer -->
            <div class="px-5 py-3 hidden md:block">
                <div class="flex items-center space-x-3">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/screencapture-127-0-0-1-8000-dashboard-member-setting-2025-01-16-13_36_51-KZjxpYL66biHRq0kVGXX7G7OpzJbLj.png" alt="Admin" class="w-8 h-8 rounded-full">
                    <div>
                        <div class="text-sm font-semibold">{{ $nama_admin ?? '-' }}</div>
                        <a href="#" class="text-xs text-blue-300 hover:text-blue-100">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu button -->
    <button id="mobile-menu-button" class="md:hidden fixed top-4 right-4 z-20 bg-blue-600 text-white p-2 rounded-md">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </button>

    <script>
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const mobileMenuButton = document.getElementById('mobile-menu-button');

        const toggleSidebar = (expand) => {
            sidebar.classList.toggle('w-64', expand);
            sidebar.classList.toggle('w-14', !expand);
        };

        mobileMenuButton.addEventListener('click', () => {
            const isExpanded = sidebar.classList.contains('w-64');
            toggleSidebar(!isExpanded);
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 && !sidebar.contains(e.target) && e.target !== mobileMenuButton) {
                toggleSidebar(false);
            }
        });

        // Adjust sidebar on window resize
        window.addEventListener('resize', () => {
            toggleSidebar(window.innerWidth >= 768);
        });

        // Manage Account submenu toggle
        const manageAccountToggle = document.getElementById('manage-account-toggle');
        const manageAccountSubmenu = document.getElementById('manage-account-submenu');
        const manageAccountArrow = document.getElementById('manage-account-arrow');

        if (manageAccountToggle && manageAccountSubmenu && manageAccountArrow) {
            manageAccountToggle.addEventListener('click', () => {
                manageAccountSubmenu.classList.toggle('hidden');
                manageAccountArrow.classList.toggle('rotate-180');
            });
        }
    </script>
</div>
