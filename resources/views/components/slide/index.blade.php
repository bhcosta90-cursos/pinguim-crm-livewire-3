@props(['title', 'scroll' => false, 'form' => false])

@php
    if($scroll) {
        $scroll = [
                'wrapper.fifth' => [
                    'replace' => [
                        'py-6' => 'pt-6'
                    ]
                ],
                'footer' => [
                    'append' => 'sticky bottom-0 bg-white',
                    'replace' => [
                        'pt-6' => 'py-6'
                    ]
                ]
            ];
    } else {
        $scroll = [];
    }
@endphp

@if($form)
    <form wire:submit="submit">
@endif
<x-ts-slide :title="__($title)" wire :personalize="$scroll"
>
    {{ $slot }}

    @if(!isset($footer) && $form)
        <x-slot:footer start>
            <div class="flex justify-between w-full">
                <x-button secondary outline label="Cancel" type="reset" />
                <x-button primary label="Save" type="submit" />
            </div>
        </x-slot:footer>
    @endif
</x-ts-slide>
@if($form)
    </form>
@endif
