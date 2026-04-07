<?php

namespace App\Exports;

use App\Models\Teletrabajo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeletrabajosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Teletrabajo::all();
    }

    public function headings(): array
    {
        return [
            'Usuario',
            'Fecha de Fin',
            'Descripción',
        ];
    }

    public function map($teletrabajo): array
    {
        return [
            $teletrabajo->usuario,
            $teletrabajo->fecha_fin ? $teletrabajo->fecha_fin->format('d/m/Y') : '-',
            $teletrabajo->descripcion,
        ];
    }
}
