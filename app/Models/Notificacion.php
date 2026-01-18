<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    
    protected $fillable = [
        'tipo', 'titulo', 'mensaje', 'prestamo_id', 'cliente_id',
        'enviada', 'fecha_envio', 'canal'
    ];

    protected $casts = [
        'enviada' => 'boolean',
        'fecha_envio' => 'datetime'
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}