<x-card :title="__('Verify Email Address')">
    <form class="space-y-4" wire:submit="submit">
        <p>
            @lang('We sent you a code. Please check your email.')
        </p>
        <x-input label="Code" wire:model="code"/>

        <div class="w-full flex items-center justify-between">
            <a href="#" wire:click="sendNewCode" class="text-muted link">
                Send a new code
            </a>
            <div>
                <x-button label="Check Code" class="btn-primary" type="submit" spinner="submit"/>
            </div>
        </div>
    </form>
</x-card>
