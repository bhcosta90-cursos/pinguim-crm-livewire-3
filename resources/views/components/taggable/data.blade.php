<div>
    @if(count($this->dataFilter))
        <div class="gap-3 flex">
            @foreach($this->dataFilter as $key => $filter)
                <x-badge :text="$filter" wire:click="removeFilter({{$key}})" class="cursor-pointer" icon="x-circle" md outline position="right" />
            @endforeach

            <x-badge :text="__('Limpar filtros')" wire:click="clearFilter" class="cursor-pointer" md outline />
        </div>
    @endif
</div>
