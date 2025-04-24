<x-app-layout>
    <x-slot name="title">Conversation avec {{ $user->name }}</x-slot>
    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-yellow-500 text-black px-6 py-4 border-b border-gray-200 flex items-center">
                <a href="{{ route('messages.index') }}" class="inline-flex items-center justify-center p-2 mr-3 bg-black text-yellow-500 hover:bg-gray-800 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L4.414 9H17a1 1 0 110 2H4.414l5.293 5.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <h1 class="text-xl font-semibold">{{ __('Conversation avec') }} {{ $user->name }}</h1>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="messages-container space-y-4 mb-6 overflow-y-auto" style="max-height: 400px;">
                    @if($messages->count() > 0)
                        @foreach($messages as $message)
                            <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[80%] {{ $message->sender_id === auth()->id() ? 'bg-black text-yellow-500' : 'bg-gray-100 text-gray-800' }} rounded-lg p-3">
                                    <p class="mb-1">{{ $message->content }}</p>
                                    <p class="text-xs {{ $message->sender_id === auth()->id() ? 'text-yellow-400' : 'text-gray-500' }}">{{ $message->created_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                            <p class="text-gray-800">{{ __('Pas encore de messages. Commencez une conversation!') }}</p>
                        </div>
                    @endif
                </div>

                <form action="{{ route('messages.store', $user) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <textarea name="content" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('content') border-red-500 @enderror" 
                            rows="3" 
                            placeholder="{{ __('Écrivez votre message ici...') }}" 
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
                            {{ __('Envoyer') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Scroll to bottom of messages container when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</x-app-layout> 