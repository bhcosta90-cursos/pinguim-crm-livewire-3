@props(['title', 'form' => false])

@if($form)
    <form wire:submit="submit">
        @endif
        <x-ts-modal :title="__($title)" {{ $attributes }} wire>
            {{ $slot }}

            @if(!isset($footer) && $form)
                <x-slot:footer start>
                    <div class="flex justify-between w-full">
                        <x-button secondary outline label="Cancel" type="button" wire:click="$toggle('modal')"  />
                        <x-button primary label="Save" type="submit" />
                    </div>
                </x-slot:footer>
            @endif
        </x-ts-modal>
        @if($form)
    </form>
@endif
