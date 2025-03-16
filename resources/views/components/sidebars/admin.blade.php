<nav class="fixed left-0 top-0 h-full w-64 bg-black text-white pt-20 px-4 overflow-y-auto">
    <div class="space-y-4">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black {{ request()->routeIs('dashboard') ? 'bg-yellow-400 text-black' : '' }}">
            <i class="fas fa-home mr-2"></i>
            Tableau de bord
        </a>

        <!-- Utilisateurs -->
        <div>
            <p class="text-gray-400 text-xs uppercase font-bold mb-2">Utilisateurs</p>
            <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black">
                <i class="fas fa-users mr-2"></i>
                Gérer les utilisateurs
            </a>
        </div>

        <!-- Catégories -->
        <div>
            <p class="text-gray-400 text-xs uppercase font-bold mb-2">Catégories</p>
            <a href="{{ route('categories.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black {{ request()->routeIs('categories.*') ? 'bg-yellow-400 text-black' : '' }}">
                <i class="fas fa-tags mr-2"></i>
                Gérer les catégories
            </a>
        </div>

        <!-- Services -->
        <div>
            <p class="text-gray-400 text-xs uppercase font-bold mb-2">Services</p>
            <a href="{{ route('services.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black {{ request()->routeIs('services.*') ? 'bg-yellow-400 text-black' : '' }}">
                <i class="fas fa-tools mr-2"></i>
                Gérer les services
            </a>
        </div>

        <!-- Matériaux -->
        <div>
            <p class="text-gray-400 text-xs uppercase font-bold mb-2">Matériaux</p>
            <a href="{{ route('materials.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black {{ request()->routeIs('materials.*') ? 'bg-yellow-400 text-black' : '' }}">
                <i class="fas fa-box mr-2"></i>
                Gérer les matériaux
            </a>
        </div>

        <!-- Avis -->
        <div>
            <p class="text-gray-400 text-xs uppercase font-bold mb-2">Avis</p>
            <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black">
                <i class="fas fa-star mr-2"></i>
                Gérer les avis
            </a>
        </div>

        <!-- Profil -->
        <div class="pt-4 border-t border-gray-700">
            <a href="{{ route('profile.edit') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black {{ request()->routeIs('profile.*') ? 'bg-yellow-400 text-black' : '' }}">
                <i class="fas fa-user-circle mr-2"></i>
                Mon Profil
            </a>
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit" class="w-full text-left py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
</nav> 