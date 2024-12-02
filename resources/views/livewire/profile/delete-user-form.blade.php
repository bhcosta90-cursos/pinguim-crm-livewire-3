<div class="space-y-4  max-w-[320px]">
    <x-input
        label="{{ __('Password') }}"
        wire:model="password"
        id="password"
        name="password"
        type="password"
        placeholder="{{ __('Password') }}"
    />
    <x-button danger wire:click="confirm">{{ __('Delete Account') }}</x-button>
</div>
