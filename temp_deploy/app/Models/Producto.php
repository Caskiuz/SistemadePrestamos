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
}
