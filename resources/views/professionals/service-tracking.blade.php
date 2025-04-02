<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Service Tracking') }}
        </h2>
    </x-slot>

    <div class="min-h-screen pb-32">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-xl font-bold">Service Tracking</h1>
                            <div class="bg-yellow-100 px-4 py-2 rounded-lg">
                                <span class="text-yellow-800">Points accumulés : </span>
                                <span class="font-bold text-yellow-800">{{ $totalPoints ?? 0 }}</span>
                            </div>
                        </div>

                        <!-- Summary Section -->
                        <div class="bg-white p-6 rounded-lg shadow-md mt-4">
                            <h2 class="text-lg font-bold">Summary</h2>
                            <div class="flex justify-between mt-4">
                                <div>
                                    <p class="text-gray-600">Vous avez complété <span class="font-semibold">{{ $completedServicesCount ?? 0 }} services</span> ce mois.</p>
                                    <p class="text-gray-600">Points accumulés: <span class="font-semibold">{{ $totalPoints ?? 0 }} points</span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Services Complétés -->
                        <h2 class="text-xl font-bold mt-8">Services Complétés</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                            @forelse($completedServices ?? [] as $service)
                            <div class="bg-white p-4 rounded-lg shadow-lg border-t-4 border-yellow-400 transition-transform transform hover:scale-105 cursor-pointer">
                                @if($service->image)
                                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->title }}" class="w-full h-32 object-cover rounded-md mb-2">
                                @else
                                    <div class="w-full h-32 bg-gray-200 rounded-md mb-2 flex items-center justify-center">
                                        <i class="fas fa-tools text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                                <h3 class="font-bold">{{ $service->title }}</h3>
                                <p class="text-gray-600">{{ Str::limit($service->description, 100) }}</p>
                                <p class="font-semibold">Points Earned: {{ $service->points ?? 0 }}</p>
                                @if($service->latestReview)
                                    <p class="text-gray-500 italic mt-2">"{{ Str::limit($service->latestReview->comment, 50) }}" - {{ $service->latestReview->client->name }}</p>
                                @endif
                            </div>
                            @empty
                            <div class="col-span-3">
                                <div class="bg-gray-50 rounded-lg p-6 text-center">
                                    <p class="text-gray-600">Aucun service complété pour le moment.</p>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 