<?php

namespace App\Imports;

use App\Models\Teletrabajo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon;

class TeletrabajosImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'TELETRABAJO' => new TeletrabajoSheetImport(),
        ];
    }
}

class TeletrabajoSheetImport implements ToModel
{
    private $rowsProcessed = 0;
    private $categoryIds = [];

    private function getCategoryId($name)
    {
        if (!isset($this->categoryIds[$name])) {
            $cat = Teletrabajo::where('usuario', $name)
                ->where('es_cabecera', true)
                ->first();
            $this->categoryIds[$name] = $cat ? $cat->id : null;
        }
        return $this->categoryIds[$name];
    }

    public function model(array $row)
    {
        $this->rowsProcessed++;

        // Saltamos filas totalmente vacías
        if (empty(array_filter($row))) {
            return null;
        }

        $usuario = ($row[0] ?? '');
        $usuarioClean = trim(strtoupper($usuario));
        $fechaRaw = $row[1] ?? null;
        $descripcion = $row[2] ?? null;

        // Si la fila coincide exactamente con el nombre de una categoría fija (es un encabezado en el excel), la saltamos
        if (in_array($usuarioClean, \App\Livewire\TeletrabajoManager::FIXED_CATEGORIES)) {
            return null;
        }

        // Saltamos el título general o filas que no tengan usuario real
        if (!$usuario || str_contains(strtolower($usuario), 'usuarios con')) {
            return null;
        }

        // Parseamos la fecha
        $fechaFin = null;
        if ($fechaRaw) {
            try {
                if (is_numeric($fechaRaw)) {
                    $fechaFin = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaRaw));
                } else {
                    $fechaFin = Carbon::parse($fechaRaw);
                }
            } catch (\Exception $e) {
                $fechaFin = null;
            }
        }

        // LÓGICA DE CATEGORIZACIÓN AUTOMÁTICA
        // 1. Si no tiene fecha -> INDEFINIDO
        // 2. Si tiene fecha y es antes de hoy -> NO TELETRABAJO
        // 3. Si tiene fecha y es hoy o después -> TELETRABAJANDO
        
        $categoryName = 'TELETRABAJANDO INDEFINIDO';
        if ($fechaFin) {
            // Usamos startOfDay para comparar solo la fecha, sin la hora
            if ($fechaFin->isPast() && !$fechaFin->isToday()) {
                $categoryName = 'NO TELETRABAJANDO';
            } else {
                $categoryName = 'TELETRABAJANDO';
            }
        }

        $parentId = $this->getCategoryId($categoryName);

        return new Teletrabajo([
            'es_cabecera' => false,
            'parent_id'   => $parentId,
            'usuario'     => trim($usuario),
            'fecha_fin'   => $fechaFin,
            'descripcion' => $descripcion,
        ]);
    }
}
