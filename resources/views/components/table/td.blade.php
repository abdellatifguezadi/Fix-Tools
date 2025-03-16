@props(['class' => ''])

<td {{ $attributes->merge(['class' => 'px-4 py-3 ' . $class]) }}>
    {{ $slot }}
</td> 