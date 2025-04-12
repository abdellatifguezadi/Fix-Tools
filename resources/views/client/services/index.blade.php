<x-app-layout>
    <!-- Header Section -->
    <header class="bg-black text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Our Services</h1>
            <p class="text-xl text-gray-300 mb-6">Find the right service for your needs</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('client.service-requests.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-yellow-400 text-black rounded-lg font-semibold hover:bg-yellow-300 transition-colors">
                    <i class="fas fa-list mr-2"></i>
                    My Service Requests
                    @if($pendingRequestsCount > 0)
                        <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $pendingRequestsCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </header>

    <!-- Search and Filter Section -->
    <div class="container mx-auto px-4">
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <div class="flex flex-wrap gap-4 justify-center">
                <div class="relative flex-1 max-w-xl">
                    <input type="text" id="searchInput" placeholder="Search services by Category or Name" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 pl-12">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <select id="categoryFilter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <select id="priceFilter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="">All Prices</option>
                    <option value="0-50">$0 - $50</option>
                    <option value="51-100">$51 - $100</option>
                    <option value="101+">$101+</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="container mx-auto px-4 py-8">
        <div id="servicesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
                @include('client.services.partials.service-card', ['service' => $service])
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script>
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const priceFilter = document.getElementById('priceFilter');
        const servicesGrid = document.getElementById('servicesGrid');

        function performSearch() {
            const search = searchInput.value;
            const category = categoryFilter.value;
            const priceRange = priceFilter.value;

            fetch(`{{ route('client.services.search') }}?search=${search}&category=${category}&price_range=${priceRange}`)
                .then(response => response.json())
                .then(services => {
                    servicesGrid.innerHTML = services.map(service => `
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                            <div class="relative h-56">
                                <img src="${service.image_path}" 
                                    alt="${service.name}" 
                                    class="w-full h-full object-cover">
                                <div class="absolute top-4 right-4 bg-yellow-400 text-black px-3 py-1 rounded-full text-sm font-semibold">
                                    $${parseFloat(service.base_price).toFixed(2)}/hr
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center space-x-4 mb-4">
                                    <img src="${service.professional.image}" 
                                        alt="${service.professional.name}" 
                                        class="w-12 h-12 rounded-full object-cover">
                                    <div>
                                        <h3 class="font-bold">${service.professional.name}</h3>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                                            <span>${parseFloat(service.professional.rating).toFixed(1)} (${service.professional.reviews_count} reviews)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <h2 class="text-xl font-bold mb-2">${service.name}</h2>
                                    <p class="text-gray-600 text-sm">
                                        ${service.description}
                                    </p>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-center text-sm">
                                        <i class="fas fa-tag text-yellow-400 mr-2"></i>
                                        <span>Category: ${service.category}</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <i class="fas fa-clock text-yellow-400 mr-2"></i>
                                        <span class="${service.is_available ? 'text-green-600' : 'text-red-600'}">
                                            ${service.is_available ? 'Available' : 'Not Available'}
                                        </span>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="bg-gray-100 px-3 py-1 rounded-full text-xs">Professional Service</span>
                                        <span class="bg-gray-100 px-3 py-1 rounded-full text-xs">Licensed</span>
                                        <span class="bg-gray-100 px-3 py-1 rounded-full text-xs">Insured</span>
                                    </div>
                                </div>
                                <form action="{{ route('client.service-requests.store') }}" method="POST" class="mt-6">
                                    @csrf
                                    <input type="hidden" name="service_id" value="${service.id}">
                                    <input type="hidden" name="professional_id" value="${service.professional.id}">
                                    <div class="mb-4">
                                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                        <textarea name="description" 
                                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                                                placeholder="Describe what you need help with..."
                                                required></textarea>
                                    </div>
                                    <button type="submit" 
                                            class="w-full px-4 py-3 rounded-lg transition-colors font-semibold text-center block ${service.is_available ? 'bg-yellow-400 text-black hover:bg-yellow-300' : 'bg-gray-300 text-gray-500 cursor-not-allowed'}"
                                            ${!service.is_available ? 'disabled' : ''}>
                                        ${service.is_available ? 'Book Service' : 'Service Not Available'}
                                    </button>
                                </form>
                            </div>
                        </div>
                    `).join('');
                })
                .catch(error => console.error('Error:', error));
        }

        // Add event listeners with debounce for search input
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 500);
        });

        // Add event listeners for filters
        categoryFilter.addEventListener('change', performSearch);
        priceFilter.addEventListener('change', performSearch);
    </script>
    @endpush
</x-app-layout> 