@props(['title'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-lg font-bold mb-4">{{ $title }}</h3>
    {{ $slot }}
</div> 