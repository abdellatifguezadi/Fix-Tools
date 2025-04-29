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
                    
                    @php
                        $hasConversations = false;
                        foreach ($users as $user) {
                            if ($user->receivedMessages()->count() > 0 || $user->sentMessages()->count() > 0) {
                                $hasConversations = true;
                                break;
                            }
                        }
                    @endphp

                    @if($hasConversations)
                        <div class="space-y-4">
                            @foreach($users as $user)
                                @if($user->receivedMessages()->count() > 0 || $user->sentMessages()->count() > 0)
                                    <a href="{{ route('messages.show', $user) }}" class="block border border-gray-200 hover:bg-gray-50 rounded-lg p-4 transition duration-150 ease-in-out">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                @if($user->deleted_at)
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">
                                                        <i class="fas fa-user-slash"></i>
                                                    </div>
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-semibold">
                                                        {{ substr($user->name ?? 'U', 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <h4 class="text-lg font-semibold text-gray-900">
                                                    {{ $user->deleted_at ? 'Utilisateur supprimé' : ($user->name ?? 'Unknown') }}
                                                </h4>
                                                @if($user->unread_count > 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        {{ $user->unread_count }} {{ __('nouveaux messages') }}
                                                    </span>
                                                @endif
                                                @if($user->deleted_at)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-1">
                                                        <i class="fas fa-info-circle mr-1"></i> Compte supprimé
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endif
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