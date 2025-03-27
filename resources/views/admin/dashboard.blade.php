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
                            <h3 class="text-2xl font-bold">2,543</h3>
                            <p class="text-green-500 text-sm">+12% from last month</p>
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
                            <h3 class="text-2xl font-bold">847</h3>
                            <p class="text-green-500 text-sm">+5% from last month</p>
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
                            <h3 class="text-2xl font-bold">1,234</h3>
                            <p class="text-green-500 text-sm">+8% from last month</p>
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
                            <h3 class="text-2xl font-bold">$45,678</h3>
                            <p class="text-green-500 text-sm">+15% from last month</p>
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
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Service</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Total</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Active</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-3">Plumbing</td>
                                    <td class="px-4 py-3">450</td>
                                    <td class="px-4 py-3 text-green-500">85%</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">Electrical</td>
                                    <td class="px-4 py-3">380</td>
                                    <td class="px-4 py-3 text-green-500">78%</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">Painting</td>
                                    <td class="px-4 py-3">275</td>
                                    <td class="px-4 py-3 text-green-500">92%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Revenue Table -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">Monthly Revenue</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Month</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Revenue</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Growth</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-3">June</td>
                                    <td class="px-4 py-3">$12,000</td>
                                    <td class="px-4 py-3 text-green-500">+15%</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">May</td>
                                    <td class="px-4 py-3">$9,500</td>
                                    <td class="px-4 py-3 text-green-500">+8%</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3">April</td>
                                    <td class="px-4 py-3">$8,800</td>
                                    <td class="px-4 py-3 text-red-500">-3%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Services -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">Recent Services</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b pb-4">
                            <div class="flex items-center space-x-3">
                                <div class="bg-blue-100 p-2 rounded-full">
                                    <i class="fas fa-wrench text-blue-500"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Plumbing Repair</p>
                                    <p class="text-sm text-gray-500">John Smith</p>
                                </div>
                            </div>
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm">Completed</span>
                        </div>
                        <div class="flex items-center justify-between border-b pb-4">
                            <div class="flex items-center space-x-3">
                                <div class="bg-yellow-100 p-2 rounded-full">
                                    <i class="fas fa-paint-roller text-yellow-500"></i>
                                </div>
                                <div>
                                    <p class="font-medium">House Painting</p>
                                    <p class="text-sm text-gray-500">Sarah Johnson</p>
                                </div>
                            </div>
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm">In Progress</span>
                        </div>
                    </div>
                </div>

                <!-- New Users -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">New Users</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde" 
                                    class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <p class="font-medium">Alex Johnson</p>
                                    <p class="text-sm text-gray-500">Customer</p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">2 mins ago</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="https://images.unsplash.com/photo-1540569014015-19a7be504e3a" 
                                    class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <p class="font-medium">Mike Brown</p>
                                    <p class="text-sm text-gray-500">Professional</p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">5 mins ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 