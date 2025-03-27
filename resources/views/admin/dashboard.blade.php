<x-app-layout>
    <x-slot name="title">
        Tableau de bord Admin
    </x-slot>

    <div class="min-h-screen flex flex-col">
        <div class="flex-1 p-8 mt-16">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Users</p>
                            <h3 class="text-2xl font-bold">{{ number_format($totalUsers) }}</h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-users text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Professionals -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Active Professionals</p>
                            <h3 class="text-2xl font-bold">{{ number_format($activeProfessionals) }}</h3>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <i class="fas fa-hard-hat text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Services -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Completed Services</p>
                            <h3 class="text-2xl font-bold">{{ number_format($completedServices) }}</h3>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total Revenue</p>
                            <h3 class="text-2xl font-bold">${{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <i class="fas fa-dollar-sign text-purple-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Services Table -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">Services Overview</h3>
                    <div class="overflow-x-auto">
                        @if(count($servicesOverview) > 0)
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Service</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Total</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Active</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($servicesOverview as $service)
                                <tr>
                                    <td class="px-4 py-3">{{ $service['name'] }}</td>
                                    <td class="px-4 py-3">{{ $service['total'] }}</td>
                                    <td class="px-4 py-3 text-{{ $service['active'] >= 70 ? 'green' : ($service['active'] >= 40 ? 'yellow' : 'red') }}-500">
                                        {{ $service['active'] }}%
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-center py-4 text-gray-500">Aucun service disponible</p>
                        @endif
                    </div>
                </div>

                <!-- Revenue Table -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">Monthly Revenue</h3>
                    <div class="overflow-x-auto">
                        @if(count($monthlyRevenue) > 0)
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Month</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Revenue</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Growth</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($monthlyRevenue as $month => $data)
                                <tr>
                                    <td class="px-4 py-3">{{ $month }}</td>
                                    <td class="px-4 py-3">${{ number_format($data['revenue'], 2) }}</td>
                                    <td class="px-4 py-3 text-{{ $data['growth'] >= 0 ? 'green' : 'red' }}-500">
                                        {{ $data['growth'] >= 0 ? '+' : '' }}{{ $data['growth'] }}%
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-center py-4 text-gray-500">Aucun revenu enregistré</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Services -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">Recent Services</h3>
                    <div class="space-y-4">
                        @if(count($recentServices) > 0)
                            @foreach($recentServices as $service)
                            <div class="flex items-center justify-between border-b pb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 p-2 rounded-full">
                                        <i class="fas fa-wrench text-blue-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $service['name'] }}</p>
                                        <p class="text-sm text-gray-500">{{ $service['client'] }}</p>
                                    </div>
                                </div>
                                <span class="bg-{{ $service['status'] === 'completed' ? 'green' : 'blue' }}-100 text-{{ $service['status'] === 'completed' ? 'green' : 'blue' }}-600 px-3 py-1 rounded-full text-sm">
                                    {{ ucfirst($service['status']) }}
                                </span>
                            </div>
                            @endforeach
                        @else
                            <p class="text-center py-4 text-gray-500">Aucun service récent</p>
                        @endif
                    </div>
                </div>

                <!-- New Users -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">New Users</h3>
                    <div class="space-y-4">
                        @if(count($newUsers) > 0)
                            @foreach($newUsers as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde" 
                                        class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <p class="font-medium">{{ $user['name'] }}</p>
                                        <p class="text-sm text-gray-500">{{ $user['role'] }}</p>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $user['created_at'] }}</span>
                            </div>
                            @endforeach
                        @else
                            <p class="text-center py-4 text-gray-500">Aucun nouvel utilisateur</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
