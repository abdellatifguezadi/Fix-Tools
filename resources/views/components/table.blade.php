@props(['header'])

<table class="w-full">
    <thead class="bg-gray-50">
        <tr>
            {{ $header }}
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        {{ $slot }}
    </tbody>
</table> 