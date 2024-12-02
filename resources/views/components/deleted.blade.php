@php
    $status = [
        ['label' => 'Ativos', 'value' => 1],
        ['label' => 'Inativos', 'value' => 2],
        ['label' => 'Todos', 'value' => 3],
    ];
@endphp

<div>
    <x-ts-select.styled :placeholder="__('Status')" searchable :options="$status" select="label:label|value:value" {{ $attributes }} />
</div>
