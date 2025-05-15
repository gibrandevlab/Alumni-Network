document.addEventListener('DOMContentLoaded', () => {
    const messageContainer = document.querySelector('main');
    const messageInput = document.getElementById('messageInput');
    let mentionDropdown = null;

    // Fetch messages
    async function fetchMessages() {
        const response = await fetch('/group-chat/fetch');
        const messages = await response.json();
        messageContainer.innerHTML = '';
        messages.forEach(msg => {
            const isCurrentUser = msg.user_id === parseInt(document.body.dataset.userId);
            const messageHTML = `
                <div class="flex ${isCurrentUser ? 'justify-end' : 'items-start space-x-3'}">
                    ${!isCurrentUser ? `<img src="https://via.placeholder.com/40" alt="User Avatar" class="w-8 h-8 rounded-full">` : ''}
                    <div class="${isCurrentUser ? 'bg-blue-500 text-white' : 'bg-gray-200 text-black'} rounded-lg p-3 max-w-xs">
                        <p class="text-sm font-medium">${isCurrentUser ? 'You' : msg.user_name}</p>
                        <p>${msg.message}</p>
                    </div>
                </div>
            `;
            messageContainer.innerHTML += messageHTML;
        });
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }

    fetchMessages();
    setInterval(fetchMessages, 5000);
});
