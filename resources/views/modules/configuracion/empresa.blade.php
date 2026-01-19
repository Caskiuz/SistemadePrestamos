@extends('layouts.main')

@section('content')
<x-mobile-header title="Configuración de Empresa" backUrl="{{ route('configuracion.index') }}" />

<div class="mobile-content">
    <div class="card-mobile">
        <form method="POST" action="{{ route('configuracion.actualizar') }}">
            @csrf
            @method('PUT')
            
            <div class="section">
                <h3>Información Corporativa</h3>
                
                <div class="form-group mb-3">
                    <label class="form-label">Nombre de la Empresa</label>
                    <input type="text" name="empresa_nombre" class="form-control" 
                           value="{{ $configuraciones['empresa_nombre']->valor ?? '' }}" required>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">RIF/NIT</label>
                    <input type="text" name="empresa_rif" class="form-control" 
                           value="{{ $configuraciones['empresa_rif']->valor ?? '' }}">
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Dirección Principal</label>
                    <textarea name="empresa_direccion" class="form-control" rows="3">{{ $configuraciones['empresa_direccion']->valor ?? '' }}</textarea>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Teléfono Principal</label>
                    <input type="text" name="empresa_telefono" class="form-control" 
                           value="{{ $configuraciones['empresa_telefono']->valor ?? '' }}">
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">Email Corporativo</label>
                    <input type="email" name="empresa_email" class="form-control" 
                           value="{{ $configuraciones['empresa_email']->valor ?? '' }}">
                </div>
            </div>
            
            <div class="action-grid">
                <button type="submit" class="btn-mobile primary">
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