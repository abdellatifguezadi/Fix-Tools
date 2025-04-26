<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Conversation with') }} {{ $user->name }}
            </h2>
            <a href="{{ route('messages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 border border-transparent rounded-md font-semibold text-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div id="messages-container" class="messages-container space-y-4 mb-6 overflow-y-auto" style="max-height: 400px;">
                        @if($messages->count() > 0)
                            @foreach($messages as $message)
                                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-[80%] {{ $message->sender_id === auth()->id() ? 'bg-black text-yellow-500' : 'bg-gray-100 text-gray-800' }} rounded-lg p-3">
                                        @if(!$message->sender_id)
                                            <p class="text-xs text-gray-500 mb-1">Message from: Deleted User</p>
                                        @endif
                                        <p class="mb-1">{{ $message->content }}</p>
                                        <p class="text-xs {{ $message->sender_id === auth()->id() ? 'text-yellow-400' : 'text-gray-500' }}">{{ $message->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                                <p class="text-gray-800">{{ __('No messages yet. Start a conversation!') }}</p>
                            </div>
                        @endif
                    </div>

                    <form id="message-form" action="{{ route('messages.store', $user) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <textarea id="message-content" name="content" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('content') border-red-500 @enderror" 
                                rows="3" 
                                placeholder="{{ __('Write your message here...') }}" 
                                required></textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-black border border-transparent rounded-md font-semibold text-sm hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                                {{ __('Send') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scrollToBottom = () => {
                const container = document.getElementById('messages-container');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            };
            
            scrollToBottom();
            
            const getToken = () => {
                const tokenElement = document.querySelector('meta[name="csrf-token"]');
                return tokenElement ? tokenElement.getAttribute('content') : '';
            };
            
            const form = document.getElementById('message-form');
            const textarea = document.getElementById('message-content');
            
            if (form && textarea) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const content = textarea.value.trim();
                    if (!content) return;
                    
                    const messagesContainer = document.getElementById('messages-container');
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'flex justify-end';
                    
                    const now = new Date();
                    const formattedDate = now.toLocaleDateString('fr-FR', { month: 'short', day: 'numeric', year: 'numeric' }) + ' ' + 
                                        now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                    
                    messageDiv.innerHTML = `
                        <div class="max-w-[80%] bg-black text-yellow-500 rounded-lg p-3">
                            <p class="mb-1">${content}</p>
                            <p class="text-xs text-yellow-400">${formattedDate}</p>
                        </div>
                    `;
                    
                    messagesContainer.appendChild(messageDiv);
                    scrollToBottom();
                    
                    const formData = new FormData(form);
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': getToken()
                        }
                    });
                    
                    textarea.value = '';
                });
            }
            
            const userId = window.userId || {{ auth()->id() }};
            
            window.addEventListener('load', function() {
                if (typeof window.Echo !== 'undefined') {
                    console.log('Echo initialized, listening on channel chat.' + userId);
                    
                    window.Echo.private(`chat.${userId}`)
                        .listen('.message.sent', (data) => {
                            console.log('Message received:', data);
                            
                            if (data.message.sender_id == {{ $user->id }}) {
                                const messagesContainer = document.getElementById('messages-container');
                                const messageDiv = document.createElement('div');
                                messageDiv.className = 'flex justify-start';
                                
                                const date = new Date(data.message.created_at);
                                const formattedDate = date.toLocaleDateString('fr-FR', { month: 'short', day: 'numeric', year: 'numeric' }) + ' ' + 
                                                     date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                                
                                messageDiv.innerHTML = `
                                    <div class="max-w-[80%] bg-gray-100 text-gray-800 rounded-lg p-3">
                                        <p class="mb-1">${data.message.content}</p>
                                        <p class="text-xs text-gray-500">${formattedDate}</p>
                                    </div>
                                `;
                                
                                messagesContainer.appendChild(messageDiv);
                                scrollToBottom();
                                
                                // Replace API call with a direct route call
                                fetch(`/messages/{{ $user->id }}/read`, {
                                    method: 'POST',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': getToken(),
                                        'Content-Type': 'application/json'
                                    }
                                });
                            }
                        });
                } else {
                    console.error('Echo not initialized');
                }
            });
        });
    </script>
    @endpush
</x-app-layout> 