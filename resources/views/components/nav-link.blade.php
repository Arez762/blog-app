@props(['active'])

@php
$classes = ($active ?? false)
            ? 'text-orange-500 transition duration-150 ease-in-out'
            : 'text-orange-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
