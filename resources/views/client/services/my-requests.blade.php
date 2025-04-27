@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">My Service Requests</h1>
            <a href="{{ route('client.services.index') }}"
                class="px-4 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-300 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Services
            </a>
        </div>

        <!-- @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif -->

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
            <div class="bg-white rounded-xl shadow-lg overflow-hidden request-card border border-transparent hover:border-yellow-300 hover:shadow-2xl cursor-pointer" 
                style="transition: all 0.3s ease; transform: translateZ(0);" 
                onmouseover="this.style.transform='translateZ(0) scale(1.05)'; this.querySelector('.card-title').style.color='#f59e0b'; this.querySelector('.prof-name').style.color='#f59e0b'; this.querySelector('.service-img').style.transform='scale(1.1)';" 
                onmouseout="this.style.transform='translateZ(0) scale(1)'; this.querySelector('.card-title').style.color=''; this.querySelector('.prof-name').style.color=''; this.querySelector('.service-img').style.transform='scale(1)';"
                data-status="{{ $request->status }}">
                <div class="relative h-48 overflow-hidden">
                    @if($request->service->image_path)
                    <img src="/storage/{{ $request->service->image_path }}"
                        alt="{{ $request->service->name }}"
                        class="w-full h-full object-cover service-img"
                        style="transition: transform 0.7s ease-in-out;">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-0 hover-overlay" style="transition: opacity 0.3s ease;"></div>
                    @else
                    <img src="https://via.placeholder.com/400x300?text=Service+Image"
                        alt="{{ $request->service->name }}"
                        class="w-full h-full object-cover service-img"
                        style="transition: transform 0.7s ease-in-out;">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-0 hover-overlay" style="transition: opacity 0.3s ease;"></div>
                    @endif
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold shadow-sm
                                    @if($request->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($request->status == 'priced') bg-purple-100 text-purple-800
                                    @elseif($request->status == 'accepted') bg-blue-100 text-blue-800
                                    @elseif($request->status == 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($request->status) }}
                        </span>
                    </div>
                </div>

                <div class="p-6 transition-colors duration-300">
                    <div class="mb-4">
                        <h2 class="text-xl font-bold card-title" style="transition: color 0.3s ease;">{{ $request->service->name }}</h2>
                        <p class="text-gray-600 text-sm">Requested on {{ $request->requested_date->format('M d, Y') }}</p>
                    </div>

                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-yellow-400 prof-img-container" style="transition: all 0.3s ease;">
                            @if(!empty($request->professional->image))
                                <img src="/storage/{{ $request->professional->image }}" alt="{{ $request->professional->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-yellow-400 text-black font-bold text-xl">
                                    {{ strtoupper(substr($request->professional->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium prof-name" style="transition: color 0.3s ease;">{{ $request->professional->name }}</p>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                <span>{{ number_format($request->professional->receivedReviews()->avg('rating') ?? 0, 1) }} ({{ $request->professional->receivedReviews()->count() }} reviews)</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 mb-4 details-container" style="transition: all 0.3s ease;">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-tag text-yellow-400 mr-2 icon-animate" style="transition: transform 0.3s ease;"></i>
                            <span>{{ $request->service->category ? $request->service->category->name : 'Uncategorized' }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-dollar-sign text-yellow-400 mr-2 icon-animate" style="transition: transform 0.3s ease;"></i>
                            <span>{{ number_format($request->service->base_price, 2) }} DH</span>
                        </div>
                        <p class="text-gray-600 text-sm">
                            {{ Str::limit($request->description, 100) }}
                        </p>
                    </div>

                    <!-- Final Price (if set) -->
                    @if($request->final_price)
                    <div class="mb-4 p-3 bg-yellow-50 rounded-lg border border-yellow-100 price-container" style="transition: all 0.3s ease;">
                        <h4 class="font-semibold mb-1">Final Price Quote:</h4>
                        <p class="text-2xl font-bold text-yellow-600 price-text" style="transition: color 0.3s ease;">{{ number_format($request->final_price, 2) }} DH</p>
                    </div>
                    @endif

                    <div class="flex space-x-2">
                        @if($request->status == 'pending')
                            <button type="button" 
                                onclick="event.stopPropagation(); document.getElementById('cancelModal{{ $request->id }}').style.display='flex';"
                                class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-yellow-500 transition-all duration-300 transform hover:scale-105 hover:shadow">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </button>
                        @endif

                        @if($request->status == 'priced')
                            <button type="button" 
                                onclick="event.stopPropagation(); document.getElementById('acceptModal{{ $request->id }}').style.display='flex';"
                                class="flex-1 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-yellow-500 transition-all duration-300 transform hover:scale-105 hover:shadow">
                                <i class="fas fa-check mr-2"></i>Accept
                            </button>

                            <button type="button" 
                                onclick="event.stopPropagation(); document.getElementById('declineModal{{ $request->id }}').style.display='flex';"
                                class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-yellow-500 transition-all duration-300 transform hover:scale-105 hover:shadow">
                                <i class="fas fa-times mr-2"></i>Decline
                            </button>
                        @endif

                        @if($request->status == 'completed' && !$request->review)
                            <a href="{{ route('reviews.create', $request->id) }}" onclick="event.stopPropagation();"
                                class="flex-1 px-4 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-500 text-center transition-all duration-300 transform hover:scale-105 hover:shadow">
                                <i class="fas fa-star mr-2"></i>Review
                            </a>
                        @endif

                        <a href="{{ route('messages.show', $request->professional->id) }}" onclick="event.stopPropagation();"
                            class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-yellow-500 text-center transition-all duration-300 transform hover:scale-105 hover:shadow">
                            <i class="fas fa-envelope mr-2"></i>Message
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Modals -->
    @foreach($requests as $request)
        @if($request->status == 'pending')
            <div id="cancelModal{{ $request->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
                <div class="bg-white p-8 rounded-lg shadow-xl max-w-md mx-auto" onclick="event.stopPropagation();">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-100 rounded-full p-2 mr-3">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Cancel Service Request</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Are you sure you want to cancel this service request? This action cannot be undone.</p>
                    <div class="flex justify-end space-x-4">
                        <button type="button" 
                            onclick="document.getElementById('cancelModal{{ $request->id }}').style.display='none'"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                            Keep Request
                        </button>
                        <form action="{{ route('client.service-requests.cancel', ['serviceRequest' => $request->id]) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Cancel Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if($request->status == 'priced')
            <div id="acceptModal{{ $request->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
                <div class="bg-white p-8 rounded-lg shadow-xl max-w-md mx-auto" onclick="event.stopPropagation();">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 rounded-full p-2 mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Accept Price</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Are you sure you want to accept the price for this service?</p>
                    <div class="flex justify-end space-x-4">
                        <button type="button" 
                            onclick="document.getElementById('acceptModal{{ $request->id }}').style.display='none'"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                            Cancel
                        </button>
                        <form action="{{ route('client.service-requests.accept-price', $request->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                Accept Price
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div id="declineModal{{ $request->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
                <div class="bg-white p-8 rounded-lg shadow-xl max-w-md mx-auto" onclick="event.stopPropagation();">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-100 rounded-full p-2 mr-3">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Decline Price</h3>
                    </div>
                    <p class="text-gray-600 mb-6">Are you sure you want to decline this price and cancel the request?</p>
                    <div class="flex justify-end space-x-4">
                        <button type="button" 
                            onclick="document.getElementById('declineModal{{ $request->id }}').style.display='none'"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                            Keep Request
                        </button>
                        <form action="{{ route('client.service-requests.cancel', ['serviceRequest' => $request->id]) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Decline and Cancel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

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

            document.querySelectorAll('.request-card').forEach(card => {
                card.addEventListener('mouseover', function() {
                    const overlay = this.querySelector('.hover-overlay');
                    if (overlay) overlay.style.opacity = '0.5';
                    
                    const icons = this.querySelectorAll('.icon-animate');
                    icons.forEach(icon => {
                        icon.style.transform = 'scale(1.1)';
                    });
                    
                    const profImg = this.querySelector('.prof-img-container');
                    if (profImg) {
                        profImg.style.transform = 'scale(1.1)';
                        profImg.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
                    }
                    
                    const details = this.querySelector('.details-container');
                    if (details) {
                        details.style.backgroundColor = 'white';
                        details.style.padding = '0.75rem';
                        details.style.borderRadius = '0.5rem';
                        details.style.boxShadow = '0 1px 3px 0 rgba(0, 0, 0, 0.1)';
                    }
                    
                    const price = this.querySelector('.price-container');
                    if (price) {
                        price.style.borderColor = '#fde68a';
                        price.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
                    }
                    
                    const priceText = this.querySelector('.price-text');
                    if (priceText) priceText.style.color = '#f59e0b';
                });
                
                card.addEventListener('mouseout', function() {
                    const overlay = this.querySelector('.hover-overlay');
                    if (overlay) overlay.style.opacity = '0';
                    
                    const icons = this.querySelectorAll('.icon-animate');
                    icons.forEach(icon => {
                        icon.style.transform = 'scale(1)';
                    });
                    
                    const profImg = this.querySelector('.prof-img-container');
                    if (profImg) {
                        profImg.style.transform = 'scale(1)';
                        profImg.style.boxShadow = 'none';
                    }
                    
                    const details = this.querySelector('.details-container');
                    if (details) {
                        details.style.backgroundColor = '';
                        details.style.padding = '';
                        details.style.borderRadius = '';
                        details.style.boxShadow = '';
                    }
                    
                    const price = this.querySelector('.price-container');
                    if (price) {
                        price.style.borderColor = '';
                        price.style.boxShadow = '';
                    }
                    
                    const priceText = this.querySelector('.price-text');
                    if (priceText) priceText.style.color = '';
                });
            });
        });
    </script>
    @endpush
</x-app-layout>