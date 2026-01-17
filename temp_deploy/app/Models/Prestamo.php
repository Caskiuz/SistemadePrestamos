<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestamo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'folio',
        'cliente_id',
        'almacen_id',
        'interes_id',
        'monto',
        'interes_mensual',
        'monto_total',
        'monto_pagado',
        'monto_pendiente',
        'fecha_prestamo',
        'fecha_vencimiento',
        'plazo_dias',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_vencimiento' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'prestamo_producto')
                    ->withPivot('valuacion')
                    ->withTimestamps();
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function interes()
    {
        return $this->belongsTo(Interes::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function operaciones()
    {
        return $this->hasMany(PrestamoOperacion::class)->orderBy('created_at', 'asc');
    }

    // Generar folio automático
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($prestamo) {
            if (empty($prestamo->folio)) {
                $ultimo = static::withTrashed()->latest('id')->first();
                $numero = $ultimo ? $ultimo->id + 1 : 1;
                $prestamo->folio = 'P-' . str_pad($numero, 6, '0', STR_PAD_LEFT);
            }
        });
    }
}
