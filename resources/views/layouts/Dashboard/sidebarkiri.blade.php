<div class="flex min-h-screen">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed flex flex-col top-0 left-0 w-14 hover:w-64 md:w-64 bg-blue-800 h-full text-white transition-all duration-300 z-10 sidebar">
        <div class="overflow-y-auto overflow-x-hidden flex flex-col justify-between flex-grow">
            <div class="flex flex-col py-4 space-y-1">
                <div class="px-5 hidden md:block">
                    <div class="flex items-center h-16 mb-4 border-b border-blue-600 border-t-0 border-x-0 border-thin">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/screencapture-127-0-0-1-8000-dashboard-member-setting-2025-01-16-13_36_51-KZjxpYL66biHRq0kVGXX7G7OpzJbLj.png" alt="Logo" class="w-8 h-8 mr-3">
                        <div>
                            <div class="text-lg font-semibold">Panel Admin</div>
                            <div class="text-xs text-blue-200">Dashboard</div>
                        </div>
                    </div>
                </div>
                <ul class="flex flex-col py-4 space-y-1">
                    <li class="px-5 hidden md:block">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-blue-100 uppercase">Main</div>
                        </div>
                    </li>
                    <li>
                        <a href="/dashboard"
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
                    <li>
                        <a href="/dashboard/member/setting"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-700 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-300 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="none" stroke="#FFFFFF" stroke-width="2" d="M18.0003,20.9998 C16.3453,20.9998 15.0003,19.6538 15.0003,17.9998 C15.0003,16.3458 16.3453,14.9998 18.0003,14.9998 C19.6543,14.9998 21.0003,16.3458 21.0003,17.9998 C21.0003,19.6538 19.6543,20.9998 18.0003,20.9998 L18.0003,20.9998 Z M24.0003,17.9998 L21.0003,17.9998 L24.0003,17.9998 Z M20.1213,20.1218 L22.2423,22.2428 L20.1213,20.1218 Z M18.0003,23.9998 L18.0003,20.9998 L18.0003,23.9998 Z M13.7573,22.2428 L15.8783,20.1208 L13.7573,22.2428 Z M12.0003,17.9998 L15.0003,17.9998 L12.0003,17.9998 Z M15.8783,15.8788 L13.7573,13.7578 L15.8783,15.8788 Z M18.0003,14.9998 L18.0003,11.9998 L18.0003,14.9998 Z M20.1213,15.8788 L22.2423,13.7578 L20.1213,15.8788 Z M12.5,12.5 C11.2660678,11.4458897 9.77508483,11 8,11 C4.13400675,11 1,13.0294373 1,18 L1,23 L11,23 M8,11 C10.7614237,11 13,8.76142375 13,6 C13,3.23857625 10.7614237,1 8,1 C5.23857625,1 3,3.23857625 3,6 C3,8.76142375 5.23857625,11 8,11 Z"/>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Manage Alumni</span>
                            <span class="hidden md:block px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-300 bg-blue-800 rounded-full">New</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/user/setting"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-700 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-300 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Manage Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="/dashboard/event/setting"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-700 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-300 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Manage Events</span>
                        </a>
                    </li>
                    <li>
                        <a href="/export-excel"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-700 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-300 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Download Data Kuesioner</span>
                        </a>
                    </li>
                    <li class="px-5 hidden md:block">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-sm font-light tracking-wide text-blue-100 uppercase">Settings</div>
                        </div>
                    </li>
                    <li>
                        <a href="#"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-700 text-white-600 hover:text-white-800 border-l-4 border-transparent hover:border-blue-300 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14h4m2-2h-4m-4-4h8m-4 8H8m12-5H8m12 5h-4m-2-2H8"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="px-5 py-3 hidden md:block">
                <div class="flex items-center space-x-3">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/screencapture-127-0-0-1-8000-dashboard-member-setting-2025-01-16-13_36_51-KZjxpYL66biHRq0kVGXX7G7OpzJbLj.png" alt="Admin" class="w-8 h-8 rounded-full">
                    <div>
                        <div class="text-sm font-semibold">Admin Name</div>
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
</script>
