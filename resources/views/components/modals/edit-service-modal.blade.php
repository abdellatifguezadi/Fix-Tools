@props(['categories'])


<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 overflow-hidden">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md mx-4 my-auto max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Edit Service</h2>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form class="space-y-4" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="service_id">
            <div>
                <label class="block text-gray-700 mb-2">Service Name</label>
                <input type="text" name="name" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"></textarea>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Category</label>
                <select name="category_id"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="">No Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Base Price (DH)</label>
                <input type="number" name="base_price" step="0.01" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Service Image</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
            </div>
            <div class="flex items-center mb-4">
                <input type="checkbox" name="is_available" id="edit_is_available"
                    class="rounded border-gray-300 text-yellow-400 focus:ring-yellow-400">
                <label for="edit_is_available" class="ml-2 text-gray-700">Service Available</label>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-yellow-400 rounded-lg hover:bg-yellow-500">Update</button>
            </div>
        </form>
    </div>
</div>