@props(['title', 'value', 'change', 'icon', 'color'])

@php
    $colors = [
        'blue' => 'bg-blue-100 text-blue-500',
        'yellow' => 'bg-yellow-100 text-yellow-500',
        'green' => 'bg-green-100 text-green-500',
        'purple' => 'bg-purple-100 text-purple-500'
    ];
@endphp

<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm">{{ $title }}</p>
            <h3 class="text-2xl font-bold">{{ $value }}</h3>
            <p class="text-green-500 text-sm">{{ $change }} depuis le mois dernier</p>
        </div>
        <div class="{{ $colors[$color] }} p-3 rounded-full">
            <i class="fas fa-{{ $icon }} text-xl"></i>
        </div>
    </div>
</div> 