<x-app-layout>
    <x-slot name="title">My Cart</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="md:w-1/4">
                    <x-marketplace.cart-sidebar :cart="$cart" :userPoints="$userPoints" />
                </div>
                
                <div class="md:w-3/4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold">My Cart</h1>
                                <div class="flex space-x-4">
                                    <a href="{{ route('material-purchases.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg flex items-center">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        Back to marketplace
                                    </a>
                                </div>
                            </div>

                    

                            @if(!$cart || $cart->items->isEmpty())
                                <div class="text-center py-8">
                                    <div class="mb-4">
                                        <i class="fas fa-shopping-cart text-gray-300 text-5xl"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-500 mb-2">Your cart is empty</h3>
                                    <p class="text-gray-500 max-w-md mx-auto mb-6">You haven't added any items to your cart yet. Check out our marketplace to find the materials you need.</p>
                                    <a href="{{ route('material-purchases.index') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black px-6 py-2 rounded-lg">
                                        Explore marketplace
                                    </a>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Material
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Unit Price
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Quantity
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Points (If purchased with points)
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Subtotal
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($cart->items as $item)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                @if($item->material->image_path)
                                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($item->material->image_path) }}" alt="{{ $item->material->name }}">
                                                                @else
                                                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                                        <i class="fas fa-tools text-gray-400"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $item->material->name }}
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    {{ $item->material->category->name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ number_format($item->material->price, 2) }} DH</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                                            @csrf
                                                            <button type="button" class="px-2 py-1 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 decrement-btn" 
                                                                data-target="quantity-{{ $item->id }}">
                                                                <i class="fas fa-minus text-xs"></i>
                                                            </button>
                                                            <input type="number" name="quantity" id="quantity-{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="{{ $item->material->stock_quantity }}" class="w-12 text-center border border-gray-300 rounded-md">
                                                            <button type="button" class="px-2 py-1 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 increment-btn" 
                                                                data-target="quantity-{{ $item->id }}" data-max="{{ $item->material->stock_quantity }}">
                                                                <i class="fas fa-plus text-xs"></i>
                                                            </button>
                                                            <button type="submit" class="px-2 py-1 bg-yellow-100 rounded-lg text-yellow-700 hover:bg-yellow-200">
                                                                <i class="fas fa-sync-alt text-xs"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-yellow-600">{{ $item->getPointsCost() }} points</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-bold text-gray-900">{{ number_format($item->getSubtotal(), 2) }} DH</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-lg font-semibold">Summary</h3>
                                        <div class="text-right">
                                            <p class="text-gray-700">Total: <span class="font-bold">{{ number_format($cart->getTotal(), 2) }} DH</span></p>
                                            <p class="text-gray-700">Points required (if buying with points): <span class="font-bold text-yellow-600">{{ $cart->items->sum(function($item) { return $item->getPointsCost(); }) }} points</span></p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.decrement-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                if (input && input.value > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });
        
        document.querySelectorAll('.increment-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const max = parseInt(this.getAttribute('data-max'));
                const input = document.getElementById(targetId);
                if (input && parseInt(input.value) < max) {
                    input.value = parseInt(input.value) + 1;
                }
            });
        });
    </script>
</x-app-layout> 