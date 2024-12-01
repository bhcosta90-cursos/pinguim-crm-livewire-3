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
        <div class="flex justify-end px-6 pt-2 pb-3 bg-gray-50 border-b-2 border-gray-300">
            <x-dev />
        </div>
        {{ $slot }}
        @livewireScripts
    </body>
</html>
