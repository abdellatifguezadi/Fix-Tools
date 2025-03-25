<nav class="bg-black shadow-lg fixed w-full z-30 h-16">
    <div class="container mx-auto px-4 h-full">
        <div class="flex justify-between h-full">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="relative">
                        <i class="fas fa-tools text-yellow-400 text-3xl transform -rotate-45"></i>
                        <i class="fas fa-wrench text-yellow-400 text-xl absolute -top-1 right-0 transform rotate-45"></i>
                    </div>
                    <div class="logo-text text-yellow-400 text-3xl">
                        FIX<span class="text-white">&</span>TOOLS
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex sm:items-center">
                <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300 px-3 py-2 rounded-md text-sm font-medium">
                    Accueil
                </a>
                <a href="{{ route('services.index') }}" class="text-yellow-400 hover:text-yellow-300 px-3 py-2 rounded-md text-sm font-medium">
                    Services
                </a>
                <a href="{{ route('professionals.index') }}" class="text-yellow-400 hover:text-yellow-300 px-3 py-2 rounded-md text-sm font-medium">
                    Professionnels
                </a>

                @auth
                    <!-- Menu utilisateur connecté -->
                    <a href="{{ route('messages.index') }}" class="text-yellow-400 hover:text-yellow-300 px-3 py-2 rounded-md text-sm font-medium">
                        Messages
                    </a>
                    <div class="ml-3 relative">
                        <a href="{{ route('profile.edit') }}" class="text-yellow-400 hover:text-yellow-300 px-3 py-2 rounded-md text-sm font-medium">
                            {{ auth()->user()->name }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline-block">
                            @csrf
                            <button type="submit" class="text-yellow-400 hover:text-yellow-300 px-3 py-2 rounded-md text-sm font-medium">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Boutons visiteur -->
                    <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 px-3 py-2 rounded-md text-sm font-medium">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="bg-yellow-400 text-black px-4 py-2 rounded-md text-sm font-medium hover:bg-yellow-300 ml-3">
                        Inscription
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button type="button" class="text-yellow-400 hover:text-yellow-300" @click="mobileMenu = !mobileMenu">
                    Menu
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenu" class="sm:hidden bg-black">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300 block px-3 py-2 text-base font-medium">
                Accueil
            </a>
            <a href="{{ route('services.index') }}" class="text-yellow-400 hover:text-yellow-300 block px-3 py-2 text-base font-medium">
                Services
            </a>
            <a href="{{ route('professionals.index') }}" class="text-yellow-400 hover:text-yellow-300 block px-3 py-2 text-base font-medium">
                Professionnels
            </a>

            @auth
                <a href="{{ route('messages.index') }}" class="text-yellow-400 hover:text-yellow-300 block px-3 py-2 text-base font-medium">
                    Messages
                </a>
                <a href="{{ route('profile.edit') }}" class="text-yellow-400 hover:text-yellow-300 block px-3 py-2 text-base font-medium">
                    Mon Profil
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left text-yellow-400 hover:text-yellow-300 px-3 py-2 text-base font-medium">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 block px-3 py-2 text-base font-medium">
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="text-yellow-400 hover:text-yellow-300 block px-3 py-2 text-base font-medium">
                    Inscription
                </a>
            @endauth
        </div>
    </div>
</nav> 