<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Fix and Tools</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <style>
        .logo-text {
            font-family: 'Brush Script MT', 'Dancing Script', cursive;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navbar />

    <!-- Header Section -->
    <header class="bg-black text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Our Services</h1>
            <p class="text-xl text-gray-300">Find the right service for your needs</p>
        </div>
    </header>

    <!-- Search and Filter Section -->
    <div class="container mx-auto px-4">
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <div class="flex flex-wrap gap-4 justify-center">
                <div class="relative flex-1 max-w-xl">
                    <input type="text" placeholder="Search services by Category or Name" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 pl-12">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <select class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="">Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <select class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="">Price Range</option>
                    <option value="0-50">$0 - $50</option>
                    <option value="51-100">$51 - $100</option>
                    <option value="101+">$101+</option>
                </select>
                <button class="bg-yellow-400 text-black px-6 py-2 rounded-lg hover:bg-yellow-300">
                    Search
                </button>
            </div>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
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
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-black text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="text-center text-yellow-400">
                <p>&copy; {{ date('Y') }} Fix and Tools. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html> 