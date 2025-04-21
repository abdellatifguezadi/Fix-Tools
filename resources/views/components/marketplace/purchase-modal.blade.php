<!-- @props(['id' => 'purchaseModal', 'userPoints' => 0])

<div id="{{ $id }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg w-full max-w-md mx-auto">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-bold">Purchase a Tool</h3>
                <button onclick="closePurchaseModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div id="material-info" class="border-b pb-4">
                    <h4 class="font-bold text-lg" id="material-name"></h4>
                    <p class="text-gray-600" id="material-price"></p>
                    <p class="text-yellow-600" id="material-points"></p>
                </div>
                
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <span>Available points: </span>
                        <span class="font-bold">{{ $userPoints }}</span>
                    </p>
                </div>
                
                <div class="flex space-x-2">
                    <form id="cartForm" action="{{ route('cart.add') }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="material_id" id="cart-material-id">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <input type="number" name="quantity" min="1" value="1" required id="cart-quantity"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        </div>
                        <button type="submit" class="mt-3 w-full px-4 py-2 bg-white border border-yellow-400 text-yellow-600 rounded-lg hover:bg-yellow-50 transition-colors duration-200">
                            <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                        </button>
                    </form>

                    <form id="purchaseForm" action="" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="material_id" id="purchase-material-id">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <input type="number" name="quantity" min="1" value="1" required id="purchase-quantity"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="card" checked
                                        class="h-4 w-4 text-yellow-400 focus:ring-yellow-400 border-gray-300">
                                    <span class="ml-2">Pay with money</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="points" id="points-radio"
                                        class="h-4 w-4 text-yellow-400 focus:ring-yellow-400 border-gray-300">
                                    <span class="ml-2">Use my points</span>
                                    <span id="insufficient-points" class="ml-2 text-xs text-red-500 hidden">(Insufficient points)</span>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="mt-3 w-full px-4 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-300 transition-colors duration-200">
                            Buy Now
                        </button>
                    </form>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="button" onclick="closePurchaseModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    const materialData = {};
    const userPoints = {{ $userPoints }};
    
    function openPurchaseModal(materialId) {
        const modal = document.getElementById('purchaseModal');
        const purchaseForm = document.getElementById('purchaseForm');
        const cartForm = document.getElementById('cartForm');
        
        // Fetch material data if not already cached
        if (!materialData[materialId]) {
            fetch(`/api/materials/${materialId}`)
                .then(response => response.json())
                .then(data => {
                    materialData[materialId] = data;
                    populateModal(materialId);
                })
                .catch(error => {
                    console.error('Error fetching material data:', error);
                    // Fallback to using placeholder data
                    materialData[materialId] = {
                        name: 'Material #' + materialId,
                        price: 0,
                        points_cost: 0
                    };
                    populateModal(materialId);
                });
        } else {
            populateModal(materialId);
        }

        // Set form action and material ID inputs
        purchaseForm.action = `/material-purchases`;
        document.getElementById('purchase-material-id').value = materialId;
        document.getElementById('cart-material-id').value = materialId;
        
        // Show modal
        modal.classList.remove('hidden');
    }

    function populateModal(materialId) {
        const material = materialData[materialId];
        const pointsRadio = document.getElementById('points-radio');
        const insufficientPoints = document.getElementById('insufficient-points');
        
        // Set material info
        document.getElementById('material-name').textContent = material.name;
        document.getElementById('material-price').textContent = `Price: ${material.price} DH`;
        document.getElementById('material-points').textContent = `Points: ${material.points_cost} points`;
        
        // Check if user has enough points
        if (userPoints < material.points_cost) {
            pointsRadio.disabled = true;
            insufficientPoints.classList.remove('hidden');
        } else {
            pointsRadio.disabled = false;
            insufficientPoints.classList.add('hidden');
        }
        
        // Sync quantities between forms
        const purchaseQuantity = document.getElementById('purchase-quantity');
        const cartQuantity = document.getElementById('cart-quantity');
        
        purchaseQuantity.addEventListener('input', function() {
            cartQuantity.value = this.value;
        });
        
        cartQuantity.addEventListener('input', function() {
            purchaseQuantity.value = this.value;
        });
    }

    function closePurchaseModal() {
        const modal = document.getElementById('purchaseModal');
        modal.classList.add('hidden');
    }

    window.onclick = function(event) {
        const modal = document.getElementById('purchaseModal');
        if (event.target === modal) {
            closePurchaseModal();
        }
    }
</script>
@endpush
@endonce  -->