@props(['type' => '', 'href' => '#'])

@php
    $class =
        'flex items-center gap-2 cursor-pointer focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900';
@endphp

@if (in_array($type, ['button', 'submit']))
    <button type="{{ $type }}" class="{{ $class }}" {{ $attributes }}>
        {{ $slot }}
    </button>
@else
    <a href="{{ $href }}" class="{{ $class }}" {{ $attributes }}>
        {{ $slot }}
    </a>
@endif
