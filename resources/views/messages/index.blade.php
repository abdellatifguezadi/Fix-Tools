<x-app-layout>
    <x-slot name="title">Messages</x-slot>
    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-yellow-500 text-black px-6 py-4 border-b border-gray-200">
                <h1 class="text-xl font-semibold">{{ __('Messages') }}</h1>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <h2 class="text-lg font-medium text-gray-800 mb-4">{{ __('Your Conversations') }}</h2>
                
                @if($users->count() > 0)
                    <div class="space-y-2">
                        @foreach($users as $user)
                            <a href="{{ route('messages.show', $user) }}" class="flex items-center justify-between p-4 bg-gray-50 hover:bg-yellow-100 rounded-lg transition">
                                <div class="flex items-center">
                                    @if($user->image)
                                        <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-yellow-500 flex items-center justify-center">
                                            <span class="text-black font-bold">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                                
                                @php
                                    $unreadCount = $user->sentMessages()
                                        ->where('receiver_id', auth()->id())
                                        ->where('is_read', false)
                                        ->count();
                                @endphp
                                
                                @if($unreadCount > 0)
                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black bg-yellow-500 rounded-full">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                        <p class="text-gray-800">{{ __('You have no conversations yet.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 