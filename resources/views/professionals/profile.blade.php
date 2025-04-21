<x-app-layout>

    <div class="bg-gray-50 h-screen flex overflow-hidden">

        <aside class="fixed inset-y-0 left-0 w-64 bg-gray-900 z-20 transform -translate-x-full sm:translate-x-0 transition-transform duration-200 ease-in-out">
            <x-sidebars.professional />
        </aside>

        <div class="w-full flex-1 flex flex-col transition-all duration-200 ease-in-out">

            <div class="h-16"></div>

            <div class="flex-1 overflow-auto">
                <div class="container mx-auto py-6 px-4">
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
                                            <span class="px-3 py-1 rounded-full text-sm {{ $user->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $user->is_available ? 'Available' : 'Not Available' }}
                                            </span>
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
                                                    <p class="text-sm text-gray-600">City</p>
                                                    <p class="font-semibold text-gray-800">{{ $user->city ?? 'Not specified' }}</p>
                                                </div>
                                            </div>
                                            <div class="md:col-span-2 flex items-center p-4 bg-gray-50 rounded-lg">
                                                <div class="flex-shrink-0">
                                                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm text-gray-600">Address</p>
                                                    <p class="font-semibold text-gray-800">{{ $user->address ?? 'Not specified' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Professional Information -->
                                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                                        <div class="flex items-center justify-between mb-6">
                                            <h2 class="text-xl font-bold text-gray-800">Professional Information</h2>
                                        </div>
                                        <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                                            <div class="flex-1 flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                                <div class="flex-shrink-0">
                                                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-6">
                                                    <h3 class="text-lg font-semibold text-gray-900">Specialty</h3>
                                                    <p class="text-gray-700 mt-1">{{ $user->specialty ?? 'Not specified' }}</p>
                                                </div>
                                            </div>
                                            <div class="flex-1 flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                                <div class="flex-shrink-0">
                                                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-6">
                                                    <h3 class="text-lg font-semibold text-gray-900">Experience</h3>
                                                    <p class="text-gray-700 mt-1">{{ $user->experience ? $user->experience . ' years' : 'Not specified' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-8 flex justify-center space-x-4">
                                    <a href="{{ route('services.my-services') }}" class="inline-flex items-center px-6 py-3 bg-yellow-400 text-gray-900 rounded-lg hover:bg-yellow-300 transition-colors duration-200 shadow-md hover:shadow-lg font-bold">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2M7 7h10"></path>
                                        </svg>
                                        My Services
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

        </div>
        
 
        <button id="sidebarToggle" class="fixed top-4 left-4 z-40 sm:hidden bg-yellow-400 text-gray-900 p-2 rounded-md shadow-md hover:bg-yellow-300 transition-colors duration-200">
            <i class="fas fa-bars"></i>
        </button>
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
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Error messages -->
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
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
                        <div>
                            <label for="specialty" class="block text-sm font-medium text-gray-700 mb-1">Specialty</label>
                            <input type="text" name="specialty" id="specialty" value="{{ $user->specialty }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        </div>
                        <div>
                            <label for="experience" class="block text-sm font-medium text-gray-700 mb-1">Experience (years)</label>
                            <input type="number" name="experience" id="experience" value="{{ $user->experience }}" min="0"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        </div>
                        <div>
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
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full border @error('password_confirmation') border-red-500 @else border-gray-300 @enderror rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="is_available" class="block text-sm font-medium text-gray-700 mb-1">Availability</label>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_available" id="is_available" value="1" {{ $user->is_available ? 'checked' : '' }}
                                    class="h-4 w-4 text-yellow-400 focus:ring-yellow-400 border-gray-300 rounded">
                                <label for="is_available" class="ml-2 text-sm text-gray-700">I am available for services</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-8 space-x-4">
                        <button type="button" onclick="closeEditProfileModal()" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200 font-bold">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-3 bg-yellow-400 text-gray-900 rounded-lg hover:bg-yellow-300 transition-colors duration-200 font-bold">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('aside').classList.toggle('-translate-x-full');
        });

        function openEditProfileModal() {
            const modal = document.getElementById('editProfileModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeEditProfileModal() {
            const modal = document.getElementById('editProfileModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('editProfileModal');
            if (event.target === modal) {
                closeEditProfileModal();
            }
        }
    </script>
</x-app-layout> 