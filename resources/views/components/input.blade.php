@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block rounded-md shadow-sm border border-gray-300 w-full p-2 mb-3 text-gray-700']) !!}>
