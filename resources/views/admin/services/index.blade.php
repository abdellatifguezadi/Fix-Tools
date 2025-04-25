<x-app-layout>
    <x-slot name="title">
        Services Management
    </x-slot>

    <div class="min-h-screen flex flex-col">
        <div class="flex-1 p-8 mt-16">
            <div class="mb-6">
                <h2 class="text-2xl font-bold">Services Management</h2>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Services Table -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="overflow-x-auto">
                    @if(count($services) > 0)
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Service</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Category</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Professional</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Price</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Status</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($services as $service)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($service->image_path)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($service->image_path) }}" alt="{{ $service->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-tools text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($service->description, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900">{{ $service->category->name }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900">{{ $service->professional->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $service->professional->email }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900">${{ number_format($service->base_price, 2) }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($service->is_available)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        <form action="{{ route('admin.services.toggle-status', $service) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="{{ $service->is_available ? 'text-yellow-600 hover:text-yellow-800' : 'text-green-600 hover:text-green-800' }}" title="{{ $service->is_available ? 'Disable' : 'Enable' }}">
                                                @if($service->is_available)
                                                    <i class="fas fa-ban"></i>
                                                @else
                                                    <i class="fas fa-check"></i>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-center py-4 text-gray-500">No services found.</p>
                    @endif
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</x-app-layout> 