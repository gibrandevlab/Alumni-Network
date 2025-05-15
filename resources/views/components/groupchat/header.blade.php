<!-- filepath: c:\Users\afwan\Alumni-Network\resources\views\components\header.blade.php -->
<header class="bg-gradient-to-r from-blue-gradient-start to-blue-gradient-end p-4 flex items-center">
    <img src="https://via.placeholder.com/40" alt="Contact Profile" class="w-10 h-10 rounded-full mr-3">
    <div>
        <h1 class="text-xl font-semibold">Group Chat</h1>
        <p class="text-xs text-gray-600">{{ $profileName ?? 'Anonymous' }}</p>
    </div>
</header>
