<div class="space-y-8 pb-20">
    <!-- Header Seccion -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-800 tracking-tight">Asignaciones y Credenciales</h1>
            <p class="text-slate-500 mt-2 font-medium">Gestión detallada de accesos, correos y sistemas por empleado.</p>
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
                        Importar Asignaciones
                        <input type="file" wire:model="file" class="hidden" accept=".xlsx,.xls,.csv">
                    </label>

                    @if ($file)
                        <button wire:click="import" class="mt-2 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg text-sm font-bold flex items-center gap-2 animate-bounce">
                            <span>Listo: {{ $file->getClientOriginalName() }}</span>
                            <span wire:loading.remove wire:target="import">-> Procesar ahora</span>
                        </button>
                    @endif
                </div>
            </div>

            <button wire:click="export" class="px-6 py-3 rounded-2xl bg-white text-slate-700 font-bold border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 transition-all shadow-sm flex items-center gap-2 group">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Exportar
            </button>

            <button wire:click="create" class="px-6 py-3 rounded-2xl bg-slate-900 text-white font-bold border border-slate-900 hover:bg-slate-800 transition-all shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Nuevo Registro
            </button>
        </div>
    </div>

    <!-- Buscador -->
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
            <svg class="h-6 w-6 text-slate-300 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <input type="text" 
               wire:model.live.debounce.300ms="search" 
               placeholder="Buscar empleado por nombre..." 
               class="block w-full pl-14 pr-6 py-5 bg-white border-0 rounded-3xl text-slate-600 font-medium placeholder-slate-300 shadow-sm ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
    </div>

    <!-- Tabla de Asignaciones -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden" 
         x-data="{ 
            scrollSync() {
                const top = this.$refs.topScroll;
                const bottom = this.$refs.bottomScroll;
                top.onscroll = () => { bottom.scrollLeft = top.scrollLeft; };
                bottom.onscroll = () => { top.scrollLeft = bottom.scrollLeft; };
            }
         }" x-init="scrollSync()">
        
        <!-- Scroll Superior (Ghost) -->
        <div x-ref="topScroll" class="overflow-x-auto overflow-y-hidden border-b border-slate-50 bg-slate-50/30 group-hover:bg-slate-50/50 transition-colors" style="height: 12px;">
            <div :style="'width: ' + ($refs.tableContent?.offsetWidth || 2000) + 'px; height: 1px;'"></div>
        </div>

        <div x-ref="bottomScroll" class="overflow-x-auto">
            <table x-ref="tableContent" class="w-full text-left border-separate border-spacing-0">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="sticky left-0 z-40 bg-slate-50 px-6 py-6 text-sm font-bold text-slate-400 uppercase tracking-widest min-w-[250px] shadow-[4px_0_15px_-5px_rgba(0,0,0,0.1)] border-b border-slate-100">Empleado</th>
                        <th class="px-6 py-6 text-sm font-bold text-slate-400 uppercase tracking-widest min-w-[280px] border-b border-slate-100">Correos / Accesos</th>
                        <th class="px-6 py-6 text-sm font-bold text-slate-400 uppercase tracking-widest min-w-[280px] border-b border-slate-100">Sistemas / ERP</th>
                        <th class="px-6 py-6 text-sm font-bold text-slate-400 uppercase tracking-widest min-w-[240px] border-b border-slate-100">Colaboración</th>
                        <th class="px-6 py-6 text-sm font-bold text-slate-400 uppercase tracking-widest min-w-[240px] border-b border-slate-100">Otros Servicios</th>
                        <th class="px-6 py-6 text-sm font-bold text-slate-400 uppercase tracking-widest text-center min-w-[180px] border-b border-l border-slate-100">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($asignaciones as $item)
                        @if($item->es_cabecera)
                            <tr class="bg-slate-800">
                                <td colspan="5" class="px-6 py-4 border-b border-slate-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-1.5 h-6 bg-indigo-500 rounded-full"></div>
                                        <span class="text-lg font-black text-white uppercase tracking-widest">{{ $item->empleado_nombre }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 border-b border-l border-slate-700 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="edit({{ $item->id }})" class="p-2 text-slate-300 hover:text-white hover:bg-slate-700 rounded-xl transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                        </button>
                                        <button onclick="confirm('¿Eliminar esta categoría? Los empleados asociados quedarán sin categoría.') || event.stopImmediatePropagation()" wire:click="delete({{ $item->id }})" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-900/30 rounded-xl transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @else
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="sticky left-0 z-20 bg-white group-hover:bg-slate-50 px-6 py-6 shadow-[4px_0_10px_-5px_rgba(0,0,0,0.1)] transition-colors border-b border-slate-100">
                                    <div class="font-black text-slate-700 text-lg leading-tight">{{ $item->empleado_nombre }}</div>
                                    <div class="mt-1 flex gap-2">
                                        <span class="text-[10px] font-bold uppercase py-0.5 px-2 bg-slate-100 text-slate-500 rounded-full tracking-wide">ID: {{ $item->id }}</span>
                                        <span class="text-[10px] font-bold uppercase py-0.5 px-2 bg-indigo-50 text-indigo-500 rounded-full tracking-wide">Activo</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 border-b border-slate-100">
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-2 group/tip">
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                                            <span class="text-sm font-medium text-slate-600 truncate max-w-[200px]" title="{{ $item->correo_u }}">{{ $item->correo_u ?: 'No asig.' }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 opacity-50">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                            <span class="text-[11px] font-mono tracking-tighter">{{ $item->correo_p ?: '****' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 border-b border-slate-100">
                                    <div class="flex flex-wrap gap-2 text-xs">
                                        @if($item->sage_u)
                                            <div class="px-2 py-1 bg-green-50 rounded-lg border border-green-100 flex flex-col">
                                                <span class="text-[9px] font-black text-green-600 uppercase">SAGE</span>
                                                <span class="font-bold text-green-800">{{ $item->sage_u }}</span>
                                            </div>
                                        @endif
                                        @if($item->erp_u)
                                            <div class="px-2 py-1 bg-purple-50 rounded-lg border border-purple-100 flex flex-col">
                                                <span class="text-[9px] font-black text-purple-600 uppercase">ERP</span>
                                                <span class="font-bold text-purple-800">{{ $item->erp_u }}</span>
                                            </div>
                                        @endif
                                        @if(!$item->sage_u && !$item->erp_u) <span class="text-slate-300 italic">Sin accesos</span> @endif
                                    </div>
                                </td>
                                <td class="px-6 py-6 border-b border-slate-100">
                                    <div class="space-y-2">
                                        @if($item->slack_u)
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] bg-slate-100 px-1.5 py-0.5 rounded font-black text-slate-500">SLACK</span>
                                                <span class="text-xs font-medium text-slate-600">{{ $item->slack_u }}</span>
                                            </div>
                                        @endif
                                        @if($item->hubspot_u)
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] bg-orange-50 px-1.5 py-0.5 rounded font-black text-orange-600">HUB</span>
                                                <span class="text-xs font-medium text-slate-600">{{ $item->hubspot_u }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-6 font-medium text-slate-600 text-xs border-b border-slate-100">
                                    <div class="grid grid-cols-2 gap-x-4 gap-y-1">
                                        <div class="flex items-center gap-1 {{ $item->microsoft_u ? 'text-indigo-600' : 'text-slate-300' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $item->microsoft_u ? 'bg-indigo-600' : 'bg-slate-200' }}"></span> MSFT
                                        </div>
                                        <div class="flex items-center gap-1 {{ $item->zoom_u ? 'text-indigo-600' : 'text-slate-300' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $item->zoom_u ? 'bg-indigo-600' : 'bg-slate-200' }}"></span> Zoom
                                        </div>
                                        <div class="flex items-center gap-1 {{ $item->trello_u ? 'text-indigo-600' : 'text-slate-300' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $item->trello_u ? 'bg-indigo-600' : 'bg-slate-200' }}"></span> Trello
                                        </div>
                                        <div class="flex items-center gap-1 {{ $item->chatgpt_u ? 'text-indigo-600' : 'text-slate-300' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $item->chatgpt_u ? 'bg-indigo-600' : 'bg-slate-200' }}"></span> GPT
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 transition-colors min-w-[180px] border-b border-l border-slate-100 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="edit({{ $item->id }})" class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-2xl transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                        </button>
                                        <button onclick="confirm('¿Eliminar asignaciones?') || event.stopImmediatePropagation()" wire:click="delete({{ $item->id }})" class="p-2.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-2xl transition-all shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center gap-6 animate-pulse">
                                    <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center border-2 border-dashed border-slate-200">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354l1.1 2.228 2.458.357-1.779 1.734.42 2.448-2.199-1.156-2.199 1.156.42-2.448-1.779-1.734 2.458-.357L12 4.354z"/></svg>
                                    </div>
                                    <div class="max-w-xs mx-auto">
                                        <h3 class="text-2xl font-black text-slate-700">Sin asignaciones registradas</h3>
                                        <p class="text-slate-400 mt-2 font-medium">Importa el archivo Excel de credenciales para visualizar los accesos.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-8 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $asignaciones->links() }}
        </div>
    </div>

    <!-- Modal de Edición -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm transition-opacity" wire:click="closeModal text-indigo-500"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-[3rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full border border-slate-100">
                <div class="bg-white p-10">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-3xl font-black text-slate-800" id="modal-title">{{ $editingId ? ($form['es_cabecera'] ? 'Editar Categoría' : 'Editar Asignaciones') : ($form['es_cabecera'] ? 'Nueva Categoría' : 'Nueva Asignación') }}</h3>
                            <p class="text-slate-400 font-medium">{{ $editingId ? ($form['es_cabecera'] ? 'Modifica el nombre del grupo.' : 'Control exhaustivo de credenciales de ' . $form['empleado_nombre']) : 'Crea un nuevo acceso o categoría.' }}</p>
                        </div>
                        <button wire:click="closeModal" class="p-3 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-3xl transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="save" class="space-y-10" x-data="{ isCategory: @entangle('form.es_cabecera') }">
                        <!-- Selector de Categoría Manual -->
                        <div class="p-6 bg-slate-900 rounded-[2rem] border border-slate-700 shadow-xl flex items-center justify-between group transition-all">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-indigo-500 rounded-2xl shadow-lg shadow-indigo-500/20">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                </div>
                                <div>
                                    <span class="block text-white font-black text-lg">¿Es una Categoría?</span>
                                    <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">MARCAR PARA CREAR UN SUBENCABEZADO (EJ: GERENCIA)</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer scale-125 mr-4">
                                <input type="checkbox" wire:model.live="form.es_cabecera" class="sr-only peer">
                                <div class="w-14 h-7 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-slate-400 after:rounded-full after:h-5 after:w-6 after:transition-all peer-checked:bg-indigo-500 peer-checked:after:bg-white"></div>
                            </label>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-2">Categoría / Grupo Padre</label>
                                <select wire:model="form.parent_id" :disabled="isCategory" class="w-full px-6 py-4 bg-slate-50 border-0 rounded-2xl ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-700 appearance-none disabled:cursor-not-allowed">
                                    <option value="">-- Sin categoría (General) --</option>
                                    @foreach($categorias as $cat)
                                        @if($editingId != $cat->id)
                                            <option value="{{ $cat->id }}">{{ $cat->empleado_nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-2">Nombre Empleado</label>
                                <input type="text" wire:model="form.empleado_nombre" class="w-full px-6 py-4 bg-slate-50 border-0 rounded-2xl ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-500 transition-all font-black text-slate-700 text-lg">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 {{ $form['es_cabecera'] ? 'opacity-30 grayscale pointer-events-none' : '' }} transition-all">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-2">Red Cima (U)</label>
                                    <input type="text" wire:model="form.red_cima_u" :disabled="isCategory" class="w-full px-4 py-4 bg-slate-50 border-0 rounded-2xl ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-600 disabled:cursor-not-allowed">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest pl-2">Red Cima (P)</label>
                                    <input type="text" wire:model="form.red_cima_p" :disabled="isCategory" class="w-full px-4 py-4 bg-slate-50 border-0 rounded-2xl ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-500 transition-all font-bold text-slate-600 disabled:cursor-not-allowed">
                                </div>
                            </div>
                        </div>

                        <!-- Grupos de Credenciales -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 {{ $form['es_cabecera'] ? 'opacity-30 grayscale pointer-events-none' : '' }} transition-all">
                            <!-- Correo E -->
                            <div class="p-6 bg-blue-50/50 rounded-[2rem] border border-blue-100 space-y-4">
                                <h4 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em]">Correo Electrónico</h4>
                                <div class="space-y-3">
                                    <input type="text" wire:model="form.correo_u" :disabled="isCategory" placeholder="Usuario Correo" class="w-full px-4 py-3 bg-white border-0 rounded-xl text-xs font-bold border-1 border-blue-100 shadow-sm disabled:cursor-not-allowed">
                                    <input type="text" wire:model="form.correo_p" :disabled="isCategory" placeholder="Contraseña Correo" class="w-full px-4 py-3 bg-white border-0 rounded-xl text-xs font-mono shadow-sm disabled:cursor-not-allowed">
                                    <input type="text" wire:model="form.correo_p_sage" :disabled="isCategory" placeholder="Pass Sage Correo" class="w-full px-4 py-3 bg-white border-0 rounded-xl text-[10px] shadow-sm disabled:cursor-not-allowed">
                                </div>
                            </div>
                            
                            <!-- Sage / ERP -->
                            <div class="p-6 bg-emerald-50/50 rounded-[2rem] border border-emerald-100 space-y-4">
                                <h4 class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em]">SAGE / ERP / GW</h4>
                                <div class="space-y-3">
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" wire:model="form.sage_u" :disabled="isCategory" placeholder="Sage U" class="px-3 py-3 bg-white border-0 rounded-xl text-xs font-bold shadow-sm disabled:cursor-not-allowed">
                                        <input type="text" wire:model="form.sage_p" :disabled="isCategory" placeholder="Sage P" class="px-3 py-3 bg-white border-0 rounded-xl text-[10px] shadow-sm disabled:cursor-not-allowed">
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" wire:model="form.erp_u" :disabled="isCategory" placeholder="ERP U" class="px-3 py-3 bg-white border-0 rounded-xl text-xs font-bold shadow-sm disabled:cursor-not-allowed">
                                        <input type="text" wire:model="form.erp_p" :disabled="isCategory" placeholder="ERP P" class="px-3 py-3 bg-white border-0 rounded-xl text-[10px] shadow-sm disabled:cursor-not-allowed">
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" wire:model="form.gw107_u" :disabled="isCategory" placeholder="GW U" class="px-3 py-3 bg-white border-0 rounded-xl text-xs font-bold shadow-sm disabled:cursor-not-allowed">
                                        <input type="text" wire:model="form.gw107_p" :disabled="isCategory" placeholder="GW P" class="px-3 py-3 bg-white border-0 rounded-xl text-[10px] shadow-sm disabled:cursor-not-allowed">
                                    </div>
                                </div>
                            </div>

                            <!-- Colaboración -->
                            <div class="p-6 bg-purple-50/50 rounded-[2rem] border border-purple-100 space-y-4">
                                <h4 class="text-[10px] font-black text-purple-500 uppercase tracking-[0.2em]">Colaboración</h4>
                                <div class="space-y-3">
                                    <div class="flex gap-2">
                                        <input type="text" wire:model="form.slack_u" :disabled="isCategory" placeholder="Slack U" class="flex-1 px-3 py-3 bg-white border-0 rounded-xl text-xs font-bold shadow-sm disabled:cursor-not-allowed">
                                        <input type="text" wire:model="form.slack_id" :disabled="isCategory" placeholder="ID" class="w-16 px-2 py-3 bg-white border-0 rounded-xl text-[9px] shadow-sm disabled:cursor-not-allowed">
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" wire:model="form.hubspot_u" :disabled="isCategory" placeholder="HS U" class="px-3 py-3 bg-white border-0 rounded-xl text-xs font-bold shadow-sm disabled:cursor-not-allowed">
                                        <input type="text" wire:model="form.hubspot_p" :disabled="isCategory" placeholder="HS P" class="px-3 py-3 bg-white border-0 rounded-xl text-[10px] shadow-sm disabled:cursor-not-allowed">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Otros Servicios -->
                        <div class="p-8 bg-slate-50/80 rounded-[2.5rem] border border-slate-200 {{ $form['es_cabecera'] ? 'opacity-30 grayscale pointer-events-none' : '' }} transition-all">
                             <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Otros Servicios Web</h4>
                             <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                 <input type="text" wire:model="form.microsoft_u" :disabled="isCategory" placeholder="Microsoft User" class="px-4 py-3 bg-white border-0 rounded-xl text-xs border border-slate-100 disabled:cursor-not-allowed">
                                 <input type="text" wire:model="form.trello_u" :disabled="isCategory" placeholder="Trello User" class="px-4 py-3 bg-white border-0 rounded-xl text-xs border border-slate-100 disabled:cursor-not-allowed">
                                 <input type="text" wire:model="form.zoom_u" :disabled="isCategory" placeholder="Zoom User" class="px-4 py-3 bg-white border-0 rounded-xl text-xs border border-slate-100 disabled:cursor-not-allowed">
                                 <input type="text" wire:model="form.chatgpt_u" :disabled="isCategory" placeholder="ChatGPT User" class="px-4 py-3 bg-white border-0 rounded-xl text-xs border border-slate-100 disabled:cursor-not-allowed">
                             </div>
                        </div>

                        <!-- Logística -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 {{ $form['es_cabecera'] ? 'opacity-30 grayscale pointer-events-none' : '' }} transition-all">
                             <div class="p-6 border border-slate-100 rounded-[2rem] space-y-3">
                                 <h5 class="text-[10px] font-black uppercase text-rose-400 tracking-wider">MRW</h5>
                                 <div class="flex gap-4">
                                     <input type="text" wire:model="form.mrw_u" :disabled="isCategory" placeholder="Usuario" class="flex-1 px-4 py-3 bg-slate-50 border-0 rounded-xl text-xs disabled:cursor-not-allowed">
                                     <input type="text" wire:model="form.mrw_p" :disabled="isCategory" placeholder="Pass" class="flex-1 px-4 py-3 bg-slate-50 border-0 rounded-xl text-[10px] disabled:cursor-not-allowed">
                                 </div>
                             </div>
                             <div class="p-6 border border-slate-100 rounded-[2rem] space-y-3">
                                 <h5 class="text-[10px] font-black uppercase text-amber-500 tracking-wider">Pallet Ways+</h5>
                                 <div class="flex gap-4">
                                     <input type="text" wire:model="form.pallet_ways_u" :disabled="isCategory" placeholder="Usuario" class="flex-1 px-4 py-3 bg-slate-50 border-0 rounded-xl text-xs disabled:cursor-not-allowed">
                                     <input type="text" wire:model="form.pallet_ways_p" :disabled="isCategory" placeholder="Pass" class="flex-1 px-4 py-2 bg-slate-50 border-0 rounded-xl text-[10px] disabled:cursor-not-allowed">
                                 </div>
                             </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-10 border-t border-slate-100">
                            <button type="button" wire:click="closeModal" class="px-10 py-5 rounded-3xl bg-white text-slate-500 font-black border border-slate-200 hover:bg-slate-50 transition-all">
                                Cancelar
                            </button>
                            <button type="submit" class="px-14 py-5 rounded-3xl bg-indigo-600 shadow-2xl shadow-indigo-100 text-white font-black hover:bg-indigo-700 transition-all">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
