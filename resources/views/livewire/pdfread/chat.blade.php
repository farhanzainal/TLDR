<div class="h-screen flex flex-col">
    <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-2">
        <div class="flex flex-col space-y-2">
            @foreach($messages as $message)
                <div class="flex flex-col items-{{ $message['role'] == 'user' ? 'end' : 'start' }}">
                    <span class="text-xs font-semibold text-gray-600">{{ $message['role'] }}:</span>
                    <p class="bg-{{ $message['role'] == 'user' ? 'blue' : 'gray' }}-100 rounded-lg p-2 text-sm text-gray-800 max-w-3/4">{{ $message['content'] }}</p>
                </div>
            @endforeach
        </div>
        <div wire:loading wire:target="sendMessage" class="flex flex-col items-start">
            <span class="text-xs font-semibold text-gray-600">assistant:</span>
            <div class="bg-gray-100 rounded-lg p-2 text-sm text-gray-800 max-w-3/4 flex items-center">
                <div class="animate-spin rounded-full h-4 w-4 border-t-2 border-b-2 border-gray-500 mr-2"></div>
                <span>Generating response...</span>
            </div>
        </div>
    </div>
    <div class="p-2 border-t">
        <form wire:submit.prevent="sendMessage" class="flex space-x-2 bg-white">
            <input type="text" wire:model.defer="newMessage" class="flex-1 px-2 py-1 text-sm focus:outline-none focus:ring-2 text-gray-800" placeholder="Type your message...">
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 text-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" wire:loading.attr="disabled">
                <span wire:loading.remove>Send</span>
                <span wire:loading>Sending...</span>
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('messageSent', function () {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    });
</script>
