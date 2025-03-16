@props(['route', 'icon', 'active' => false, 'label'])

<a href="{{ route($route) }}" 
   class="flex items-center space-x-3 {{ $active ? 'text-yellow-400 bg-gray-900' : 'text-gray-300 hover:bg-gray-900' }} p-3 rounded-lg">
    <i class="fas fa-{{ $icon }}"></i>
    <span>{{ $label }}</span>
</a> 