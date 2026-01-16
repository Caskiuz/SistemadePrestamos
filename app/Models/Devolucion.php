<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devolucion extends Model
{
    protected $table = 'devoluciones';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'prestamo_id',
        'fecha_devolucion',
        'estado',
        'observaciones',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
}
