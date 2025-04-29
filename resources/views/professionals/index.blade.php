<x-app-layout>

    <div class="bg-gray-50 h-screen flex overflow-hidden">

        <div class="w-full flex-1 flex flex-col transition-all duration-200 ease-in-out">

            <div class="h-16"></div>

            <div class="flex-1 overflow-auto">
                <div class="container mx-auto py-6 px-4">
                                                                                        <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900">Hello, {{ $user->name }}</h1>
                        <p class="mt-2 text-gray-600">Here's an overview of your activity</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl group">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-gray-700 transition duration-300 group-hover:text-yellow-500">Services Offered</h2>
                                    <p class="text-3xl font-bold text-gray-900 transition duration-300 group-hover:text-yellow-500">{{ $servicesCount }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl group">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-gray-700 transition duration-300 group-hover:text-yellow-500">Materials Purchased</h2>
                                    <p class="text-3xl font-bold text-gray-900 transition duration-300 group-hover:text-yellow-500">{{ $materialPurchasesCount }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl group">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-lg font-semibold text-gray-700 transition duration-300 group-hover:text-yellow-500">Total Purchases</h2>
                                    <p class="text-3xl font-bold text-gray-900 transition duration-300 group-hover:text-yellow-500">{{ number_format($totalPurchasesAmount, 2) }} DH</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 transition duration-300 hover:shadow-lg">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Services</h2>
                                @if($recentServices->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($recentServices as $service)
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg transition duration-300 transform hover:scale-102 hover:shadow-md group">
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 transition duration-300 group-hover:text-yellow-500">{{ $service->title }}</h3>
                                                    <p class="text-sm text-gray-600">{{ $service->base_price }} DH</p>
                                                </div>
                                                <span class="px-3 py-1 text-sm rounded-full {{ $service->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $service->is_available ? 'Available' : 'Not Available' }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-600">No recent services</p>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 transition duration-300 hover:shadow-lg">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Purchases</h2>
                                @if($recentPurchases->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($recentPurchases as $purchase)
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg transition duration-300 transform hover:scale-102 hover:shadow-md group">
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 transition duration-300 group-hover:text-yellow-500">
                                                        {{ $purchase->material ? $purchase->material->name : 'Material not available' }}
                                                    </h3>
                                                    <p class="text-sm text-gray-600">{{ $purchase->quantity }} units - {{ $purchase->total_amount }} DH</p>
                                                </div>
                                                <span class="text-sm text-gray-500">
                                                    {{ $purchase->created_at->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-600">No recent purchases</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout> 