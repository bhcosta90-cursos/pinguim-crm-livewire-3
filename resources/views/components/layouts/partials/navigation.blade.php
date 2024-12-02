@php
    use App\Actions\Admin\Layout\VerifyMenuAction;
    $menu = app(VerifyMenuAction::class)->handle(config('menu'));
@endphp

<div>
    <div class="relative z-50 lg:hidden" role="dialog" aria-modal="true" x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
        <div class="fixed inset-0 bg-gray-900/80"></div>

        <div class="fixed inset-0 flex"
             x-transition:enter="transition ease-linear duration-300 transform"
             x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-linear duration-300 transform"
             x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
            <div class="relative mr-16 flex w-full max-w-xs flex-1"
                 x-transition:enter="ease-linear duration-300"
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-linear duration-300" x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-2 pb-1.0 ring-1 ring-white/10">
                    <div class="flex h-16 shrink-0 items-center pt-4">
                        <x-layouts.partials.logo class="h-6 w-auto"/>
                    </div>
                    <nav class="flex flex-1 flex-col menu">
                        <x-layouts.partials.menu :$menu />
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden lg:inset-y-0 lg:z-50 lg:flex lg:w-72 min-h-screen h-full">
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-2 pb-1.0">
            <div class="flex h-16 shrink-0 items-center pt-4">
                <x-layouts.partials.logo class="h-6 w-auto"/>
            </div>
            <nav class="flex flex-1 flex-col menu">
                <x-layouts.partials.menu :$menu />
            </nav>
        </div>
    </div>
</div>
