<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900 selection:bg-indigo-100 selection:text-indigo-700">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-50 to-indigo-50/30">
            <div class="mb-8">
                <a href="/" wire:navigate class="flex flex-col items-center gap-2 group transition-all duration-300">
                    <div class="p-3 bg-white rounded-2xl shadow-sm ring-1 ring-slate-200 group-hover:ring-indigo-400 group-hover:shadow-md transition-all">
                        <x-application-logo class="w-12 h-12 fill-current text-indigo-600" />
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-slate-200/60 overflow-hidden sm:rounded-3xl">
                {{ $slot }}
            </div>
            
            <footer class="mt-8 text-slate-400 text-xs font-medium tracking-wide uppercase">
                &copy; {{ date('Y') }} {{ config('app.name') }} &bull; IT Inventory System
            </footer>
        </div>
    </body>
</html>
