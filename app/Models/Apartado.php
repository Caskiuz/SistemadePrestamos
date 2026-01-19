<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'producto_id',
        'almacen_id',
        'anticipo',
        'saldo',
        'monto_total',
        'fecha_apartado',
        'fecha_vencimiento',
        'estado',
        'observaciones',
    ];
    
    protected $casts = [
        'fecha_apartado' => 'date',
        'fecha_vencimiento' => 'date',
        'anticipo' => 'decimal:2',
        'saldo' => 'decimal:2',
        'monto_total' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }
}
