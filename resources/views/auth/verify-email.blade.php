<x-app-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 py-12">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-yellow-400 px-6 py-4">
                <h2 class="text-xl font-bold text-gray-900">Email Verification</h2>
            </div>
            
            <div class="p-6">
                <!-- @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif -->
                
                <div class="mb-6">
                    <p class="text-gray-700 mb-4">
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just sent you? If you didn't receive the email, we'd be happy to send you another one.
                    </p>
                    
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-600 text-sm">
                            Please check your inbox or spam folder.
                        </p>
                    </div>
                </div>
                
                <div class="flex flex-col space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full bg-yellow-400 text-gray-900 px-4 py-3 rounded-lg font-semibold hover:bg-yellow-500 transition duration-200">
                            Resend Verification Email
                        </button>
                    </form>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-gray-200 text-gray-800 px-4 py-3 rounded-lg font-semibold hover:bg-gray-300 transition duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 