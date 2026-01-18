<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table = 'auditoria';
    
    protected $fillable = [
        'tabla', 'accion', 'registro_id', 'datos_anteriores',
        'datos_nuevos', 'usuario_id', 'ip', 'user_agent'
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}

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