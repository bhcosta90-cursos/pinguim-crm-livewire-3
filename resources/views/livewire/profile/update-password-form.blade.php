<form class="space-y-4 max-w-[500px]" wire:submit="updatePassword">
<div>
        <x-input autofocus :label="__('Current Password')" wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
    </div>

    <div>
        <x-input :label="__('New Password')" wire:model="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
    </div>

    <div>
        <x-input :label="__('Confirm Password')" wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
    </div>

    <div class="flex items-center gap-4">
        <x-button primary type="submit">{{ __('Save') }}</x-button>

        <x-action-message class="me-3" on="password-updated">
            {{ __('Saved.') }}
        </x-action-message>
    </div>
</form>
