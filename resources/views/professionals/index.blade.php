<x-app-layout>
    <!-- Main Container -->
    <div class="bg-gray-100 h-screen flex overflow-hidden">
        <!-- Sidebar - Hidden on initial view but can be toggled -->
        <aside class="fixed inset-y-0 left-0 w-64 bg-black z-20 transform -translate-x-full sm:translate-x-0 transition-transform duration-200 ease-in-out">
            <x-sidebars.professional />
        </aside>

        <!-- Main Content Area -->
        <div class="w-full flex-1 flex flex-col transition-all duration-200 ease-in-out">
            <!-- Top Navbar Space -->
            <div class="h-16"></div>
            
            <!-- Page Content -->
            <div class="flex-1 overflow-auto">
                <div class="container mx-auto py-6 px-4">
                    <!-- Header -->
                    <div class="mb-6 bg-white shadow-sm rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <h1 class="text-2xl font-bold">Mes Services</h1>
                            <button onclick="openAddModal()" class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                Ajouter un service
                            </button>
                        </div>
                    </div>

                    <!-- Services Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Service Card 1 -->
                        <x-professional-service-card 
                            :id="1"
                            name="Service de Plomberie"
                            category="Plomberie"
                            description="Installation et réparation de systèmes de plomberie, débouchage, maintenance..."
                            price="75.00"
                            image="https://images.unsplash.com/photo-1581244277943-fe4a9c777189"
                            :isAvailable="true"
                        />

                        <!-- Service Card 2 -->
                        <x-professional-service-card 
                            :id="2"
                            name="Service d'Électricité"
                            category="Électricité"
                            description="Installation électrique, dépannage, mise aux normes, installation domotique..."
                            price="85.00"
                            image="https://images.unsplash.com/photo-1621905251918-48416bd8575a"
                            :isAvailable="true"
                        />

                        <!-- Service Card 3 -->
                        <x-professional-service-card 
                            :id="3"
                            name="Service de Peinture"
                            category="Peinture"
                            description="Travaux de peinture intérieure et extérieure, revêtements muraux..."
                            price="65.00"
                            image="https://images.unsplash.com/photo-1589939705384-5185137a7f0f"
                            :isAvailable="true"
                        />
                    </div>
                </div>
            </div>


        </div>
        
        <!-- Mobile sidebar toggle button -->
        <button id="sidebarToggle" class="fixed top-4 left-4 z-40 sm:hidden bg-yellow-400 text-black p-2 rounded-md">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Add Service Modal -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 overflow-hidden">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md mx-4 my-auto max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Ajouter un nouveau service</h2>
                <button onclick="closeAddModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">Nom du service</label>
                    <input type="text" name="name" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"></textarea>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Catégorie</label>
                    <select name="category_id" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        <option value="1">Plomberie</option>
                        <option value="2">Électricité</option>
                        <option value="3">Peinture</option>
                        <option value="4">Menuiserie</option>
                        <option value="5">Jardinage</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Prix de base (€)</label>
                    <input type="number" name="base_price" step="0.01" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Image du service</label>
                    <input type="file" name="image" accept="image/*" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="flex items-center mb-4">
                    <input type="checkbox" name="is_available" id="is_available" checked
                        class="rounded border-gray-300 text-yellow-400 focus:ring-yellow-400">
                    <label for="is_available" class="ml-2 text-gray-700">Service disponible</label>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeAddModal()"
                        class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Annuler</button>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-400 rounded-lg hover:bg-yellow-500">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 overflow-hidden">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md mx-4 my-auto max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">Modifier le service</h2>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">Nom du service</label>
                    <input type="text" name="name" value="Service de Plomberie" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">Installation et réparation de systèmes de plomberie, débouchage, maintenance...</textarea>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Catégorie</label>
                    <select name="category_id" required
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
                    <input type="number" name="base_price" value="75.00" step="0.01" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Image du service</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="flex items-center mb-4">
                    <input type="checkbox" name="is_available" checked
                        class="rounded border-gray-300 text-yellow-400 focus:ring-yellow-400">
                    <label class="ml-2 text-gray-700">Service disponible</label>
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

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 overflow-hidden">
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md mx-4 my-auto">
            <h2 class="text-xl font-bold mb-4">Supprimer le service</h2>
            <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir supprimer ce service ? Cette action est irréversible.</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()" 
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Annuler</button>
                <button onclick="closeDeleteModal()" 
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Supprimer</button>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }

        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('-translate-x-full');
        });

        // Close sidebar when the close button is clicked
        document.getElementById('closeSidebar').addEventListener('click', function() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.add('-translate-x-full');
        });

        window.onclick = function(event) {
            if (event.target.classList.contains('bg-black')) {
                closeAddModal();
                closeEditModal();
                closeDeleteModal();
            }
        }
    </script>
</x-app-layout> 