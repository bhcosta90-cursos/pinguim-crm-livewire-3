<div class="nav-bar-dev">
    @if(!app()->isProduction())
        <div class="flex flex-row items-center gap-2">
            <livewire:dev.branch-env />
            <livewire:dev.login />
        </div>
    @endif
</div>
