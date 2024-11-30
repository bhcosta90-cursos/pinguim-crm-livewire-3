<form class="space-y-4">
    <x-input label="Nome" wire:model="name" autofocus />
    <div class="grid grid-cols-2 gap-4">
        <x-input label="E-mail" type="email" wire:model="email" />
        <x-input label="Confirmar seu e-mail" type="email" wire:model="email_confirmation" />
    </div>
    <x-input label="Senha" type="password" wire:model="password" />

    <div class="w-full flex items-center justify-between">
        <a wire:navigate href="{{ route('login') }}" class="link link-primary">
            @lang('I already have an account')
        </a>
        <div>
            <x-button label="Limpar" neutral type="reset"/>
            <x-button label="Cadastrar" primary type="submit" spinner="submit"/>
        </div>
    </div>
</form>
