<x-card title="Login">

    @if($message = session()->get('status'))
        <x-alert icon="o-exclamation-triangle" class="alert-error mb-4">
            {{ $message }}
        </x-alert>
    @endif

    <form wire:submit="submit" class="space-y-4">
        @if($errors->hasAny(['invalidCredentials', 'rateLimiter']))
            <x-alert icon="exclamation-triangle">
                @error('invalidCredentials')
                <span>{{ $message }}</span>
                @enderror

                @error('rateLimiter')
                <span>{{ $message }}</span>
                @enderror
            </x-alert>
        @endif

        <x-input label="Email" wire:model="email"/>
        <div>
            <x-input label="Password" wire:model="password" type="password"/>
            <div class="w-full text-right text-sm">
                <a href="{{ route('password.recovery') }}" class="link link-primary text-xs">
                    @lang('Forgot your password?')
                </a>
            </div>
        </div>
        <div class="w-full flex items-center justify-between">
            <a wire:navigate href="{{ route('register') }}" class="link link-primary">
                @lang('I want to create an account')
            </a>
            <div>
                <x-button label="Login" class="btn-primary" type="submit" spinner="submit"/>
            </div>
        </div>
    </form>
</x-card>

