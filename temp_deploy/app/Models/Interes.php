<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interes extends Model
{
    protected $table = 'intereses';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'porcentaje',
        'descripcion',
        'activo',
    ];
}
