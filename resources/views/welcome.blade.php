<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inventario de IT + Control de Licencias y Accesos</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-slate-50 text-slate-900 selection:bg-indigo-100 selection:text-indigo-700">
        <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-slate-50 via-white to-indigo-50/20">
            <!-- Decorative blobs -->
            <div class="absolute -top-24 -left-20 w-96 h-96 bg-indigo-200/20 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 -right-20 w-80 h-80 bg-slate-200/30 rounded-full blur-3xl"></div>

            <div class="relative max-w-7xl mx-auto px-6 py-12 lg:py-20 flex flex-col min-h-screen">
                <header class="flex justify-between items-center mb-16 lg:mb-24">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-200">
                            <x-application-logo class="w-7 h-7 fill-current text-white" />
                        </div>
                        <span class="text-xl font-bold tracking-tight text-slate-900">Portal IT</span>
                    </div>

                    @if (Route::has('login'))
                        <nav class="flex items-center gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-full bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition-all shadow-sm">Panel de Control</a>
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-full bg-white ring-1 ring-slate-200 text-slate-700 text-sm font-semibold hover:ring-indigo-400 hover:text-indigo-600 transition-all shadow-sm">Iniciar Sesión</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition-all shadow-indigo-100 shadow-lg">Registro</a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <main class="flex-1 flex flex-col items-center justify-center text-center max-w-4xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-wider mb-8 ring-1 ring-indigo-100">
                        Herramienta Interna de Gestión
                    </div>
                    
                    <h1 class="text-4xl lg:text-7xl font-extrabold text-slate-900 tracking-tight leading-[1.1] mb-8">
                        Inventario de <span class="text-indigo-600">IT</span><br> 
                        <span class="text-slate-400 font-medium">+</span> control de licencias y accesos
                    </h1>
                    
                    <p class="text-lg lg:text-xl text-slate-500 mb-12 max-w-2xl leading-relaxed">
                        Gestiona los activos tecnológicos, licencias de software y accesos de usuario de forma centralizada y eficiente.
                    </p>

                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ route('login') }}" class="px-8 py-4 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 transform hover:-translate-y-0.5 active:translate-y-0">
                            Acceder al Inventario
                        </a>
                        <div class="px-6 flex items-center gap-2 text-sm text-slate-400 font-medium italic">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Acceso restringido a empleados
                        </div>
                    </div>
                </main>

                <footer class="mt-20 pt-8 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-400 text-sm font-medium">
                    <div>&copy; {{ date('Y') }} {{ config('app.name') }} &bull; Departamento de IT</div>
                    <div class="flex items-center gap-6">
                        <span>Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span>
                        <span>PHP v{{ PHP_VERSION }}</span>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
