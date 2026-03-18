<div class="space-y-8 pb-20">
    <!-- Header Seccion -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-800 tracking-tight">Gestión de Teletrabajo</h1>
            <p class="text-slate-500 mt-2 font-medium">Control de fechas de finalización y detalles de trabajo a distancia.</p>
        </div>
        
        <div class="flex items-center gap-3">
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

                    @if ($file)
                        <button wire:click="import" class="mt-2 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-bold flex items-center gap-2">
                            <span>Archivo: {{ $file->getClientOriginalName() }}</span>
                            <span wire:loading.remove wire:target="import">-> Procesar</span>
                        </button>
                    @endif
                </div>
            </div>

            <button wire:click="export" class="px-6 py-3 rounded-2xl bg-white text-slate-700 font-bold border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 transition-all shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Exportar
            </button>

            <button wire:click="edit()" class="px-6 py-3 rounded-2xl bg-slate-900 text-white font-bold border border-slate-900 hover:bg-slate-800 transition-all shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Nuevo Registro
            </button>
        </div>
    </div>

    <div class="relative group">
        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
            <svg class="h-6 w-6 text-slate-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
        <input type="text" 
               wire:model.live.debounce.300ms="search" 
               placeholder="Buscar usuario..." 
               class="block w-full pl-14 pr-6 py-5 bg-white border-0 rounded-3xl text-slate-600 font-medium placeholder-slate-300 shadow-sm ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 text-emerald-700 border-l-4 border-emerald-500 rounded-lg flex items-center gap-3">
            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Tabla Principal -->
    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Usuario</th>
                        <th class="px-8 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Fecha Fin Teletrabajo</th>
                        <th class="px-8 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest">Descripción / Notas</th>
                        <th class="px-8 py-5 text-sm font-bold text-slate-400 uppercase tracking-widest text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($teletrabajos as $item)
                        @if($item->es_cabecera)
                            <tr class="bg-slate-800">
                                <td colspan="3" class="px-8 py-4 border-b border-slate-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-1.5 h-6 bg-indigo-500 rounded-full"></div>
                                        <span class="text-lg font-black text-white uppercase tracking-widest">{{ $item->usuario }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-4 border-b border-l border-slate-700 text-right">
                                    <div class="flex items-center justify-end gap-2 text-right">
                                        {{-- Acciones deshabilitadas para categorías fijas para evitar borrado accidental --}}
                                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mr-2">Categoría Fija</span>
                                        <button wire:click="edit({{ $item->id }})" class="p-2 text-slate-300 hover:text-white hover:bg-slate-700 rounded-xl transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @php
                                $isPast = $item->fecha_fin ? \Carbon\Carbon::parse($item->fecha_fin)->isPast() : false;
                            @endphp
                            <tr class="{{ $isPast ? 'bg-rose-50/50 hover:bg-rose-100/70' : 'bg-emerald-50/50 hover:bg-emerald-100/70' }} transition-colors group border-b border-white/50">
                                <td class="px-8 py-6">
                                    <div class="font-bold text-slate-700 text-lg flex items-center gap-2">
                                        @if($item->parent_id)
                                            <div class="w-1.5 h-1.5 rounded-full bg-slate-400"></div>
                                        @endif
                                        {{ $item->usuario }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="font-mono font-bold {{ $isPast ? 'text-rose-700' : 'text-emerald-700' }}">
                                        {{ $item->fecha_fin ? \Carbon\Carbon::parse($item->fecha_fin)->format('d/m/Y') : 'INDEFINIDO' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-sm {{ $isPast ? 'text-rose-600/80' : 'text-emerald-600/80' }} max-w-md italic leading-relaxed font-medium">
                                        {{ $item->descripcion ?: 'Sin descripción adicional' }}
                                    </p>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button wire:click="edit({{ $item->id }})" class="p-2.5 {{ $isPast ? 'text-rose-400 hover:text-rose-800 hover:bg-rose-100' : 'text-emerald-400 hover:text-emerald-800 hover:bg-emerald-100' }} rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                        </button>
                                        <button onclick="confirm('¿Eliminar este registro?') || event.stopImmediatePropagation()" 
                                                wire:click="delete({{ $item->id }})" 
                                                class="p-2.5 {{ $isPast ? 'text-rose-400 hover:text-rose-800 hover:bg-rose-100' : 'text-emerald-400 hover:text-emerald-800 hover:bg-emerald-100' }} rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-700">No hay registros</h3>
                                    <button wire:click="edit()" class="text-indigo-600 font-bold hover:underline">Añadir el primero</button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-8 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $teletrabajos->links() }}
        </div>
    </div>

    <!-- Modal de Edición -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100">
                <div class="bg-white px-8 pt-8 pb-10">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-slate-800">{{ $editingId ? ($form['es_cabecera'] ? 'Editar Categoría' : 'Editar Log') : ($form['es_cabecera'] ? 'Nueva Categoría' : 'Nuevo Registro de Teletrabajo') }}</h3>
                            <p class="text-slate-400 text-sm font-medium">{{ $form['es_cabecera'] ? 'Grupo de teletrabajo para organizar usuarios.' : 'Define el usuario y la fecha límite.' }}</p>
                        </div>
                        <button wire:click="closeModal" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-6" x-data="{ isCategory: @entangle('form.es_cabecera') }">
                        <!-- Selector de Categoría Manual -->
                        <div class="p-6 bg-slate-900 rounded-[2rem] border border-slate-700 shadow-xl flex items-center justify-between group transition-all">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-indigo-500 rounded-2xl shadow-lg shadow-indigo-500/20">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                                <div>
                                    <span class="block text-white font-black text-lg">¿Es una Categoría?</span>
                                    <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">EJ: ACTUALMENTE TELETRABAJANDO</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer scale-110 mr-4">
                                <input type="checkbox" wire:model.live="form.es_cabecera" class="sr-only peer">
                                <div class="w-14 h-7 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-slate-400 after:rounded-full after:h-5 after:w-6 after:transition-all peer-checked:bg-indigo-500 peer-checked:after:bg-white"></div>
                            </label>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-400 uppercase pl-1">Usuario / Nombre</label>
                                <input type="text" wire:model="form.usuario" class="w-full px-5 py-3.5 bg-slate-50 border-0 rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-700">
                                @error('form.usuario') <span class="text-rose-500 text-[10px] font-bold mt-1 pl-1 uppercase">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="space-y-6 {{ $form['es_cabecera'] ? 'opacity-30 grayscale pointer-events-none' : '' }} transition-all" x-data="{ isIndefinite: @entangle('form.es_indefinido') }">
                            <!-- Toggle de Indefinido -->
                            <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-2xl">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span class="font-bold text-slate-700">Teletrabajo Indefinido</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model.live="form.es_indefinido" :disabled="isCategory" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                                </label>
                            </div>

                            <div :class="isIndefinite ? 'opacity-40' : ''" class="transition-opacity">
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 pl-1">Fecha de Fin</label>
                                <input type="date" wire:model="form.fecha_fin" :disabled="isCategory || isIndefinite" class="w-full px-5 py-3.5 bg-slate-50 border-0 rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-700 disabled:cursor-not-allowed">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase mb-2 pl-1">Descripción / Observaciones</label>
                                <textarea wire:model="form.descripcion" rows="4" :disabled="isCategory" class="w-full px-5 py-3.5 bg-slate-50 border-0 rounded-2xl ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all font-medium text-slate-700 disabled:cursor-not-allowed"></textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                            <button type="button" wire:click="closeModal" class="px-8 py-4 rounded-2xl bg-white text-slate-500 font-bold border border-slate-200 hover:bg-slate-50 transition-all">
                                Cancelar
                            </button>
                            <button type="submit" class="px-10 py-4 rounded-2xl bg-indigo-600 shadow-lg shadow-indigo-100 text-white font-bold hover:bg-indigo-700 transition-all">
                                Guardar Datos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
