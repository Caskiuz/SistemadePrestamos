<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes';

    protected $fillable = [
        'nombre',
        'direccion',
    ];

    // Relación con Equipos
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    // Relación con Productos
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    // Relación con Compras
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    // Relación con Ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}