<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marketplace') }}
        </h2>
    </x-slot>

    <div class="min-h-screen pb-32">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-xl font-bold">Marketplace</h1>
                            <div class="bg-yellow-100 px-4 py-2 rounded-lg">
                                <span class="text-yellow-800">Mes points : </span>
                                <span class="font-bold text-yellow-800">{{ auth()->user()->loyalty_points ?? 0 }}</span>
                            </div>
                        </div>

                        <!-- Section des filtres -->
                        <x-marketplace.filters :categories="$categories" />

                        <!-- Liste des matériels -->
                        <div class="mt-6">
                            <p class="mb-4">Parcourir et acheter des outils professionnels :</p>

                            @if($materials->isEmpty())
                                <div class="text-center py-8">
                                    <i class="fas fa-tools text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-600">Aucun outil ne correspond à vos critères de recherche.</p>
                                </div>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($materials as $material)
                                        <x-marketplace.material-card :material="$material" />
                                    @endforeach
                                </div>

                                <!-- Pagination -->
                                <div class="mt-6">
                                    {{ $materials->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'achat -->
    <x-marketplace.purchase-modal />

    <!-- Modal d'image -->
    <x-marketplace.image-modal />

    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" 
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg" 
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)">
            {{ session('error') }}
        </div>
    @endif

    <script>
        function openImageModal(imageUrl) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Fermer le modal si on clique en dehors de l'image
        document.getElementById('imageModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeImageModal();
            }
        });
    </script>
</x-app-layout> 