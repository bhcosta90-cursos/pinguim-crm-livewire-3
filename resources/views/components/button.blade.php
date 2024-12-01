@props([
    'label' => null,
    'primary' => null,
    'secondary' => null,
    'neutral' => null,
])

@php
    $attributes = match(true) {
        $secondary === true => $attributes->merge(['color' => 'secondary']),
        $neutral === true => $attributes->merge(['color' => 'neutral']),
        default => $attributes->merge(['color' => 'primary']),
    };
@endphp

<x-ts-button {{ $attributes }}>
    {{ __($label) ?: $slot }}
</x-ts-button>
