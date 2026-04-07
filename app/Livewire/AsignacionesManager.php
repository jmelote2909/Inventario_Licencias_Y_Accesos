<?php

namespace App\Livewire;

use App\Models\Asignacion;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AsignacionesImport;
use App\Exports\AsignacionesExport;
use Illuminate\Support\Facades\Log;

class AsignacionesManager extends Component
{
    use WithFileUploads, WithPagination;

    public $file;
    public $search = '';
    
    // Propiedades para edición (30+ campos)
    public $showModal = false;
    public $editingId = null;
    public $form = [
        'es_cabecera'     => false,
        'parent_id'       => null,
        'empleado_nombre' => '',
        'red_cima_u'      => '',
        'red_cima_p'      => '',
        'correo_u'        => '',
        'correo_p'        => '',
        'correo_p_sage'   => '',
        'correo_u_reest'  => '',
        'correo_p_reest'  => '',
        'sage_u'          => '',
        'sage_p'          => '',
        'erp_u'           => '',
        'erp_p'           => '',
        'gw107_u'         => '',
        'gw107_p'         => '',
        'slack_u'         => '',
        'slack_p'         => '',
        'slack_id'        => '',
        'hubspot_u'       => '',
        'hubspot_p'       => '',
        'microsoft_u'     => '',
        'trello_u'        => '',
        'zoom_u'          => '',
        'vodafone_u'      => '',
        'chatgpt_u'       => '',
        'mrw_u'           => '',
        'mrw_p'           => '',
        'pallet_ways_u'   => '',
        'pallet_ways_p'   => '',
        'openproyect_u'   => '',
        'openproyect_p'   => '',
    ];
    public function updatedFormEsCabecera($value)
    {
        if ($value) {
            // Si es categoría, limpiamos todo menos el nombre y el propio flag
            $nombre = $this->form['empleado_nombre'];
            $this->reset('form');
            $this->form['empleado_nombre'] = $nombre;
            $this->form['es_cabecera'] = true;
            $this->form['parent_id'] = null;
        }
    }

    public function import()
    {
        if (!$this->file) return;

        try {
            Excel::import(new AsignacionesImport, $this->file->getRealPath());
            session()->flash('message', 'Asignaciones importadas con éxito.');
            $this->reset('file');
        } catch (\Exception $e) {
            Log::error('Error importación Asignaciones: ' . $e->getMessage());
            session()->flash('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $this->reset('form');
        $this->editingId = null;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $asignacion = Asignacion::findOrFail($id);
        $this->editingId = $id;
        $this->form = $asignacion->toArray();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'form.empleado_nombre' => 'required|string|max:255',
        ]);

        if ($this->editingId) {
            $asignacion = Asignacion::find($this->editingId);
            $asignacion->update($this->form);
            session()->flash('message', 'Asignación actualizada correctamente.');
        } else {
            Asignacion::create($this->form);
            session()->flash('message', 'Nueva asignación creada con éxito.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        Asignacion::destroy($id);
        session()->flash('message', 'Asignación eliminada.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingId = null;
        $this->reset('form');
    }

    public function export()
    {
        return Excel::download(new AsignacionesExport, 'asignaciones_' . now()->format('Y-m-d') . '.xlsx');
    }

    public function render()
    {
        $asignaciones = Asignacion::where('empleado_nombre', 'like', '%' . $this->search . '%')
            ->orderByRaw('COALESCE(parent_id, id), es_cabecera DESC, id ASC')
            ->paginate(30); // Aumentamos para ver mejor los grupos

        $categorias = Asignacion::where('es_cabecera', true)->get();

        return view('livewire.asignaciones-manager', [
            'asignaciones' => $asignaciones,
            'categorias'   => $categorias
        ])->layout('layouts.app');
    }
}
