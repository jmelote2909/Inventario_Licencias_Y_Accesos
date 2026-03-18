<x-app-layout>
    <x-slot name="header">
        {{ __('Panel de Control') }}
    </x-slot>

    <div class="space-y-10">
        <!-- Hero Section -->
        <div class="bg-indigo-600 p-10 rounded-[2.5rem] shadow-xl shadow-indigo-100 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
            <div class="relative z-10">
                <h3 class="text-3xl font-extrabold text-white mb-3">Gestión de Inventario IT</h3>
                <p class="text-indigo-100 text-lg max-w-xl">Centraliza el control de equipos, licencias y accesos de la empresa de forma profesional.</p>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Equipos -->
            <a href="{{ route('equipos') }}" class="group bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-slate-200/60 transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl w-fit mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Equipos</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Gestión completa de hardware, dispositivos y activos tecnológicos.</p>
            </a>

            <!-- Asignaciones -->
            <a href="{{ route('asignaciones') }}" class="group bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-slate-200/60 transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl w-fit mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Asignaciones</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Control de entrega y devolución de equipos a empleados.</p>
            </a>

            <!-- Licencias y caducidades -->
            <a href="#" class="group bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-slate-200/60 transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl w-fit mb-6 group-hover:bg-amber-600 group-hover:text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Licencias y caducidades</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Seguimiento de software y alertas de renovación de licencias.</p>
            </a>

            <!-- Export / auditoría rápida -->
            <a href="#" class="group bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-slate-200/60 transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="p-4 bg-violet-50 text-violet-600 rounded-2xl w-fit mb-6 group-hover:bg-violet-600 group-hover:text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Export / Auditoría rápida</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Generación de informes Excel y revisión rápida del estado del sistema.</p>
            </a>

            <!-- Teletrabajos -->
            <a href="{{ route('teletrabajo') }}" class="group bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-slate-200/60 transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="p-4 bg-indigo-50 text-indigo-600 rounded-2xl w-fit mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Teletrabajos</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Control de puestos de trabajo remotos y conectividad externa.</p>
            </a>

            <!-- Credenciales -->
            <a href="{{ route('asignaciones') }}" class="group bg-white p-8 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] ring-1 ring-slate-200/60 transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="p-4 bg-rose-50 text-rose-600 rounded-2xl w-fit mb-6 group-hover:bg-rose-600 group-hover:text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Credenciales</h4>
                <p class="text-slate-500 text-sm leading-relaxed">Almacén seguro de accesos a correos y páginas corporativas.</p>
            </a>
        </div>
    </div>
</x-app-layout>
