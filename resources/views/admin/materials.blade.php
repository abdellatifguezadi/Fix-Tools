<x-app-layout>
    <x-slot name="title">
        Materials Management
    </x-slot>

    <div class="min-h-screen flex flex-col">
        <div class="flex-1 p-8 mt-16">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Materials Management</h2>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" 
                    onclick="document.getElementById('addMaterialModal').classList.remove('hidden')">
                    <i class="fas fa-plus mr-2"></i>Add Material
                </button>
            </div>


            <!-- Materials Table -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="overflow-x-auto">
                    @if(count($materials) > 0)
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Image</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Category</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Price</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Points</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Stock</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Available</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($materials as $material)
                            <tr>
                                <td class="px-4 py-3">
                                    @if($material->image_path)
                                        <img src="{{ asset('storage/' . $material->image_path) }}" alt="{{ $material->name }}" class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-tools text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $material->name }}</td>
                                <td class="px-4 py-3">{{ $material->category ? $material->category->name : 'Unknown category' }}</td>
                                <td class="px-4 py-3">{{ number_format($material->price, 2) }} MAD</td>
                                <td class="px-4 py-3">{{ $material->points_cost }}</td>
                                <td class="px-4 py-3">{{ $material->stock_quantity }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $material->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $material->is_available ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800" 
                                            data-id="{{ $material->id }}"
                                            data-name="{{ addslashes($material->name) }}"
                                            data-description="{{ addslashes($material->description) }}"
                                            data-category-id="{{ $material->category_id }}"
                                            data-price="{{ $material->price }}"
                                            data-points-cost="{{ $material->points_cost }}"
                                            data-stock-quantity="{{ $material->stock_quantity }}"
                                            data-is-available="{{ $material->is_available ? 'true' : 'false' }}"
                                            onclick="openEditModal(
                                                this.dataset.id,
                                                this.dataset.name,
                                                this.dataset.description,
                                                Number(this.dataset.categoryId || 0),
                                                Number(this.dataset.price || 0),
                                                Number(this.dataset.pointsCost || 0),
                                                Number(this.dataset.stockQuantity || 0),
                                                this.dataset.isAvailable === 'true'
                                            )">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <x-delete-confirmation-modal 
                                            :title="'Delete Material'"
                                            :message="'Are you sure you want to delete ' . $material->name . '? This action cannot be undone.'">
                                            <i class="fas fa-trash"></i>
                                            <x-slot name="actions">
                                                <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Delete Material
                                                    </button>
                                                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Cancel
                                                    </button>
                                                </form>
                                            </x-slot>
                                        </x-delete-confirmation-modal>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-center py-4 text-gray-500">No materials available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Material Modal -->
    <div id="addMaterialModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-lg mx-4">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-bold">Add Material</h3>
                <button onclick="document.getElementById('addMaterialModal').classList.add('hidden')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category (Optional)</label>
                    <select name="category_id" id="category_id" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                        <input type="number" name="price" id="price" step="0.01" min="0" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="points_cost" class="block text-sm font-medium text-gray-700 mb-1">Points Cost</label>
                        <input type="number" name="points_cost" id="points_cost" min="0" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" min="0" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                    <input type="file" name="image" id="image" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="is_available" id="is_available" class="mr-2" checked>
                    <label for="is_available" class="text-sm font-medium text-gray-700">Available</label>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('addMaterialModal').classList.add('hidden')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Material Modal -->
    <div id="editMaterialModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-lg mx-4">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-bold">Edit Material</h3>
                <button onclick="document.getElementById('editMaterialModal').classList.add('hidden')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editMaterialForm" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="edit_name" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="edit_description" rows="3" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="mb-4">
                    <label for="edit_category_id" class="block text-sm font-medium text-gray-700 mb-1">Category (Optional)</label>
                    <select name="category_id" id="edit_category_id" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="edit_price" class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                        <input type="number" name="price" id="edit_price" step="0.01" min="0" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="edit_points_cost" class="block text-sm font-medium text-gray-700 mb-1">Points Cost</label>
                        <input type="number" name="points_cost" id="edit_points_cost" min="0" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="edit_stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="edit_stock_quantity" min="0" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="edit_image" class="block text-sm font-medium text-gray-700 mb-1">Image (leave empty to keep current image)</label>
                    <input type="file" name="image" id="edit_image" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="is_available" id="edit_is_available" class="mr-2">
                    <label for="edit_is_available" class="text-sm font-medium text-gray-700">Available</label>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('editMaterialModal').classList.add('hidden')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.openEditModal = function(id, name, description, categoryId, price, pointsCost, stockQuantity, isAvailable) {
                document.getElementById('editMaterialForm').action = "{{ url('/materials') }}/" + id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_description').value = description;
                document.getElementById('edit_category_id').value = categoryId;
                document.getElementById('edit_price').value = price;
                document.getElementById('edit_points_cost').value = pointsCost;
                document.getElementById('edit_stock_quantity').value = stockQuantity;
                document.getElementById('edit_is_available').checked = isAvailable;
                document.getElementById('editMaterialModal').classList.remove('hidden');
            };
        });
    </script>
</x-app-layout>