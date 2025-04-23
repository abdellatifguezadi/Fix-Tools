@props(['material'])

<div class="bg-white p-4 rounded-lg shadow-lg border-t-4 border-yellow-400 transition-transform transform hover:scale-105">
    <img src="{{ $material->image_path ? Storage::url($material->image_path) : 'https://via.placeholder.com/300x200?text=Tool' }}"
        alt="{{ $material->name }}"
        class="w-full h-32 object-cover rounded-md mb-2 cursor-pointer hover:opacity-75 transition-opacity"
        onclick="openImageModal('{{ $material->image_path ? Storage::url($material->image_path) : 'https://via.placeholder.com/800x600?text=Tool' }}')">

    <h3 class="font-bold">{{ $material->name }}</h3>
    <p class="text-gray-600">{{ Str::limit($material->description, 100) }}</p>

    <div class="mt-2">
        <p class="font-semibold">Price: {{ $material->price }} DH</p>
        @if($material->points_cost)
        <p class="text-sm text-gray-500">or {{ $material->points_cost }} points</p>
        @endif
    </div>

    <div class="mt-2 flex justify-between items-center">
        <span class="text-sm {{ $material->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ $material->stock_quantity > 0 ? 'In stock' : 'Out of stock' }}
        </span>

        <div class="flex space-x-2">
            @if($material->stock_quantity > 0)
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="material_id" value="{{ $material->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="bg-white border border-yellow-400 text-yellow-600 px-2 py-2 rounded-lg hover:bg-yellow-50 transition-colors duration-200">
                    <i class="fas fa-shopping-cart"></i>
                </button>
            </form>

            <!-- <button onclick="openPurchaseModal('{{ $material->id }}')" 
                    class="bg-yellow-400 text-black px-3 py-2 rounded-lg hover:bg-yellow-300 transition-colors duration-200">
                    Buy
                </button> -->
            @endif
        </div>
    </div>
</div>