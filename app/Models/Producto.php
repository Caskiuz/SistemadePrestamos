<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'tipo',
        'categoria',
        'marca',
        'modelo',
        'numero_serie',
        'descripcion',
        'peso',
        'quilates',
        'precio_compra',
        'precio_venta',
        'valuacion',
        'avaluo',
        'estado',
        'almacen_id',
        'foto'
    ];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id', 'id');
    }

    public function prestamos()
    {
        return $this->belongsToMany(Prestamo::class, 'prestamo_producto')
                    ->withPivot('valuacion')
                    ->withTimestamps();
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    public function apartados()
    {
        return $this->hasMany(Apartado::class);
    }

    public function fotos()
    {
        return $this->hasMany(FotoEquipo::class, 'equipo_id', 'id');
    }
}
