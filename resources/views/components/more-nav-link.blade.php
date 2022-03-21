<!-- used for the submenu "more" for example (configuration, actions history, ...) -->

@props(['active'])

@php

$classes = ($active ?? false)
        ? 'navigation__link inline-flex items-center px-1 pt-1 text-sm leading-5 font-bold text-'.$primary_color.'-600 focus:outline-none transition duration-150 ease-in-out'
        : 'navigation__link inline-flex items-center px-1 pt-1 text-sm leading-5 font-semibold text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out';


@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
