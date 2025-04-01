<x-app-layout>

    <div class="bg-gray-50 h-screen flex overflow-hidden">

        <aside class="fixed inset-y-0 left-0 w-64 bg-gray-900 z-20 transform -translate-x-full sm:translate-x-0 transition-transform duration-200 ease-in-out">
            <x-sidebars.professional />
        </aside>

        <div class="w-full flex-1 flex flex-col transition-all duration-200 ease-in-out">

            <div class="h-16"></div>

            <div class="flex-1 overflow-auto">
                <div class="container mx-auto py-6 px-4">
                    <!-- Welcome Section -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900">Bonjour, {{ $user->name }}</h1>
                        <p class="mt-2 text-gray-600">Voici un aperçu de votre activité</p>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Services Card -->
                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-gray-700">Services Proposés</h2>
                                    <p class="text-3xl font-bold text-gray-900">{{ $servicesCount }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Materials Card -->
                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-gray-700">Matériaux Achetés</h2>
                                    <p class="text-3xl font-bold text-gray-900">{{ $materialPurchasesCount }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Amount Card -->
                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-gray-700">Total des Achats</h2>
                                    <p class="text-3xl font-bold text-gray-900">{{ number_format($totalPurchasesAmount, 2) }} DH</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Recent Services -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Services Récents</h2>
                                @if($recentServices->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($recentServices as $service)
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">{{ $service->title }}</h3>
                                                    <p class="text-sm text-gray-600">{{ $service->base_price }} DH</p>
                                                </div>
                                                <span class="px-3 py-1 text-sm rounded-full {{ $service->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $service->is_available ? 'Disponible' : 'Non disponible' }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-600">Aucun service récent</p>
                                @endif
                            </div>
                        </div>

                        <!-- Recent Purchases -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Achats Récents</h2>
                                @if($recentPurchases->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($recentPurchases as $purchase)
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">{{ $purchase->material->name }}</h3>
                                                    <p class="text-sm text-gray-600">{{ $purchase->quantity }} unités - {{ $purchase->total_amount }} DH</p>
                                                </div>
                                                <span class="text-sm text-gray-500">
                                                    {{ $purchase->created_at->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-600">Aucun achat récent</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
 
        <button id="sidebarToggle" class="fixed top-4 left-4 z-40 sm:hidden bg-yellow-400 text-gray-900 p-2 rounded-md shadow-md hover:bg-yellow-300 transition-colors duration-200">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('aside').classList.toggle('-translate-x-full');
        });
    </script>
</x-app-layout> 