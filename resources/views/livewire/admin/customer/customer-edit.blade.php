<div>
    <x-button primary outline wire:click="$toggle('slide')" label="New customer"/>

    <x-slide title="New customer" form>
        <div class="space-y-3">
            <x-input wire:model="customer.name" label="Name" />
            <x-input wire:model="customer.email" label="Email" />
            <x-input wire:model="customer.phone" label="Phone" />
        </div>
    </x-slide>
</div>
