@extends('layouts.main')

@section('content')
<div class="main-content fade-in">
    <section class="section">
        <div class="section-header">
            <h1>Configuración del Sistema</h1>
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
                        <h4>Configuración General del Sistema</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('configuracion.actualizar') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Frecuencia de Backup</label>
                                        <select name="sistema_backup_frecuencia" class="form-control">
                                            <option value="diario" {{ ($configuraciones['sistema_backup_frecuencia']->valor ?? 'diario') == 'diario' ? 'selected' : '' }}>Diario</option>
                                            <option value="semanal" {{ ($configuraciones['sistema_backup_frecuencia']->valor ?? 'diario') == 'semanal' ? 'selected' : '' }}>Semanal</option>
                                            <option value="mensual" {{ ($configuraciones['sistema_backup_frecuencia']->valor ?? 'diario') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                                        </select>
                                        <small class="text-muted">Frecuencia para generar backups automáticos</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Zona Horaria</label>
                                        <select name="sistema_zona_horaria" class="form-control">
                                            <option value="America/Caracas" {{ ($configuraciones['sistema_zona_horaria']->valor ?? 'America/Caracas') == 'America/Caracas' ? 'selected' : '' }}>Venezuela (UTC-4)</option>
                                            <option value="America/New_York" {{ ($configuraciones['sistema_zona_horaria']->valor ?? 'America/Caracas') == 'America/New_York' ? 'selected' : '' }}>New York (UTC-5)</option>
                                            <option value="America/Mexico_City" {{ ($configuraciones['sistema_zona_horaria']->valor ?? 'America/Caracas') == 'America/Mexico_City' ? 'selected' : '' }}>México (UTC-6)</option>
                                        </select>
                                        <small class="text-muted">Zona horaria del sistema</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Moneda del Sistema</label>
                                        <select name="sistema_moneda" class="form-control">
                                            <option value="USD" {{ ($configuraciones['sistema_moneda']->valor ?? 'USD') == 'USD' ? 'selected' : '' }}>Dólar (USD)</option>
                                            <option value="VES" {{ ($configuraciones['sistema_moneda']->valor ?? 'USD') == 'VES' ? 'selected' : '' }}>Bolívar (VES)</option>
                                            <option value="EUR" {{ ($configuraciones['sistema_moneda']->valor ?? 'USD') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                        </select>
                                        <small class="text-muted">Moneda principal para transacciones</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tiempo de Sesión (minutos)</label>
                                        <input type="number" name="sistema_tiempo_sesion" class="form-control" 
                                               value="{{ $configuraciones['sistema_tiempo_sesion']->valor ?? '120' }}" 
                                               min="30" max="480">
                                        <small class="text-muted">Tiempo antes de cerrar sesión automáticamente</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">
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