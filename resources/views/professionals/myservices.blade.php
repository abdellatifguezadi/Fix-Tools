<x-app-layout>

    <div class="bg-gray-100 h-screen flex overflow-hidden">

        <aside class="fixed inset-y-0 left-0 w-64 bg-black z-20 transform -translate-x-full sm:translate-x-0 transition-transform duration-200 ease-in-out">
            <x-sidebars.professional />
        </aside>

        <div class="w-full flex-1 flex flex-col transition-all duration-200 ease-in-out">

            <div class="h-16"></div>

            <div class="flex-1 overflow-auto">
                <div class="container mx-auto py-6 px-4">

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

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($services as $service)
                                <x-professional-service-card 
                                    :id="$service['id']"
                                    :name="$service['name']"
                                    :category="$service['category']"
                                    :categoryId="$service['category_id']"
                                    :description="$service['description']"
                                    :price="number_format($service['base_price'], 2)"
                                    :image="$service['image_path']"
                                    :isAvailable="$service['is_available']"
                                >
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800" 
                                            data-id="{{ $service['id'] }}"
                                            data-name="{{ $service['name'] }}"
                                            data-description="{{ $service['description'] }}"
                                            data-category-id="{{ $service['category_id'] }}"
                                            data-price="{{ $service['base_price'] }}"
                                            data-is-available="{{ $service['is_available'] ? 'true' : 'false' }}"
                                            onclick="openEditModal(
                                                this.dataset.id,
                                                this.dataset.name,
                                                this.dataset.description,
                                                Number(this.dataset.categoryId || 0),
                                                Number(this.dataset.price || 0),
                                                this.dataset.isAvailable === 'true'
                                            )">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('services.destroy', $service['id']) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </x-professional-service-card>
                            @empty
                                <div class="col-span-full text-center py-8">
                                    <p class="text-gray-500">Vous n'avez pas encore de services. Ajoutez-en un en cliquant sur le bouton ci-dessus.</p>
                                </div>
                            @endforelse
                    </div>

                    <!-- Debug section (commented out) -->
                    <!-- <div class="mb-4">
                        @foreach($services as $service)
                            <div class="text-sm text-gray-600">
                                Image URL: {{ $service['image_path'] }}<br>
                                Storage URL: {{ Storage::url($service['image_path']) }}<br>
                                Asset URL: {{ asset('storage/' . $service['image_path']) }}
                            </div>
                        @endforeach
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <x-modals.add-service-modal :categories="$categories" />
    <x-modals.edit-service-modal :categories="$categories" />
    <x-modals.delete-service-modal :service="isset($services[0]) ? $services[0] : null" />

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
            document.getElementById('addModal').classList.add('flex');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
            document.getElementById('addModal').classList.remove('flex');
        }

        function openEditModal(id, name, description, categoryId, price, isAvailable) {
            const editModal = document.getElementById('editModal');
            const editForm = editModal.querySelector('form');
            
            // Construire l'URL de base pour le formulaire
            const baseUrl = '{{ route("services.update", ":service_id") }}';
            editForm.action = baseUrl.replace(':service_id', id);

            // Mettre à jour les champs du formulaire
            editForm.querySelector('[name="service_id"]').value = id;
            editForm.querySelector('[name="name"]').value = name;
            editForm.querySelector('[name="description"]').value = description;
            editForm.querySelector('[name="category_id"]').value = categoryId;
            editForm.querySelector('[name="base_price"]').value = price;
            editForm.querySelector('[name="is_available"]').checked = isAvailable;
            
            // Afficher le modal
            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }

        function openDeleteModal(id) {
            const deleteModal = document.getElementById('deleteModal');
            const deleteForm = deleteModal.querySelector('form');
            
            if (deleteForm) {
                const formAction = deleteForm.action;
                deleteForm.action = formAction.replace(':service', id);
            }
            
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('bg-black')) {
                closeAddModal();
                closeEditModal();
                closeDeleteModal();
            }
        }
    </script>
</x-app-layout> 