@props(['name', 'title', 'experience', 'jobs', 'rating', 'image'])

<div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-yellow-400">
    <div class="relative h-64 mb-4">
        <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover rounded-lg">
        <div class="absolute top-4 right-4 bg-yellow-400 text-black px-3 py-1 rounded-full text-sm font-semibold">
            {{ $rating }} ★
        </div>
    </div>
    <h3 class="text-xl font-bold mb-2">{{ $name }}</h3>
    <p class="text-gray-600 mb-4">{{ $title }}</p>
    <div class="flex items-center justify-between text-sm">
        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">{{ $experience }} d'expérience</span>
        <span class="text-yellow-600 font-semibold">{{ $jobs }} services</span>
    </div>
</div> 