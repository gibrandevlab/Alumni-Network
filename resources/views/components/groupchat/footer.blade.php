<footer class="bg-gradient-to-r from-blue-gradient-start to-blue-gradient-end p-4">
    <form id="groupChatForm"
          method="POST"
          action="{{ route('group-chat.store') }}"
          enctype="multipart/form-data"
          class="flex items-center space-x-2"
          data-fetch-url="{{ route('group-chat.messages') }}"
          data-search-url="{{ route('users.search') }}">
        @csrf
        <button type="button"
                class="text-black hover:text-gray-700 transition"
                title="Attach file"
                onclick="fileInput.click()">
            <!-- icon clip -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
            </svg>
        </button>
        <input type="file" id="fileInput" name="media" accept="image/*,video/*" class="hidden">
        <input type="text"
               name="message"
               id="messageInput"
               placeholder="Type a message and mention users with @..."
               class="flex-grow bg-gray-200 text-black rounded-full py-2 px-4 focus:outline-none">
        <button type="submit"
                class="bg-blue-gradient-end text-white rounded-full p-3 hover:bg-gray-800 transition"
                title="Send message">
            <!-- icon send -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
        </button>
    </form>
</footer>

