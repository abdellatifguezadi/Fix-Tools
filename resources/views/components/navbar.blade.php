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
        <div class="hidden md:flex items-center">
            @auth
                <div class="space-x-6 mr-8">
                    <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300">Home</a>
                    
                    @if(auth()->user()->role === 'client')
                        <a href="{{ route('client.services.index') }}" class="text-yellow-400 hover:text-yellow-300">Services</a>
                        <a href="{{ route('client.professionals.index') }}" class="text-yellow-400 hover:text-yellow-300">Professionals</a>
                    @endif
                    
                    @if(auth()->user()->role === 'professional')
                        <a href="{{ route('services.my-services') }}" class="text-yellow-400 hover:text-yellow-300">Mes Services</a>
                    @endif
                    
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-yellow-400 hover:text-yellow-300">Dashboard</a>
                    @endif
                    
                    <a href="{{ route('contact') }}" class="text-yellow-400 hover:text-yellow-300">Contact</a>
                </div>
                <div class="space-x-4">
                    <span class="text-yellow-400">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-yellow-400 hover:text-yellow-300">Déconnexion</button>
                    </form>
                </div>
            @else
                <div class="space-x-6 mr-8">
                    <a href="{{ route('home') }}" class="text-yellow-400 hover:text-yellow-300">Home</a>
                    <a href="{{ route('contact') }}" class="text-yellow-400 hover:text-yellow-300">Contact</a>
                </div>
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 px-4 py-2 border border-yellow-400 rounded-lg">Login</a>
                    <a href="{{ route('register') }}" class="bg-yellow-400 text-black px-4 py-2 rounded-lg hover:bg-yellow-300">Register</a>
                </div>
            @endauth
        </div>
    </div>
</nav> 