<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        {{-- Changed min-h-screen background to the deep slate #0f172a --}}
        <div class="min-h-screen bg-[#0f172a]">
            @include('layouts.navigation')

            @isset($header)
                {{-- Updated Header: Darker background with gray-800 border --}}
                <header class="bg-[#1e293b] border-b border-gray-800 shadow-lg shadow-black/20">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Wrapped main in a container to ensure consistent theme --}}
            <main class="text-gray-100">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>