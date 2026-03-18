<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $fillable = [
        'nombre',
        'centro',
        'planta',
        'zona',
        'dispositivotipo',
        'dispositivomarca',
        'dispositivomodelo',
        'dispositivoserial',
        'dispositivomac',
        'tipoconexion',
        'conectado_a',
        'compartida',
        'empleadocodigo',
        'empleadonombre',
        'empleadomentor',
        'empleado_taquilla',
        'firefox',
        'sage',
        't_plant',
        't_stock',
        'instalado',
        'estado',
        'observaciones',
    ];
}
