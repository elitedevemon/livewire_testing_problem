@props(['active'])

@php

$classes = ($active ?? false)
        ? 'navigation__link inline-flex items-center px-1 pt-1 border-b-2 border-'.$primary_color.'-400 text-sm leading-5 font-semibold text-gray-900 focus:outline-none focus:border-'.$primary_color.'-700 transition duration-150 ease-in-out'
        : 'navigation__link inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm leading-5 font-semibold text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';


@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
