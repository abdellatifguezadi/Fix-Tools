<x-app-layout>
    <div class="bg-gray-100 min-h-screen">
        <div class="container mx-auto py-6 px-4">
            <div class="mb-6 bg-white shadow-sm rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold">My Services</h1>
                    @if(auth()->check() && auth()->user()->isProfessional())
                        <button onclick="openAddModal()" class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Add a service
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
                    />
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">You don't have any services yet. Add one by clicking the button above.</p>
                    </div>
                @endforelse
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
            
            const baseUrl = '{{ route("services.update", ":service_id") }}';
            editForm.action = baseUrl.replace(':service_id', id);

            editForm.querySelector('[name="service_id"]').value = id;
            editForm.querySelector('[name="name"]').value = name;
            editForm.querySelector('[name="description"]').value = description;
            editForm.querySelector('[name="category_id"]').value = categoryId;
            editForm.querySelector('[name="base_price"]').value = price;
            editForm.querySelector('[name="is_available"]').checked = isAvailable;
            
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