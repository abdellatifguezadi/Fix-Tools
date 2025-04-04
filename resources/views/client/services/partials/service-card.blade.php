<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
    <div class="relative h-56">
        <img src="{{ $service['image_path'] }}" 
            alt="{{ $service['name'] }}" 
            class="w-full h-full object-cover">
        <div class="absolute top-4 right-4 bg-yellow-400 text-black px-3 py-1 rounded-full text-sm font-semibold">
            ${{ number_format($service['base_price'], 2) }}/hr
        </div>
    </div>
    <div class="p-6">
        <div class="flex items-center space-x-4 mb-4">
            <img src="{{ $service['professional']['image'] }}" 
                alt="{{ $service['professional']['name'] }}" 
                class="w-12 h-12 rounded-full object-cover">
            <div>
                <h3 class="font-bold">{{ $service['professional']['name'] }}</h3>
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <span>{{ number_format($service['professional']['rating'], 1) }} ({{ $service['professional']['reviews_count'] }} reviews)</span>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <h2 class="text-xl font-bold mb-2">{{ $service['name'] }}</h2>
            <p class="text-gray-600 text-sm">
                {{ $service['description'] }}
            </p>
        </div>
        <div class="space-y-3">
            <div class="flex items-center text-sm">
                <i class="fas fa-tag text-yellow-400 mr-2"></i>
                <span>Category: {{ $service['category'] }}</span>
            </div>
            <div class="flex items-center text-sm">
                <i class="fas fa-clock text-yellow-400 mr-2"></i>
                <span class="{{ $service['is_available'] ? 'text-green-600' : 'text-red-600' }}">
                    {{ $service['is_available'] ? 'Available' : 'Not Available' }}
                </span>
            </div>
            <div class="flex flex-wrap gap-2">
                <span class="bg-gray-100 px-3 py-1 rounded-full text-xs">Professional Service</span>
                <span class="bg-gray-100 px-3 py-1 rounded-full text-xs">Licensed</span>
                <span class="bg-gray-100 px-3 py-1 rounded-full text-xs">Insured</span>
            </div>
        </div>
        <a href="{{ $service['is_available'] ? route('client.services.show', $service['id']) : '#' }}" 
           class="w-full mt-6 px-4 py-3 rounded-lg transition-colors font-semibold text-center block {{ $service['is_available'] ? 'bg-yellow-400 text-black hover:bg-yellow-300' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
           {{ !$service['is_available'] ? 'disabled' : '' }}>
            {{ $service['is_available'] ? 'Book Service' : 'Service Not Available' }}
        </a>
    </div>
</div> 