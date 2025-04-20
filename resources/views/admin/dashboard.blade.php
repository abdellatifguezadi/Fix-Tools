<x-app-layout>
    <x-slot name="title">
        Tableau de bord Admin
    </x-slot>

    <div class="min-h-screen flex flex-col">
        <div class="flex-1 p-8 mt-16">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <x-stats-card 
                    title="Total Users" 
                    value="{{ number_format($totalUsers) }}" 
                    change="+12%" 
                    icon="users" 
                    color="blue"
                />

                <!-- Active Professionals -->
                <x-stats-card 
                    title="Active Professionals" 
                    value="{{ number_format($activeProfessionals) }}" 
                    change="+8%" 
                    icon="hard-hat" 
                    color="yellow"
                />

                <!-- Total Services -->
                <x-stats-card 
                    title="Completed Services" 
                    value="{{ number_format($completedServices) }}" 
                    change="+15%" 
                    icon="check-circle" 
                    color="green"
                />

                <!-- Revenue -->
                <x-stats-card 
                    title="Total Revenue" 
                    value="{{ number_format($totalRevenue, 2) }} MAD" 
                    change="+20%" 
                    icon="coins" 
                    color="purple"
                />
            </div>

            <!-- Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Services Table -->
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
                            <tr>
                                <td class="px-4 py-3">{{ $service['name'] }}</td>
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

                <!-- Revenue Table -->
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
                            <tr>
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

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Services -->
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

                <!-- New Users -->
                <x-card title="New Users">
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
                </x-card>
            </div>
        </div>
    </div>
 
</x-app-layout> 
