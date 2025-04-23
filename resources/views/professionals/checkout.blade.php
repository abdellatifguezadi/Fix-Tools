<x-app-layout>
    <x-slot name="title">Paiement</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="md:w-1/4">
                    <x-marketplace.checkout-sidebar :cart="$cart" :userPoints="$userPoints" :pointsUsed="$pointsUsed" :priceToPay="$priceToPay" />
                </div>
                
                <div class="md:w-3/4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-2xl font-bold">Finaliser votre commande</h1>
                                <div class="flex space-x-4">
                                    <a href="{{ route('cart.index') }}" class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg flex items-center">
                                        <i class="fas fa-arrow-left mr-2"></i>
                                        Retour au panier
                                    </a>
                                </div>
                            </div>

                            @if (session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                    <span class="font-bold">Succès!</span>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                    <span class="font-bold">Erreur!</span>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif

                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle text-yellow-500"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium">Vérifiez votre commande avant de confirmer le paiement.</p>
                                    </div>
                                </div>
                            </div>

                            @if(!$cart || $cart->items->isEmpty())
                                <div class="text-center py-8">
                                    <div class="mb-4">
                                        <i class="fas fa-shopping-cart text-gray-300 text-5xl"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-500 mb-2">Votre panier est vide</h3>
                                    <p class="text-gray-500 max-w-md mx-auto mb-6">Vous n'avez pas encore ajouté d'articles à votre panier.</p>
                                    <a href="{{ route('material-purchases.index') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black px-6 py-2 rounded-lg">
                                        Explorer le marché
                                    </a>
                                </div>
                            @else
                                <div class="mb-6">
                                    <h2 class="text-xl font-bold mb-4">Articles de votre commande</h2>
                                    <div class="grid grid-cols-1 gap-4">
                                        @foreach ($cart->items as $item)
                                            <div class="border rounded-lg overflow-hidden bg-white">
                                                <div class="flex flex-col md:flex-row">
                                                    <div class="md:w-1/4 flex-shrink-0">
                                                        @if($item->material->image_path)
                                                            <img src="{{ Storage::url($item->material->image_path) }}" alt="{{ $item->material->name }}" class="w-full h-40 md:h-full object-cover">
                                                        @else
                                                            <div class="w-full h-40 md:h-full bg-gray-100 flex items-center justify-center">
                                                                <i class="fas fa-tools text-gray-400 text-3xl"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="p-4 md:w-3/4">
                                                        <div class="flex justify-between">
                                                            <div>
                                                                <h3 class="text-lg font-bold">{{ $item->material->name }}</h3>
                                                                <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">{{ $item->material->category->name }}</span>
                                                            </div>
                                                            <div class="text-right">
                                                                <p class="text-lg font-bold">{{ number_format($item->getSubtotal(), 2) }} DH</p>
                                                                <p class="text-sm text-gray-600">{{ number_format($item->material->price, 2) }} DH x {{ $item->quantity }}</p>
                                                            </div>
                                                        </div>
                                                        <p class="mt-2 text-gray-600">{{ $item->material->description }}</p>
                                                        <div class="mt-3 flex justify-between items-end">
                                                            <div>
                                                                <p class="text-sm text-gray-600">Points pour cet article: <span class="text-yellow-600 font-medium">{{ $item->getPointsCost() }} points</span></p>
                                                            </div>
                                                            <div>
                                                                <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                                                    Quantité: {{ $item->quantity }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @if(session('checkout_data.payment_method') != 'points')
                                    <div class="mb-6">
                                        <h2 class="text-xl font-bold mb-4">Informations de paiement</h2>
                                        <div class="bg-blue-50 p-4 rounded-lg">
                                            <h3 class="font-bold text-blue-800 mb-2">Paiement par carte bancaire</h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de carte</label>
                                                    <input type="text" class="w-full p-2 border border-gray-300 rounded-md" placeholder="1234 5678 9012 3456" disabled>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Date d'expiration</label>
                                                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md" placeholder="MM / AA" disabled>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">CVC</label>
                                                        <input type="text" class="w-full p-2 border border-gray-300 rounded-md" placeholder="123" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 text-sm text-blue-700">
                                                <i class="fas fa-lock mr-1"></i> Ce formulaire est désactivé pour la démonstration. En production, un système de paiement sécurisé serait intégré.
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                                        <div>
                                            <h3 class="text-lg font-semibold">Total à payer</h3>
                                            <p class="text-sm text-gray-600">{{ $cart->getTotalItems() }} articles</p>
                                        </div>
                                        <div class="mt-2 md:mt-0 text-right">
                                            @if($pointsUsed > 0)
                                                <p class="text-sm text-gray-600">Sous-total: <span class="font-semibold">{{ number_format($cart->getTotal(), 2) }} DH</span></p>
                                                <p class="text-sm text-yellow-600">Points utilisés: <span class="font-semibold">{{ $pointsUsed }} points</span></p>
                                                <p class="text-sm text-gray-600">Réduction: <span class="font-semibold">-{{ number_format($cart->getTotal() - $priceToPay, 2) }} DH</span></p>
                                            @endif
                                            <p class="text-xl font-bold {{ $pointsUsed > 0 ? 'mt-1' : '' }}">{{ number_format($priceToPay, 2) }} DH</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 