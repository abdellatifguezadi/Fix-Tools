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
                        <div class="bg-white p-6 rounded-lg shadow-md mt-4">
                            <form id="filterForm" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <!-- Recherche -->
                                    <div>
                                        <input type="text" 
                                            name="search" 
                                            placeholder="Rechercher des outils..." 
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                    </div>

                                    <!-- Catégorie -->
                                    <div>
                                        <select name="category" 
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                            <option value="">Toutes les catégories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Prix -->
                                    <div>
                                        <select name="price_range" 
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                            <option value="">Tous les prix</option>
                                            <option value="0-100">0 - 100 DH</option>
                                            <option value="101-500">101 - 500 DH</option>
                                            <option value="501-1000">501 - 1000 DH</option>
                                            <option value="1001-+">Plus de 1000 DH</option>
                                        </select>
                                    </div>

                                    <!-- Points -->
                                    <div>
                                        <select name="points_range" 
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                            <option value="">Tous les points</option>
                                            <option value="0-50">0 - 50 points</option>
                                            <option value="51-100">51 - 100 points</option>
                                            <option value="101-+">Plus de 100 points</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Liste des matériels -->
                        <div id="materialsContainer" class="mt-6">
                            <p class="mb-4">Parcourir et acheter des outils professionnels :</p>
                            <x-marketplace.materials-grid :materials="$materials" />
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
        // Fonction pour mettre à jour les résultats
        function updateResults() {
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);
            const queryString = new URLSearchParams(formData).toString();

            fetch(`{{ route('professionals.marketplace.filter') }}?${queryString}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('materialsContainer').innerHTML = html;
            });
        }

        // Écouteurs d'événements pour les filtres
        document.querySelectorAll('#filterForm select').forEach(element => {
            element.addEventListener('change', updateResults);
        });

        // Délai pour la recherche
        let searchTimeout;
        document.querySelector('#filterForm input[name="search"]').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(updateResults, 300);
        });

        // Fonctions pour les modals
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