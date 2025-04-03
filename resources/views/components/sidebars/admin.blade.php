<div class="fixed left-0 top-0 w-64 h-full bg-black shadow-lg pt-20">
    <div class="px-4">
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
                        <span>User Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-list w-6"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('materials.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-box-open w-6"></i>
                        <span>Matériaux</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.services.index') }}" class="flex items-center text-gray-300 hover:text-yellow-400 py-2">
                        <i class="fas fa-tools w-6"></i>
                        <span>Services</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div> 