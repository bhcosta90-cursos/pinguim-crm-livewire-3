@props(['is' => false])
<div>
    <span @class([
        'inline-flex items-center rounded-md px-4 py-2.5 text-xs font-medium  ring-1 ring-inset',
        'bg-green-50 text-green-700 ring-green-600/20' => $is === false || $is === null,
        'bg-red-50 text-red-700 ring-red-600/20' => !($is === false || $is === null)
    ])>
        @if($is === false || $is === null)
            <span>@lang('Ativo')</span>
        @else
            <span>@lang('Inativo')</span>
        @endif
    </span>
</div>
