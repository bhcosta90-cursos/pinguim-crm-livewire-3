<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        <tallstackui:script />
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @if(session()->has('impersonate'))
            <livewire:admin.user.user-impersonate-stop />
        @endif
        <div class="flex justify-end px-6 pt-2 pb-3 bg-gray-50 border-b-2 border-gray-300">
            <x-dev />
        </div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="w-[500px]">
                {{ $slot }}
            </div>
        </div>
        @livewireScripts
    </body>
</html>
