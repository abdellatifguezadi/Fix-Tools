@props(['type' => 'success', 'message' => null])

@php
    $classes = [
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'error' => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-400 text-blue-700'
    ];
@endphp

@if(session('success'))
    <div class="fixed top-4 right-4 {{ $classes['success'] }} px-4 py-3 rounded z-50" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 {{ $classes['error'] }} px-4 py-3 rounded z-50" role="alert">
        {{ session('error') }}
    </div>
@endif

@if(session('warning'))
    <div class="fixed top-4 right-4 {{ $classes['warning'] }} px-4 py-3 rounded z-50" role="alert">
        {{ session('warning') }}
    </div>
@endif

@if(session('info'))
    <div class="fixed top-4 right-4 {{ $classes['info'] }} px-4 py-3 rounded z-50" role="alert">
        {{ session('info') }}
    </div>
@endif

@if($message)
    <div class="fixed top-4 right-4 {{ $classes[$type] }} px-4 py-3 rounded z-50" role="alert">
        {{ $message }}
    </div>
@endif 