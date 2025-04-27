<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Profile Header -->
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 px-6 py-8">
                        <div class="flex items-center">
                            <div class="w-24 h-24 rounded-full bg-white overflow-hidden ring-4 ring-white shadow-lg">
                                @if($user->image)
                                    <img src="{{ Storage::url($user->image) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <span class="text-4xl text-yellow-500 font-bold">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-6">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-gray-800">{{ $user->email }}</p>
                                <span class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                    Client
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Content -->
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Personal Information -->
                            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-800">Personal Information</h2>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-600">Full Name</p>
                                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-600">Email</p>
                                            <p class="font-semibold text-gray-800">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-600">Phone</p>
                                            <p class="font-semibold text-gray-800">{{ $user->phone ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-600">Address</p>
                                            <p class="font-semibold text-gray-800">{{ $user->address ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-600">City</p>
                                            <p class="font-semibold text-gray-800">{{ $user->city ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm text-gray-600">Joined</p>
                                            <p class="font-semibold text-gray-800">{{ $user->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Requests Summary -->
                            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-bold text-gray-800">Service Requests Summary</h2>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex-shrink-0">
                                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-6">
                                            <h3 class="text-lg font-semibold text-gray-900">Total Requests</h3>
                                            <p class="text-gray-700 mt-1">{{ $user->serviceRequests()->count() ?? 0 }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex-shrink-0">
                                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-6">
                                            <h3 class="text-lg font-semibold text-gray-900">Completed</h3>
                                            <p class="text-gray-700 mt-1">{{ $user->serviceRequests()->completed()->count() ?? 0 }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex-shrink-0">
                                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-6">
                                            <h3 class="text-lg font-semibold text-gray-900">Pending</h3>
                                            <p class="text-gray-700 mt-1">{{ $user->serviceRequests()->active()->count() ?? 0 }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-center space-x-4">
                            <a href="{{ route('client.my-requests') }}" class="inline-flex items-center px-6 py-3 bg-yellow-400 text-gray-900 rounded-lg hover:bg-yellow-300 transition-colors duration-200 shadow-md hover:shadow-lg font-bold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                My Requests
                            </a>
                            <button onclick="openEditProfileModal()" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors duration-200 shadow-md hover:shadow-lg font-bold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 {{ $errors->any() ? 'block' : 'hidden' }}">
        <div class="bg-white rounded-lg w-full max-w-2xl mx-4 my-8">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-bold">Edit Profile</h3>
                <button onclick="closeEditProfileModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="max-h-[calc(100vh-200px)] overflow-y-auto">
                <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Success messages -->
                    <!-- @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif -->

                    <!-- Error messages -->
                    <!-- @if($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif -->

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}" readonly
                                class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none cursor-not-allowed">
                            <p class="mt-1 text-sm text-gray-500">Email address cannot be changed</p>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="tel" name="phone" id="phone" value="{{ $user->phone }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" name="address" id="address" value="{{ $user->address }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" name="city" id="city" value="{{ $user->city }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        </div>
                        <div>
                            <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-1">Profile Photo</label>
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                            @if($user->image)
                                <p class="mt-1 text-sm text-gray-500">Current photo will be kept if no new one is selected</p>
                            @endif
                        </div>
                        <div class="md:col-span-2">
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" name="current_password" id="current_password"
                                class="w-full border @error('current_password') border-red-500 @else border-gray-300 @enderror rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" name="password" id="password"
                                class="w-full border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                            <p class="mt-1 text-sm text-gray-500">Leave blank to keep current password</p>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="button" onclick="closeEditProfileModal()" class="px-4 py-2 mr-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2 bg-yellow-400 text-gray-900 rounded-lg hover:bg-yellow-500 transition-colors duration-200 font-bold">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditProfileModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
        }

        function closeEditProfileModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
        }
    </script>
</x-app-layout> 