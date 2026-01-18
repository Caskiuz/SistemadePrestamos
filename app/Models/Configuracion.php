<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuraciones';
    
    protected $fillable = [
        'clave', 'valor', 'tipo', 'categoria', 'descripcion'
    ];

    public static function obtener($clave, $default = null)
    {
        $config = static::where('clave', $clave)->first();
        return $config ? $config->valor : $default;
    }

    public static function establecer($clave, $valor, $tipo = 'text', $categoria = 'general', $descripcion = null)
    {
        return static::updateOrCreate(
            ['clave' => $clave],
            [
                'valor' => $valor,
                'tipo' => $tipo,
                'categoria' => $categoria,
                'descripcion' => $descripcion
            ]
        );
    }

    public function getValorFormateadoAttribute()
    {
        switch ($this->tipo) {
            case 'boolean':
                return $this->valor ? 'Sí' : 'No';
            case 'number':
                return number_format($this->valor, 2);
            case 'json':
                return json_decode($this->valor, true);
            default:
                return $this->valor;
        }
    }
}