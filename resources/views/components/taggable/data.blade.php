<div>
    @if(count($this->dataFilter))
        <div class="space-x-3">
            @foreach($this->dataFilter as $key => $filter)
                <x-badge wire:click="removeFilter({{$key}})" class="cursor-pointer">
                    {!! $filter !!} <x-ts-icon name="x-circle" class="!size-5" />
                </x-badge>
            @endforeach

            <x-badge wire:click="clearFilter" class="cursor-pointer">
                @lang('Limpar filtros')
            </x-badge>
        </div>
    @endif
</div>
