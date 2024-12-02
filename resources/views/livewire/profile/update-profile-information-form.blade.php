<form class="space-y-4 max-w-[500px]" wire:submit="updateProfileInformation">
    <div>
        <x-input :label="__('Name')" wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
    </div>
    <div>
        <x-input :label="__('Email')" wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
        @if (! auth()->user()->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                <x-ts-pin length="6" wire:model="code" />

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div>
        <x-input type="password" :label="__('Password')" wire:model="password" id="name" name="password" class="mt-1 block w-full" required autofocus autocomplete="password" />
    </div>

    <div class="flex items-center gap-4">
        <x-button primary type="submit">{{ __('Save') }}</x-button>

        <x-action-message class="me-3" on="profile-updated">
            {{ __('Saved.') }}
        </x-action-message>
    </div>

</form>
