<x-app-layout>
    <x-slot name="title">
        Tableau de bord Admin
    </x-slot>

    <div class="min-h-screen flex flex-col">
        <div class="flex-1 p-8 mt-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
                    <x-stats-card 
                        title="Total Users" 
                        value="{{ number_format($totalUsers) }}" 
                        icon="users" 
                        color="blue"
                    />
                </div>

                <div class="transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
                    <x-stats-card 
                        title="Active Professionals" 
                        value="{{ number_format($activeProfessionals) }}" 
                        icon="hard-hat" 
                        color="yellow"
                    />
                </div>

                <div class="transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
                    <x-stats-card 
                        title="Completed Services" 
                        value="{{ number_format($completedServices) }}" 
                        icon="check-circle" 
                        color="green"
                    />
                </div>

                <div class="transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">
                    <x-stats-card 
                        title="Total Revenue" 
                        value="{{ number_format($totalRevenue, 2) }} MAD"  
                        icon="coins" 
                        color="purple"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="transition duration-300 hover:shadow-lg">
                    <x-card title="Services Overview">
                        <div class="overflow-x-auto">
                            @if(count($servicesOverview) > 0)
                            <x-table>
                                <x-slot name="header">
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Service</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Total</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Active</th>
                                </x-slot>
                                
                                @foreach($servicesOverview as $service)
                                <tr class="transition duration-200 hover:bg-gray-50">
                                    <td class="px-4 py-3 group-hover:text-yellow-500">{{ $service['name'] }}</td>
                                    <td class="px-4 py-3">{{ $service['total'] }}</td>
                                    <td class="px-4 py-3 text-{{ $service['active'] >= 70 ? 'green' : ($service['active'] >= 40 ? 'yellow' : 'red') }}-500">
                                        {{ $service['active'] }}%
                                    </td>
                                </tr>
                                @endforeach
                            </x-table>
                            @else
                            <p class="text-center py-4 text-gray-500">Aucun service disponible</p>
                            @endif
                        </div>
                    </x-card>
                </div>

                <div class="transition duration-300 hover:shadow-lg">
                    <x-card title="Monthly Revenue">
                        <div class="overflow-x-auto">
                            @if(count($monthlyRevenue) > 0)
                            <x-table>
                                <x-slot name="header">
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Month</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Revenue</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Growth</th>
                                </x-slot>
                                
                                @foreach($monthlyRevenue as $month => $data)
                                <tr class="transition duration-200 hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $month }}</td>
                                    <td class="px-4 py-3">{{ number_format($data['revenue'], 2) }} MAD</td>
                                    <td class="px-4 py-3 text-{{ $data['growth'] >= 0 ? 'green' : 'red' }}-500">
                                        {{ $data['growth'] >= 0 ? '+' : '' }}{{ $data['growth'] }}%
                                    </td>
                                </tr>
                                @endforeach
                            </x-table>
                            @else
                            <p class="text-center py-4 text-gray-500">Aucun revenu enregistré</p>
                            @endif
                        </div>
                    </x-card>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="transition duration-300 hover:shadow-lg">
                    <x-card title="Recent Services">
                        <div class="space-y-4">
                            @if(count($recentServices) > 0)
                                @foreach($recentServices as $service)
                                    <x-activity-item 
                                        icon="wrench" 
                                        color="blue" 
                                        title="{{ $service['name'] }}" 
                                        subtitle="{{ $service['client'] }}" 
                                        status="{{ $service['status'] === 'completed' ? 'completed' : 'in-progress' }}"
                                    />
                                @endforeach
                            @else
                                <p class="text-center py-4 text-gray-500">Aucun service récent</p>
                            @endif
                        </div>
                    </x-card>
                </div>

                <div class="transition duration-300 hover:shadow-lg">
                    <x-card title="New Users">
                        <div class="space-y-4">
                            @if(count($newUsers) > 0)
                                @foreach($newUsers as $user)
                                <div class="flex items-center justify-between transition duration-300 transform hover:scale-102 hover:bg-gray-50 rounded-lg p-2 group">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde" 
                                            class="w-10 h-10 rounded-full object-cover transition duration-300 group-hover:scale-110">
                                        <div>
                                            <p class="font-medium transition duration-300 group-hover:text-yellow-500">{{ $user['name'] }}</p>
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
                    </x-card>
                </div>
            </div>
        </div>
    </div>
 
</x-app-layout> 
