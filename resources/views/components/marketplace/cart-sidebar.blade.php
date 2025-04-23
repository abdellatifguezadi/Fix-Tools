@props(['cart' => null, 'userPoints' => 0])

<div class="bg-white shadow-md rounded-lg p-4 sticky top-4">
    <h2 class="text-lg font-bold mb-4 flex items-center">
        <i class="fas fa-shopping-cart mr-2 text-yellow-500"></i>
        My Cart
    </h2>
    
    @if(!$cart || $cart->items->isEmpty())
        <div class="text-center py-6">
            <div class="mb-4">
                <i class="fas fa-shopping-cart text-gray-300 text-4xl"></i>
            </div>
            <p class="text-gray-500 mb-4">Your cart is empty</p>
            <a href="{{ route('material-purchases.index') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg text-sm">
                Explore marketplace
            </a>
        </div>
    @else
        <div class="mb-4">
            <p class="text-sm text-gray-600 mb-1">Number of items: <span class="font-semibold">{{ $cart->getTotalItems() }}</span></p>
            <p class="text-sm text-gray-600 mb-1">Total: <span class="font-semibold">{{ number_format($cart->getTotal(), 2) }} DH</span></p>
            
            <div class="bg-yellow-100 px-3 py-2 rounded-lg mt-2">
                <p class="text-sm text-yellow-800">Available points: <span class="font-bold">{{ $userPoints }}</span></p>
            </div>
        </div>

        <div class="max-h-64 overflow-y-auto mb-4 border-t border-b py-3">
            <h3 class="font-medium text-gray-700 mb-2">Items in your cart</h3>
            <div class="space-y-3">
                @foreach($cart->items as $item)
                    <div class="flex items-start space-x-2 pb-2 border-b border-gray-100">
                        <div class="flex-shrink-0 w-12 h-12">
                            @if($item->material->image_path)
                                <img src="{{ Storage::url($item->material->image_path) }}" alt="{{ $item->material->name }}" class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-100 flex items-center justify-center rounded">
                                    <i class="fas fa-tools text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $item->material->name }}</p>
                            <p class="text-xs text-gray-500">{{ number_format($item->material->price, 2) }} DH x {{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ number_format($item->getSubtotal(), 2) }} DH</p>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-3 mb-6">
            <h3 class="font-medium text-gray-700">Payment Options</h3>
            <form action="{{ route('cart.checkout') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="space-y-2">
                    <label class="flex items-center p-2 rounded-lg hover:bg-gray-100 cursor-pointer transition-all">
                        <input type="radio" name="payment_method" value="cart" class="mr-2" checked>
                        <i class="fas fa-credit-card text-blue-500 mr-2"></i>
                        <span>Credit Card (via Mollie)</span>
                    </label>
                    <label class="flex items-center p-2 rounded-lg hover:bg-gray-100 cursor-pointer transition-all">
                        <input type="radio" name="payment_method" value="points" class="mr-2" 
                               {{ $userPoints < $cart->items->sum(function($item) { return $item->getPointsCost(); }) ? 'disabled' : '' }}>
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        <span>Loyalty Points</span>
                        @if($userPoints < $cart->items->sum(function($item) { return $item->getPointsCost(); }))
                            <span class="text-xs text-red-500 ml-1">(Insufficient)</span>
                        @endif
                    </label>
                </div>
                
                <div class="border-t pt-4 mt-4">
                    <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        Proceed to Payment
                    </button>
                </div>
            </form>
        </div>

        <div class="space-y-3">
            <a href="{{ route('material-purchases.index') }}" class="w-full bg-white border border-yellow-400 text-yellow-600 hover:bg-yellow-50 px-4 py-2 rounded-lg text-center block">
                Continue Shopping
            </a>
            
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-white border border-red-300 text-red-500 hover:bg-red-50 px-4 py-2 rounded-lg flex items-center justify-center">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Empty Cart
                </button>
            </form>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // No mixed payment options to handle anymore
    });
</script> 