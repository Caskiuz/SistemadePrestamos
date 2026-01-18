<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $fillable = [
        'nombre', 'ruta', 'tamaño', 'tipo', 'estado',
        'fecha_backup', 'usuario_id'
    ];

    protected $casts = [
        'fecha_backup' => 'datetime'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function getTamañoFormateadoAttribute()
    {
        $bytes = $this->tamaño;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}