@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header with Return Button -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">My Service Requests</h1>
            <a href="{{ route('client.services.index') }}" 
               class="px-4 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-300 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Services
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Status Filter -->
        <div class="mb-6">
            <div class="flex space-x-4">
                <button class="status-filter px-4 py-2 rounded-lg bg-yellow-400 text-black font-semibold" data-status="all">
                    All Requests
                </button>
                <button class="status-filter px-4 py-2 rounded-lg bg-gray-200 text-gray-700" data-status="pending">
                    Pending
                </button>
                <button class="status-filter px-4 py-2 rounded-lg bg-gray-200 text-gray-700" data-status="priced">
                    Priced
                </button>
                <button class="status-filter px-4 py-2 rounded-lg bg-gray-200 text-gray-700" data-status="accepted">
                    Accepted
                </button>
                <button class="status-filter px-4 py-2 rounded-lg bg-gray-200 text-gray-700" data-status="completed">
                    Completed
                </button>
                <button class="status-filter px-4 py-2 rounded-lg bg-gray-200 text-gray-700" data-status="cancelled">
                    Cancelled
                </button>
            </div>
        </div>

        @if($requests->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                <p class="text-xl text-gray-500">You don't have any service requests yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="requestsGrid">
                @foreach($requests as $request)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden request-card" data-status="{{ $request->status }}">
                        <!-- Service Image -->
                        <div class="relative h-48">
                            @if($request->service->image_path)
                                <img src="/storage/{{ $request->service->image_path }}" 
                                     alt="{{ $request->service->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <img src="https://via.placeholder.com/400x300?text=Service+Image" 
                                     alt="{{ $request->service->name }}" 
                                     class="w-full h-full object-cover">
                            @endif
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    @if($request->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($request->status == 'priced') bg-purple-100 text-purple-800
                                    @elseif($request->status == 'accepted') bg-blue-100 text-blue-800
                                    @elseif($request->status == 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <!-- Service Title and Date -->
                            <div class="mb-4">
                                <h2 class="text-xl font-bold">{{ $request->service->name }}</h2>
                                <p class="text-gray-600 text-sm">Requested on {{ $request->requested_date->format('M d, Y') }}</p>
                            </div>

                            <!-- Professional Info -->
                            <div class="flex items-center space-x-4 mb-4">
                                @if(!empty($request->professional->image))
                                    <!-- Try with direct URL - might work if images are public -->
                                    <img src="/storage/{{ $request->professional->image }}" 
                                         alt="{{ $request->professional->name }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-yellow-400">
                                @elseif(!empty($request->professional->profile_image))
                                    <img src="/storage/{{ $request->professional->profile_image }}" 
                                         alt="{{ $request->professional->name }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-yellow-400">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($request->professional->name) }}&background=4F46E5&color=ffffff" 
                                         alt="{{ $request->professional->name }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-gray-300">
                                @endif
                                <div>
                                    <p class="font-medium">{{ $request->professional->name }}</p>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        <span>{{ number_format($request->professional->receivedReviews()->avg('rating') ?? 0, 1) }} ({{ $request->professional->receivedReviews()->count() }} reviews)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Details -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-tag text-yellow-400 mr-2"></i>
                                    <span>{{ $request->service->category ? $request->service->category->name : 'Uncategorized' }}</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-coins text-yellow-400 mr-2"></i>
                                    <span>{{ number_format($request->service->base_price, 2) }} DH/hr</span>
                                </div>
                                <p class="text-gray-600 text-sm">
                                    {{ Str::limit($request->description, 100) }}
                                </p>
                            </div>

                            <!-- Final Price (if set) -->
                            @if($request->final_price)
                                <div class="mb-4 p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                                    <h4 class="font-semibold mb-1">Final Price Quote:</h4>
                                    <p class="text-2xl font-bold text-yellow-600">{{ number_format($request->final_price, 2) }} DH</p>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                @if($request->status == 'pending')
                                    <form action="{{ route('client.service-requests.cancel', ['serviceRequest' => $request->id]) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                                                onclick="return confirm('Are you sure you want to cancel this service request?')">
                                            <i class="fas fa-times mr-2"></i>Cancel
                                        </button>
                                    </form>
                                @endif

                                @if($request->status == 'priced')
                                    <form action="{{ route('client.service-requests.accept-price', $request->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600"
                                                onclick="return confirm('Are you sure you want to accept this price?')">
                                            <i class="fas fa-check mr-2"></i>Accept
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('client.service-requests.cancel', ['serviceRequest' => $request->id]) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                                                onclick="return confirm('Are you sure you want to decline this price and cancel the request?')">
                                            <i class="fas fa-times mr-2"></i>Decline
                                        </button>
                                    </form>
                                @endif

                                @if($request->status == 'completed' && !$request->review)
                                    <a href="{{ route('reviews.create', $request->id) }}" 
                                       class="flex-1 px-4 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-500 text-center">
                                        <i class="fas fa-star mr-2"></i>Review
                                    </a>
                                @endif

                                <a href="{{ route('messages.show', $request->professional->id) }}" 
                                   class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-center">
                                    <i class="fas fa-envelope mr-2"></i>Message
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilters = document.querySelectorAll('.status-filter');
            const requestCards = document.querySelectorAll('.request-card');

            statusFilters.forEach(filter => {
                filter.addEventListener('click', function() {
                    statusFilters.forEach(f => f.classList.remove('bg-yellow-400', 'text-black'));
                    statusFilters.forEach(f => f.classList.add('bg-gray-200', 'text-gray-700'));
                    this.classList.remove('bg-gray-200', 'text-gray-700');
                    this.classList.add('bg-yellow-400', 'text-black');

                    const status = this.dataset.status;
                    
                    requestCards.forEach(card => {
                        if (status === 'all' || card.dataset.status === status) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 