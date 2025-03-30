@props(['id' => 'purchaseModal'])

<div id="{{ $id }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg w-full max-w-md mx-auto">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-bold">Acheter un outil</h3>
                <button onclick="closePurchaseModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="purchaseForm" action="" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantité</label>
                    <input type="number" name="quantity" min="1" value="1" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mode de paiement</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="money" checked
                                class="h-4 w-4 text-yellow-400 focus:ring-yellow-400 border-gray-300">
                            <span class="ml-2">Payer avec de l'argent</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="points"
                                class="h-4 w-4 text-yellow-400 focus:ring-yellow-400 border-gray-300">
                            <span class="ml-2">Utiliser mes points</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closePurchaseModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-300 transition-colors duration-200">
                        Confirmer l'achat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    function openPurchaseModal(materialId) {
        const modal = document.getElementById('purchaseModal');
        const form = document.getElementById('purchaseForm');
        form.action = `/materials/${materialId}/purchase`;
        modal.classList.remove('hidden');
    }

    function closePurchaseModal() {
        const modal = document.getElementById('purchaseModal');
        modal.classList.add('hidden');
    }

    // Fermer le modal si on clique en dehors
    window.onclick = function(event) {
        const modal = document.getElementById('purchaseModal');
        if (event.target === modal) {
            closePurchaseModal();
        }
    }
</script>
@endpush
@endonce 