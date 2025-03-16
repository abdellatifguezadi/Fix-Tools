<nav class="bg-black py-4">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="flex items-center space-x-2">
            <div class="relative">
                <i class="fas fa-tools text-yellow-400 text-3xl transform -rotate-45"></i>
                <i class="fas fa-wrench text-yellow-400 text-xl absolute -top-1 right-0 transform rotate-45"></i>
            </div>
            <div class="logo-text text-yellow-400 text-3xl">
                FIX<span class="text-white">&</span>TOOLS
            </div>
        </a>
        
        @guest
            <div class="hidden md:flex items-center">
                <div class="space-x-6 mr-8">
                    <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300">Accueil</a>
                    <a href="{{ route('services.index') }}" class="text-yellow-400 hover:text-yellow-300">Services</a>
                    <a href="{{ route('professionals.index') }}" class="text-yellow-400 hover:text-yellow-300">Professionnels</a>
                    <a href="{{ route('contact') }}" class="text-yellow-400 hover:text-yellow-300">Contact</a>
                </div>
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 px-4 py-2 border border-yellow-400 rounded-lg">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-300">Inscription</a>
                </div>
            </div>
        @else
            <div class="flex items-center space-x-3">
                <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                    alt="{{ auth()->user()->name }}"
                    class="w-8 h-8 rounded-full object-cover">
                <span class="text-yellow-400">{{ auth()->user()->name }}</span>
            </div>
        @endguest
    </div>
</nav> 