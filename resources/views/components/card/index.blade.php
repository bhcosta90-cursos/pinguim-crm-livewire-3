@props(['title', 'subtitle' => null])
<div class="mx-auto max-w-none">
    <div class="overflow-hidden bg-white sm:rounded-lg sm:shadow">

        <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
            <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                <div class="ml-4 mt-4">
                    <h3 class="text-base font-semibold text-gray-900">{{ __($title) }}</h3>
                    @if($subtitle)
                        <p class="mt-1 text-sm text-gray-500">{{ __($subtitle) }}</p>
                    @endif
                </div>
                @if(isset($actions))
                    <div class="ml-4 mt-4 shrink-0 flex flex-row gap-2">
                        {{ $actions }}
                    </div>
                @endif
            </div>
        </div>

        <div class="sm:px-3 py-4">
            {{ $slot }}
        </div>
    </div>
</div>
