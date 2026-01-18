<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = [
        'nombre', 'tipo', 'pasos', 'activo', 'descripcion'
    ];

    protected $casts = [
        'pasos' => 'array',
        'activo' => 'boolean'
    ];

    public function aprobaciones()
    {
        return $this->hasMany(Aprobacion::class);
    }
}

class Aprobacion extends Model
{
    protected $table = 'aprobaciones';
    
    protected $fillable = [
        'tipo_documento', 'documento_id', 'workflow_id', 'paso_actual',
        'estado', 'usuario_solicitante_id', 'usuario_aprobador_id',
        'comentarios', 'fecha_solicitud', 'fecha_aprobacion'
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_aprobacion' => 'datetime'
    ];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function usuarioSolicitante()
    {
        return $this->belongsTo(User::class, 'usuario_solicitante_id');
    }

    public function usuarioAprobador()
    {
        return $this->belongsTo(User::class, 'usuario_aprobador_id');
    }
}

class EstadoPrestamoWorkflow extends Model
{
    protected $table = 'estados_prestamo_workflow';
    
    protected $fillable = [
        'nombre', 'descripcion', 'color', 'es_final', 'transiciones_permitidas'
    ];

    protected $casts = [
        'es_final' => 'boolean',
        'transiciones_permitidas' => 'array'
    ];
}