<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aval extends Model
{
    protected $table = 'avales';
    
    protected $fillable = [
        'prestamo_id', 'cliente_aval_id', 'tipo_aval', 'monto_garantizado',
        'estado', 'observaciones', 'fecha_constitucion', 'fecha_vencimiento'
    ];

    protected $casts = [
        'fecha_constitucion' => 'date',
        'fecha_vencimiento' => 'date',
        'monto_garantizado' => 'decimal:2'
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function clienteAval()
    {
        return $this->belongsTo(Cliente::class, 'cliente_aval_id');
    }
}

class SeguroPrenda extends Model
{
    protected $table = 'seguros_prendas';
    
    protected $fillable = [
        'prestamo_id', 'aseguradora', 'numero_poliza', 'valor_asegurado',
        'prima', 'fecha_inicio', 'fecha_vencimiento', 'estado', 'cobertura'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_vencimiento' => 'date',
        'valor_asegurado' => 'decimal:2',
        'prima' => 'decimal:2'
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
}

class GarantiaCruzada extends Model
{
    protected $table = 'garantias_cruzadas';
    
    protected $fillable = [
        'prestamo_principal_id', 'prestamo_garantia_id', 'porcentaje_garantia',
        'estado', 'condiciones'
    ];

    protected $casts = [
        'porcentaje_garantia' => 'decimal:2'
    ];

    public function prestamoPrincipal()
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_principal_id');
    }

    public function prestamoGarantia()
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_garantia_id');
    }
}