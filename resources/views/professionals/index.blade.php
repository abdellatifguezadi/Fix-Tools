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
                            @if(auth()->check() && auth()->user()->isProfessional())
                                <button onclick="openAddModal()" class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg flex items-center">
                                    <i class="fas fa-plus mr-2"></i>
                                    Ajouter un service
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Services Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($services as $service)
                                <x-professional-service-card 
                                    :id="$service['id']"
                                    :name="$service['name']"
                                    :category="$service['category']"
                                    :categoryId="$service['categoryId']"
                                    :description="$service['description']"
                                    :price="$service['price']"
                                    :image="$service['image']"
                                    :isAvailable="$service['isAvailable']"
                                />
                            @empty
                                <div class="col-span-full text-center py-8">
                                    <p class="text-gray-500">Vous n'avez pas encore de services. Ajoutez-en un en cliquant sur le bouton ci-dessus.</p>
                                </div>
                            @endforelse
                    </div>

                    <!-- Ajoutez ceci juste après la balise <div class="container mx-auto py-6 px-4"> -->
                    <!-- <div class="mb-4">
                        @foreach($services as $service)
                            <div class="text-sm text-gray-600">
                                Image URL: {{ $service['image'] }}<br>
                                Storage URL: {{ Storage::url($service['image']) }}<br>
                                Asset URL: {{ asset('storage/' . $service['image']) }}
                            </div>
                        @endforeach
                    </div> -->
                </div>
            </div>


        </div>
        
        <!-- Mobile sidebar toggle button -->
        <button id="sidebarToggle" class="fixed top-4 left-4 z-40 sm:hidden bg-yellow-400 text-black p-2 rounded-md">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Add, Edit, Delete Modals -->
    <x-modals.add-service-modal :categories="$categories" />
    <x-modals.edit-service-modal :categories="$categories" />
    <x-modals.delete-service-modal />

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function openEditModal(id, name, description, category_id, price, isAvailable) {

            const editModal = document.getElementById('editModal');
            const editForm = editModal.querySelector('form');

            const formAction = editForm.action;
            editForm.action = formAction.replace(':service_id', id);

            document.getElementById('edit_service_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;
            

            const categorySelect = document.getElementById('edit_category_id');

            if (category_id) {
                for (let i = 0; i < categorySelect.options.length; i++) {
                    if (categorySelect.options[i].value == category_id) {
                        categorySelect.selectedIndex = i;
                        break;
                    }
                }
            } else {
                categorySelect.selectedIndex = 0;
            }
            
            document.getElementById('edit_base_price').value = price;
            document.getElementById('edit_is_available').checked = isAvailable;

            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }

        let currentServiceId = null;

        function openDeleteModal(id) {
            currentServiceId = id;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        function confirmDelete() {
            alert("Service " + currentServiceId + " supprimé avec succès");
            closeDeleteModal();
        }

        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('-translate-x-full');
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