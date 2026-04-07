<?php

namespace App\Exports;

use App\Models\Asignacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AsignacionesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Asignacion::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre Empleado',
            'Red Cima (U)',
            'Red Cima (P)',
            'Correo (U)',
            'Correo (P)',
            'Correo P Sage',
            'Correo U (Reest)',
            'Correo P (Reest)',
            'Sage (U)',
            'Sage (P)',
            'ERP (U)',
            'ERP (P)',
            'GW107 (U)',
            'GW107 (P)',
            'Slack (U)',
            'Slack (P)',
            'Slack ID',
            'Hubspot (U)',
            'Hubspot (P)',
            'Microsoft (U)',
            'Trello (U)',
            'Zoom (U)',
            'Vodafone (U)',
            'ChatGPT (U)',
            'MRW (U)',
            'MRW (P)',
            'Pallet Ways (U)',
            'Pallet Ways (P)',
            'OpenProject (U)',
            'OpenProject (P)',
            'Creado',
            'Actualizado',
        ];
    }
}
