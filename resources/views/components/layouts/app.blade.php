<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    <tallstackui:script/>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<!--
This example requires updating your template:

```
<html class="h-full bg-white">
<body class="h-full">
```
-->

<body class="flex flex-col font-sans antialiased min-h-full max-w-screen" x-data>
    <div class="flex flex-col w-full min-h-screen bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: false }">
        <div class="flex w-full">

            <x-layouts.partials.navigation />

            <div class="flex flex-col w-full">
                <div class="flex justify-end px-6 pt-2 pb-3 bg-gray-50 border-b-2 border-gray-300">
                    <x-dev/>
                </div>

                <div
                    class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                    <x-layouts.partials.open-side-bar />

                    <x-layouts.partials.separator />

                    <div class="flex flex-1 justify-end gap-x-4 self-stretch lg:gap-x-6">
                        <x-layouts.partials.global-search />
                        <div class="flex items-center gap-x-4 lg:gap-x-6">
                            <x-layouts.partials.notification />

                            <x-layouts.partials.separator />

                            <x-layouts.partials.profile-dropdown />
                        </div>
                    </div>
                </div>

                <main class="py-10">
                    <div class="px-4 sm:px-6 lg:px-8 space-y-4">
                        @if(isset($header))
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ $header }}
                            </h2>
                        @endif

                        <div>
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <x-ts-dialog />
    <x-ts-toast />
</body>

@livewireScripts
</body>
</html>
