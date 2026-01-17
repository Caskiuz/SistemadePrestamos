<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportePrestamo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'prestamo_id',
        'fecha_reporte',
        'tipo',
        'detalle',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
}
