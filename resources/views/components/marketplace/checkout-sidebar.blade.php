@props(['cart' => null, 'userPoints' => 0, 'pointsUsed' => 0, 'priceToPay' => 0])

<div class="bg-white shadow-md rounded-lg p-4 sticky top-4">
    <h2 class="text-lg font-bold mb-4 flex items-center">
        <i class="fas fa-receipt mr-2 text-yellow-500"></i>
        Order Summary
    </h2>
    
    @if(!$cart || $cart->items->isEmpty())
        <div class="text-center py-6">
            <p class="text-gray-500 mb-4">No items selected</p>
            <a href="{{ route('cart.index') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg text-sm">
                Return to cart
            </a>
        </div>
    @else
        <div class="mb-4">
            <p class="text-sm text-gray-600 mb-1">Number of items: <span class="font-semibold">{{ $cart->getTotalItems() }}</span></p>
            
            <div class="bg-yellow-100 px-3 py-2 rounded-lg mt-2">
                <p class="text-sm text-yellow-800">Available points: <span class="font-bold">{{ $userPoints }}</span></p>
                @if($pointsUsed > 0)
                    <p class="text-sm text-yellow-800">Points used: <span class="font-bold">{{ $pointsUsed }}</span></p>
                @endif
            </div>
        </div>

        <div class="border-t pt-3 mb-4">
            <h3 class="font-medium text-gray-700 mb-2">Selected payment method</h3>
            <div class="bg-gray-50 p-3 rounded-lg">
                @if(session('checkout_data.payment_method') == 'card')
                    <div class="flex items-center">
                        <i class="fas fa-credit-card text-blue-500 mr-2"></i>
                        <span>Credit Card</span>
                    </div>
                @elseif(session('checkout_data.payment_method') == 'points')
                    <div class="flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>
                        <span>Loyalty Points</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="border-t pt-3 mb-4">
            <h3 class="font-medium text-gray-700 mb-2">Summary</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total items:</span>
                    <span>{{ number_format($cart->getTotal(), 2) }} DH</span>
                </div>
                
                @if($pointsUsed > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Discount (points):</span>
                        <span class="text-yellow-600">-{{ number_format($cart->getTotal() - $priceToPay, 2) }} DH</span>
                    </div>
                @endif
                
                <div class="flex justify-between font-bold border-t pt-2 mt-2">
                    <span>Amount to pay:</span>
                    <span class="text-lg">{{ number_format($priceToPay, 2) }} DH</span>
                </div>
            </div>
        </div>

        <div class="space-y-3 mb-6">
            <h3 class="font-medium text-gray-700">Payment method</h3>
            @if(session('checkout_data.payment_method') == 'points')
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <p class="text-sm text-yellow-800">Your purchase will be fully paid with your loyalty points.</p>
                </div>
            @else
                <div class="bg-blue-50 p-3 rounded-lg">
                    <p class="text-sm text-blue-800">Prepare your credit card to pay {{ number_format($priceToPay, 2) }} DH.</p>
                </div>
            @endif
        </div>

        <div class="border-t pt-4">
            <form action="{{ route('cart.complete-checkout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-3 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    Confirm and pay
                </button>
            </form>
            
            <a href="{{ route('cart.index') }}" class="w-full mt-3 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-center block">
                Back to cart
            </a>
        </div>
    @endif
</div>