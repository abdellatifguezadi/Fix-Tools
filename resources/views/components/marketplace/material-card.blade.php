@props(['material'])

<div class="bg-white p-4 rounded-lg shadow-lg border-t-4 border-yellow-400 transition-transform transform hover:scale-105">
    <img src="{{ $material->image_path ? Storage::url($material->image_path) : 'https://via.placeholder.com/300x200?text=Outil' }}" 
        alt="{{ $material->name }}" 
        class="w-full h-32 object-cover rounded-md mb-2 cursor-pointer hover:opacity-75 transition-opacity"
        onclick="openImageModal('{{ $material->image_path ? Storage::url($material->image_path) : 'https://via.placeholder.com/800x600?text=Outil' }}')">
    
    <h3 class="font-bold">{{ $material->name }}</h3>
    <p class="text-gray-600">{{ Str::limit($material->description, 100) }}</p>
    
    <div class="mt-2">
        <p class="font-semibold">Prix : {{ $material->price }} DH</p>
        @if($material->points_cost)
            <p class="text-sm text-gray-500">ou {{ $material->points_cost }} points</p>
        @endif
    </div>

    <div class="mt-2 flex justify-between items-center">
        <span class="text-sm {{ $material->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ $material->stock_quantity > 0 ? 'En stock' : 'Rupture de stock' }}
        </span>
        
        @if($material->stock_quantity > 0)
            <button onclick="openPurchaseModal('{{ $material->id }}')" 
                class="bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-300 transition-colors duration-200">
                Acheter
            </button>
        @endif
    </div>
</div> 