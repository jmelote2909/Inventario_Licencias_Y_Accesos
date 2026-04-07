<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teletrabajo extends Model
{
    protected $fillable = [
        'es_cabecera',
        'parent_id',
        'usuario',
        'fecha_fin',
        'descripcion',
    ];

    protected $casts = [
        'es_cabecera' => 'boolean',
        'fecha_fin' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Teletrabajo::class, 'parent_id');
    }

    public function members()
    {
        return $this->hasMany(Teletrabajo::class, 'parent_id');
    }
}
