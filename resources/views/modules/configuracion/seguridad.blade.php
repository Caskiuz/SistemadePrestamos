@extends('layouts.main')

@section('content')
<div class="main-content fade-in">
    <section class="section">
        <div class="section-header">
            <h1>Configuración de Seguridad</h1>
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
                        <h4>Configuración de Acceso y Auditoría</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('configuracion.actualizar') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Intentos de Login Fallidos</label>
                                        <input type="number" name="seguridad_intentos_login" class="form-control" 
                                               value="{{ $configuraciones['seguridad_intentos_login']->valor ?? '3' }}" 
                                               min="1" max="10">
                                        <small class="text-muted">Número de intentos fallidos antes de bloquear cuenta</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Retención de Logs (días)</label>
                                        <input type="number" name="seguridad_retencion_logs" class="form-control" 
                                               value="{{ $configuraciones['seguridad_retencion_logs']->valor ?? '90' }}" 
                                               min="30" max="365">
                                        <small class="text-muted">Días que se mantienen los logs del sistema</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Auditoría de Acciones</label>
                                        <select name="seguridad_auditoria" class="form-control">
                                            <option value="1" {{ ($configuraciones['seguridad_auditoria']->valor ?? '1') == '1' ? 'selected' : '' }}>Activada</option>
                                            <option value="0" {{ ($configuraciones['seguridad_auditoria']->valor ?? '1') == '0' ? 'selected' : '' }}>Desactivada</option>
                                        </select>
                                        <small class="text-muted">Registrar todas las acciones de usuarios en el sistema</small>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle"></i>
                                <strong>Importante:</strong> Los cambios en la configuración de seguridad afectan a todos los usuarios del sistema.
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-danger">
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