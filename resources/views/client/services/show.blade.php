<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Back button -->
            <a href="{{ route('client.services.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Services
            </a>

            <!-- Service Details -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Service Image -->
                <div class="relative h-96">
                    <img src="{{ $formattedService['image_path'] }}" alt="{{ $formattedService['name'] }}" 
                         class="w-full h-full object-cover">
                </div>

                <div class="p-6">
                    <!-- Service Title and Category -->
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $formattedService['name'] }}</h1>
                            <p class="text-gray-600 mt-1">Category: {{ $formattedService['category'] }}</p>
                        </div>
                        <div class="text-right">
                            <div class="mt-4 flex items-center space-x-4">
                                <span class="text-2xl font-bold text-blue-600">{{ number_format($formattedService['base_price'], 2) }} DH</span>
                                <span class="text-gray-500 text-sm">/hr</span>
                            </div>
                            <div class="mt-1">
                                @if($formattedService['is_available'])
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Available
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Unavailable
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Service Description -->
                    <div class="prose max-w-none mb-8">
                        <p class="text-gray-700">{{ $formattedService['description'] }}</p>
                    </div>

                    <!-- Professional Information -->
                    <div class="border-t pt-6">
                        <h2 class="text-xl font-semibold mb-4">Professional</h2>
                        <div class="flex items-center">
                            <img src="{{ $formattedService['professional']['image'] }}" 
                                 alt="{{ $formattedService['professional']['name'] }}"
                                 class="w-16 h-16 rounded-full object-cover">
                            <div class="ml-4">
                                <h3 class="text-lg font-medium">{{ $formattedService['professional']['name'] }}</h3>
                                <div class="flex items-center mt-1">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $formattedService['professional']['rating'])
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600">
                                        ({{ $formattedService['professional']['reviews_count'] }} reviews)
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-4">Book this Service</h2>
                        
                        @if(isset($formattedService['already_booked']) && $formattedService['already_booked'])
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-blue-500 text-lg mr-3"></i>
                                    <p class="text-blue-600">You have already booked this service.</p>
                                </div>
                                <a href="{{ route('client.my-requests') }}" class="mt-4 inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">
                                    View My Requests
                                </a>
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
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Be as specific as possible about your requirements, timeline, and any special considerations..."
                                            required></textarea>
                                    <p class="text-sm text-gray-500 mt-1">The more details you provide, the better the professional can prepare for your service.</p>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="px-6 py-3 bg-yellow-400 text-black rounded-lg font-medium hover:bg-yellow-300 transition duration-150 flex items-center"
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
        </div>
    </div>
</x-app-layout> 