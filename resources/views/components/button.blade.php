<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center m-4 '.$button_style]) }}>
    {{ $slot }}
</button>
