@extends('layouts.main')

@section('content')
<div class="main-content fade-in">
    <section class="section">
        <div class="section-header">
            <h1>Configuración de Tarifas</h1>
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
                        <h4>Comisiones y Cargos</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('configuracion.actualizar') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Comisión por Préstamo (%)</label>
                                        <input type="number" name="tarifa_comision_prestamo" class="form-control" 
                                               value="{{ $configuraciones['tarifa_comision_prestamo']->valor ?? '2.5' }}" 
                                               step="0.1" min="0" max="100">
                                        <small class="text-muted">Porcentaje cobrado sobre el monto del préstamo</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tarifa de Almacenamiento ($)</label>
                                        <input type="number" name="tarifa_almacenamiento" class="form-control" 
                                               value="{{ $configuraciones['tarifa_almacenamiento']->valor ?? '10' }}" 
                                               step="0.01" min="0">
                                        <small class="text-muted">Tarifa mensual por almacenamiento de prendas</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Penalización por Mora (%)</label>
                                        <input type="number" name="tarifa_mora" class="form-control" 
                                               value="{{ $configuraciones['tarifa_mora']->valor ?? '5' }}" 
                                               step="0.1" min="0" max="100">
                                        <small class="text-muted">Porcentaje adicional por pagos tardíos</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Comisión por Renovación (%)</label>
                                        <input type="number" name="tarifa_renovacion" class="form-control" 
                                               value="{{ $configuraciones['tarifa_renovacion']->valor ?? '1' }}" 
                                               step="0.1" min="0" max="100">
                                        <small class="text-muted">Porcentaje cobrado por renovar un préstamo</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-warning">
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