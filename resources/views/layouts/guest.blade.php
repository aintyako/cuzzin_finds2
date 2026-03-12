<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0f172a]">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-indigo-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-[#1e293b] border border-gray-800 shadow-2xl overflow-hidden sm:rounded-[2rem]">
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-gray-600 text-[10px] font-black uppercase tracking-[0.3em]">
                &copy; {{ date('Y') }} {{ config('app.name') }}
            </p>
        </div>
    </body>
</html>