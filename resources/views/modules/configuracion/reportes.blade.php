@extends('layouts.main')

@section('content')
<div class="main-content fade-in">
    <section class="section">
        <div class="section-header">
            <h1>Configuración de Reportes</h1>
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
                        <h4>Formatos y Automatización de Reportes</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('configuracion.actualizar') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Formato de Exportación por Defecto</label>
                                        <select name="reportes_formato_default" class="form-control">
                                            <option value="pdf" {{ ($configuraciones['reportes_formato_default']->valor ?? 'pdf') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                            <option value="excel" {{ ($configuraciones['reportes_formato_default']->valor ?? 'pdf') == 'excel' ? 'selected' : '' }}>Excel</option>
                                            <option value="csv" {{ ($configuraciones['reportes_formato_default']->valor ?? 'pdf') == 'csv' ? 'selected' : '' }}>CSV</option>
                                        </select>
                                        <small class="text-muted">Formato por defecto para exportar reportes</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Reportes Automáticos</label>
                                        <select name="reportes_automaticos" class="form-control">
                                            <option value="1" {{ ($configuraciones['reportes_automaticos']->valor ?? '0') == '1' ? 'selected' : '' }}>Activados</option>
                                            <option value="0" {{ ($configuraciones['reportes_automaticos']->valor ?? '0') == '0' ? 'selected' : '' }}>Desactivados</option>
                                        </select>
                                        <small class="text-muted">Generar reportes automáticamente de forma periódica</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Frecuencia de Reportes Automáticos</label>
                                        <select name="reportes_frecuencia" class="form-control">
                                            <option value="diario" {{ ($configuraciones['reportes_frecuencia']->valor ?? 'semanal') == 'diario' ? 'selected' : '' }}>Diario</option>
                                            <option value="semanal" {{ ($configuraciones['reportes_frecuencia']->valor ?? 'semanal') == 'semanal' ? 'selected' : '' }}>Semanal</option>
                                            <option value="mensual" {{ ($configuraciones['reportes_frecuencia']->valor ?? 'semanal') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                                        </select>
                                        <small class="text-muted">Con qué frecuencia generar reportes automáticos</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email para Reportes</label>
                                        <input type="email" name="reportes_email" class="form-control" 
                                               value="{{ $configuraciones['reportes_email']->valor ?? '' }}" 
                                               placeholder="gerencia@empresa.com">
                                        <small class="text-muted">Email donde enviar reportes automáticos</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-purple">
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

<style>
.btn-purple {
    background-color: #6f42c1;
    border-color: #6f42c1;
    color: #fff;
}
.btn-purple:hover {
    background-color: #5a32a3;
    border-color: #5a32a3;
    color: #fff;
}
</style>
@endsection