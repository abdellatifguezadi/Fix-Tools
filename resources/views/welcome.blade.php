<x-app-layout>
    <x-slot name="title">
        Accueil
    </x-slot>

    <!-- Hero Section -->
    <header class="bg-black text-white py-20 relative">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1581244277943-fe4a9c777189" alt="Tools and Equipment" class="w-full h-full object-cover opacity-40">
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Vos Projets, <span class="text-yellow-400">Nos Solutions</span>
            </h1>
            <p class="text-xl mb-8">
                Trouvez des professionnels qualifiés pour tous vos travaux de maintenance, installation et réparation
            </p>
            <button class="bg-yellow-400 text-black px-8 py-3 rounded-lg font-bold hover:bg-yellow-300 inline-block">
                Trouver un Professionnel
            </button>
        </div>
    </header>

    <!-- Services Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Nos Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service Card 1 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1607472586893-edb57bdc0e39" 
                         alt="Plomberie" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Plomberie</h3>
                        <p class="text-gray-600">Installation, réparation et maintenance de vos systèmes de plomberie</p>
                    </div>
                </div>

                <!-- Service Card 2 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1621905251918-48416bd8575a" 
                         alt="Électricité" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Électricité</h3>
                        <p class="text-gray-600">Installations et réparations électriques pour votre sécurité</p>
                    </div>
                </div>

                <!-- Service Card 3 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f" 
                         alt="Peinture" 
                         class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Peinture</h3>
                        <p class="text-gray-600">Travaux de peinture intérieure et extérieure</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="py-16 bg-black text-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-yellow-400">À Propos de Nous</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h3 class="text-2xl font-bold text-yellow-400">Votre Partenaire de Confiance</h3>
                    <p class="text-gray-300">Fix and Tools connecte les propriétaires avec des professionnels qualifiés pour tous leurs besoins de maintenance et de réparation.</p>
                    <ul class="space-y-4">
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-yellow-400 mr-2"></i>
                            Réseau de Professionnels Vérifiés
                        </li>
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-yellow-400 mr-2"></i>
                            Service de Qualité Garanti
                        </li>
                        <li class="flex items-center text-gray-300">
                            <i class="fas fa-check text-yellow-400 mr-2"></i>
                            Support Client 24/7
                        </li>
                    </ul>
                </div>
                <div class="relative h-96">
                    <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e" 
                        alt="Professional at work" 
                        class="w-full h-full object-cover rounded-lg shadow-xl">
                    <div class="absolute inset-0 bg-black opacity-40 rounded-lg"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Professionals Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Professionnels les Mieux Notés</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Professional Card 1 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1540569014015-19a7be504e3a" 
                             alt="John Smith" 
                             class="w-16 h-16 rounded-full">
                        <div class="ml-4">
                            <h3 class="text-xl font-bold">John Smith</h3>
                            <p class="text-gray-600">Maître Plombier</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-600"><i class="fas fa-tools text-yellow-400 mr-2"></i>15+ ans d'expérience</p>
                        <p class="text-gray-600"><i class="fas fa-briefcase text-yellow-400 mr-2"></i>250+ projets</p>
                        <p class="text-gray-600"><i class="fas fa-star text-yellow-400 mr-2"></i>4.9/5 (120 avis)</p>
                    </div>
                </div>

                <!-- Professional Card 2 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1516822669470-95f059f5a051" 
                             alt="Sarah Johnson" 
                             class="w-16 h-16 rounded-full">
                        <div class="ml-4">
                            <h3 class="text-xl font-bold">Sarah Johnson</h3>
                            <p class="text-gray-600">Expert Peintre</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-600"><i class="fas fa-tools text-yellow-400 mr-2"></i>10+ ans d'expérience</p>
                        <p class="text-gray-600"><i class="fas fa-briefcase text-yellow-400 mr-2"></i>180+ projets</p>
                        <p class="text-gray-600"><i class="fas fa-star text-yellow-400 mr-2"></i>4.8/5 (95 avis)</p>
                    </div>
                </div>

                <!-- Professional Card 3 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4" 
                             alt="Mike Brown" 
                             class="w-16 h-16 rounded-full">
                        <div class="ml-4">
                            <h3 class="text-xl font-bold">Mike Brown</h3>
                            <p class="text-gray-600">Spécialiste Bricolage</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-600"><i class="fas fa-tools text-yellow-400 mr-2"></i>12+ ans d'expérience</p>
                        <p class="text-gray-600"><i class="fas fa-briefcase text-yellow-400 mr-2"></i>200+ projets</p>
                        <p class="text-gray-600"><i class="fas fa-star text-yellow-400 mr-2"></i>4.9/5 (150 avis)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-black py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Prêt à Commencer ?</h2>
            <p class="text-yellow-400 text-xl mb-8">Rejoignez notre communauté de professionnels et de clients satisfaits</p>
            <div class="space-x-4">
                <button class="bg-yellow-400 text-black px-8 py-3 rounded-lg font-bold hover:bg-yellow-300 inline-block">
                    Je suis un Client
                </button>
                <button class="border-2 border-yellow-400 text-yellow-400 px-8 py-3 rounded-lg font-bold hover:bg-yellow-400 hover:text-black inline-block">
                    Je suis un Professionnel
                </button>
            </div>
        </div>
    </section>
</x-app-layout>
