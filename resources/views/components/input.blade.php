@props(['label' => null])

@switch($attributes->get('type'))
    @case('password')
        <x-ts-password :label="__($label)" {{ $attributes }} />
        @break
    @default
        <x-ts-input :label="__($label)" {{ $attributes }} />
@endswitch
