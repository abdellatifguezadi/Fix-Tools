<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header with Return Button -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Leave a Review</h1>
            <a href="{{ route('client.my-requests') }}" 
               class="px-4 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-300 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to My Requests
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <!-- Service and Professional Info -->
            <div class="flex flex-col md:flex-row items-start gap-6 mb-6">
                <!-- Service Info -->
                <div class="w-full md:w-1/2">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-xl font-bold mb-2">Service Information</h3>
                        <div class="mb-4">
                            <img src="{{ $serviceRequest->service->image_path ? '/storage/' . $serviceRequest->service->image_path : 'https://via.placeholder.com/400x200?text=Service+Image' }}" 
                                 alt="{{ $serviceRequest->service->name }}" 
                                 class="w-full h-48 object-cover rounded-lg">
                        </div>
                        <h4 class="text-lg font-semibold">{{ $serviceRequest->service->name }}</h4>
                        <p class="text-gray-600 mb-2">{{ $serviceRequest->service->category ? $serviceRequest->service->category->name : 'Uncategorized' }}</p>
                        <p class="text-gray-600 mb-4">Completed on {{ $serviceRequest->completion_date ? $serviceRequest->completion_date->format('M d, Y') : 'N/A' }}</p>
                        <p class="font-medium">Price: {{ number_format($serviceRequest->final_price, 2) }} MAD</p>
                    </div>
                </div>
                
                <!-- Professional Info -->
                <div class="w-full md:w-1/2">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-xl font-bold mb-2">Professional Information</h3>
                        <div class="flex items-center space-x-4 mb-4">
                            @if(!empty($serviceRequest->professional->image))
                                <img src="/storage/{{ $serviceRequest->professional->image }}" 
                                     alt="{{ $serviceRequest->professional->name }}" 
                                     class="w-16 h-16 rounded-full object-cover border-2 border-yellow-400">
                            @elseif(!empty($serviceRequest->professional->profile_image))
                                <img src="/storage/{{ $serviceRequest->professional->profile_image }}" 
                                     alt="{{ $serviceRequest->professional->name }}" 
                                     class="w-16 h-16 rounded-full object-cover border-2 border-yellow-400">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($serviceRequest->professional->name) }}&background=4F46E5&color=ffffff" 
                                     alt="{{ $serviceRequest->professional->name }}" 
                                     class="w-16 h-16 rounded-full object-cover border-2 border-gray-300">
                            @endif
                            <div>
                                <p class="font-medium text-lg">{{ $serviceRequest->professional->name }}</p>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span>{{ number_format($serviceRequest->professional->receivedReviews()->avg('rating') ?? 0, 1) }} ({{ $serviceRequest->professional->receivedReviews()->count() }} reviews)</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600">{{ $serviceRequest->professional->bio ?? 'No bio available' }}</p>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="service_request_id" value="{{ $serviceRequest->id }}">
                
                <!-- Rating -->
                <div class="mb-6">
                    <label for="rating" class="block text-gray-700 font-semibold mb-2">Rating</label>
                    <div class="flex items-center space-x-2">
                        <div class="rating-container flex space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="rating-star text-3xl text-gray-300 hover:text-yellow-400 focus:outline-none" data-value="{{ $i }}">★</button>
                            @endfor
                        </div>
                        <span class="ml-2 text-gray-600" id="rating-text">Select a rating</span>
                        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                    </div>
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Comment -->
                <div class="mb-6">
                    <label for="comment" class="block text-gray-700 font-semibold mb-2">Your Review</label>
                    <textarea name="comment" id="comment" rows="5" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                              placeholder="Share your experience with this service...">{{ old('comment') }}</textarea>
                    <p class="text-gray-500 text-sm mt-1">Minimum 10 characters, maximum 500 characters.</p>
                    @error('comment')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <div class="text-right">
                    <button type="submit" class="px-6 py-3 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition-colors">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rating-star');
            const ratingInput = document.getElementById('rating-input');
            const ratingText = document.getElementById('rating-text');
            const ratingLabels = ['Very Poor', 'Poor', 'Average', 'Good', 'Excellent'];
            
            // Check if there's an existing rating to restore
            if (ratingInput.value) {
                highlightStars(parseInt(ratingInput.value));
            }
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = parseInt(this.dataset.value);
                    highlightStars(value);
                    ratingInput.value = value;
                    ratingText.textContent = `${value} - ${ratingLabels[value-1]}`;
                });
                
                star.addEventListener('mouseenter', function() {
                    const value = parseInt(this.dataset.value);
                    
                    stars.forEach((s, index) => {
                        if (index < value) {
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300');
                        } else {
                            s.classList.add('text-gray-300');
                            s.classList.remove('text-yellow-400');
                        }
                    });
                });
                
                star.addEventListener('mouseleave', function() {
                    // Restore the selected rating
                    if (ratingInput.value) {
                        highlightStars(parseInt(ratingInput.value));
                    } else {
                        // No rating selected, reset all stars
                        stars.forEach(s => {
                            s.classList.add('text-gray-300');
                            s.classList.remove('text-yellow-400');
                        });
                    }
                });
            });
            
            function highlightStars(value) {
                stars.forEach((s, index) => {
                    if (index < value) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.add('text-gray-300');
                        s.classList.remove('text-yellow-400');
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout> 