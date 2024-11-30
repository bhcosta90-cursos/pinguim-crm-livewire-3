@props(['title' => null])
<x-ts-card>
    <x-slot:header>
        {{ $title }}
    </x-slot:header>
    {{ $slot }}
</x-ts-card>
