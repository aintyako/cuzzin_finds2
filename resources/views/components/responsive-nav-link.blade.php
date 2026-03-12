@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pr-4 py-2 border-l-4 border-indigo-500 text-start text-base font-black text-indigo-400 bg-indigo-500/10 focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full ps-3 pr-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-400 hover:text-white hover:bg-gray-800 hover:border-gray-700 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>