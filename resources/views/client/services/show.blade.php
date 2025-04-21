<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('client.services.index') }}" class="inline-flex items-center text-blue-600 hover:text-yellow-500 mb-4 transition duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Services
            </a>

            <!-- Main Service Image with Gradient Overlay -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 mb-6">
                <div class="relative h-96 overflow-hidden">
                    <img src="{{ $formattedService['image_path'] }}" alt="{{ $formattedService['name'] }}"
                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-60"></div>
                    
                    <!-- Title and Price Overlay -->
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="inline-block bg-yellow-400 text-black px-3 py-1 rounded-full text-sm font-semibold mb-2">
                                    {{ $formattedService['category'] }}
                                </span>
                                <h1 class="text-3xl font-bold" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                                    {{ $formattedService['name'] }}
                                </h1>
                            </div>
                            <div>
                                <div class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-sm px-4 py-2 rounded-lg">
                                    <span class="text-2xl font-bold">{{ number_format($formattedService['base_price'], 2) }} DH</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Main Content (Left 2/3) -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Description Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-yellow-400 px-6 py-3 flex items-center">
                            <div class="bg-white p-2 rounded-full mr-3">
                                <i class="fas fa-clipboard-list text-yellow-500"></i>
                            </div>
                            <h2 class="text-lg font-bold">Description</h2>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700">{{ $formattedService['description'] }}</p>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-blue-600 px-6 py-3 flex items-center">
                            <div class="bg-white p-2 rounded-full mr-3">
                                <i class="fas fa-calendar-plus text-blue-600"></i>
                            </div>
                            <h2 class="text-lg font-bold text-white">Book this Service</h2>
                        </div>
                        
                        <div class="p-6">
                            @if(isset($formattedService['already_booked']) && $formattedService['already_booked'])
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-blue-700">You have already booked this service.</p>
                                            <a href="{{ route('client.my-requests') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-yellow-500 transition duration-300">
                                                <i class="fas fa-eye mr-2"></i>
                                                View My Requests
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('client.service-requests.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ $formattedService['id'] }}">
                                    <input type="hidden" name="professional_id" value="{{ $formattedService['professional']['id'] }}">
                                    
                                    <div class="mb-4">
                                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                            Please describe what you need help with
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <textarea id="description"
                                            name="description"
                                            rows="4"
                                            class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Be as specific as possible about your requirements, timeline, and any special considerations..."
                                            required></textarea>
                                        <p class="text-sm text-gray-500 mt-2 flex items-start">
                                            <i class="fas fa-lightbulb text-yellow-400 mr-2 mt-1"></i>
                                            <span>The more details you provide, the better the professional can prepare.</span>
                                        </p>
                                    </div>
                                    
                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="px-6 py-3 bg-yellow-400 text-black rounded-lg font-medium hover:bg-yellow-500 transition duration-300 flex items-center"
                                            {{ !$formattedService['is_available'] ? 'disabled' : '' }}>
                                            <i class="fas fa-calendar-check mr-2"></i>
                                            {{ $formattedService['is_available'] ? 'Book Service Now' : 'Service Not Available' }}
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar (Right 1/3) -->
                <div class="space-y-6">
                    <!-- Professional Info -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gray-800 px-6 py-3 flex items-center">
                            <div class="bg-white p-2 rounded-full mr-3">
                                <i class="fas fa-user-tie text-gray-800"></i>
                            </div>
                            <h2 class="text-lg font-bold text-white">Professional</h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="w-16 h-16 rounded-full border-2 border-yellow-400 overflow-hidden mr-4">
                                    <img src="{{ $formattedService['professional']['image'] }}"
                                        alt="{{ $formattedService['professional']['name'] }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold">{{ $formattedService['professional']['name'] }}</h3>
                                    <div class="flex items-center mt-1">
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $formattedService['professional']['rating'])
                                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                @else
                                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600">
                                            ({{ $formattedService['professional']['reviews_count'] }})
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            @auth
                                @if(isset($formattedService['already_booked']) && $formattedService['already_booked'])
                                <div class="mt-4 bg-blue-50 p-3 rounded-lg text-center">
                                    <span class="text-blue-600 font-medium flex items-center justify-center">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Service Requested
                                    </span>
                                </div>
                                @endif
                            @endauth

                            @if($formattedService['is_available'])
                            <div class="mt-4 bg-green-50 p-3 rounded-lg text-center">
                                <span class="text-green-600 font-medium flex items-center justify-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Available Now
                                </span>
                            </div>
                            @else
                            <div class="mt-4 bg-red-50 p-3 rounded-lg text-center">
                                <span class="text-red-600 font-medium flex items-center justify-center">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Currently Unavailable
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Tips Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-green-600 px-6 py-3 flex items-center">
                            <div class="bg-white p-2 rounded-full mr-3">
                                <i class="fas fa-shield-alt text-green-600"></i>
                            </div>
                            <h2 class="text-lg font-bold text-white">Tips</h2>
                        </div>
                        <div class="p-6">
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span class="text-sm">Verify professional credentials</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                    <span class="text-sm">Use platform for communications</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>