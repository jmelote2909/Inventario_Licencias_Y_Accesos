<?php

namespace App\Exports;

use App\Models\Equipo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EquiposExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Equipo::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Centro',
            'Planta',
            'Zona',
            'Tipo Dispositivo',
            'Marca Dispositivo',
            'Modelo Dispositivo',
            'Nº Serie Dispositivo',
            'MAC Dispositivo',
            'Tipo Conexión',
            'Conectado a',
            'Compartida',
            'Código Empleado',
            'Nombre Empleado',
            'Mentor Empleado',
            'Taquilla Empleado',
            'Firefox',
            'Sage',
            'T-Plant',
            'T-Stock',
            'Instalado',
            'Estado',
            'Observaciones',
            'Fecha Creación',
            'Fecha Actualización',
        ];
    }
}
