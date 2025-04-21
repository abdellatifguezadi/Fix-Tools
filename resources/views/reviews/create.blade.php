<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header with Return Button -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-star text-yellow-400 mr-2"></i>Leave a Review
            </h1>
            <a href="{{ route('client.my-requests') }}" 
               class="px-4 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-500 hover:scale-105 transition duration-300 transform shadow-sm hover:shadow flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to My Requests
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md mb-6" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-xl text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-bold">Please fix the following errors:</p>
                        <ul class="mt-1 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content - Using Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Service Info Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition duration-300 transform hover:scale-102">
                <div class="bg-yellow-400 text-white px-4 py-3 flex items-center">
                    <i class="fas fa-tools mr-2"></i>
                    <h3 class="text-lg font-bold">Service Details</h3>
                </div>
                
                <div class="relative">
                    <img src="{{ $serviceRequest->service->image_path ? '/storage/' . $serviceRequest->service->image_path : 'https://via.placeholder.com/400x200?text=Service+Image' }}" 
                         alt="{{ $serviceRequest->service->name }}" 
                         class="w-full h-48 object-cover transition duration-300 hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-0 hover:opacity-50 transition duration-300 pointer-events-none"></div>
                </div>
                
                <div class="p-4">
                    <h4 class="text-xl font-semibold text-gray-800 hover:text-yellow-500 transition duration-300">{{ $serviceRequest->service->name }}</h4>
                    
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center">
                            <span class="bg-gray-100 rounded-full p-2 mr-3">
                                <i class="fas fa-tag text-yellow-500"></i>
                            </span>
                            <p class="text-gray-700">{{ $serviceRequest->service->category ? $serviceRequest->service->category->name : 'Uncategorized' }}</p>
                        </div>
                        
                        <div class="flex items-center">
                            <span class="bg-gray-100 rounded-full p-2 mr-3">
                                <i class="far fa-calendar-check text-green-500"></i>
                            </span>
                            <p class="text-gray-700">Completed on {{ $serviceRequest->completion_date ? $serviceRequest->completion_date->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        
                        <div class="flex items-center bg-yellow-50 p-3 rounded-lg mt-4 border-l-4 border-yellow-400">
                            <i class="fas fa-coins text-yellow-500 mr-2 text-xl"></i>
                            <p class="font-medium text-gray-800">{{ number_format($serviceRequest->final_price, 2) }} MAD</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Professional Info Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition duration-300 transform hover:scale-102">
                <div class="bg-blue-500 text-white px-4 py-3 flex items-center">
                    <i class="fas fa-user-tie mr-2"></i>
                    <h3 class="text-lg font-bold">Professional Profile</h3>
                </div>
                
                <div class="p-4">
                    <div class="flex items-center space-x-4 mb-6 bg-gray-50 p-4 rounded-lg">
                        <div class="relative">
                            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-yellow-400 shadow-md transition duration-300 hover:scale-110 hover:shadow-lg">
                                @if(!empty($serviceRequest->professional->image))
                                    <img src="/storage/{{ $serviceRequest->professional->image }}" 
                                         alt="{{ $serviceRequest->professional->name }}" 
                                         class="w-full h-full object-cover">
                                @elseif(!empty($serviceRequest->professional->profile_image))
                                    <img src="/storage/{{ $serviceRequest->professional->profile_image }}" 
                                         alt="{{ $serviceRequest->professional->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($serviceRequest->professional->name) }}&background=4F46E5&color=ffffff" 
                                         alt="{{ $serviceRequest->professional->name }}" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="absolute -bottom-1 -right-1 bg-green-500 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center border-2 border-white">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                        </div>
                        <div>
                            <p class="font-medium text-lg text-gray-800 hover:text-yellow-500 transition duration-300">{{ $serviceRequest->professional->name }}</p>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($serviceRequest->professional->receivedReviews()->avg('rating') ?? 0))
                                    <i class="fas fa-star text-yellow-400"></i>
                                    @else
                                    <i class="far fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                                </div>
                                <span class="ml-2">({{ $serviceRequest->professional->receivedReviews()->count() }} reviews)</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500 mt-4">
                        <div class="flex">
                            <i class="fas fa-quote-left text-blue-500 text-xl mr-2 mt-1"></i>
                            <p class="text-gray-600 italic">{{ $serviceRequest->professional->bio ?? 'No bio available' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Review Form Card -->
            <form action="{{ route('reviews.store') }}" method="POST" class="lg:col-span-1">
                @csrf
                <input type="hidden" name="service_request_id" value="{{ $serviceRequest->id }}">
                
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition duration-300 h-full flex flex-col">
                    <div class="bg-purple-500 text-white px-4 py-3 flex items-center">
                        <i class="fas fa-comment-alt mr-2"></i>
                        <h3 class="text-lg font-bold">Your Feedback</h3>
                    </div>
                    
                    <div class="p-4 flex-grow">
                        <!-- Rating -->
                        <div class="mb-6">
                            <label for="rating" class="block text-gray-700 font-semibold mb-3 flex items-center">
                                <i class="fas fa-star text-yellow-400 mr-2"></i>Rating
                            </label>
                            <div class="flex flex-col items-center space-y-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="rating-container flex space-x-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" class="rating-star text-4xl text-gray-300 hover:text-yellow-400 focus:outline-none transition duration-300 transform hover:scale-110" data-value="{{ $i }}">★</button>
                                    @endfor
                                </div>
                                <span class="text-gray-600 font-medium px-3 py-1 bg-gray-100 rounded-full" id="rating-text">Select a rating</span>
                                <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                            </div>
                            @error('rating')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Comment -->
                        <div class="mb-4 flex-grow">
                            <label for="comment" class="block text-gray-700 font-semibold mb-3 flex items-center">
                                <i class="fas fa-pencil-alt text-yellow-400 mr-2"></i>Your Comments
                            </label>
                            <div class="relative">
                                <textarea name="comment" id="comment" rows="5" 
                                      class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent shadow-sm resize-none bg-white"
                                      placeholder="Share your experience with this service...">{{ old('comment') }}</textarea>
                                <div class="absolute bottom-3 right-3 text-gray-400">
                                    <i class="fas fa-pen"></i>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                Minimum 10 characters, maximum 500 characters.
                            </p>
                            @error('comment')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="bg-gray-50 p-4 border-t border-gray-100">
                        <button type="submit" class="w-full px-6 py-3 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition duration-300 transform hover:scale-105 shadow-sm hover:shadow-md flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Review
                        </button>
                    </div>
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
            const ratingColors = ['#ef4444', '#f97316', '#f59e0b', '#84cc16', '#22c55e'];
            
            // Check if there's an existing rating to restore
            if (ratingInput.value) {
                highlightStars(parseInt(ratingInput.value));
                updateRatingText(parseInt(ratingInput.value));
            }
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = parseInt(this.dataset.value);
                    highlightStars(value);
                    ratingInput.value = value;
                    updateRatingText(value);
                    
                    // Add animation effect
                    this.classList.add('animate-pulse');
                    setTimeout(() => {
                        this.classList.remove('animate-pulse');
                    }, 300);
                });
                
                star.addEventListener('mouseenter', function() {
                    const value = parseInt(this.dataset.value);
                    
                    stars.forEach((s, index) => {
                        if (index < value) {
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300');
                            s.style.transform = 'scale(1.1)';
                        } else {
                            s.classList.add('text-gray-300');
                            s.classList.remove('text-yellow-400');
                            s.style.transform = 'scale(1)';
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
                            s.style.transform = 'scale(1)';
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
                    s.style.transform = 'scale(1)';
                });
            }
            
            function updateRatingText(value) {
                ratingText.textContent = `${value} - ${ratingLabels[value-1]}`;
                ratingText.style.backgroundColor = ratingColors[value-1];
                ratingText.style.color = value <= 2 ? 'white' : 'black';
            }
        });
    </script>
    @endpush
</x-app-layout> 