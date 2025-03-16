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
            <a href="{{ route('professionals.index') }}" class="bg-yellow-400 text-black px-8 py-3 rounded-lg font-bold hover:bg-yellow-300 inline-block">
                Trouver un Professionnel
            </a>
        </div>
    </header>

    <!-- Services Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Nos Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <x-service-card 
                    title="Plomberie"
                    description="Installation, réparation et maintenance de vos systèmes de plomberie"
                    image="https://images.unsplash.com/photo-1607472586893-edb57bdc0e39"
                />

                <x-service-card 
                    title="Électricité"
                    description="Installations et réparations électriques pour votre sécurité"
                    image="https://images.unsplash.com/photo-1621905251918-48416bd8575a"
                />

                <x-service-card 
                    title="Peinture"
                    description="Travaux de peinture intérieure et extérieure"
                    image="https://images.unsplash.com/photo-1589939705384-5185137a7f0f"
                />
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
                        <x-feature-item>Réseau de Professionnels Vérifiés</x-feature-item>
                        <x-feature-item>Service de Qualité Garanti</x-feature-item>
                        <x-feature-item>Support Client 24/7</x-feature-item>
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
                <x-professional-card 
                    name="John Smith"
                    title="Maître Plombier"
                    experience="15+ ans"
                    jobs="250+"
                    rating="4.9"
                    image="https://images.unsplash.com/photo-1540569014015-19a7be504e3a"
                />

                <x-professional-card 
                    name="Sarah Johnson"
                    title="Expert Peintre"
                    experience="10+ ans"
                    jobs="180+"
                    rating="4.8"
                    image="https://images.unsplash.com/photo-1516822669470-95f059f5a051"
                />

                <x-professional-card 
                    name="Mike Brown"
                    title="Spécialiste Bricolage"
                    experience="12+ ans"
                    jobs="200+"
                    rating="4.9"
                    image="https://images.unsplash.com/photo-1621905252507-b35492cc74b4"
                />
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-black py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Prêt à Commencer ?</h2>
            <p class="text-yellow-400 text-xl mb-8">Rejoignez notre communauté de professionnels et de clients satisfaits</p>
            <div class="space-x-4">
                <a href="{{ route('register') }}?type=client" class="bg-yellow-400 text-black px-8 py-3 rounded-lg font-bold hover:bg-yellow-300 inline-block">
                    Je suis un Client
                </a>
                <a href="{{ route('register') }}?type=professional" class="border-2 border-yellow-400 text-yellow-400 px-8 py-3 rounded-lg font-bold hover:bg-yellow-400 hover:text-black inline-block">
                    Je suis un Professionnel
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
