@props([
    'label' => null,
    'primary' => null,
    'secondary' => null,
    'danger' => null,
    'warning' => null,
    'neutral' => null,
])

@php
    $attributes = match(true) {
        $secondary === true => $attributes->merge(['color' => 'secondary']),
        $neutral === true => $attributes->merge(['color' => 'neutral']),
        $danger === true => $attributes->merge(['color' => 'red']),
        $warning === true => $attributes->merge(['color' => 'orange']),
        default => $attributes->merge(['color' => 'primary']),
    };
@endphp

<x-ts-button {{ $attributes }}>
    {{ __($label) ?: $slot }}
</x-ts-button>
