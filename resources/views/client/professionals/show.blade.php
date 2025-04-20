<x-app-layout>
    <x-slot name="title">{{ $professional->name }} - Professional Profile</x-slot>

    <div class="bg-gray-50 min-h-screen">
        <!-- Header -->
        <div class="bg-black text-white py-8">
            <div class="container mx-auto px-4">
                <div class="flex items-center mb-4">
                    <a href="{{ route('client.professionals.index') }}" class="text-yellow-400 hover:text-yellow-300 mr-4">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to Professionals') }}
                    </a>
                </div>
                <h1 class="text-3xl font-bold">{{ $professional->name }}</h1>
                <p class="text-lg text-gray-300 mt-1">{{ $professional->specialty ?? 'Professional' }}</p>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Left Column - Profile Info -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                        <div class="relative h-60">
                            @if($professional->image)
                                <img src="{{ asset('storage/'.$professional->image) }}" alt="{{ $professional->name }}" 
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400 text-6xl"></i>
                                </div>
                            @endif
                            @if($professional->average_rating)
                                <div class="absolute top-4 right-4 bg-yellow-400 text-black px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ number_format($professional->average_rating, 1) }} ★
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-yellow-400 mr-3 w-5 text-center"></i>
                                    <span>{{ $professional->completed_services_count ?? 0 }}+ {{ __('completed jobs') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-yellow-400 mr-3 w-5 text-center"></i>
                                    <span>{{ $professional->experience ?? '?' }}+ {{ __('years experience') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-yellow-400 mr-3 w-5 text-center"></i>
                                    <span>{{ $professional->city ?? __('Location not specified') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-yellow-400 mr-3 w-5 text-center"></i>
                                    <span>{{ $professional->phone ?? __('Contact via platform') }}</span>
                                </div>
                                @if($professional->email)
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-yellow-400 mr-3 w-5 text-center"></i>
                                    <span class="truncate">{{ $professional->email }}</span>
                                </div>
                                @endif
                            </div>

                            <hr class="my-4">

                            <h3 class="font-semibold text-lg mb-2">{{ __('Specializations') }}</h3>
                            <div class="flex flex-wrap gap-2 mb-4">
                                @forelse($professional->skills as $skill)
                                    <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">{{ $skill }}</span>
                                @empty
                                    <span class="text-gray-500 text-sm">{{ __('No specializations listed') }}</span>
                                @endforelse
                            </div>

                            <a href="{{ route('client.services.index', ['professional_id' => $professional->id]) }}" 
                               class="block w-full bg-yellow-400 text-center text-black px-4 py-3 rounded-lg hover:bg-yellow-300 transition-colors font-semibold mt-4">
                                {{ __('View Services') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Bio, Services and Reviews -->
                <div class="md:col-span-2">
                    <!-- Bio -->
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <h2 class="text-xl font-bold mb-4">{{ __('About') }}</h2>
                        <p class="text-gray-700">
                            {{ $professional->description ?? __('This professional has not added a description yet.') }}
                        </p>
                    </div>

                    <!-- Services -->
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">{{ __('Available Services') }}</h2>
                            <a href="{{ route('client.services.index', ['professional_id' => $professional->id]) }}" class="text-yellow-500 hover:text-yellow-600">
                                {{ __('View All') }} <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-4">
                            @forelse($services->take(3) as $service)
                                <div class="border rounded-lg p-4 flex items-center">
                                    <div class="h-16 w-16 bg-gray-100 rounded-lg mr-4 flex-shrink-0 overflow-hidden">
                                        @if($service->image_path)
                                            <img src="{{ asset('storage/'.$service->image_path) }}" alt="{{ $service->name }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center">
                                                <i class="fas fa-tools text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <h3 class="font-semibold">{{ $service->name }}</h3>
                                        <p class="text-sm text-gray-600 mb-1">{{ Str::limit($service->description, 60) }}</p>
                                        <div class="flex justify-between items-center">
                                            <span class="font-bold text-yellow-600">{{ number_format($service->base_price, 2) }} €</span>
                                            <a href="{{ route('client.services.show', $service) }}" class="text-sm text-yellow-500 hover:text-yellow-600">
                                                {{ __('View Details') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500">
                                    {{ __('No services available from this professional.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Reviews -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">{{ __('Client Reviews') }}</h2>
                        </div>
                        
                        <div class="space-y-4">
                            @forelse($reviews as $review)
                                <div class="border-b pb-4 last:border-0">
                                    <div class="flex items-center mb-2">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700 mb-2">{{ $review->comment }}</p>
                                    <div class="flex items-center">
                                        <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                                        <span class="text-sm font-medium">{{ $review->client->name }}</span>
                                        <span class="mx-2 text-sm text-gray-500">•</span>
                                        <span class="text-sm text-gray-500">{{ $review->serviceRequest->service->name ?? 'Service' }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-500">
                                    {{ __('No reviews yet for this professional.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 