<div>
    <x-slide title="Update user" form>
        @if($user)
            <div class="grid grid-cols-2 gap-3">
                <div class="col-span-full"><x-input disabled :value="$user->name" :label="__('Nome')" /></div>
                <x-input type="email"  disabled :value="$user->email" :label="__('E-mail')" />
                <x-input type="password"  disabled value="******" :label="__('Password')" />
                <div class="col-span-full"><x-select :label="__('Selecione as permissões')" searchable wire:model="permissions" :options="$this->cans" multiple /></div>
            </div>
        @endif
    </x-slide>
</div>
