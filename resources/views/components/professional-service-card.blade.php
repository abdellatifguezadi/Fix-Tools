@props(['id', 'name', 'category', 'categoryId', 'description', 'price', 'image', 'isAvailable'])

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
                <p class="font-semibold text-lg">{{ $price }} DH</p>
                <span class="text-sm text-gray-500">{{ $isAvailable ? 'Disponible' : 'Non disponible' }}</span>
            </div>
            <div class="space-x-2">
                <button type="button"
                        data-id="{{ $id }}"
                        data-name="{{ $name }}"
                        data-description="{{ $description }}"
                        data-category-id="{{ $categoryId }}"
                        data-price="{{ str_replace(',', '', $price) }}"
                        data-is-available="{{ $isAvailable ? 'true' : 'false' }}"
                        onclick="openEditModal(
                            this.dataset.id,
                            this.dataset.name,
                            this.dataset.description,
                            Number(this.dataset.categoryId || 0),
                            this.dataset.price,
                            this.dataset.isAvailable === 'true'
                        )" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                    <i class="fas fa-edit"></i>
                </button>
                <form action="{{ route('services.destroy', $id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> 