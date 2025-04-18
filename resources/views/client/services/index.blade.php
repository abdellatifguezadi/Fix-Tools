<x-app-layout>
    <!-- Header Section -->
    <header class="bg-black text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Our Services</h1>
            <p class="text-xl text-gray-300 mb-6">Find the right service for your needs</p>
            <a href="{{ route('client.my-requests') }}" class="inline-flex items-center bg-yellow-400 hover:bg-yellow-300 text-black font-semibold py-3 px-6 rounded-lg transition-colors">
                <i class="fas fa-clipboard-list mr-2"></i>
                My Service Requests
                @if(isset($pendingRequestsCount) && $pendingRequestsCount > 0)
                    <span class="ml-2 bg-white text-yellow-500 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">{{ $pendingRequestsCount }}</span>
                @endif
            </a>
        </div>
    </header>

    <!-- Search and Filter Section -->
    <div class="container mx-auto px-4">
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <div class="flex flex-wrap gap-4 justify-center">
                <div class="relative flex-1 max-w-xl">
                    <input type="text" id="searchInput" name="search" placeholder="Search services by Category or Name" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 pl-12"
                        value="{{ request('search') }}">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button type="button" id="clearSearch" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="relative">
                    <select id="categoryFilter" name="category" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 pr-10">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" id="clearCategory" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="relative">
                    <select id="priceFilter" name="price_range" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 pr-10">
                        <option value="">All Prices</option>
                        <option value="0-50" {{ request('price_range') == '0-50' ? 'selected' : '' }}>0 - 50 DH</option>
                        <option value="51-100" {{ request('price_range') == '51-100' ? 'selected' : '' }}>51 - 100 DH</option>
                        <option value="101+" {{ request('price_range') == '101+' ? 'selected' : '' }}>101+ DH</option>
                    </select>
                    <button type="button" id="clearPrice" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
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
        
        <!-- Loading indicator -->
        <div id="loadingIndicator" class="hidden text-center py-12">
            <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-yellow-400 mx-auto"></div>
            <p class="mt-4 text-gray-600">Loading services...</p>
        </div>
        
        <!-- No results message -->
        <div id="noResults" class="hidden text-center py-12">
            <i class="fas fa-search text-5xl text-gray-300 mb-4"></i>
            <p class="text-xl text-gray-500">No services found matching your criteria.</p>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const priceFilter = document.getElementById('priceFilter');
            const servicesGrid = document.getElementById('servicesGrid');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const noResults = document.getElementById('noResults');

            const clearSearch = document.getElementById('clearSearch');
            const clearCategory = document.getElementById('clearCategory');
            const clearPrice = document.getElementById('clearPrice');

            let searchTimeout;

            function updateClearButtons() {

                clearSearch.style.display = searchInput.value ? 'block' : 'none';
                clearCategory.style.display = categoryFilter.value ? 'block' : 'none';
                clearPrice.style.display = priceFilter.value ? 'block' : 'none';
            }

            function performSearch() {
                servicesGrid.style.opacity = '0.5';
                loadingIndicator.style.display = 'block';
                noResults.style.display = 'none';

                updateClearButtons();

                const search = searchInput.value;
                const category = categoryFilter.value;
                const priceRange = priceFilter.value;

                const url = `{{ route('client.services.search') }}?search=${encodeURIComponent(search)}&category=${encodeURIComponent(category)}&price_range=${encodeURIComponent(priceRange)}`;

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    servicesGrid.style.opacity = '1';
                    loadingIndicator.style.display = 'none';

                    if (data.length === 0) {
                        servicesGrid.innerHTML = '';
                        noResults.style.display = 'block';
                        return;
                    }

                    noResults.style.display = 'none';
                    const serviceHTML = data.map(service => {
                        return `
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                <div class="relative h-56">
                                    <img src="${service.image_path}" 
                                        alt="${service.name}" 
                                        class="w-full h-full object-cover">
                                    <div class="absolute top-4 right-4 bg-yellow-400 text-black px-3 py-1 rounded-full text-sm font-semibold">
                                        ${service.base_price} DH/hr
                                    </div>
                                    ${service.already_booked ? `
                                        <div class="absolute top-4 left-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                            Already Booked
                                        </div>
                                    ` : ''}
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
                                                <span>${service.professional.rating} (${service.professional.reviews_count} reviews)</span>
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
                                    </div>
                                    
                                    ${service.already_booked ? `
                                        <a href="{{ route('client.my-requests') }}" 
                                           class="w-full mt-6 px-4 py-3 rounded-lg transition-colors font-semibold text-center block bg-blue-500 text-white hover:bg-blue-600">
                                            View My Request
                                        </a>
                                    ` : `
                                        <a href="/services/${service.id}" 
                                           class="w-full mt-6 px-4 py-3 rounded-lg transition-colors font-semibold text-center block ${service.is_available ? 'bg-yellow-400 text-black hover:bg-yellow-300' : 'bg-gray-300 text-gray-500 cursor-not-allowed'}">
                                            ${service.is_available ? 'View Details & Book' : 'Service Not Available'}
                                        </a>
                                    `}
                                </div>
                            </div>
                        `;
                    }).join('');
                    
                    servicesGrid.innerHTML = serviceHTML;
                })
                .catch(error => {
                    // Cacher l'indicateur de chargement
                    servicesGrid.style.opacity = '1';
                    loadingIndicator.style.display = 'none';
                    
                    // Afficher un message d'erreur
                    servicesGrid.innerHTML = `
                        <div class="col-span-3 text-center py-12">
                            <i class="fas fa-exclamation-circle text-5xl text-red-500 mb-4"></i>
                            <p class="text-xl text-gray-700">Error loading services</p>
                            <p class="text-sm text-gray-500 mt-2">Please try again</p>
                        </div>
                    `;
                });
            }
            
            // Événement pour le champ de recherche (avec debounce)
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 500);
                updateClearButtons();
            });
            
            // Événements pour les filtres
            categoryFilter.addEventListener('change', function() {
                performSearch();
                updateClearButtons();
            });
            
            priceFilter.addEventListener('change', function() {
                performSearch();
                updateClearButtons();
            });
            
            // Gestionnaires pour les boutons de réinitialisation
            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                performSearch();
            });
            
            clearCategory.addEventListener('click', function() {
                categoryFilter.value = '';
                performSearch();
            });
            
            clearPrice.addEventListener('click', function() {
                priceFilter.value = '';
                performSearch();
            });
            
            // Exécuter la recherche au chargement de la page
            updateClearButtons();
            performSearch();
        });
    </script>
    @endpush
</x-app-layout> 