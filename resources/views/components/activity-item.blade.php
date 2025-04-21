@props(['icon', 'color', 'title', 'subtitle', 'status'])

@php
    $colors = [
        'blue' => 'bg-blue-100 text-blue-500',
        'yellow' => 'bg-yellow-100 text-yellow-500',
        'green' => 'bg-green-100 text-green-500'
    ];

    $statusColors = [
        'completed' => 'bg-green-100 text-green-600',
        'in-progress' => 'bg-blue-100 text-blue-600',
        'pending' => 'bg-yellow-100 text-yellow-600'
    ];

    $statusLabels = [
        'completed' => 'Terminé',
        'in-progress' => 'En cours',
        'pending' => 'En attente'
    ];
@endphp

<div class="flex items-center justify-between border-b pb-4 transition duration-300 transform hover:scale-102 hover:bg-gray-50 rounded-lg p-2 group">
    <div class="flex items-center space-x-3">
        <div class="{{ $colors[$color] }} p-2 rounded-full transition duration-300 group-hover:scale-110">
            <i class="fas fa-{{ $icon }}"></i>
        </div>
        <div>
            <p class="font-medium transition duration-300 group-hover:text-yellow-500">{{ $title }}</p>
            <p class="text-sm text-gray-500">{{ $subtitle }}</p>
        </div>
    </div>
    <span class="{{ $statusColors[$status] }} px-3 py-1 rounded-full text-sm transition duration-300 hover:shadow-sm">
        {{ $statusLabels[$status] }}
    </span>
</div> 