<x-app-layout>
    <x-slot name="title">
        Tableau de bord Admin
    </x-slot>

    <div class="p-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">Total Utilisateurs</p>
                        <p class="text-2xl font-bold">2,543</p>
                    </div>
                    <div class="text-blue-500">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
                <p class="text-green-500 text-sm mt-2">
                    <i class="fas fa-arrow-up"></i> +12% ce mois
                </p>
            </div>

            <!-- Active Professionals -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">Professionnels Actifs</p>
                        <p class="text-2xl font-bold">847</p>
                    </div>
                    <div class="text-yellow-500">
                        <i class="fas fa-hard-hat text-2xl"></i>
                    </div>
                </div>
                <p class="text-green-500 text-sm mt-2">
                    <i class="fas fa-arrow-up"></i> +5% ce mois
                </p>
            </div>

            <!-- Completed Services -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">Services Complétés</p>
                        <p class="text-2xl font-bold">1,234</p>
                    </div>
                    <div class="text-green-500">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                </div>
                <p class="text-green-500 text-sm mt-2">
                    <i class="fas fa-arrow-up"></i> +8% ce mois
                </p>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">Revenu Total</p>
                        <p class="text-2xl font-bold">45,678€</p>
                    </div>
                    <div class="text-purple-500">
                        <i class="fas fa-euro-sign text-2xl"></i>
                    </div>
                </div>
                <p class="text-green-500 text-sm mt-2">
                    <i class="fas fa-arrow-up"></i> +15% ce mois
                </p>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Services -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-semibold">Services Récents</h2>
                </div>
                <div class="p-4 space-y-4">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-wrench text-blue-500"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold">Réparation Plomberie</p>
                            <p class="text-sm text-gray-600">John Smith - Terminé</p>
                        </div>
                        <span class="ml-auto text-sm text-gray-500">Il y a 2h</span>
                    </div>

                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <i class="fas fa-paint-roller text-yellow-500"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold">Peinture Maison</p>
                            <p class="text-sm text-gray-600">Sarah Johnson - En cours</p>
                        </div>
                        <span class="ml-auto text-sm text-gray-500">Il y a 4h</span>
                    </div>

                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-bolt text-green-500"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold">Installation Électrique</p>
                            <p class="text-sm text-gray-600">Mike Brown - Terminé</p>
                        </div>
                        <span class="ml-auto text-sm text-gray-500">Il y a 6h</span>
                    </div>
                </div>
            </div>

            <!-- New Users -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-semibold">Nouveaux Utilisateurs</h2>
                </div>
                <div class="p-4 space-y-4">
                    <div class="flex items-center">
                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde" 
                             alt="Alex Johnson" 
                             class="w-10 h-10 rounded-full">
                        <div class="ml-4">
                            <p class="font-semibold">Alex Johnson</p>
                            <p class="text-sm text-gray-600">Client</p>
                        </div>
                        <span class="ml-auto text-sm text-gray-500">Il y a 2 mins</span>
                    </div>

                    <div class="flex items-center">
                        <img src="https://images.unsplash.com/photo-1540569014015-19a7be504e3a" 
                             alt="Mike Brown" 
                             class="w-10 h-10 rounded-full">
                        <div class="ml-4">
                            <p class="font-semibold">Mike Brown</p>
                            <p class="text-sm text-gray-600">Professionnel</p>
                        </div>
                        <span class="ml-auto text-sm text-gray-500">Il y a 5 mins</span>
                    </div>

                    <div class="flex items-center">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330" 
                             alt="Sophie Martin" 
                             class="w-10 h-10 rounded-full">
                        <div class="ml-4">
                            <p class="font-semibold">Sophie Martin</p>
                            <p class="text-sm text-gray-600">Client</p>
                        </div>
                        <span class="ml-auto text-sm text-gray-500">Il y a 10 mins</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 