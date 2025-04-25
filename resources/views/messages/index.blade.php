<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Conversations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Vos conversations') }}</h3>
                    
                    @if($users->count() > 0)
                        <div class="space-y-4">
                            @foreach($users as $user)
                                <a href="{{ route('messages.show', $user) }}" class="block border border-gray-200 hover:bg-gray-50 rounded-lg p-4 transition duration-150 ease-in-out">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-semibold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h4>
                                            @php
                                                $unreadCount = \App\Models\Message::where('sender_id', $user->id)
                                                    ->where('receiver_id', auth()->id())
                                                    ->where('is_read', false)
                                                    ->count();
                                            @endphp
                                            @if($unreadCount > 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    {{ $unreadCount }} {{ __('nouveaux messages') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                            <p class="text-gray-800">{{ __('Vous n\'avez pas encore de conversations actives.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 