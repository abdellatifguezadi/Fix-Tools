@props(['title', 'description', 'image'])

<div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-yellow-400 transition-transform transform hover:scale-105 cursor-pointer">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover rounded-lg mb-4">
    <h3 class="text-xl font-bold mb-4">{{ $title }}</h3>
    <p class="text-gray-600">{{ $description }}</p>
</div> 