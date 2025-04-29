<x-app-layout>
    <x-slot name="title">Our Professional Network</x-slot>
    
    <header class="bg-black text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">{{ __('Our Professional Network') }}</h1>
            <p class="text-xl text-gray-300">{{ __('Find the right expert for your project') }}</p>
        </div>
    </header>

    <div class="bg-white shadow-md py-6">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap gap-4 items-center justify-center">
                <div class="relative flex-1 max-w-xl">
                    <input type="text" id="search-input" placeholder="{{ __('Search professionals by name, service, or location...') }}" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 pl-12">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                
                <select id="service-filter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="">{{ __('All Services') }}</option>
                    @foreach($serviceCategories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>

                <select id="experience-filter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="">{{ __('Experience Level') }}</option>
                    <option value="1-5">1-5 {{ __('years') }}</option>
                    <option value="5-10">5-10 {{ __('years') }}</option>
                    <option value="10-15">10-15 {{ __('years') }}</option>
                    <option value="15+">15+ {{ __('years') }}</option>
                </select>

                <button id="filter-button" class="bg-yellow-400 text-black px-6 py-2 rounded-lg hover:bg-yellow-300 font-medium">
                    <i class="fas fa-filter mr-2"></i>{{ __('Filter') }}
                </button>
            </div>
        </div>
    </div>

    <section class="py-12">
        <div class="container mx-auto px-4">
            <div id="professionals-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($professionals as $professional)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div class="relative h-56">
                            @if($professional->image)
                                <img src="{{ asset('storage/'.$professional->image) }}" alt="{{ $professional->name }}" 
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                            @if($professional->average_rating)
                                <div class="absolute top-4 right-4 bg-yellow-400 text-black px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ number_format($professional->average_rating, 1) }} ★
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <h3 class="text-xl font-bold mb-1">{{ $professional->name }}</h3>
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="font-medium">{{ $professional->specialty ?? 'No specialty' }}</span>
                                    @if($professional->experience)
                                        <span class="mx-2">•</span>
                                        <span class="bg-gray-100 px-2 py-0.5 rounded-full">{{ $professional->experience }}+ {{ __('years') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-check-circle text-yellow-400 mr-2"></i>
                                    <span>{{ $professional->completed_services_count ?? 0 }}+ {{ __('completed jobs') }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-map-marker-alt text-yellow-400 mr-2"></i>
                                    <span>{{ $professional->city ?? __('Not specified') }}</span>
                                </div>
                                <p class="text-gray-600 text-sm">
                                    {{ $professional->bio ?? __('No description available') }}
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($professional->skills as $skill)
                                        <span class="bg-gray-100 px-3 py-1 rounded-full text-xs">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex gap-2 mt-6">
                                <a href="{{ route('client.professionals.show', $professional) }}" 
                                    class="flex-1 block bg-yellow-400 text-center text-black px-4 py-3 rounded-lg hover:bg-yellow-300 transition-colors font-semibold">
                                    {{ __('View Profile') }}
                                </a>
                                <a href="{{ route('messages.show', $professional->user_id ?? $professional->id) }}" 
                                    class="flex-none block bg-black text-center text-yellow-400 px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors font-semibold w-12">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-8">
                        <div class="bg-gray-50 rounded-lg p-6 inline-block">
                            <p class="text-gray-600">{{ __('No professionals found matching your criteria.') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $professionals->links() }}
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const serviceFilter = document.getElementById('service-filter');
            const experienceFilter = document.getElementById('experience-filter');
            const filterButton = document.getElementById('filter-button');

            filterButton.addEventListener('click', function() {
                applyFilters();
            });

            function applyFilters() {
                let url = new URL(window.location.href);
                
                if (searchInput.value) {
                    url.searchParams.set('search', searchInput.value);
                } else {
                    url.searchParams.delete('search');
                }
                
                if (serviceFilter.value) {
                    url.searchParams.set('service', serviceFilter.value);
                } else {
                    url.searchParams.delete('service');
                }
                
                if (experienceFilter.value) {
                    url.searchParams.set('experience', experienceFilter.value);
                } else {
                    url.searchParams.delete('experience');
                }
                
                window.location.href = url.toString();
            }
        });
    </script>
    @endpush
</x-app-layout> 