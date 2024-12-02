@props(['filterPlaceholder' => null])

<div>
    @if(property_exists($this, 'stringFilter') && property_exists($this, 'dataFilter'))
        <div class="space-y-2">
            <form wire:submit="addFilter">
                <div class="mt-[0.250rem] flex">
                    <div class="-mr-px grid grow grid-cols-1 focus-within:relative">
                        <input
                            x-ref="filterInput"
                            x-init="@this.on('focusFilterInput', () => { $refs.filterInput.focus() })"
                            type="text" wire:model="stringFilter"
                            class="col-start-1 row-start-1 block w-full rounded-l-md bg-white py-1.5 px-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            placeholder="{{ __('Procurar') }} {{ filled($filterPlaceholder) ? "por: " . $filterPlaceholder : '' }}"
                        >
                    </div>
                    <button type="submit"
                            class="flex shrink-0 items-center gap-x-1.5 rounded-r-md bg-white px-3 py-0.5 text-sm font-semibold text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 hover:bg-gray-50 focus:relative focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                        <x-ts-icon name="plus"/>
                        @lang('Adicionar')
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
