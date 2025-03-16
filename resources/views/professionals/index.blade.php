<x-app-layout>
    <x-slot name="title">
        Nos Professionnels
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Nos Professionnels</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($professionals as $professional)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img src="{{ $professional->profile_photo_url }}" alt="{{ $professional->name }}" class="w-16 h-16 rounded-full object-cover">
                            <div class="ml-4">
                                <h2 class="text-xl font-semibold">{{ $professional->name }}</h2>
                                <p class="text-gray-600">{{ $professional->specialization ?? 'Professionnel polyvalent' }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                <span class="font-semibold">{{ number_format($professional->received_reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="text-gray-600 ml-1">({{ $professional->received_reviews_count ?? 0 }} avis)</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-tools text-gray-600 mr-1"></i>
                                <span>{{ $professional->service_requests_count ?? 0 }} services réalisés</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('professionals.show', $professional) }}" class="inline-block bg-yellow-400 text-black px-4 py-2 rounded font-semibold hover:bg-yellow-300">
                                Voir le profil
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $professionals->links() }}
        </div>
    </div>
</x-app-layout> 