<?php

namespace App\Livewire;

use App\Models\Equipo;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EquiposImport;
use App\Exports\EquiposExport;
use Illuminate\Support\Facades\Log;

class EquiposManager extends Component
{
    use WithFileUploads, WithPagination;

    public $file;
    public $search = '';
    
    // Propiedades para edición
    public $showModal = false;
    public $editingId = null;
    public $form = [
        'nombre' => '',
        'centro' => '',
        'planta' => '',
        'zona' => '',
        'dispositivotipo' => '',
        'dispositivomarca' => '',
        'dispositivomodelo' => '',
        'dispositivoserial' => '',
        'dispositivomac' => '',
        'tipoconexion' => '',
        'conectado_a' => '',
        'compartida' => false,
        'empleadocodigo' => '',
        'empleadonombre' => '',
        'empleadomentor' => '',
        'empleado_taquilla' => '',
        'firefox' => '',
        'sage' => '',
        't_plant' => '',
        't_stock' => '',
        'instalado' => '',
        'estado' => 'disponible',
    ];

    public function updatedFile()
    {
        Log::info('Archivo seleccionado.');
        session()->flash('info', 'Archivo cargado. Pulsa en "Procesar ahora" para importar.');
    }

    public function import()
    {
        if (!$this->file) return;

        try {
            Excel::import(new EquiposImport, $this->file->getRealPath());
            session()->flash('message', 'Equipos importados con éxito.');
            $this->reset('file');
        } catch (\Exception $e) {
            Log::error('Error importación: ' . $e->getMessage());
            session()->flash('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $this->reset('form');
        $this->editingId = null;
        $this->form['estado'] = 'disponible';
        $this->showModal = true;
    }

    public function edit($id)
    {
        $equipo = Equipo::findOrFail($id);
        $this->editingId = $id;
        $this->form = $equipo->toArray();
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'form.nombre' => 'required|string|max:255',
            'form.estado' => 'required',
        ]);

        if ($this->editingId) {
            $equipo = Equipo::find($this->editingId);
            $equipo->update($this->form);
            session()->flash('message', 'Equipo actualizado correctamente.');
        } else {
            Equipo::create($this->form);
            session()->flash('message', 'Nuevo equipo creado con éxito.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        Equipo::destroy($id);
        session()->flash('message', 'Equipo eliminado.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingId = null;
        $this->reset('form');
    }

    public function export()
    {
        return Excel::download(new EquiposExport, 'equipos_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function render()
    {
        $equipos = Equipo::where(function($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('dispositivomarca', 'like', '%' . $this->search . '%')
                  ->orWhere('dispositivomodelo', 'like', '%' . $this->search . '%')
                  ->orWhere('dispositivoserial', 'like', '%' . $this->search . '%')
                  ->orWhere('empleadonombre', 'like', '%' . $this->search . '%');
        })->latest()->paginate(15);

        return view('livewire.equipos-manager', [
            'equipos' => $equipos
        ])->layout('layouts.app');
    }
}
