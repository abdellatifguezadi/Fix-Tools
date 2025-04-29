<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">User Profile</h1>
                        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Users
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-lg font-semibold mb-4">Basic Information</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Role</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ ucfirst($user->role) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <p class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $user->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $user->is_available ? 'Active' : 'Suspended' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-lg font-semibold mb-4">Additional Information</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Address</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->address ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">City</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->city ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Total Points</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->total_points }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Member Since</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F j, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        @if($user->role === 'professional')
                        <div class="bg-white p-6 rounded-lg shadow md:col-span-2">
                            <h2 class="text-lg font-semibold mb-4">Professional Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Specialty</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->specialty ?? 'Not specified' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Experience (years)</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->experience ?? 'Not specified' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->description ?? 'No description provided' }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="mt-6 flex justify-end space-x-4">
                        @if($user->is_available)
                            <x-delete-confirmation-modal 
                                :title="'Suspend User'"
                                :message="'Are you sure you want to suspend ' . $user->name . '? They will not be able to log in or use any services until reactivated.'"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Suspend User
                                <x-slot name="actions">
                                    <form action="{{ route('admin.users.suspend', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Suspend User
                                        </button>
                                        <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </form>
                                </x-slot>
                            </x-delete-confirmation-modal>
                        @else
                            <x-delete-confirmation-modal 
                                :title="'Activate User'"
                                :message="'Are you sure you want to activate ' . $user->name . '? They will regain access to all platform features.'"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Activate User
                                <x-slot name="actions">
                                    <form action="{{ route('admin.users.activate', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Activate User
                                        </button>
                                        <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </form>
                                </x-slot>
                            </x-delete-confirmation-modal>
                        @endif

                        <x-delete-confirmation-modal 
                            :title="'Delete User'"
                            :message="'Are you sure you want to delete ' . $user->name . '? This action cannot be undone and will anonymize all their messages and reviews.'"
                            class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">
                            Delete User
                            <x-slot name="actions">
                                <form action="{{ route('admin.users.delete', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                        Delete User
                                    </button>
                                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Cancel
                                    </button>
                                </form>
                            </x-slot>
                        </x-delete-confirmation-modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 