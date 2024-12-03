<div class="bg-yellow-100 text-yellow-700 p-1 text-center cursor-pointer" role="alert" wire:click="execute">
    @lang('Você está acessando como usuário <span class="font-bold italic">:name</span>, clica aqui para cancelar.', ['name' => auth()->user()->name])
</div>
