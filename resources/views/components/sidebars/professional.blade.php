<div class="fixed left-0 top-0 w-64 h-full bg-black shadow-lg pt-16 overflow-hidden flex flex-col">
    <div class="px-4 pt-4 overflow-y-auto flex-1">
        <!-- Close sidebar button (mobile only) -->
        <button id="closeSidebar" class="sm:hidden absolute top-4 right-4 text-gray-400 hover:text-white">
            <i class="fas fa-times"></i>
        </button>
        <div class="mb-8">
            <h2 class="text-yellow-400 text-lg font-semibold mb-4">Espace Professionnel</h2>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('services.my-services') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-tools w-6"></i>
                        <span>Mes Services</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('material-purchases.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-shopping-cart w-6"></i>
                        <span>Achats Matériaux</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('messages.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-envelope w-6"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('service-tracking.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-tasks w-6"></i>
                        <span>Service Tracking</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-user-circle w-6"></i>
                        <span>Mon Profil</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div> 