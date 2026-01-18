<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renovacion extends Model
{
    protected $table = 'renovaciones';
    
    protected $fillable = [
        'prestamo_original_id', 'prestamo_nuevo_id', 'monto_renovado',
        'intereses_pagados', 'fecha_renovacion', 'dias_extension',
        'observaciones', 'usuario_id'
    ];

    protected $casts = [
        'fecha_renovacion' => 'date',
        'monto_renovado' => 'decimal:2',
        'intereses_pagados' => 'decimal:2'
    ];

    public function prestamoOriginal()
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_original_id');
    }

    public function prestamoNuevo()
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_nuevo_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}