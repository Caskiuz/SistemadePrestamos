<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    protected $fillable = [
        'codigo', 'almacen_origen_id', 'almacen_destino_id', 'producto_id',
        'motivo', 'observaciones', 'estado', 'fecha_envio', 'fecha_recepcion',
        'usuario_envia_id', 'usuario_recibe_id'
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
        'fecha_recepcion' => 'datetime'
    ];

    public function almacenOrigen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_origen_id');
    }

    public function almacenDestino()
    {
        return $this->belongsTo(Almacen::class, 'almacen_destino_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuarioEnvia()
    {
        return $this->belongsTo(User::class, 'usuario_envia_id');
    }

    public function usuarioRecibe()
    {
        return $this->belongsTo(User::class, 'usuario_recibe_id');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($transferencia) {
            if (empty($transferencia->codigo)) {
                $ultimo = static::latest('id')->first();
                $numero = $ultimo ? $ultimo->id + 1 : 1;
                $transferencia->codigo = 'T-' . str_pad($numero, 6, '0', STR_PAD_LEFT);
            }
        });
    }
}

class ConsolidadoSucursal extends Model
{
    protected $table = 'consolidados_sucursal';
    
    protected $fillable = [
        'almacen_id', 'fecha', 'prestamos_activos', 'monto_prestamos_activos',
        'prestamos_liquidados', 'ingresos_intereses', 'productos_inventario',
        'valor_inventario'
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto_prestamos_activos' => 'decimal:2',
        'ingresos_intereses' => 'decimal:2',
        'valor_inventario' => 'decimal:2'
    ];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }
}