@props(['class' => ''])

<th {{ $attributes->merge(['class' => 'px-4 py-2 text-left text-sm font-medium text-gray-500 ' . $class]) }}>
    {{ $slot }}
</th> 