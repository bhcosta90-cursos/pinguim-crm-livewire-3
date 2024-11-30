<x-card :title="__('Forgot Your Password?')">
    <form class="space-y-4" wire:submit="submit">
        @if($message)
            <x-alert icon="exclamation-triangle">
                <span>{{ $message }}</span>
            </x-alert>
        @endif

        <x-input label="E-mail" type="email" wire:model="email" />

        <div class="w-full flex items-center justify-between">
            <a wire:navigate href="{{ route('login') }}" class="link link-primary">
                @lang('Never mind, get back to login page.')
            </a>
            <div>
                <x-button label="Enviar" primary type="submit" spinner="submit"/>
            </div>
        </div>
    </form>
</x-card>
