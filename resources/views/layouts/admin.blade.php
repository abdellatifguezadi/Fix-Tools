<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Fix & Tools') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-10 w-64 bg-black transition-transform duration-300 ease-in-out transform md:translate-x-0" 
            id="sidebar" x-data="{ sidebarOpen: false }">
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-800">
                <div class="flex items-center">
                    <div class="relative mr-2">
                        <i class="fas fa-tools text-yellow-400 text-3xl transform -rotate-45"></i>
                        <i class="fas fa-wrench text-yellow-400 text-xl absolute -top-1 right-0 transform rotate-45"></i>
                    </div>
                    <div class="text-yellow-400 text-xl font-bold">
                        FIX<span class="text-white">&</span>TOOLS
                    </div>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-400 hover:text-white focus:outline-none focus:text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="pt-5 px-2 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                    class="group flex items-center px-4 py-3 text-base font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 text-yellow-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fas fa-chart-line mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-yellow-400' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.users.index') }}" 
                    class="group flex items-center px-4 py-3 text-base font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-gray-900 text-yellow-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fas fa-users mr-3 {{ request()->routeIs('admin.users.*') ? 'text-yellow-400' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                    Users
                </a>

                <a href="{{ route('admin.services.index') }}" 
                    class="group flex items-center px-4 py-3 text-base font-medium rounded-md {{ request()->routeIs('admin.services.*') ? 'bg-gray-900 text-yellow-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fas fa-tools mr-3 {{ request()->routeIs('admin.services.*') ? 'text-yellow-400' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                    Services
                </a>

                <a href="{{ route('admin.reviews.index') }}" 
                    class="group flex items-center px-4 py-3 text-base font-medium rounded-md {{ request()->routeIs('admin.reviews.*') ? 'bg-gray-900 text-yellow-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fas fa-star mr-3 {{ request()->routeIs('admin.reviews.*') ? 'text-yellow-400' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                    Reviews
                </a>

                <a href="{{ route('categories.index') }}" 
                    class="group flex items-center px-4 py-3 text-base font-medium rounded-md {{ request()->routeIs('categories.*') ? 'bg-gray-900 text-yellow-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fas fa-tags mr-3 {{ request()->routeIs('categories.*') ? 'text-yellow-400' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                    Categories
                </a>

                <a href="{{ route('materials.index') }}" 
                    class="group flex items-center px-4 py-3 text-base font-medium rounded-md {{ request()->routeIs('materials.*') ? 'bg-gray-900 text-yellow-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fas fa-boxes mr-3 {{ request()->routeIs('materials.*') ? 'text-yellow-400' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                    Materials
                </a>
            </nav>

            <!-- User Profile/Logout -->
            <div class="absolute bottom-0 w-full px-4 pb-5">
                <div class="border-t border-gray-700 pt-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full bg-gray-400" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="{{ auth()->user()->name }}">
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-white">{{ auth()->user()->name }}</div>
                            <div class="text-sm font-medium text-gray-400">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2 text-gray-300 transition duration-150 ease-in-out hover:bg-gray-700 hover:text-white rounded-md">
                                <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Page Content -->
        <div class="md:pl-64 flex flex-col flex-1 min-h-screen">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex justify-between items-center px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center md:hidden">
                        <button @click="sidebarOpen = !sidebarOpen" type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-yellow-500">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex-1 flex justify-center md:justify-end">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input class="form-input w-full rounded-md pl-10 pr-4 py-2 border-gray-300 focus:border-yellow-500 focus:ring focus:ring-yellow-500 focus:ring-opacity-50 md:w-56" type="text" placeholder="Search...">
                        </div>
                    </div>
                    
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Notification Dropdown -->
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    <span class="sr-only">View notifications</span>
                                    <i class="fas fa-bell"></i>
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center h-4 w-4 rounded-full bg-yellow-500 text-white text-xs">3</span>
                                </button>
                            </div>
                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" 
                                x-transition:enter="transition ease-out duration-100" 
                                x-transition:enter-start="transform opacity-0 scale-95" 
                                x-transition:enter-end="transform opacity-100 scale-100" 
                                x-transition:leave="transition ease-in duration-75" 
                                x-transition:leave-start="transform opacity-100 scale-100" 
                                x-transition:leave-end="transform opacity-0 scale-95"
                                style="display: none;">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <span class="text-sm font-semibold text-gray-900">Notifications</span>
                                </div>
                                <!-- Example notifications -->
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-user text-blue-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">New user registration</div>
                                            <div class="text-sm text-gray-500">5 minutes ago</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-star text-yellow-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">New review submitted</div>
                                            <div class="text-sm text-gray-500">1 hour ago</div>
                                        </div>
                                    </div>
                                </a>
                                <div class="px-4 py-3 text-center text-sm border-t border-gray-100">
                                    <a href="#" class="text-blue-600 hover:text-blue-800">View all notifications</a>
                                </div>
                            </div>
                        </div>
                        <!-- Profile Dropdown -->
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" class="max-w-xs bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500" id="user-menu-button">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" alt="{{ auth()->user()->name }}">
                                </button>
                            </div>
                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" 
                                x-transition:enter="transition ease-out duration-100" 
                                x-transition:enter-start="transform opacity-0 scale-95" 
                                x-transition:enter-end="transform opacity-100 scale-100" 
                                x-transition:leave="transition ease-in duration-75" 
                                x-transition:leave-start="transform opacity-100 scale-100" 
                                x-transition:leave-end="transform opacity-0 scale-95"
                                style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page content -->
            <main class="flex-1">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <p class="text-center text-sm text-gray-500">
                        &copy; {{ date('Y') }} Fix&Tools. All rights reserved.
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Alpine.js for interaction -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    
    <!-- Additional scripts -->
    @stack('scripts')
</body>
</html> 