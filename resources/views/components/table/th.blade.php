@props(['text' => null, 'name' => null, 'sortDirection' => null, 'sortColumn' => null])
<th {{ $attributes->class(['px-3 py-3.5 text-left text-sm font-semibold text-gray-900']) }}>
    @if(blank($name))
        {{ $text ?: $slot }}
    @else
        <div wire:click="sortBy('{{ $name }}', '{{ $sortDirection === 'asc' && $sortColumn === $name ? 'desc' : 'asc' }}')"
             class="cursor-pointer">
            <div class="flex flex-row items-center">
                <div>{{ $text ?: $slot }}</div>
                @if($sortColumn === $name)
                    <x-ts-icon
                        :name="$sortDirection === 'asc' && $sortColumn ? 'chevron-up' : 'chevron-down'"
                        class="!size-4"
                    />
                @else
                    <x-ts-icon
                        name="chevron-up"
                        class="!size-4 !text-gray-300"
                    />
                @endif
            </div>
        </div>
    @endif
</th>

