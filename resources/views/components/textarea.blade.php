@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block rounded-md shadow-sm border border-gray-300 w-full sm:w-96 p-2 mb-3 text-gray-700']) !!}></textarea>


