<div>
    <x-card title="Lista de usuário" subtitle="Usuário cadastrado em nosso sistema">
        @can('create', \App\Models\User::class)
            <x-slot:actions>
                <livewire:admin.user.user-create />
            </x-slot:actions>
        @endif
        <x-table :records="$this->records">
            <x-slot name="filter">
                <div class="space-y-2">
                    <div class="flex justify-between items-center gap-4">
                        <div class="w-full"><x-deleted wire:model.live="status" /></div>
                        <div class="w-full"><x-select :placeholder="__('Selecione as permissões')" searchable wire:model.live="permissions" :options="$this->cans" multiple /></div>
                        <div class="w-full"><x-taggable :filter-placeholder="__('nome ou e-mail')" /></div>
                    </div>

                    <x-taggable.data />
                </div>
            </x-slot>
            <x-slot name="head">
                <x-table.th class="w-0" name="id" :$sortDirection :$sortColumn></x-table.th>
                <x-table.th name="name" :$sortDirection :$sortColumn>@lang('Nome e e-mail')</x-table.th>
                <x-table.th class="w-0"></x-table.th>
                <x-table.th class="w-0"></x-table.th>
                <x-table.th class="w-0"></x-table.th>
                <x-table.th class="w-0"></x-table.th>
            </x-slot>
            @foreach($this->records as $record)
                @php
                    $disableUpdate = auth()->user()->cannot('edit', $record);
                    $disableDelete = auth()->user()->cannot('delete', $record);
                    $disableRestore = auth()->user()->cannot('restore', $record);
                    $disableImpersonate = auth()->user()->cannot('impersonate', $record);
                @endphp

                <x-table.tr>
                    <x-table.td :text="$record->id" />
                    <x-table.td>
                        <div class="flex items-center">
                            <div class="size-11 shrink-0">
                                <img class="size-11 rounded-full" src="{{ $record->photo }}" alt="">
                            </div>
                            <div class="ml-4 flex flex-col">
                                <span>{{ $record->name }}</span>
                                <span><a class="underline" href="mailto:{{ $record->email }}">{{ $record->email }}</a></span>
                                @if($record->permissions->count())
                                    <span class="text-xs text-muted">@lang('Permissões: ') {{ implode(', ', $record->permissions->pluck('name')->toArray()) }}</span>
                                @endif
                            </div>
                        </div>
                    </x-table.td>
                    <x-table.td class="w-0 text-center">
                        <x-disabled :is="$record->deleted_at" />
                    </x-table.td>
                    <x-table.td>
                        <x-button
                            neutral
                            :disabled="$disableUpdate"
                            outline
                            @click="$dispatch('user::edit', {user: {{ $record->id }} })"
                            icon="pencil"
                        />
                    </x-table.td>
                    <x-table.td>
                        <x-button
                            :disabled="$disableImpersonate"
                            outline
                            @click="$dispatch('user::impersonate', {user: {{ $record->id }} })"
                            icon="finger-print"
                        />
                    </x-table.td>
                    <x-table.td>
                        @if(blank($record->deleted_at))
                            <x-button
                                danger
                                :disabled="$disableDelete"
                                outline
                                @click="$dispatch('model::delete', {model: {{ $record->id }} })"
                                icon="trash"
                            />
                        @else
                            <x-button
                                warning
                                :disabled="$disableRestore"
                                outline
                                @click="$dispatch('model::restore', {model: {{ $record->id }} })"
                                icon="arrow-uturn-left"
                            />
                        @endif
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table>
    </x-card>

    <livewire:admin.user.user-edit />
    <livewire:admin.user.user-delete />
    <livewire:admin.user.user-restore />
    <livewire:admin.user.user-impersonate />
</div>
