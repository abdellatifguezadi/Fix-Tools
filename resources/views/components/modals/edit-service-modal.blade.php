<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 overflow-hidden">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md mx-4 my-auto max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Modifier le service</h2>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form class="space-y-4" action="#" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="service_id" id="edit_service_id">
            <div>
                <label class="block text-gray-700 mb-2">Nom du service</label>
                <input type="text" name="name" id="edit_name" value="Service de Plomberie" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Description</label>
                <textarea name="description" id="edit_description" rows="3" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">Installation et réparation de systèmes de plomberie, débouchage, maintenance...</textarea>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Catégorie</label>
                <select name="category_id" id="edit_category_id" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="1" selected>Plomberie</option>
                    <option value="2">Électricité</option>
                    <option value="3">Peinture</option>
                    <option value="4">Menuiserie</option>
                    <option value="5">Jardinage</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Prix de base (€)</label>
                <input type="number" name="base_price" id="edit_base_price" value="75.00" step="0.01" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Image du service</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <p class="text-sm text-gray-500 mt-1">Laissez vide pour conserver l'image actuelle</p>
            </div>
            <div class="flex items-center mb-4">
                <input type="checkbox" name="is_available" id="edit_is_available" checked
                    class="rounded border-gray-300 text-yellow-400 focus:ring-yellow-400">
                <label for="edit_is_available" class="ml-2 text-gray-700">Service disponible</label>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Annuler</button>
                <button type="submit"
                    class="px-4 py-2 bg-yellow-400 rounded-lg hover:bg-yellow-500">Enregistrer</button>
            </div>
        </form>
    </div>
</div> 