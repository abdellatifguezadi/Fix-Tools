@props(['slot'])

<li class="flex items-center space-x-3">
    <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    <span class="text-gray-300">{{ $slot }}</span>
</li> 