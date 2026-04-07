<?php

namespace App\Imports;

use App\Models\Asignacion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Illuminate\Support\Facades\Log;

class AsignacionesImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            // El usuario indica que es la hoja de asignación. 
            // Usaremos un índice o nombre si es posible. 
            // Por defecto, procesamos la hoja que coincida con patrones de 'asignacion'
            0 => new AsignacionCredencialesImport(),
        ];
    }
}

class AsignacionCredencialesImport implements ToModel, WithHeadingRow, WithEvents
{
    private $sheetName = '';
    private $currentParentId = null;

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();
                Log::info('AsignacionesImport: Iniciando hoja -> ' . $this->sheetName);
                $this->currentParentId = null; // Reiniciar por cada hoja
            },
        ];
    }

    public function model(array $row)
    {
        $get = function($keys, $row) {
            foreach ((array)$keys as $k) {
                $slug = str_replace([' ', '-', '/', '_', '(', ')', '.', '+'], '', strtolower($k));
                foreach ($row as $rowKey => $value) {
                    $slugRow = str_replace([' ', '-', '/', '_', '(', ')', '.', '+'], '', strtolower($rowKey));
                    if ($slug == $slugRow) return $value;
                }
            }
            return null;
        };

        // Identificar al empleado (primera columna habitualmente)
        $nombre = $get(['nombre', 'empleado', '0', ''], $row) ?? reset($row);
        $nombre = trim($nombre);

        if (!$nombre) {
            return null;
        }

        // Detectar si es un subencabezado (fila gris en el Excel)
        // La regla solicitada por el usuario: solo el nombre/grupo está relleno, el resto vacío.
        $r_values = array_filter($row, function($v) {
            return !is_null($v) && trim((string)$v) !== '';
        });

        if (count($r_values) === 1) {
            $cabecera = Asignacion::create([
                'empleado_nombre' => $nombre,
                'es_cabecera'     => true,
            ]);
            $this->currentParentId = $cabecera->id;
            return null; // Ya lo creamos manualmente para obtener el ID
        }

        return new Asignacion([
            'parent_id'       => $this->currentParentId,
            'empleado_nombre' => trim($nombre),
            'red_cima_u'      => $get(['redcimacableados', 'redcimacableadosu', 'red_cima_u'], $row),
            'red_cima_p'      => $get(['redcimacableadosp', 'red_cima_p'], $row),
            'correo_u'        => $get(['correoelectronicou', 'correo_u'], $row),
            'correo_p'        => $get(['correoelectronicop', 'correo_p'], $row),
            'correo_p_sage'   => $get(['correoelectronicopsage', 'correo_p_sage'], $row),
            'correo_u_reest'  => $get(['correoelectronicoureest', 'correo_u_reest'], $row),
            'correo_p_reest'  => $get(['correoelectronicopreest', 'correo_p_reest'], $row),
            'sage_u'          => $get(['sageu', 'sage_u'], $row),
            'sage_p'          => $get(['sagep', 'sage_p'], $row),
            'erp_u'           => $get(['erpu', 'erp_u'], $row),
            'erp_p'           => $get(['erpp', 'erp_p'], $row),
            'gw107_u'         => $get(['gw107u', 'gw107_u'], $row),
            'gw107_p'         => $get(['gw107p', 'gw107_p'], $row),
            'slack_u'         => $get(['slacku', 'slack_u'], $row),
            'slack_p'         => $get(['slackp', 'slack_p'], $row),
            'slack_id'        => $get(['slackidentificador', 'slack_id'], $row),
            'hubspot_u'       => $get(['hubspotu', 'hubspot_u'], $row),
            'hubspot_p'       => $get(['hubspotp', 'hubspot_p'], $row),
            'microsoft_u'     => $get(['microsoftu', 'microsoft_u'], $row),
            'trello_u'        => $get(['trellou', 'trello_u'], $row),
            'zoom_u'          => $get(['zoomu', 'zoom_u'], $row),
            'vodafone_u'      => $get(['vodafoneu', 'vodafone_u'], $row),
            'chatgpt_u'       => $get(['chatgptu', 'chatgpt_u'], $row),
            'mrw_u'           => $get(['mrwu', 'mrw_u'], $row),
            'mrw_p'           => $get(['mrwp', 'mrw_p'], $row),
            'pallet_ways_u'   => $get(['palletwaysu', 'pallet_ways_u'], $row),
            'pallet_ways_p'   => $get(['palletwaysp', 'pallet_ways_p'], $row),
            'openproyect_u'   => $get(['openproyectu', 'openproyect_u'], $row),
            'openproyect_p'   => $get(['openproyectp', 'openproyect_p'], $row),
        ]);
    }
}
