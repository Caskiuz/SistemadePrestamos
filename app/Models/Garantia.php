<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Garantia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'prestamo_id',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'observaciones',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
}
