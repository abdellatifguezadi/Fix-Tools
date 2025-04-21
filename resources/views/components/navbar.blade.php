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
        <div class="hidden md:flex items-center space-x-8">
            @auth
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">Home</a>
                    
                    @if(auth()->user()->role === 'client')
                        <a href="{{ route('client.services.index') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">Services</a>
                        <a href="{{ route('client.professionals.index') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">Professionals</a>
                    @endif
                    
                    @if(auth()->user()->role === 'professional')
                        <a href="{{ route('services.my-services') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">My Services</a>
                        <a href="{{ route('material-purchases.index') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">Marketplace</a>
                        
                        <a href="{{ route('cart.index') }}" class="text-yellow-400 hover:text-yellow-300 flex items-center whitespace-nowrap">
                            <i class="fas fa-shopping-cart mr-1"></i> Cart
                            @if(isset($cartItemsCount) && $cartItemsCount > 0)
                                <span class="ml-1 bg-yellow-400 text-black text-xs px-1.5 py-0.5 rounded-full">{{ $cartItemsCount }}</span>
                            @endif
                        </a>
                    @endif
                    
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">Dashboard</a>
                    @endif
                    
                    <a href="{{ route('contact') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">Contact</a>
                </div>
                <div class="flex items-center space-x-4 ml-4">
                    <span class="text-yellow-400 whitespace-nowrap">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">Logout</button>
                    </form>
                </div>
            @else
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">Home</a>
                    <a href="{{ route('contact') }}" class="text-yellow-400 hover:text-yellow-300 whitespace-nowrap">Contact</a>
                </div>
                <div class="flex items-center space-x-4 ml-4">
                    <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 px-4 py-2 border border-yellow-400 rounded-lg whitespace-nowrap">Login</a>
                    <a href="{{ route('register') }}" class="bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-300 whitespace-nowrap">Register</a>
                </div>
            @endauth
        </div>
    </div>
</nav> 