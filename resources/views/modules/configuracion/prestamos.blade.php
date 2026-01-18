@extends('layouts.main')

@section('content')
<div class="main-content fade-in">
    <section class="section">
        <div class="section-header">
            <h1>Configuración de Préstamos</h1>
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
                        <h4>Parámetros de Préstamos</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('configuracion.actualizar') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tasa de Interés Mensual (%)</label>
                                        <input type="number" name="prestamo_interes_mensual" class="form-control" 
                                               value="{{ $configuraciones['prestamo_interes_mensual']->valor ?? '10' }}" 
                                               step="0.1" min="0" max="100" required>
                                        <small class="text-muted">Porcentaje de interés mensual aplicado a los préstamos</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Plazo Estándar (días)</label>
                                        <input type="number" name="prestamo_plazo_dias" class="form-control" 
                                               value="{{ $configuraciones['prestamo_plazo_dias']->valor ?? '30' }}" 
                                               min="1" max="365" required>
                                        <small class="text-muted">Plazo por defecto para nuevos préstamos</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Monto Mínimo ($)</label>
                                        <input type="number" name="prestamo_monto_minimo" class="form-control" 
                                               value="{{ $configuraciones['prestamo_monto_minimo']->valor ?? '50' }}" 
                                               step="0.01" min="0" required>
                                        <small class="text-muted">Monto mínimo permitido para préstamos</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Monto Máximo ($)</label>
                                        <input type="number" name="prestamo_monto_maximo" class="form-control" 
                                               value="{{ $configuraciones['prestamo_monto_maximo']->valor ?? '50000' }}" 
                                               step="0.01" min="0" required>
                                        <small class="text-muted">Monto máximo permitido para préstamos</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Porcentaje Máximo sobre Avalúo (%)</label>
                                        <input type="number" name="prestamo_porcentaje_avaluo" class="form-control" 
                                               value="{{ $configuraciones['prestamo_porcentaje_avaluo']->valor ?? '70' }}" 
                                               min="1" max="100" required>
                                        <small class="text-muted">Porcentaje máximo del avalúo que se puede prestar</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">
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