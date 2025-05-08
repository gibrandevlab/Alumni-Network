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
                        'blue-gradient-start': '#0073E6',
                        'blue-gradient-end': '#66B2FF',
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-gradient-to-b from-blue-gradient-start to-blue-gradient-end text-black h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-gradient-start to-blue-gradient-end p-4 flex items-center">
        <img src="https://via.placeholder.com/40" alt="Contact Profile" class="w-10 h-10 rounded-full mr-3">
        <div>
            <h1 class="text-xl font-semibold">Group Chat</h1>
            <p class="text-xs text-gray-600">{{ $profileName ?? 'Anonymous' }}</p>
        </div>
    </header>

    <!-- Chat Container -->
    <main class="flex-grow overflow-y-auto p-4 space-y-4 bg-white">
        @for ($i = 0; $i < 50; $i++)
            <div class="flex justify-center">
                <img src="https://via.placeholder.com/50?text=Duck" alt="Duck Ornament" class="w-12 h-12">
            </div>
        @endfor
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-blue-gradient-start to-blue-gradient-end p-4">
        <form method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
            @csrf
            <!-- Button to Trigger File Input -->
            <button type="button" class="text-black hover:text-gray-700 transition" title="Attach file" onclick="document.getElementById('fileInput').click()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
            </button>
            <!-- Hidden File Input -->
            <input type="file" id="fileInput" name="media" accept="image/*,video/*" class="hidden">
            <input type="text" name="message" placeholder="Type a message..." class="flex-grow bg-gray-200 text-black rounded-full py-2 px-4 focus:outline-none">
            <button class="bg-blue text-white rounded-full p-3 hover:bg-gray-800 transition" title="Send message">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>
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

    <script>
        const messageContainer = document.querySelector('main'); // Chat container

        // Function to fetch messages
        async function fetchMessages() {
            const response = await fetch('{{ route('group-chat.fetch') }}');
            const messages = await response.json();

            // Clear the container
            messageContainer.innerHTML = '';

            // Render messages
            messages.forEach(msg => {
                const isCurrentUser = msg.user_id === {{ auth()->id() }};
                const messageHTML = `
                    <div class="flex ${isCurrentUser ? 'justify-end' : 'items-start space-x-3'}">
                        ${!isCurrentUser ? `<img src="https://via.placeholder.com/40" alt="User Avatar" class="w-8 h-8 rounded-full">` : ''}
                        <div class="${isCurrentUser ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'} rounded-lg p-3 max-w-xs">
                            <p class="text-sm font-medium">${isCurrentUser ? 'You' : (msg.user.profil?.nama || 'Anonymous')}</p>
                            <p>${msg.message}</p>
                            ${msg.media_path ? (msg.media_type === 'image' ? `<img src="/storage/${msg.media_path}" class="mt-2 rounded-lg max-w-full">` : `<video src="/storage/${msg.media_path}" controls class="mt-2 rounded-lg max-w-full"></video>`) : ''}
                        </div>
                    </div>
                `;
                messageContainer.innerHTML += messageHTML;
            });

            // Scroll to the bottom
            messageContainer.scrollTop = messageContainer.scrollHeight;
        }

        // Function to send a message
        async function sendMessage(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const response = await fetch('{{ route('group-chat.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (response.ok) {
                event.target.reset(); // Clear the form
                fetchMessages(); // Reload messages
            } else {
                alert('Failed to send message.');
            }
        }

        // Fetch messages on page load
        fetchMessages();

        // Set up form submission
        const messageForm = document.querySelector('form');
        messageForm.addEventListener('submit', sendMessage);

        // Polling to fetch new messages every 5 seconds
        setInterval(fetchMessages, 5000);
    </script>
</body>
</html>
