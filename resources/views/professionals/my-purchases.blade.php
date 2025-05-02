<x-app-layout>
    <div class="min-h-screen bg-gray-100">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="mb-6 bg-white shadow-sm rounded-lg p-4">
                <div class="flex flex-wrap justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">My Purchased Materials</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('professionals.marketplace') }}" class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Purchase more materials
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                            <i class="fas fa-shopping-basket text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Purchases</p>
                            <p class="text-lg font-semibold">{{ $purchases->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Completed Purchases</p>
                            <p class="text-lg font-semibold">{{ $completedPurchases->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                            <i class="fas fa-coins text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Points Used</p>
                            <p class="text-lg font-semibold">{{ $totalPointsUsed }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                            <i class="fas fa-money-bill-wave text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Spent</p>
                            <p class="text-lg font-semibold">{{ number_format($totalAmountSpent, 2) }} DH</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tabs for different purchase statuses -->
            <div x-data="{ tab: 'all' }" class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button @click="tab = 'all'" :class="{ 'border-yellow-500 text-yellow-600': tab === 'all', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'all' }" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            All Purchases ({{ $purchases->count() }})
                        </button>
                        <button @click="tab = 'pending'" :class="{ 'border-yellow-500 text-yellow-600': tab === 'pending', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'pending' }" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Pending ({{ $pendingPurchases->count() }})
                        </button>
                        <button @click="tab = 'completed'" :class="{ 'border-yellow-500 text-yellow-600': tab === 'completed', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'completed' }" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm">
                            Completed ({{ $completedPurchases->count() }})
                        </button>
                    </nav>
                </div>
                
                <div class="mt-4">
                    <!-- All Purchases Tab -->
                    <div x-show="tab === 'all'">
                        @if($purchases->isEmpty())
                            <div class="bg-white rounded-lg shadow p-6 text-center">
                                <p class="text-gray-500">You haven't purchased any materials yet.</p>
                                <a href="{{ route('professionals.marketplace') }}" class="mt-4 inline-block bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg">
                                    Browse materials
                                </a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($purchases as $purchase)
                                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                        @if($purchase->material && $purchase->material->image_path)
                                            <img src="{{ Storage::url($purchase->material->image_path) }}" alt="{{ $purchase->material->name }}" class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-tools text-gray-400 text-5xl"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="p-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <h3 class="text-lg font-bold text-gray-800">
                                                    {{ $purchase->material ? $purchase->material->name : 'Unknown Material' }}
                                                </h3>
                                                <span class="px-2 py-1 text-xs rounded-full {{ $purchase->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($purchase->status) }}
                                                </span>
                                            </div>
                                            
                                            <div class="space-y-2 text-sm text-gray-600">
                                                <p><span class="font-medium">Quantity:</span> {{ $purchase->quantity }}</p>
                                                <p><span class="font-medium">Price Paid:</span> {{ number_format($purchase->price_paid, 2) }} DH</p>
                                                @if($purchase->points_used > 0)
                                                    <p><span class="font-medium">Points Used:</span> {{ $purchase->points_used }}</p>
                                                @endif
                                                <p><span class="font-medium">Purchase Date:</span> {{ $purchase->created_at->format('M d, Y') }}</p>
                                            </div>
                                            
                                            @if($purchase->status === 'pending')
                                                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-100 rounded-lg">
                                                    <p class="text-sm text-yellow-800 flex items-center">
                                                        <i class="fas fa-clock mr-2"></i>
                                                        Your order is being processed and will be delivered soon.
                                                    </p>
                                                </div>
                                            @endif
                                            
                                            @if($purchase->delivery_address)
                                                <div class="mt-4 border-t pt-4">
                                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Delivery Information</h4>
                                                    <p class="text-xs text-gray-600">{{ $purchase->delivery_address }}, {{ $purchase->delivery_city }} {{ $purchase->delivery_postal_code }}</p>
                                                    <p class="text-xs text-gray-600">{{ $purchase->delivery_phone }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <!-- Pending Purchases Tab -->
                    <div x-show="tab === 'pending'">
                        @if($pendingPurchases->isEmpty())
                            <div class="bg-white rounded-lg shadow p-6 text-center">
                                <p class="text-gray-500">You don't have any pending purchases.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($pendingPurchases as $purchase)
                                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                        @if($purchase->material && $purchase->material->image_path)
                                            <img src="{{ Storage::url($purchase->material->image_path) }}" alt="{{ $purchase->material->name }}" class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-tools text-gray-400 text-5xl"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="p-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <h3 class="text-lg font-bold text-gray-800">
                                                    {{ $purchase->material ? $purchase->material->name : 'Unknown Material' }}
                                                </h3>
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            </div>
                                            
                                            <div class="space-y-2 text-sm text-gray-600">
                                                <p><span class="font-medium">Quantity:</span> {{ $purchase->quantity }}</p>
                                                <p><span class="font-medium">Price Paid:</span> {{ number_format($purchase->price_paid, 2) }} DH</p>
                                                @if($purchase->points_used > 0)
                                                    <p><span class="font-medium">Points Used:</span> {{ $purchase->points_used }}</p>
                                                @endif
                                                <p><span class="font-medium">Purchase Date:</span> {{ $purchase->created_at->format('M d, Y') }}</p>
                                            </div>
                                            
                                            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-100 rounded-lg">
                                                <p class="text-sm text-yellow-800 flex items-center">
                                                    <i class="fas fa-clock mr-2"></i>
                                                    Your order is being processed and will be delivered soon.
                                                </p>
                                            </div>
                                            
                                            @if($purchase->delivery_address)
                                                <div class="mt-4 border-t pt-4">
                                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Delivery Information</h4>
                                                    <p class="text-xs text-gray-600">{{ $purchase->delivery_address }}, {{ $purchase->delivery_city }} {{ $purchase->delivery_postal_code }}</p>
                                                    <p class="text-xs text-gray-600">{{ $purchase->delivery_phone }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <div x-show="tab === 'completed'">
                        @if($completedPurchases->isEmpty())
                            <div class="bg-white rounded-lg shadow p-6 text-center">
                                <p class="text-gray-500">You don't have any completed purchases yet.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($completedPurchases as $purchase)
                                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                        @if($purchase->material && $purchase->material->image_path)
                                            <img src="{{ Storage::url($purchase->material->image_path) }}" alt="{{ $purchase->material->name }}" class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-tools text-gray-400 text-5xl"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="p-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <h3 class="text-lg font-bold text-gray-800">
                                                    {{ $purchase->material ? $purchase->material->name : 'Unknown Material' }}
                                                </h3>
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                    Completed
                                                </span>
                                            </div>
                                            
                                            <div class="space-y-2 text-sm text-gray-600">
                                                <p><span class="font-medium">Quantity:</span> {{ $purchase->quantity }}</p>
                                                <p><span class="font-medium">Price Paid:</span> {{ number_format($purchase->price_paid, 2) }} DH</p>
                                                @if($purchase->points_used > 0)
                                                    <p><span class="font-medium">Points Used:</span> {{ $purchase->points_used }}</p>
                                                @endif
                                                <p><span class="font-medium">Purchase Date:</span> {{ $purchase->created_at->format('M d, Y') }}</p>
                                            </div>
                                            
                                            <div class="mt-4 p-3 bg-green-50 border border-green-100 rounded-lg">
                                                <p class="text-sm text-green-800 flex items-center">
                                                    <i class="fas fa-check-circle mr-2"></i>
                                                    Your order has been delivered successfully.
                                                </p>
                                            </div>
                                            
                                            @if($purchase->delivery_address)
                                                <div class="mt-4 border-t pt-4">
                                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Delivery Information</h4>
                                                    <p class="text-xs text-gray-600">{{ $purchase->delivery_address }}, {{ $purchase->delivery_city }} {{ $purchase->delivery_postal_code }}</p>
                                                    <p class="text-xs text-gray-600">{{ $purchase->delivery_phone }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 