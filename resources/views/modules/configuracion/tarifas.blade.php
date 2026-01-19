@extends('layouts.main')

@section('content')
<x-mobile-header title="Configuración de Tarifas" backUrl="{{ route('configuracion.index') }}" />

<div class="mobile-content">
    <div class="card-mobile">
        <form method="POST" action="{{ route('configuracion.actualizar') }}">
            @csrf
            @method('PUT')
            
            <div class="section">
                <h3>Comisiones y Cargos</h3>
                
                <div class="form-group mb-3">
                    <label class="form-label">Comisión por Préstamo (%)</label>
                    <input type="number" name="tarifa_comision_prestamo" class="form-control" 
                           value="{{ $configuraciones['tarifa_comision_prestamo']->valor ?? '2.5' }}" 
                           step="0.1" min="0" max="100">
                    <small class="text-muted">Porcentaje cobrado sobre el monto del préstamo</small>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Tarifa de Almacenamiento (Bs)</label>
                    <input type="number" name="tarifa_almacenamiento" class="form-control" 
                           value="{{ $configuraciones['tarifa_almacenamiento']->valor ?? '10' }}" 
                           step="0.01" min="0">
                    <small class="text-muted">Tarifa mensual por almacenamiento de prendas</small>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Penalización por Mora (%)</label>
                    <input type="number" name="tarifa_mora" class="form-control" 
                           value="{{ $configuraciones['tarifa_mora']->valor ?? '5' }}" 
                           step="0.1" min="0" max="100">
                    <small class="text-muted">Porcentaje adicional por pagos tardíos</small>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Comisión por Renovación (%)</label>
                    <input type="number" name="tarifa_renovacion" class="form-control" 
                           value="{{ $configuraciones['tarifa_renovacion']->valor ?? '1' }}" 
                           step="0.1" min="0" max="100">
                    <small class="text-muted">Porcentaje cobrado por renovar un préstamo</small>
                </div>
            </div>
            
            <div class="action-grid">
                <button type="submit" class="btn-mobile warning">
                    <i class="fa fa-save"></i>
                    <span>Guardar</span>
                </button>
                <a href="{{ route('configuracion.index') }}" class="btn-mobile outline">
                    <i class="fa fa-arrow-left"></i>
                    <span>Volver</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection