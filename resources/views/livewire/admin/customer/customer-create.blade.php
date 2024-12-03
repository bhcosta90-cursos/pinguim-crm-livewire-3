<div>
    <x-button primary outline wire:click="$toggle('modal')" label="New customer"/>

    <x-modal title="New customer" form>
        <div class="flex gap-3">
            <x-input wire:model="customer.name" label="Name" />
            <x-input wire:model="customer.email" label="Email" />
            <x-input wire:model="customer.phone" label="Phone" />
        </div>
    </x-modal>
</div>
