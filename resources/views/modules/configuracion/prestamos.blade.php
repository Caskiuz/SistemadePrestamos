@extends('layouts.main')

@section('content')
<x-mobile-header title="Configuración de Préstamos" backUrl="{{ route('configuracion.index') }}" />

<div class="mobile-content">
    <div class="card-mobile">
        <form method="POST" action="{{ route('configuracion.actualizar') }}">
            @csrf
            @method('PUT')
            
            <div class="section">
                <h3>Parámetros de Préstamos</h3>
                
                <div class="form-group mb-3">
                    <label class="form-label">Tasa de Interés Mensual (%)</label>
                    <input type="number" name="prestamo_interes_mensual" class="form-control" 
                           value="{{ $configuraciones['prestamo_interes_mensual']->valor ?? '10' }}" 
                           step="0.1" min="0" max="100" required>
                    <small class="text-muted">Porcentaje de interés mensual aplicado a los préstamos</small>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Plazo Estándar (días)</label>
                    <input type="number" name="prestamo_plazo_dias" class="form-control" 
                           value="{{ $configuraciones['prestamo_plazo_dias']->valor ?? '30' }}" 
                           min="1" max="365" required>
                    <small class="text-muted">Plazo por defecto para nuevos préstamos</small>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Monto Mínimo (Bs)</label>
                    <input type="number" name="prestamo_monto_minimo" class="form-control" 
                           value="{{ $configuraciones['prestamo_monto_minimo']->valor ?? '50' }}" 
                           step="0.01" min="0" required>
                    <small class="text-muted">Monto mínimo permitido para préstamos</small>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Monto Máximo (Bs)</label>
                    <input type="number" name="prestamo_monto_maximo" class="form-control" 
                           value="{{ $configuraciones['prestamo_monto_maximo']->valor ?? '50000' }}" 
                           step="0.01" min="0" required>
                    <small class="text-muted">Monto máximo permitido para préstamos</small>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Porcentaje Máximo sobre Avalúo (%)</label>
                    <input type="number" name="prestamo_porcentaje_avaluo" class="form-control" 
                           value="{{ $configuraciones['prestamo_porcentaje_avaluo']->valor ?? '70' }}" 
                           min="1" max="100" required>
                    <small class="text-muted">Porcentaje máximo del avalúo que se puede prestar</small>
                </div>
            </div>
            
            <div class="action-grid">
                <button type="submit" class="btn-mobile success">
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