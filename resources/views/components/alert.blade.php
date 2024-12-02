@props([
    'text' => null,
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
<x-ts-alert {{ $attributes }} light>
    {{ $text ?: $slot }}
</x-ts-alert>
