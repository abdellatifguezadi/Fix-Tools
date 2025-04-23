<x-app-layout>
<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold mb-8">Service Requests</h1>
    
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
    
    <div class="flex space-x-4 mb-6">
        <button data-status="all" class="status-filter bg-yellow-400 text-black px-4 py-2 rounded-lg">
            All Requests
        </button>
        <button data-status="pending" class="status-filter bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
            Pending
        </button>
        <button data-status="priced" class="status-filter bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
            Priced
        </button>
        <button data-status="accepted" class="status-filter bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
            Accepted
        </button>
        <button data-status="completed" class="status-filter bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
            Completed
        </button>
        <button data-status="cancelled" class="status-filter bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
            Cancelled
        </button>
    </div>
    
    @if($requests->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
            <p class="text-xl text-gray-500">You don't have any service requests yet.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($requests as $request)
                <div class="request-card bg-white rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl group" data-status="{{ $request->status }}">
                    @if($request->service->image_path)
                        <div class="overflow-hidden">
                            <img src="/storage/{{ $request->service->image_path }}" 
                                 alt="{{ $request->service->name }}" 
                                 class="w-full h-36 object-cover transition-transform duration-500 ease-in-out hover:scale-110">
                        </div>
                    @else
                        <div class="w-full h-36 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-tools text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold transition-colors duration-300 group-hover:text-yellow-500">{{ $request->service->name }}</h3>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                @if($request->status == 'pending') bg-blue-100 text-blue-800
                                @elseif($request->status == 'priced') bg-yellow-100 text-yellow-800
                                @elseif($request->status == 'accepted') bg-green-100 text-green-800
                                @elseif($request->status == 'completed') bg-green-400 text-green-900
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </div>
                        
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-full bg-gray-300 mr-3 overflow-hidden">
                                @if($request->client->image)
                                
                                    <img src="{{ asset('storage/' . $request->client->profile_image) }}" 
                                         alt="{{ $request->client->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-yellow-400 text-white text-xl">
                                        {{ substr($request->client->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold transition-colors duration-300 group-hover:text-yellow-500">{{ $request->client->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $request->requested_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="font-semibold mb-1">Description:</h4>
                            <p class="text-gray-700">{{ $request->description }}</p>
                        </div>
                        
                        @if($request->status == 'pending')
                            <form action="{{ route('professional.requests.update-price', $request) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="final_price" class="block text-sm font-medium text-gray-700 mb-1">Propose Final Price:</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md text-gray-500">
                                            DH
                                        </span>
                                        <input type="number" name="final_price" id="final_price" 
                                               class="flex-1 min-w-0 block w-full px-3 py-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                                               min="0" step="0.01" required>
                                    </div>
                                </div>
                                <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded transition duration-200">
                                    Submit Price
                                </button>
                            </form>
                        @elseif($request->final_price)
                            <div class="mb-4">
                                <h4 class="font-semibold mb-1">Final Price:</h4>
                                <p class="text-xl font-bold text-yellow-600 transition-colors duration-300 group-hover:text-yellow-500">{{ number_format($request->final_price, 2) }} DH</p>
                            </div>
                        @endif
                        
                        <div class="flex space-x-2 mt-4">
                            @if($request->status == 'accepted' || $request->status == 'completed')
                                <a href="{{ route('messages.show', $request->client->id) }}" 
                                   class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-yellow-500 text-center transition duration-200">
                                    <i class="fas fa-envelope mr-2"></i>Message Client
                                </a>
                                
                                @if($request->status == 'accepted')
                                    <form action="{{ route('professional.requests.complete', $request) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-yellow-500 transition duration-200"
                                                onclick="return confirm('Are you sure you want to mark this request as completed?')">
                                            <i class="fas fa-check mr-2"></i>Complete
                                        </button>
                                    </form>
                                @endif
                            @endif
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
                // Update active filter button
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