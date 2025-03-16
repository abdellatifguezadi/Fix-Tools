<x-app-layout>
    <x-slot name="title">
        Contact
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl font-bold text-center mb-8">Contactez-nous</h1>
            
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Informations de contact -->
                        <div>
                            <h2 class="text-2xl font-bold mb-4">Nos coordonnées</h2>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-yellow-400 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-semibold">Adresse</p>
                                        <p class="text-gray-600">123 Rue Example<br>75000 Paris, France</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-phone text-yellow-400 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-semibold">Téléphone</p>
                                        <p class="text-gray-600">+33 1 23 45 67 89</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-envelope text-yellow-400 mt-1 mr-3"></i>
                                    <div>
                                        <p class="font-semibold">Email</p>
                                        <p class="text-gray-600">contact@fixandtools.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Horaires -->
                        <div>
                            <h2 class="text-2xl font-bold mb-4">Horaires d'ouverture</h2>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="font-semibold">Lundi - Vendredi</span>
                                    <span class="text-gray-600">9h00 - 18h00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-semibold">Samedi</span>
                                    <span class="text-gray-600">9h00 - 12h00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-semibold">Dimanche</span>
                                    <span class="text-gray-600">Fermé</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire de contact -->
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Sujet</label>
                            <input type="text" name="subject" id="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea name="message" id="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required></textarea>
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-yellow-400 text-black px-6 py-3 rounded-lg font-bold hover:bg-yellow-300 transition duration-200">
                                Envoyer le message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 