<div id="adminSidebar" class="fixed left-0 top-0 w-64 h-full bg-black shadow-lg overflow-hidden transform transition-transform duration-300 md:translate-x-0 -translate-x-full z-20 flex flex-col">
    <div class="h-16 bg-black"></div>
    <div class="px-4 pt-4 overflow-y-auto flex-1">
        <button id="closeAdminSidebar" class="sm:block md:hidden absolute top-4 right-4 text-gray-400 hover:text-white">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="mb-8">
            <h2 class="text-yellow-400 text-lg font-semibold mb-4">Administration</h2>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-users w-6"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.services.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-tools w-6"></i>
                        <span>Services</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-tags w-6"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('materials.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-boxes w-6"></i>
                        <span>Materials</span>
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
</div> 