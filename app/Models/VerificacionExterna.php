<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificacionExterna extends Model
{
    protected $table = 'verificaciones_externas';
    
    protected $fillable = [
        'cliente_id', 'tipo', 'servicio', 'datos_enviados',
        'respuesta', 'estado', 'resultado', 'observaciones', 'fecha_consulta'
    ];

    protected $casts = [
        'datos_enviados' => 'array',
        'respuesta' => 'array',
        'fecha_consulta' => 'datetime'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}