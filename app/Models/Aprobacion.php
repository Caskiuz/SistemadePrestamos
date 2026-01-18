<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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