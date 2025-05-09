document.addEventListener('DOMContentLoaded', () => {
    const messageInput = document.getElementById('messageInput');
    const groupChatForm = document.getElementById('groupChatForm');
    const fileInput = document.getElementById('fileInput');
    const fetchUrl = groupChatForm.dataset.fetchUrl;
    const searchUrl = groupChatForm.dataset.searchUrl;

    // Fetch messages dynamically
    const fetchMessages = async () => {
        try {
            const response = await fetch(fetchUrl);
            if (response.ok) {
                const messages = await response.json();
                renderMessages(messages);
            }
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    };

    // Render messages
    const renderMessages = (messages) => {
        const chatContainer = document.querySelector('main');
        chatContainer.innerHTML = ''; // Clear existing messages
        messages.forEach((msg) => {
            const messageElement = document.createElement('div');
            messageElement.className = `flex ${msg.user_id === authUserId ? 'justify-end' : 'items-start space-x-3'}`;
            messageElement.innerHTML = `
                ${msg.user_id !== authUserId ? `<img src="https://via.placeholder.com/40" alt="User Avatar" class="w-8 h-8 rounded-full">` : ''}
                <div class="${msg.user_id === authUserId ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'} rounded-lg p-3 max-w-xs">
                    <p class="text-sm font-medium">${msg.user?.profile?.nama || 'Anonymous'}</p>
                    <p class="break-words text-sm mt-1">${msg.message}</p>
                    ${msg.media_path ? renderMedia(msg.media_path, msg.media_type) : ''}
                </div>
            `;
            chatContainer.appendChild(messageElement);
        });
    };

    // Render media (image or video)
    const renderMedia = (mediaPath, mediaType) => {
        if (mediaType === 'image') {
            return `<img src="/storage/${mediaPath}" class="mt-2 rounded-lg max-w-full">`;
        } else if (mediaType === 'video') {
            return `<video src="/storage/${mediaPath}" controls class="mt-2 rounded-lg max-w-full"></video>`;
        }
        return '';
    };

    // Handle form submission
    groupChatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(groupChatForm);

        try {
            const response = await fetch(groupChatForm.action, {
                method: 'POST',
                body: formData,
            });

            if (response.ok) {
                messageInput.value = ''; // Clear input
                fileInput.value = ''; // Clear file input
                await fetchMessages(); // Refresh messages
            } else {
                console.error('Error sending message:', await response.text());
            }
        } catch (error) {
            console.error('Error sending message:', error);
        }
    });

    // Mention user search
    messageInput.addEventListener('input', async (e) => {
        const query = e.target.value;
        if (query.includes('@')) {
            const searchTerm = query.split('@').pop();
            try {
                const response = await fetch(`${searchUrl}?q=${searchTerm}`);
                if (response.ok) {
                    const users = await response.json();
                    showMentionDropdown(users);
                }
            } catch (error) {
                console.error('Error searching users:', error);
            }
        }
    });

    // Show mention dropdown
    const showMentionDropdown = (users) => {
        const dropdown = document.createElement('div');
        dropdown.className = 'mention-dropdown';
        users.forEach((user) => {
            const userElement = document.createElement('div');
            userElement.textContent = user.name;
            userElement.addEventListener('click', () => {
                messageInput.value += user.name + ' ';
                dropdown.remove();
            });
            dropdown.appendChild(userElement);
        });
        document.body.appendChild(dropdown);
    };

    // Initial fetch of messages
    fetchMessages();
});
