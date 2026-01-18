<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subasta extends Model
{
    protected $fillable = [
        'codigo', 'prestamo_id', 'precio_base', 'precio_actual',
        'fecha_inicio', 'fecha_fin', 'estado', 'descripcion', 'ganador_id'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'precio_base' => 'decimal:2',
        'precio_actual' => 'decimal:2'
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function ganador()
    {
        return $this->belongsTo(Cliente::class, 'ganador_id');
    }

    public function ofertas()
    {
        return $this->hasMany(Oferta::class)->orderBy('monto', 'desc');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($subasta) {
            if (empty($subasta->codigo)) {
                $ultimo = static::latest('id')->first();
                $numero = $ultimo ? $ultimo->id + 1 : 1;
                $subasta->codigo = 'S-' . str_pad($numero, 6, '0', STR_PAD_LEFT);
            }
        });
    }
}

class Oferta extends Model
{
    protected $fillable = [
        'subasta_id', 'cliente_id', 'monto', 'fecha_oferta', 'activa'
    ];

    protected $casts = [
        'fecha_oferta' => 'datetime',
        'monto' => 'decimal:2',
        'activa' => 'boolean'
    ];

    public function subasta()
    {
        return $this->belongsTo(Subasta::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}