<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestamoOperacion extends Model
{
    protected $table = 'prestamo_operaciones';

    protected $fillable = [
        'prestamo_id',
        'tipo',
        'cargo',
        'abono',
        'saldo',
        'usuario_id',
        'descripcion'
    ];

    protected $casts = [
        'cargo' => 'decimal:2',
        'abono' => 'decimal:2',
        'saldo' => 'decimal:2'
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
