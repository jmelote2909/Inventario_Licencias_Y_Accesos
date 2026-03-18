<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Teletrabajo;
use App\Imports\TeletrabajosImport;
use App\Exports\TeletrabajosExport;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TeletrabajoManager extends Component
{
    use WithFileUploads, WithPagination;

    public const FIXED_CATEGORIES = [
        'TELETRABAJANDO',
        'TELETRABAJANDO INDEFINIDO',
        'NO TELETRABAJANDO'
    ];

    public $search = '';
    public $file;
    public $showModal = false;
    public $editingId = null;
    public $form = [
        'usuario' => '',
        'fecha_fin' => '',
        'descripcion' => '',
        'es_cabecera' => false,
        'parent_id' => null,
        'es_indefinido' => false,
    ];

    public function render()
    {
        $this->ensureCategoriesExist();

        $query = Teletrabajo::query();

        if ($this->search) {
            $query->where('usuario', 'like', '%' . $this->search . '%');
        }

        // Ordenamos: Los padres van primero en su grupo, seguidos por sus hijos
        $teletrabajos = $query->orderByRaw('COALESCE(parent_id, id), es_cabecera DESC, id ASC')
            ->paginate(100); // Pagination higher for grouping visibility

        return view('livewire.teletrabajo-manager', [
            'teletrabajos' => $teletrabajos,
            'categorias' => Teletrabajo::where('es_cabecera', true)->get()
        ])->layout('layouts.app');
    }

    private function ensureCategoriesExist()
    {
        foreach (self::FIXED_CATEGORIES as $catName) {
            Teletrabajo::firstOrCreate(
                ['usuario' => $catName, 'es_cabecera' => true],
                ['parent_id' => null]
            );
        }
    }

    public function import()
    {
        $this->validate(['file' => 'required|mimes:xlsx,xls,csv|max:10240']);
        
        try {
            Excel::import(new TeletrabajosImport, $this->file->getRealPath());
            session()->flash('message', 'Teletrabajo importado con éxito.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al importar: ' . $e->getMessage());
        }
        
        $this->file = null;
    }

    public function export()
    {
        return Excel::download(new TeletrabajosExport, 'teletrabajo_it.xlsx');
    }

    public function edit($id = null)
    {
        try {
            $this->editingId = $id;
            if ($id) {
                $tele = Teletrabajo::findOrFail($id);
                $this->form = [
                    'usuario' => $tele->usuario,
                    'fecha_fin' => $tele->fecha_fin ? $tele->fecha_fin->format('Y-m-d') : '',
                    'descripcion' => $tele->descripcion,
                    'es_cabecera' => $tele->es_cabecera,
                    'parent_id' => $tele->parent_id,
                    'es_indefinido' => $tele->fecha_fin === null && !$tele->es_cabecera,
                ];
            } else {
                $this->form = [
                    'usuario' => '', 
                    'fecha_fin' => '', 
                    'descripcion' => '',
                    'es_cabecera' => false,
                    'parent_id' => null,
                    'es_indefinido' => false,
                ];
            }
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar el registro: ' . $e->getMessage());
        }
    }

    public function save()
    {
        $this->validate([
            'form.usuario' => 'required|min:3',
        ]);

        // Si no es una cabecera, calculamos el padre automáticamente por fecha
        if (!$this->form['es_cabecera']) {
            if ($this->form['es_indefinido']) {
                $this->form['fecha_fin'] = null;
            }
            $this->form['parent_id'] = $this->calculateParentIdFromDate($this->form['fecha_fin'], $this->form['es_indefinido']);
        }

        // Eliminamos campos auxiliares antes de guardar en DB si no existen en el modelo (aunque no da error si están en $fillable)
        $dbForm = $this->form;
        unset($dbForm['es_indefinido']);

        if ($this->editingId) {
            Teletrabajo::updateOrCreate(['id' => $this->editingId], $dbForm);
            session()->flash('message', 'Actualizado correctamente.');
        } else {
            Teletrabajo::create($dbForm);
            session()->flash('message', 'Creado correctamente.');
        }

        $this->closeModal();
    }

    private function calculateParentIdFromDate($dateString, $isIndefinite = false)
    {
        $categoryName = 'TELETRABAJANDO INDEFINIDO';
        
        if (!$isIndefinite && $dateString) {
            $date = \Carbon\Carbon::parse($dateString);
            if ($date->isPast() && !$date->isToday()) {
                $categoryName = 'NO TELETRABAJANDO';
            } else {
                $categoryName = 'TELETRABAJANDO';
            }
        }

        $category = Teletrabajo::where('usuario', $categoryName)
            ->where('es_cabecera', true)
            ->first();

        return $category ? $category->id : null;
    }

    public function updatedFormEsCabecera($value)
    {
        if ($value) {
            // Si es categoría, limpiamos campos de registro individual
            $this->form['fecha_fin'] = '';
            $this->form['descripcion'] = '';
            $this->form['parent_id'] = null;
        }
    }

    public function delete($id)
    {
        Teletrabajo::destroy($id);
        session()->flash('message', 'Eliminado correctamente.');
    }

    public function closeModal() { $this->showModal = false; }
}
