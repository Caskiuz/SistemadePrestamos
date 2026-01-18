@extends('layouts.main')

@section('content')
<div class="main-content fade-in">
    <section class="section">
        <div class="section-header">
            <h1>Configuración de Notificaciones</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('configuracion.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Alertas y Avisos Automáticos</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('configuracion.actualizar') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Días antes de vencimiento para alertar</label>
                                        <input type="number" name="notif_dias_vencimiento" class="form-control" 
                                               value="{{ $configuraciones['notif_dias_vencimiento']->valor ?? '3' }}" 
                                               min="1" max="30">
                                        <small class="text-muted">Cuántos días antes del vencimiento enviar alertas</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hora de envío de notificaciones</label>
                                        <input type="time" name="notif_hora_envio" class="form-control" 
                                               value="{{ $configuraciones['notif_hora_envio']->valor ?? '08:00' }}">
                                        <small class="text-muted">Hora del día para enviar notificaciones automáticas</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Notificaciones Automáticas</label>
                                        <select name="notif_automaticas" class="form-control">
                                            <option value="1" {{ ($configuraciones['notif_automaticas']->valor ?? '1') == '1' ? 'selected' : '' }}>Activadas</option>
                                            <option value="0" {{ ($configuraciones['notif_automaticas']->valor ?? '1') == '0' ? 'selected' : '' }}>Desactivadas</option>
                                        </select>
                                        <small class="text-muted">Activar o desactivar el sistema de notificaciones automáticas</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection