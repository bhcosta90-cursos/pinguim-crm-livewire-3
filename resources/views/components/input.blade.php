@switch($attributes->get('type'))
    @case('password')
        <x-ts-password {{ $attributes }} />
        @break
    @default
        <x-ts-input {{ $attributes }} />
@endswitch
