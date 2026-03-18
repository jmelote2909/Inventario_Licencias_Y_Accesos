<div class="space-y-8 pb-20">
    <!-- Header Seccion -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-800 tracking-tight">Gestión de Equipos</h1>
            <p class="text-slate-500 mt-2 font-medium">Control total del inventario de dispositivos y activos de IT.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Botón Importar Excel -->
            <div x-data="{ uploading: false, progress: 0 }" 
                 x-on:livewire-upload-start="uploading = true" 
                 x-on:livewire-upload-finish="uploading = false" 
                 x-on:livewire-upload-error="uploading = false" 
                 x-on:livewire-upload-progress="progress = $event.detail.progress">
                
                <div class="flex flex-col items-end gap-2">
                    <label class="cursor-pointer px-6 py-3 rounded-2xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Importar Excel
                        <input type="file" wire:model="file" class="hidden" accept=".xlsx,.xls,.csv">
                    </label>

                    <div x-show="uploading" class="mt-2 text-xs text-indigo-600 font-bold animate-pulse">
                        Subiendo... <span x-text="progress + '%'"></span>
                    </div>

                    @if ($file)
                        <button wire:click="import" class="mt-2 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-bold flex items-center gap-2">
                            <span>Archivo listo: {{ $file->getClientOriginalName() }}</span>
                            <span wire:loading.remove wire:target="import">-> Procesar ahora</span>
                            <span wire:loading wire:target="import">Procesando...</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Botón Exportar -->
            <button wire:click="export" class="px-6 py-3 rounded-2xl bg-white text-slate-700 font-bold border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 transition-all shadow-sm flex items-center gap-2 group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Exportar Datos
            </button>

            <button wire:click="create" class="px-6 py-3 rounded-2xl bg-slate-900 text-white font-bold border border-slate-900 hover:bg-slate-800 transition-all shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Nuevo Registro
            </button>
        </div>
    </div>

    <!-- Buscador y Filtros -->
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
            <svg class="h-6 w-6 text-slate-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <input type="text" 
               wire:model.live.debounce.300ms="search" 
               placeholder="Buscar por dispositivo, marca, modelo, serie o empleado..." 
               class="block w-full pl-14 pr-6 py-5 bg-white border-0 rounded-3xl text-slate-600 font-medium placeholder-slate-300 shadow-sm ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
    </div>

    <!-- Mensajes de Feedback -->
    <div class="space-y-2">
        @if (session()->has('message'))
            <div class="p-4 bg-emerald-50 text-emerald-700 border-l-4 border-emerald-500 rounded-lg flex items-center gap-3 animate-fade-in-down">
                <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('info'))
            <div class="p-4 bg-indigo-50 text-indigo-700 border-l-4 border-indigo-500 rounded-lg flex items-center gap-3 animate-fade-in-down">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                {{ session('info') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 bg-rose-50 text-rose-700 border-l-4 border-rose-500 rounded-lg flex items-center gap-3 animate-fade-in-down">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Tabla Principal -->
    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Dispositivo / Nombre</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Ubicación</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Hardware / Red</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Empleado / Mentor</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Soft / Config</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Estado</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($equipos as $equipo)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="font-bold text-slate-700 group-hover:text-indigo-600 transition-colors">{{ $equipo->nombre }}</div>
                                <div class="text-[10px] text-slate-400 uppercase font-bold tracking-tight">{{ $equipo->dispositivotipo ?? 'Hardware' }}</div>
                            </td>
                            <td class="px-6 py-5 text-sm">
                                <div class="text-slate-600 font-medium">{{ $equipo->centro ?? '-' }}</div>
                                <div class="text-[11px] text-slate-400">P: {{ $equipo->planta ?? '-' }} / Z: {{ $equipo->zona ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm">
                                    <div class="text-slate-900 font-medium">{{ $equipo->dispositivomarca ?? $equipo->marca ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $equipo->dispositivomodelo ?? $equipo->modelo ?? '-' }} / {{ $equipo->tipoconexion ?? '-' }}</div>
                                    <div class="text-[10px] font-mono text-slate-300">SN: {{ $equipo->dispositivoserial ?? $equipo->numero_serie ?? '-' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-sm">
                                <div class="text-slate-700 font-bold">{{ $equipo->empleadonombre ?? '-' }}</div>
                                <div class="text-[11px] text-indigo-500 font-medium">Mentor: {{ $equipo->empleadomentor ?? '-' }}</div>
                                <div class="text-[10px] text-slate-400">Cod: {{ $equipo->empleadocodigo ?? '-' }} / Taq: {{ $equipo->empleado_taquilla ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-5 text-sm">
                                <div class="flex flex-wrap gap-1 mb-1">
                                    @if($equipo->firefox) <span class="px-1.5 py-0.5 bg-orange-50 text-orange-600 rounded text-[9px] font-bold border border-orange-100 italic">Firefox: {{ $equipo->firefox }}</span> @endif
                                    @if($equipo->sage) <span class="px-1.5 py-0.5 bg-blue-50 text-blue-600 rounded text-[9px] font-bold border border-blue-100 italic">Sage: {{ $equipo->sage }}</span> @endif
                                </div>
                                <div class="text-[10px] text-slate-400">Inst: {{ $equipo->instalado ?? '-' }}</div>
                                <div class="text-[9px] text-slate-300 font-bold uppercase">PL: {{ $equipo->t_plant ?? '-' }} / ST: {{ $equipo->t_stock ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                @php
                                    $statusClasses = [
                                        'libre' => 'bg-indigo-50 text-indigo-700 ring-indigo-100',
                                        'disponible' => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
                                        'rota' => 'bg-amber-50 text-amber-700 ring-amber-100',
                                        'baja' => 'bg-rose-50 text-rose-700 ring-rose-100',
                                    ][strtolower($equipo->estado)] ?? 'bg-slate-50 text-slate-700 ring-slate-100';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide ring-1 {{ $statusClasses }}">
                                    {{ $equipo->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <button wire:click="edit({{ $equipo->id }})" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    </button>
                                    <button onclick="confirm('¿Seguro que quieres eliminar este equipo?') || event.stopImmediatePropagation()" 
                                            wire:click="delete({{ $equipo->id }})" 
                                            class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-slate-700">No hay datos todavía</h3>
                                        <p class="text-slate-400 mt-1">Importa un archivo arriba para comenzar o usa el buscador.</p>
                                    </div>
                                    <label class="cursor-pointer text-indigo-600 font-bold hover:underline">
                                        Importa tu primer Excel
                                        <input type="file" wire:model="file" class="hidden" accept=".xlsx,.xls,.csv">
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-8 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $equipos->links() }}
        </div>
    </div>

    <!-- Modal de Edición -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-slate-100">
                <div class="bg-white px-8 pt-8 pb-10">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-slate-800" id="modal-title">{{ $editingId ? 'Editar Dispositivo' : 'Nuevo Dispositivo' }}</h3>
                            <p class="text-slate-400 text-sm font-medium">{{ $editingId ? 'Modifica los detalles técnicos y de asignación.' : 'Registra un nuevo activo en el inventario.' }}</p>
                        </div>
                        <button wire:click="closeModal" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-2xl transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-8">
                        <!-- Seccion 1: Identificacion -->
                        <div class="p-6 bg-slate-50/50 rounded-3xl border border-slate-100">
                            <h4 class="text-xs font-black text-indigo-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                                Identificación y Ubicación
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nombre / Tag</label>
                                    <input type="text" wire:model="form.nombre" class="w-full px-4 py-3 bg-white border-0 ring-1 ring-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-600">
                                    @error('form.nombre') <span class="text-rose-500 text-[10px] font-bold mt-1 uppercase">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Centro</label>
                                    <input type="text" wire:model="form.centro" class="w-full px-4 py-3 bg-white border-0 ring-1 ring-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-600">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Estado</label>
                                    <select wire:model="form.estado" class="w-full px-4 py-3 bg-white border-0 ring-1 ring-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-600 appearance-none">
                                        <option value="disponible">Disponible</option>
                                        <option value="libre">Libre</option>
                                        <option value="rota">Rota</option>
                                        <option value="baja">Baja</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Planta</label>
                                    <input type="text" wire:model="form.planta" class="w-full px-4 py-3 bg-white border-0 ring-1 ring-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-600">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Zona</label>
                                    <input type="text" wire:model="form.zona" class="w-full px-4 py-3 bg-white border-0 ring-1 ring-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-600">
                                </div>
                            </div>
                        </div>

                        <!-- Seccion 2: Hardware -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Hardware</h4>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Tipo</label>
                                            <input type="text" wire:model="form.dispositivotipo" class="w-full px-4 py-2 bg-slate-50 border-0 ring-1 ring-transparent rounded-xl focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium text-slate-600">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Marca</label>
                                            <input type="text" wire:model="form.dispositivomarca" class="w-full px-4 py-2 bg-slate-50 border-0 ring-1 ring-transparent rounded-xl focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium text-slate-600">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Modelo</label>
                                        <input type="text" wire:model="form.dispositivomodelo" class="w-full px-4 py-2 bg-slate-50 border-0 ring-1 ring-transparent rounded-xl focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium text-slate-600">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nº Serie</label>
                                        <input type="text" wire:model="form.dispositivoserial" class="w-full px-4 py-2 bg-slate-50 border-0 ring-1 ring-transparent rounded-xl focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium text-slate-600">
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Red y Conexión</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Dirección MAC</label>
                                        <input type="text" wire:model="form.dispositivomac" class="w-full px-4 py-2 bg-slate-50 border-0 ring-1 ring-transparent rounded-xl focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium text-slate-600">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Tipo Conexión</label>
                                        <input type="text" wire:model="form.tipoconexion" class="w-full px-4 py-2 bg-slate-50 border-0 ring-1 ring-transparent rounded-xl focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium text-slate-600">
                                    </div>
                                    <div class="flex items-center gap-4 mt-6">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" wire:model="form.compartida" class="sr-only peer">
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                            <span class="ml-3 text-xs font-bold text-slate-500 uppercase">Compartida</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Seccion 3: Empleado -->
                        <div class="p-6 bg-indigo-50/30 rounded-3xl border border-indigo-100">
                            <h4 class="text-xs font-black text-indigo-500 uppercase tracking-widest mb-4">Asignación y Usuario</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Código Empleado</label>
                                    <input type="text" wire:model="form.empleadocodigo" class="w-full px-4 py-3 bg-white border-0 ring-1 ring-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-600">
                                </div>
                                <div class="lg:col-span-2">
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nombre Completo</label>
                                    <input type="text" wire:model="form.empleadonombre" class="w-full px-4 py-3 bg-white border-0 ring-1 ring-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-600">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nº Taquilla</label>
                                    <input type="text" wire:model="form.empleado_taquilla" class="w-full px-4 py-3 bg-white border-0 ring-1 ring-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-600">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Mentor Asignado</label>
                                    <input type="text" wire:model="form.empleadomentor" class="w-full px-4 py-3 bg-white border-0 ring-1 ring-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-600">
                                </div>
                            </div>
                        </div>

                        <!-- Seccion 4: Software -->
                        <div class="p-6 bg-white rounded-3xl border border-slate-100">
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Software e Instalación</h4>
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 italic">Firefox</label>
                                    <input type="text" wire:model="form.firefox" class="w-full px-4 py-2 bg-slate-50 border-0 ring-1 ring-transparent rounded-xl focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium text-slate-600">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1 italic">Sage</label>
                                    <input type="text" wire:model="form.sage" class="w-full px-4 py-2 bg-slate-50 border-0 ring-1 ring-transparent rounded-xl focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium text-slate-600">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">T-Plant</label>
                                    <input type="text" wire:model="form.t_plant" class="w-full px-4 py-2 bg-slate-50 border-0 ring-1 ring-transparent rounded-xl focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium text-slate-600">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">T-Stock</label>
                                    <input type="text" wire:model="form.t_stock" class="w-full px-4 py-2 bg-slate-50 border-0 ring-1 ring-transparent rounded-xl focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium text-slate-600">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Instalado / Fecha</label>
                                    <input type="text" wire:model="form.instalado" class="w-full px-4 py-2 bg-slate-50 border-0 ring-1 ring-transparent rounded-xl focus:ring-1 focus:ring-indigo-500 transition-all text-sm font-medium text-slate-600">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                            <button type="button" wire:click="closeModal" class="px-8 py-4 rounded-2xl bg-white text-slate-500 font-bold border border-slate-200 hover:bg-slate-50 transition-all">
                                Cancelar
                            </button>
                            <button type="submit" class="px-10 py-4 rounded-2xl bg-indigo-600 shadow-lg shadow-indigo-100 text-white font-bold hover:bg-indigo-700 transition-all flex items-center gap-2">
                                <span wire:loading.remove wire:target="save">Guardar Cambios</span>
                                <span wire:loading wire:target="save" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Guardando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
