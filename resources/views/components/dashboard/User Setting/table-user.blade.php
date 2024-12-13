<div class="flex justify-end mb-4">
    <button onclick="showCreateModal()"
        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-700">Tambah User</button>
</div>
<h2 class="text-2xl font-semibold mb-4 dark:bg-gray-800 dark:text-gray-200">Data Users</h2>

<!-- Search Form -->
<form id="searchForm" method="GET" action="{{ route('dashboard.user-setting') }}" class="flex items-center mb-4">
    <div class="bg-white rounded flex items-center w-full max-w-xl mr-4 p-2 shadow-sm border border-gray-200">
        <button type="button" class="outline-none focus:outline-none" id="searchButton">
            <svg class="w-5 text-gray-600 h-5 cursor-pointer" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
        <input type="search" name="search" id="searchInput" placeholder="Search" class="w-full pl-3 text-sm text-black outline-none focus:outline-none bg-transparent" value="{{ request()->input('search') }}">
    </div>
</form>

<!-- User Table -->
<table class="min-w-full leading-normal">
    <thead>
        <tr>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-center text-sm uppercase font-semibold">ID</th>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-center text-sm uppercase font-semibold">Email</th>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-center text-sm uppercase font-semibold">Role</th>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-center text-sm uppercase font-semibold">Status</th>
            <th scope="col" class="px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-center text-sm uppercase font-semibold">Aksi</th>
        </tr>
    </thead>
    <tbody id="userTableBody">
        @include('components.dashboard.User Setting.partial-table', ['users' => $users])
    </tbody>
</table>

<!-- Pagination and Result Count -->
<div class="flex justify-between items-center mt-4">
    <div class="text-sm text-gray-700 dark:text-gray-300">
        Showing
        @if ($users->count())
            {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
        @else
            0 results
        @endif
    </div>
    <div>
        {{ $users->links('vendor.pagination.tailwind') }} <!-- Display pagination links -->
    </div>
</div>



<script>
// Attach input event listener to search input
document.getElementById('searchInput').addEventListener('input', function() {
    const searchQuery = this.value;

    // Send AJAX request to fetch search results
    fetch(`{{ route('dashboard.user-setting') }}?search=${encodeURIComponent(searchQuery)}`)
        .then(response => response.text())
        .then(html => {
            // Update the table body with new results
            document.getElementById('userTableBody').innerHTML = new DOMParser().parseFromString(html, 'text/html').querySelector('#userTableBody').innerHTML;
        })
        .catch(error => console.error('Error fetching search results:', error));
});

// Optional: Implement button click event for search button
document.getElementById('searchButton').addEventListener('click', function() {
    const searchInput = document.getElementById('searchInput');
    searchInput.focus(); // Set focus on the input field
    searchInput.select(); // Select the current input
});
</script>
