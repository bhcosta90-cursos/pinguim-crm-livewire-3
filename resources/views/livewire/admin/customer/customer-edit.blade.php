<div>
    <x-button primary outline wire:click="$toggle('slide')" label="New customer"/>

    <x-slide title="New customer" form>
        <div class="space-y-3">
            <x-input wire:model="form.name" label="Name" />
            <x-input wire:model="form.email" label="Email" />
            <x-input wire:model="form.phone" label="Phone" />
        </div>
    </x-slide>
</div>
