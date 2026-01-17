<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    protected $table = 'cash_flow';
    
    protected $fillable = [
        'fecha',
        'usuario_id',
        'concepto',
        'detalles',
        'monto',
        'tipo_movimiento',
        'branch_id'
    ];
    
    protected $casts = [
        'fecha' => 'datetime',
        'monto' => 'decimal:2'
    ];
    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
