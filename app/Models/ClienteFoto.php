<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteFoto extends Model
{
    protected $fillable = ['cliente_id', 'ruta'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
