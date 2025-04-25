<div id="professionalSidebar" class="fixed left-0 top-0 w-64 h-full bg-black shadow-lg overflow-hidden transform transition-transform duration-300 md:translate-x-0 -translate-x-full z-20 flex flex-col">
    <div class="h-16 bg-black"></div>
    <div class="px-4 pt-4 overflow-y-auto flex-1">
        <button id="closeSidebar" class="sm:block md:hidden absolute top-4 right-4 text-gray-400 hover:text-white">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="mb-8">
            <h2 class="text-yellow-400 text-lg font-semibold mb-4">Professional Area</h2>
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
                        <span>My Services</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('material-purchases.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-shopping-cart w-6"></i>
                        <span>Material Purchases</span>
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
                    <a href="{{ route('professional.requests.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-clipboard-list w-6"></i>
                        <span>Service Requests</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-user-circle w-6"></i>
                        <span>My Profile</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Logout Button -->
    <div class="px-4 py-4 border-t border-gray-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center space-x-2 bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-300">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div> 