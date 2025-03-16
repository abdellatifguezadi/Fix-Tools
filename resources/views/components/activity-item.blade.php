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

<div class="flex items-center justify-between border-b pb-4">
    <div class="flex items-center space-x-3">
        <div class="{{ $colors[$color] }} p-2 rounded-full">
            <i class="fas fa-{{ $icon }}"></i>
        </div>
        <div>
            <p class="font-medium">{{ $title }}</p>
            <p class="text-sm text-gray-500">{{ $subtitle }}</p>
        </div>
    </div>
    <span class="{{ $statusColors[$status] }} px-3 py-1 rounded-full text-sm">
        {{ $statusLabels[$status] }}
    </span>
</div> 