<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    protected $fillable = [
        'es_cabecera',
        'parent_id',
        'empleado_nombre',
        'red_cima_u',
        'red_cima_p',
        'correo_u',
        'correo_p',
        'correo_p_sage',
        'correo_u_reest',
        'correo_p_reest',
        'sage_u',
        'sage_p',
        'erp_u',
        'erp_p',
        'gw107_u',
        'gw107_p',
        'slack_u',
        'slack_p',
        'slack_id',
        'hubspot_u',
        'hubspot_p',
        'microsoft_u',
        'trello_u',
        'zoom_u',
        'vodafone_u',
        'chatgpt_u',
        'mrw_u',
        'mrw_p',
        'pallet_ways_u',
        'pallet_ways_p',
        'openproyect_u',
        'openproyect_p',
    ];

    public function category()
    {
        return $this->belongsTo(Asignacion::class, 'parent_id');
    }

    public function members()
    {
        return $this->hasMany(Asignacion::class, 'parent_id');
    }
}
