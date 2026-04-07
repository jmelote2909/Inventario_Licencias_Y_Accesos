<?php

namespace App\Imports;

use App\Models\Equipo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Illuminate\Support\Facades\Log;

class EquiposImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        Log::info('EquiposImport: Iniciando proceso por múltiples hojas.');
        $import = new EquiposDispositivosImport();
        return [
            1 => $import, // Basado en el usuario: la segunda hoja es Dispositivos
        ];
    }
}

class EquiposDispositivosImport implements ToModel, WithHeadingRow, WithEvents
{
    private $sheetName = '';

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();
                Log::info('EquiposImport: Abriendo hoja -> ' . $this->sheetName);
            },
        ];
    }

    public function model(array $row)
    {
        // Función auxiliar para buscar claves de forma flexible
        $get = function($keys, $row) {
            foreach ((array)$keys as $k) {
                $slug = str_replace([' ', '-', '/', '_'], '', strtolower($k));
                foreach ($row as $rowKey => $value) {
                    $slugRow = str_replace([' ', '-', '/', '_'], '', strtolower($rowKey));
                    if ($slug == $slugRow) return $value;
                }
            }
            return null;
        };

        // El primer valor suele ser el nombre (primera columna sin nombre)
        $nombre = $get(['nombre', 'dispositivo', '0', ''], $row) ?? reset($row);
        $nombre = trim($nombre);

        // Saltar cabeceras o filas vacías
        if (!$nombre || in_array(strtolower($nombre), ['dispositivo', 'centro', 'planta', 'zona', 'estado'])) {
            return null;
        }

        return new Equipo([
            'nombre'            => $nombre,
            'centro'            => $get(['centro'], $row),
            'planta'            => $get(['planta'], $row),
            'zona'              => $get(['zona'], $row),
            'estado'            => $get(['estado'], $row) ?? 'disponible',
            'dispositivotipo'   => $get(['dispositivotipo', 'tipo_dispositivo', 'dispositivo_tipo'], $row),
            'dispositivomarca'  => $get(['dispositivomarca', 'marca_dispositivo', 'dispositivo_marca'], $row),
            'dispositivomodelo' => $get(['dispositivomodelo', 'modelo_dispositivo', 'dispositivo_modelo'], $row),
            'dispositivoserial' => $get(['dispositivoserial', 'serial_dispositivo', 'dispositivo_serial'], $row),
            'dispositivomac'    => $get(['dispositivomac', 'mac_dispositivo', 'dispositivo_mac'], $row),
            'tipoconexion'      => $get(['tipoconexion', 'tipo_conexion'], $row),
            'conectado_a'       => $get(['conectadoa', 'conectado_a'], $row),
            'compartida'        => in_array(strtolower($get(['compartida'], $row) ?? ''), ['sí', 'si', '1', 'true', 'yes']),
            'empleadocodigo'    => $get(['empleadocodigo', 'codigo_empleado', 'empleado_codigo'], $row),
            'empleadonombre'    => $get(['empleadonombre', 'nombre_empleado', 'empleado_nombre', 'empleadonommbre'], $row),
            'empleadomentor'    => $get(['empleadomentor', 'mentor_empleado', 'empleado_mentor'], $row),
            'empleado_taquilla' => $get(['empleadotaquilla', 'taquilla_empleado', 'empleado_taquilla'], $row),
            'firefox'           => $get(['firefox'], $row),
            'sage'              => $get(['sage'], $row),
            't_plant'           => $get(['tplant', 't_plant', 't-plant'], $row),
            't_stock'           => $get(['tstock', 't_stock', 't-stock'], $row),
            'instalado'         => $get(['instalado'], $row),
        ]);
    }
}
