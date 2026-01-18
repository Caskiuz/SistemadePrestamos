<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $fillable = [
        'nombre', 'tipo', 'valor', 'aplicacion', 'activa', 'descripcion'
    ];

    protected $casts = [
        'activa' => 'boolean',
        'valor' => 'decimal:2'
    ];

    public function comisiones()
    {
        return $this->hasMany(Comision::class);
    }

    public function calcularMonto($base)
    {
        return $this->tipo === 'porcentaje' 
            ? ($base * $this->valor / 100)
            : $this->valor;
    }
}

class Comision extends Model
{
    protected $table = 'comisiones';
    
    protected $fillable = [
        'prestamo_id', 'tarifa_id', 'monto', 'fecha_aplicacion', 
        'concepto', 'usuario_id'
    ];

    protected $casts = [
        'fecha_aplicacion' => 'date',
        'monto' => 'decimal:2'
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function tarifa()
    {
        return $this->belongsTo(Tarifa::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}