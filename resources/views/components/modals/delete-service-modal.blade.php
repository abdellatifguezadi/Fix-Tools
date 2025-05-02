@props(['service' => null])

<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 overflow-hidden">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md mx-4 my-auto">
        <h2 class="text-xl font-bold mb-4">Delete Service</h2>
        <p class="text-gray-600 mb-6">Are you sure you want to delete this service? This action cannot be undone.</p>
        
        <form method="POST" action="{{ route('services.destroy', ':service') }}">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" 
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
                <button type="submit" 
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
            </div>
        </form>
    </div>
</div> 