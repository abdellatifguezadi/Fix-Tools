<x-app-layout>

    <div class="bg-gray-50 h-screen flex overflow-hidden">

        <aside class="fixed inset-y-0 left-0 w-64 bg-gray-900 z-20 transform -translate-x-full sm:translate-x-0 transition-transform duration-200 ease-in-out">
            <x-sidebars.professional />
        </aside>

        <div class="w-full flex-1 flex flex-col transition-all duration-200 ease-in-out">

            <div class="h-16"></div>

            <div class="flex-1 overflow-auto">
                <div class="container mx-auto py-6 px-4">
                    <div class="max-w-4xl mx-auto">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <!-- Profile Header -->
                            <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 px-6 py-8">
                                <div class="flex items-center">
                                    <div class="w-24 h-24 rounded-full bg-white overflow-hidden ring-4 ring-white shadow-lg">
                                        @if($user->profile_photo_path)
                                            <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Profile" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                <span class="text-4xl text-yellow-500 font-bold">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-6">
                                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                        <p class="text-gray-800">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Content -->
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Personal Information -->
                                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                                        <h2 class="text-lg font-semibold mb-4 text-gray-800">Informations Personnelles</h2>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="text-sm text-gray-600">Nom Complet</label>
                                                <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm text-gray-600">Email</label>
                                                <p class="font-medium text-gray-800">{{ $user->email }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm text-gray-600">Téléphone</label>
                                                <p class="font-medium text-gray-800">{{ $user->phone ?? 'Non spécifié' }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm text-gray-600">Statut</label>
                                                <p class="font-medium">
                                                    <span class="px-3 py-1 rounded-full text-sm {{ $user->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $user->is_available ? 'Disponible' : 'Non disponible' }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Professional Information -->
                                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                                        <h2 class="text-lg font-semibold mb-4 text-gray-800">Informations Professionnelles</h2>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="text-sm text-gray-600">Spécialité</label>
                                                <p class="font-medium text-gray-800">{{ $user->specialty ?? 'Non spécifié' }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm text-gray-600">Expérience</label>
                                                <p class="font-medium text-gray-800">{{ $user->experience ?? 'Non spécifié' }}</p>
                                            </div>
                                            <div>
                                                <label class="text-sm text-gray-600">Tarif Horaire</label>
                                                <p class="font-medium text-gray-800">{{ $user->hourly_rate ?? 'Non spécifié' }} DH</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-8 flex space-x-4">
                                    <a href="{{ route('services.my-services') }}" class="inline-flex items-center px-6 py-3 bg-yellow-400 text-gray-900 rounded-lg hover:bg-yellow-300 transition-colors duration-200 shadow-md hover:shadow-lg font-bold">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        Mes Services
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors duration-200 shadow-md hover:shadow-lg font-bold">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Modifier le Profil
                                    </a>
                                </div>
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