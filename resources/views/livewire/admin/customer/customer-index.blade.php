<div>
    <x-card title="Lista de clientes" subtitle="Cliente cadastrado em nosso sistema">
        @can('create', \App\Models\Customer::class)
            <x-slot:actions>
                <livewire:admin.customer.customer-create />
            </x-slot:actions>
        @endif
        <x-table :records="$this->records">
            <x-slot name="filter">
                <div class="space-y-2">
                    <div class="flex justify-between items-center gap-4">
                        <div class="w-full"><x-deleted wire:model.live="status" /></div>
                        <div class="w-full"><x-taggable :filter-placeholder="__('nome ou e-mail')" /></div>
                    </div>

                    <x-taggable.data />
                </div>
            </x-slot>
            <x-slot name="head">
                <x-table.th class="w-0" name="id" :$sortDirection :$sortColumn></x-table.th>
                <x-table.th name="name" :$sortDirection :$sortColumn>@lang('Nome e e-mail')</x-table.th>
                <x-table.th class="w-0"></x-table.th>
            </x-slot>
            @foreach($this->records as $record)
                <x-table.tr>
                    <x-table.td :text="$record->id" />
                    <x-table.td>
                        <div>{{ $record->name }}</div>
                        <div><a class="underline" href="mailto:{{ $record->email }}">{{ $record->email }}</a></div>
                    </x-table.td>
                    <x-table.td class="w-0 text-center">
                        <x-disabled :is="$record->deleted_at" />
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table>
    </x-card>
</div>
