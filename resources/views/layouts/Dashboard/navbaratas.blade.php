<div class="fixed w-full flex items-center justify-between h-16 bg-gray-900 text-gray-100 shadow-lg z-50 px-8 border-b border-gray-100">
    <!-- Left Section: User Info -->
    <div class="flex items-center space-x-4 pl-4 w-16 md:w-64 h-full bg-gray-900">
        <img class="w-10 h-10 rounded-full object-cover"
             src="https://therminic2018.eu/wp-content/uploads/2018/07/dummy-avatar.jpg"
             alt="User Avatar" />
        <span class="hidden md:block text-sm font-medium truncate">{{ $profil->nama }}</span>
    </div>

    <!-- Right Section: Header Actions -->
    <div class="flex items-center space-x-4 bg-gray-900">
        <!-- Divider -->
        <div class="hidden md:block w-px h-6 bg-gray-600"></div>

        <!-- Logout Button -->
        <a href="/logout" class="flex items-center text-sm font-medium text-gray-200 hover:text-blue-400 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            Logout
        </a>
    </div>
</div>
