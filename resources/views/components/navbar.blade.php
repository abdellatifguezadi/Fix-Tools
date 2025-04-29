<nav class="bg-black py-4">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center">
        @auth
                @if(auth()->user()->isProfessional())
                    <button id="toggleSidebar" class="mr-2 md:block lg:hidden bg-yellow-400 text-black p-2 rounded-lg shadow-lg">
                        <i class="fas fa-bars"></i>
                    </button>
                @elseif(auth()->user()->isAdmin())
                    <button id="toggleAdminSidebar" class="mr-2 md:block lg:hidden bg-yellow-400 text-black p-2 rounded-lg shadow-lg">
                        <i class="fas fa-bars"></i>
                    </button>
                @endif
            @endauth
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
        

        <button id="mobileMenuBtn" class="block md:hidden text-yellow-400 hover:text-yellow-300">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <div class="hidden md:flex items-center md:space-x-4 lg:space-x-8">
            @auth
                <div class="flex items-center md:space-x-4 lg:space-x-8">
                    @if(auth()->user()->role === 'client')
                        <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap text-base md:text-sm lg:text-base">Home</a>
                        <a href="{{ route('client.services.index') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap text-base md:text-sm lg:text-base">Services</a>
                        <a href="{{ route('client.professionals.index') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap text-base md:text-sm lg:text-base">Professionals</a>
                        <a href="{{ route('messages.index') }}" class="text-yellow-400 hover:text-yellow-300 flex items-center whitespace-nowrap text-base md:text-sm lg:text-base">
                            <i class="fas fa-envelope mr-1"></i> Messages
                            @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                                <span class="ml-1 bg-yellow-400 text-black text-xs px-1.5 py-0.5 rounded-full">{{ $unreadMessagesCount }}</span>
                            @endif
                        </a>
                    @endif
                    
                    @if(auth()->user()->role === 'professional')
                        <a href="{{ route('cart.index') }}" class="text-yellow-400 hover:text-yellow-300 flex items-center whitespace-nowrap">
                            <i class="fas fa-shopping-cart mr-1"></i> Cart
                            @if(isset($cartItemsCount) && $cartItemsCount > 0)
                                <span class="ml-1 bg-yellow-400 text-black text-xs px-1.5 py-0.5 rounded-full">{{ $cartItemsCount }}</span>
                            @endif
                        </a>
                    @endif
                    
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">Home</a>
                    @endif
                </div>
                
                <div class="relative ml-4" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-yellow-400 hover:text-yellow-300 whitespace-nowrap focus:outline-none">
                        <i class="fas fa-user-circle mr-2 text-xl"></i>
                        <span>{{ auth()->user()->name }}</span>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-black border border-gray-700 rounded-md shadow-lg py-1 z-50 overflow-hidden">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-yellow-400 hover:bg-gray-800">
                            <i class="fas fa-user-edit mr-2"></i> Profile
                        </a>
                        @if(auth()->user()->role !== 'professional' && auth()->user()->role !== 'admin')
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-yellow-400 hover:bg-gray-800">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">Home</a>
                </div>
                <div class="flex items-center space-x-4 ml-4">
                    <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 px-4 py-2 border border-yellow-400 rounded-lg whitespace-nowrap">Login</a>
                    <a href="{{ route('register') }}" class="bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-300 whitespace-nowrap">Register</a>
                </div>
            @endauth
        </div>
    </div>
    
    <div id="mobileMenu" class="hidden md:hidden bg-black border-t border-gray-800 mt-4">
        <div class="container mx-auto px-4 py-2">
            @auth
                @if(auth()->user()->role === 'client')
                    <div class="py-2 flex justify-between items-center border-b border-gray-800">
                        <span class="text-yellow-400">
                            <i class="fas fa-user-circle mr-1"></i> {{ auth()->user()->name }}
                        </span>
                        <a href="{{ route('profile.edit') }}" class="text-yellow-400 hover:text-yellow-300">
                            <i class="fas fa-user-edit"></i> Profile
                        </a>
                    </div>
                    <a href="{{ route('home') }}" class="block py-2 text-yellow-400 hover:text-yellow-300">Home</a>
                    <a href="{{ route('client.services.index') }}" class="block py-2 text-yellow-400 hover:text-yellow-300">Services</a>
                    <a href="{{ route('client.professionals.index') }}" class="block py-2 text-yellow-400 hover:text-yellow-300">Professionals</a>
                    <a href="{{ route('messages.index') }}" class="block py-2 text-yellow-400 hover:text-yellow-300">
                        <i class="fas fa-envelope mr-1"></i> Messages
                        @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                            <span class="ml-1 bg-yellow-400 text-black text-xs px-1.5 py-0.5 rounded-full">{{ $unreadMessagesCount }}</span>
                        @endif
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-800 mt-2 pt-2">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-yellow-400 hover:text-yellow-300">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                @elseif(auth()->user()->role === 'professional')
                    <div class="py-2 flex justify-between items-center border-b border-gray-800">
                        <span class="text-yellow-400">
                            <i class="fas fa-user-circle mr-1"></i> {{ auth()->user()->name }}
                        </span>
                        <a href="{{ route('profile.edit') }}" class="text-yellow-400 hover:text-yellow-300">
                            <i class="fas fa-user-edit"></i> Profile
                        </a>
                    </div>
                    <a href="{{ route('cart.index') }}" class="block py-2 text-yellow-400 hover:text-yellow-300">
                        <i class="fas fa-shopping-cart mr-1"></i> Cart
                        @if(isset($cartItemsCount) && $cartItemsCount > 0)
                            <span class="ml-1 bg-yellow-400 text-black text-xs px-1.5 py-0.5 rounded-full">{{ $cartItemsCount }}</span>
                        @endif
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-800 mt-2 pt-2">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-yellow-400 hover:text-yellow-300">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                @elseif(auth()->user()->role === 'admin')
                    <div class="py-2 flex justify-between items-center border-b border-gray-800">
                        <span class="text-yellow-400">
                            <i class="fas fa-user-circle mr-1"></i> {{ auth()->user()->name }}
                        </span>
                        <a href="{{ route('profile.edit') }}" class="text-yellow-400 hover:text-yellow-300">
                            <i class="fas fa-user-edit"></i> Profile
                        </a>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 text-yellow-400 hover:text-yellow-300">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-800 mt-2 pt-2">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-yellow-400 hover:text-yellow-300">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> 