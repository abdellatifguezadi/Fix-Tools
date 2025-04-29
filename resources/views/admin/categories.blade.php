<x-app-layout>
    <x-slot name="title">
        Categories Management
    </x-slot>

    <div class="min-h-screen flex flex-col">
        <div class="flex-1 p-8 mt-16">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Categories Management</h2>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" 
                    onclick="document.getElementById('addCategoryModal').classList.remove('hidden')">
                    <i class="fas fa-plus mr-2"></i>Add Category
                </button>
            </div>


            <!-- Categories Table -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="overflow-x-auto">
                    @if(count($categories) > 0)
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">ID</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Type</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($categories as $category)
                            <tr>
                                <td class="px-4 py-3">{{ $category->id }}</td>
                                <td class="px-4 py-3">{{ $category->name }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->type === 'service' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $category->type === 'service' ? 'Service' : 'Material' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800" 
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}"
                                            data-description="{{ $category->description }}"
                                            onclick="openEditModal(this.dataset.id, this.dataset.name, this.dataset.description)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <x-delete-confirmation-modal 
                                            :title="'Delete Category'"
                                            :message="'Are you sure you want to delete ' . $category->name . '? This will also affect all related materials and services.'">
                                            <i class="fas fa-trash"></i>
                                            <x-slot name="actions">
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Delete Category
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
                    <p class="text-center py-4 text-gray-500">No categories available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-lg mx-4">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-bold">Add Category</h3>
                <button onclick="document.getElementById('addCategoryModal').classList.add('hidden')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST" class="p-6">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                    <input type="text" name="name" id="name" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="type" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="service">Service</option>
                        <option value="material">Material</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('addCategoryModal').classList.add('hidden')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="editCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-lg mx-4">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-bold">Edit Category</h3>
                <button onclick="document.getElementById('editCategoryModal').classList.add('hidden')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="editCategoryForm" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                    <input type="text" name="name" id="edit_name" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="edit_type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="edit_type" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="service">Service</option>
                        <option value="material">Material</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('editCategoryModal').classList.add('hidden')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
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
            window.openEditModal = function(id, name, description) {
                document.getElementById('editCategoryForm').action = "{{ url('/categories') }}/" + id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_type').value = description.type;
                document.getElementById('editCategoryModal').classList.remove('hidden');
            };
        });
    </script>
</x-app-layout> 