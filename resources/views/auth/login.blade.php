<x-app-layout>
    <x-slot name="title">
        Connexion
    </x-slot>

    <!-- Login Form -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-black opacity-50 z-10"></div>
            <img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4" alt="Tools Background" 
                class="w-full h-full object-cover opacity-70">
        </div>
        
        <!-- Form Container -->
        <div class="max-w-md w-full space-y-8 bg-white/90 backdrop-blur-sm p-8 rounded-lg shadow-xl relative z-20">
            <div>
                <h2 class="mt-6 text-center text-3xl font-bold text-gray-900">Connectez-vous à votre compte</h2>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required 
                            class="mt-1 appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <input id="password" name="password" type="password" required 
                            class="mt-1 appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                            class="h-4 w-4 text-yellow-400 focus:ring-yellow-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-900">Se souvenir de moi</label>
                    </div>
                    <a href="#" class="text-sm text-yellow-600 hover:text-yellow-500">Mot de passe oublié ?</a>
                </div>

                @if ($errors->any())
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Il y a eu des erreurs avec votre soumission
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <button type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-black bg-yellow-400 hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    Se connecter
                </button>

                <div class="text-center">
                    <a href="{{ route('register') }}" class="text-sm text-yellow-600 hover:text-yellow-500">
                        Vous n'avez pas de compte ? Inscrivez-vous
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 