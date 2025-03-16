<nav class="fixed left-0 top-0 h-full w-64 bg-black text-white pt-20 px-4 overflow-y-auto">
    <div class="space-y-4">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black {{ request()->routeIs('dashboard') ? 'bg-yellow-400 text-black' : '' }}">
            <i class="fas fa-home mr-2"></i>
            Tableau de bord
        </a>

        <!-- Services -->
        <div>
            <p class="text-gray-400 text-xs uppercase font-bold mb-2">Services</p>
            <a href="{{ route('services.my-services') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black {{ request()->routeIs('services.*') ? 'bg-yellow-400 text-black' : '' }}">
                <i class="fas fa-tools mr-2"></i>
                Mes Services
            </a>
        </div>

        <!-- Demandes -->
        <div>
            <p class="text-gray-400 text-xs uppercase font-bold mb-2">Demandes</p>
            <a href="{{ route('service-requests.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black {{ request()->routeIs('service-requests.*') ? 'bg-yellow-400 text-black' : '' }}">
                <i class="fas fa-clipboard-list mr-2"></i>
                Demandes de Service
            </a>
        </div>

        <!-- Messages -->
        <div>
            <p class="text-gray-400 text-xs uppercase font-bold mb-2">Communication</p>
            <a href="{{ route('messages.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black {{ request()->routeIs('messages.*') ? 'bg-yellow-400 text-black' : '' }}">
                <i class="fas fa-envelope mr-2"></i>
                Messages
            </a>
        </div>

        <!-- Points de fidélité -->
        <div>
            <p class="text-gray-400 text-xs uppercase font-bold mb-2">Points</p>
            <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-yellow-400 hover:text-black">
                <i class="fas fa-star mr-2"></i>
                Points de fidélité
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