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
                                <span class="text-yellow-800">My points: </span>
                                <span class="font-bold text-yellow-800">{{ $userPoints }}</span>
                            </div>
                        </div>

                        <x-marketplace.filters :categories="$categories" />

                        <div id="materialsContainer" class="mt-6">
                            <p class="mb-4">Browse and purchase professional tools:</p>
                            <x-marketplace.materials-grid :materials="$materials" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-marketplace.image-modal />

 

    <script>
        function updateResults() {
            const form = document.querySelector('form[action="{{ route("professionals.marketplace") }}"]');
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

        document.querySelectorAll('form[action="{{ route("professionals.marketplace") }}"] select').forEach(element => {
            element.addEventListener('change', updateResults);
        });

        let searchTimeout;
        document.querySelector('form[action="{{ route("professionals.marketplace") }}"] input[name="search"]').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(updateResults, 300);
        });

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

        document.getElementById('imageModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeImageModal();
            }
        });
    </script>
</x-app-layout> 