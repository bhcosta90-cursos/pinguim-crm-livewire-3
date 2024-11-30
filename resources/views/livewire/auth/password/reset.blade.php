<x-card :title="__('Reset Password')">
    @if($message = session()->get('status'))
        <x-alert icon="o-exclamation-triangle" class="alert-error mb-4">
            {{ $message }}
        </x-alert>
    @endif

    <form class="space-y-4" wire:submit="submit">
        <x-input label="Email" value="{{ $this->obfuscatedEmail }}" readonly/>
        <x-input label="Confirmation Email" wire:model="email_confirmation"/>
        <x-input label="Password" wire:model="password" type="password"/>
        <x-input label="Confirm Password" wire:model="password_confirmation" type="password"/>

        <div class="w-full flex items-center justify-between">
            <a wire:navigate href="{{ route('login') }}" class="link link-primary">
                @lang('Never mind, get back to login page.')
            </a>
            <div>
                <x-button label="Alterar senha" class="btn-primary" type="submit" spinner="submit"/>
            </div>
        </div>
    </form>
</x-card>
