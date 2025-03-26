<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <img src="{{ $image }}" 
         alt="{{ $name }}" 
         class="w-full h-48 object-cover">
    <div class="p-6">
        <h3 class="text-xl font-bold mb-2">{{ $name }}</h3>
        <p class="text-gray-500 text-sm mb-2">{{ $category }}</p>
        <p class="text-gray-600 mb-4">{{ $description }}</p>
        <div class="flex justify-between items-center mt-4">
            <div>
                <p class="font-semibold text-lg">{{ $price }}€</p>
                <span class="text-sm text-gray-500">{{ $isAvailable ? 'Disponible' : 'Non disponible' }}</span>
            </div>
            <div class="space-x-2">
                <button type="button"
                        data-id="{{ $id }}"
                        onclick="openEditModal(this.dataset.id)" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button"
                        data-id="{{ $id }}"
                        onclick="openDeleteModal(this.dataset.id)" 
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
</div> 