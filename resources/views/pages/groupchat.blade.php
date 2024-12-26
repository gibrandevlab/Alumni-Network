<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komunitas Alumnet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'whatsapp-dark': '#0D1418',
                        'whatsapp-green': '#00A884',
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-whatsapp-dark text-gray-200 h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gray-800 p-4 flex items-center">
        <img src="https://via.placeholder.com/40" alt="Contact Profile" class="w-10 h-10 rounded-full mr-3">
        <div>
            <h1 class="text-xl font-semibold">Group Chat</h1>
            <p class="text-xs text-gray-400">Online</p>
        </div>
    </header>

    <!-- Chat Container -->
    <main class="flex-grow overflow-y-auto p-4 space-y-4">
        @foreach ($messages as $msg)
            @if ($msg->user_id == auth()->id())
                <!-- User Message -->
                <div class="flex justify-end">
                    <div class="bg-whatsapp-green rounded-tl-lg rounded-bl-lg rounded-br-lg p-3 max-w-xs text-white">
                        <p class="text-sm font-medium">You</p>
                        <p>{{ $msg->message }}</p>
                        @if ($msg->media_path)
                            @if ($msg->media_type === 'image')
                                <img src="{{ asset('storage/' . $msg->media_path) }}" alt="Image" class="mt-2 rounded-lg max-w-full">
                            @elseif ($msg->media_type === 'video')
                                <video src="{{ asset('storage/' . $msg->media_path) }}" controls class="mt-2 rounded-lg max-w-full">
                                    Your browser does not support this video format.
                                </video>
                            @endif
                        @endif
                    </div>
                </div>
            @else
                <!-- Other User Message -->
                <div class="flex items-start space-x-3">
                    <img src="https://via.placeholder.com/40" alt="User Avatar" class="w-8 h-8 rounded-full">
                    <div>
                        <p class="text-sm font-medium text-gray-400">{{ $msg->user->profil->nama ?? 'Anonymous' }}</p>
                        <div class="bg-gray-700 rounded-lg p-3 max-w-xs text-white">
                            <p>{{ $msg->message }}</p>
                            @if ($msg->media_path)
                                @if ($msg->media_type === 'image')
                                    <img src="{{ asset('storage/' . $msg->media_path) }}" alt="Image" class="mt-2 rounded-lg max-w-full">
                                @elseif ($msg->media_type === 'video')
                                    <video src="{{ asset('storage/' . $msg->media_path) }}" controls class="mt-2 rounded-lg max-w-full">
                                        Your browser does not support this video format.
                                    </video>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 p-4">
        <form method="POST" action="{{ route('group-chat.store') }}" enctype="multipart/form-data" class="flex items-center space-x-2">
            @csrf
            <!-- Button to Trigger File Input -->
            <button type="button" class="text-whatsapp-green hover:text-white transition" title="Attach file" onclick="document.getElementById('fileInput').click()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
            </button>
            <!-- Hidden File Input -->
            <input type="file" id="fileInput" name="media" accept="image/*,video/*" class="hidden">
            <input type="text" name="message" placeholder="Type a message..." class="flex-grow bg-gray-700 text-white rounded-full py-2 px-4 focus:outline-none">
            <button class="bg-whatsapp-green text-white rounded-full p-3 hover:bg-opacity-90 transition" title="Send message">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>

        <!-- Preview Section -->
        <div id="preview" class="hidden mt-4">
            <img id="preview-image" class="w-full max-w-sm rounded-lg" alt="Preview">
        </div>
    </footer>

    <!-- Script for Preview -->
    <script>
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');
        const previewImage = document.getElementById('preview-image');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
