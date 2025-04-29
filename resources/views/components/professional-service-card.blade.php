@props(['id', 'name', 'category', 'categoryId', 'description', 'price', 'image', 'isAvailable'])

<div class="bg-white rounded-lg shadow-lg overflow-hidden transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl group">
    <div class="overflow-hidden">
        <img src="{{ $image }}" 
             alt="{{ $name }}" 
             class="w-full h-48 object-cover transition-transform duration-500 ease-in-out hover:scale-110">
    </div>
    <div class="p-6">
        <h3 class="text-xl font-bold mb-2 transition-colors duration-300 group-hover:text-yellow-500">{{ $name }}</h3>
        <p class="text-gray-500 text-sm mb-2">{{ $category }}</p>
        <p class="text-gray-600 mb-4">{{ $description }}</p>
        <div class="flex justify-between items-center mt-4">
            <div>
                <p class="font-semibold text-lg transition-colors duration-300 group-hover:text-yellow-500">{{ $price }} DH</p>
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
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition duration-200">
                    <i class="fas fa-edit"></i>
                </button>

                <x-delete-confirmation-modal 
                    :title="'Delete Service'"
                    :message="'Are you sure you want to delete this service? This action cannot be undone.'"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition duration-200">
                    <i class="fas fa-trash"></i>
                    <x-slot name="actions">
                        <form action="{{ route('services.destroy', $id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Delete Service
                            </button>
                            <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </form>
                    </x-slot>
                </x-delete-confirmation-modal>
            </div>
        </div>
    </div>
</div> 