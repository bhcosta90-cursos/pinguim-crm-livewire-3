<div>
    <x-button primary outline label="New user" wire:click="$toggle('slide')" />

    <x-slide title="New user" form>
        <div class="grid grid-cols-2 gap-3">
            <div class="col-span-full"><x-input wire:model="user.name" :label="__('Nome')" /></div>
            <x-input type="email" wire:model="user.email" :label="__('E-mail')" />
            <x-input type="password" wire:model="password" :label="__('Password')" />
            <div class="col-span-full"><x-select :label="__('Selecione as permissões')" searchable wire:model="permissions" :options="$this->cans" multiple /></div>
        </div>
    </x-slide>
</div>
