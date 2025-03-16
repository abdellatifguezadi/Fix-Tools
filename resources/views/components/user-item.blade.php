@props(['name', 'role', 'time', 'image'])

<div class="flex items-center justify-between">
    <div class="flex items-center space-x-3">
        <img src="{{ $image }}" 
            alt="{{ $name }}" 
            class="w-10 h-10 rounded-full object-cover">
        <div>
            <p class="font-medium">{{ $name }}</p>
            <p class="text-sm text-gray-500">{{ $role }}</p>
        </div>
    </div>
    <span class="text-sm text-gray-500">{{ $time }}</span>
</div> 