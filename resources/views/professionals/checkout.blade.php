<x-app-layout>
    <x-slot name="title">Payment</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('cart.complete-checkout') }}">
                @csrf
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="md:w-1/4">
                        <x-marketplace.checkout-sidebar :cart="$cart" :userPoints="$userPoints" :pointsUsed="$pointsUsed" :priceToPay="$priceToPay" />
                    </div>
                    
                    <div class="md:w-3/4">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-6">
                                    <h1 class="text-2xl font-bold">Complete your order</h1>
                                    <div class="flex space-x-4">
                                        <a href="{{ route('cart.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg flex items-center">
                                            <i class="fas fa-arrow-left mr-2"></i>
                                            Back to cart
                                        </a>
                                    </div>
                                </div>

                                @if (session('success'))
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                        <span class="font-bold">Success!</span>
                                        <span>{{ session('success') }}</span>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                        <span class="font-bold">Error!</span>
                                        <span>{{ session('error') }}</span>
                                    </div>
                                @endif

                                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-yellow-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium">Check your order before confirming payment.</p>
                                        </div>
                                    </div>
                                </div>

                                @if(!$cart || $cart->items->isEmpty())
                                    <div class="text-center py-8">
                                        <div class="mb-4">
                                            <i class="fas fa-shopping-cart text-gray-300 text-5xl"></i>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-500 mb-2">Your cart is empty</h3>
                                        <p class="text-gray-500 max-w-md mx-auto mb-6">You haven't added any items to your cart yet.</p>
                                        <a href="{{ route('material-purchases.index') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black px-6 py-2 rounded-lg">
                                            Explore marketplace
                                        </a>
                                    </div>
                                @else
                                    <div class="mb-6">
                                        <h2 class="text-xl font-bold mb-4">Items in your order</h2>
                                        <div class="grid grid-cols-1 gap-4">
                                            @foreach ($cart->items as $item)
                                                <div class="border rounded-lg overflow-hidden bg-white">
                                                    <div class="flex flex-col md:flex-row">
                                                        <div class="md:w-1/4 flex-shrink-0">
                                                            @if($item->material->image_path)
                                                                <img src="{{ Storage::url($item->material->image_path) }}" alt="{{ $item->material->name }}" class="w-full h-40 md:h-full object-cover">
                                                            @else
                                                                <div class="w-full h-40 md:h-full bg-gray-100 flex items-center justify-center">
                                                                    <i class="fas fa-tools text-gray-400 text-3xl"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="p-4 md:w-3/4">
                                                            <div class="flex justify-between">
                                                                <div>
                                                                    <h3 class="text-lg font-bold">{{ $item->material->name }}</h3>
                                                                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">{{ $item->material->category->name }}</span>
                                                                </div>
                                                                <div class="text-right">
                                                                    <p class="text-lg font-bold">{{ number_format($item->getSubtotal(), 2) }} DH</p>
                                                                    <p class="text-sm text-gray-600">{{ number_format($item->material->price, 2) }} DH x {{ $item->quantity }}</p>
                                                                </div>
                                                            </div>
                                                            <p class="mt-2 text-gray-600">{{ $item->material->description }}</p>
                                                            <div class="mt-3 flex justify-between items-end">
                                                                <div>
                                                                    <p class="text-sm text-gray-600">Points for this item: <span class="text-yellow-600 font-medium">{{ $item->getPointsCost() }} points</span></p>
                                                                </div>
                                                                <div>
                                                                    <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                                                        Quantity: {{ $item->quantity }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Delivery Information Section -->
                                    <div class="mb-6">
                                        <h2 class="text-xl font-bold mb-4">Delivery Information</h2>
                                        <div class="bg-white p-4 rounded-lg border">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Delivery Address <span class="text-red-500">*</span></label>
                                                    <textarea id="address" name="address" rows="3" class="w-full p-2 border @error('address') border-red-500 @enderror rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your complete address">{{ old('address', $user->address ?? '') }}</textarea>
                                                    @error('address')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                                    <input type="tel" id="phone" name="phone" class="w-full p-2 border @error('phone') border-red-500 @enderror rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Example: 0612345678" value="{{ old('phone', $user->phone ?? '') }}">
                                                    @error('phone')
                                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                    @enderror
                                                    
                                                    <div class="mt-4">
                                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City <span class="text-red-500">*</span></label>
                                                        <input type="text" id="city" name="city" class="w-full p-2 border @error('city') border-red-500 @enderror rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="City" value="{{ old('city', $user->city ?? '') }}">
                                                        @error('city')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="mt-4">
                                                        <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code <span class="text-red-500">*</span></label>
                                                        <input type="text" id="postal_code" name="postal_code" class="w-full p-2 border @error('postal_code') border-red-500 @enderror rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="Postal code" value="{{ old('postal_code', $user->postal_code ?? '') }}">
                                                        @error('postal_code')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-4">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" id="save_info" name="save_info" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('save_info') ? 'checked' : '' }}>
                                                    <span class="ml-2 text-sm text-gray-600">Save this information for my future orders</span>
                                                </label>
                                            </div>

                                            @if (session('delivery_errors'))
                                                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                                    <p class="font-bold">Errors in delivery information:</p>
                                                    <ul class="mt-1 list-disc list-inside text-sm">
                                                        @foreach (session('delivery_errors') as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if(session('checkout_data.payment_method') != 'points')
                                        <div class="mb-6">
                                            <h2 class="text-xl font-bold mb-4">Payment Information</h2>
                                            
                                            <div class="bg-blue-50 p-4 rounded-lg">
                                                <h3 class="font-bold text-blue-800 mb-2">Credit Card Payment via Mollie</h3>
                                                <p class="text-blue-700 mb-3">
                                                    <i class="fas fa-info-circle mr-1"></i> You will be redirected to Mollie's secure payment page after confirming your order.
                                                </p>
                                                <div class="flex items-center mb-3">
                                                    <img src="https://www.mollie.com/images/payscreen/methods/ideal.png" alt="iDEAL" class="h-8 mr-2">
                                                    <img src="https://www.mollie.com/images/payscreen/methods/creditcard.png" alt="Credit Card" class="h-8 mr-2">
                                                    <img src="https://www.mollie.com/images/payscreen/methods/paypal.png" alt="PayPal" class="h-8 mr-2">
                                                    <img src="https://www.mollie.com/images/payscreen/methods/sofort.png" alt="SOFORT Banking" class="h-8">
                                                </div>
                                                <p class="text-sm text-blue-700">
                                                    <i class="fas fa-lock mr-1"></i> 100% secure payment via Mollie platform.
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                            <div>
                                                <h3 class="text-lg font-semibold">Total to pay</h3>
                                                <p class="text-sm text-gray-600">{{ $cart->getTotalItems() }} items</p>
                                            </div>
                                            <div class="mt-2 md:mt-0 text-right">
                                                @if($pointsUsed > 0)
                                                    <p class="text-sm text-gray-600">Subtotal: <span class="font-semibold">{{ number_format($cart->getTotal(), 2) }} DH</span></p>
                                                    <p class="text-sm text-yellow-600">Points used: <span class="font-semibold">{{ $pointsUsed }} points</span></p>
                                                    <p class="text-sm text-gray-600">Discount: <span class="font-semibold">-{{ number_format($cart->getTotal() - $priceToPay, 2) }} DH</span></p>
                                                @endif
                                                <p class="text-xl font-bold {{ $pointsUsed > 0 ? 'mt-1' : '' }}">{{ number_format($priceToPay, 2) }} DH</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons section -->
                                    <div class="mt-6 flex justify-end">
                                        <a href="{{ route('cart.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold px-6 py-3 rounded-lg mr-4">
                                            Back to cart
                                        </a>
                                        @if(session('checkout_data.payment_method') == 'cart')
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold px-6 py-3 rounded-lg">
                                                <i class="fas fa-credit-card mr-2"></i> Proceed to payment
                                            </button>
                                        @else
                                            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold px-6 py-3 rounded-lg">
                                                <i class="fas fa-check-circle mr-2"></i> Confirm and pay with my points
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 