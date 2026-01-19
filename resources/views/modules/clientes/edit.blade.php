@extends('layouts.main')

@section('content')
<div class="mobile-header">
    <div class="mobile-header-content">
        <a href="{{ route('clientes.show', $cliente->id) }}" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>
        <div class="header-info">
            <h1>Editar Cliente</h1>
            <p>{{ $cliente->nombre }}</p>
        </div>
        <div class="status-badge status-edit">
            Editando
        </div>
    </div>
</div>

<div class="mobile-content">
    <div class="info-card">
        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="info-row">
                <span class="label">Tipo de cliente:</span>
                <select name="tipo" class="value-input" required>
                    <option value="">Seleccionar...</option>
                    <option value="PERSONA" {{ $cliente->tipo == 'PERSONA' ? 'selected' : '' }}>Persona</option>
                    <option value="EMPRESA" {{ $cliente->tipo == 'EMPRESA' ? 'selected' : '' }}>Empresa</option>
                </select>
            </div>
            
            <div class="info-row">
                <span class="label">Nombre:</span>
                <input type="text" name="nombre" value="{{ $cliente->nombre }}" class="value-input" required>
            </div>
            
            <div class="info-row">
                <span class="label">Tipo documento:</span>
                <select name="tipo_documento" class="value-input" required>
                    <option value="">Seleccionar...</option>
                    <option value="CI" {{ $cliente->tipo_documento == 'CI' ? 'selected' : '' }}>CI</option>
                    <option value="NIT" {{ $cliente->tipo_documento == 'NIT' ? 'selected' : '' }}>NIT</option>
                    <option value="PASAPORTE" {{ $cliente->tipo_documento == 'PASAPORTE' ? 'selected' : '' }}>Pasaporte</option>
                    <option value="OTRO" {{ $cliente->tipo_documento == 'OTRO' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            
            <div class="info-row">
                <span class="label">Número documento:</span>
                <input type="text" name="numero_documento" value="{{ $cliente->numero_documento }}" class="value-input" required>
            </div>
            
            <div class="info-row">
                <span class="label">Teléfono:</span>
                <input type="text" name="telefono_1" value="{{ $cliente->telefono_1 }}" class="value-input" required>
            </div>
            
            <div class="info-row">
                <span class="label">Dirección:</span>
                <input type="text" name="direccion" value="{{ $cliente->direccion }}" class="value-input" required>
            </div>
            
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Guardar Cambios
                </button>
                <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-secondary">
                    <i class="fa fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
/* Mobile-First Design - Copiado de inventario */
.mobile-header {
    background: linear-gradient(135deg, #5c6bc0 0%, #3f51b5 100%);
    color: white;
    padding: 15px;
    margin: -20px -20px 20px -20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.mobile-header-content {
    display: flex;
    align-items: center;
    gap: 15px;
}

.back-btn {
    color: white;
    font-size: 20px;
    text-decoration: none;
    padding: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.header-info {
    flex: 1;
}

.header-info h1 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.header-info p {
    margin: 2px 0 0 0;
    opacity: 0.9;
    font-size: 14px;
}

.mobile-content {
    padding: 0 5px;
}

.info-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-row:last-child {
    border-bottom: none;
}

.label {
    font-weight: 500;
    color: #666;
    min-width: 120px;
}

.value-input {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 14px;
    width: 60%;
    max-width: 250px;
}

.value-input:focus {
    outline: none;
    border-color: #5c6bc0;
    box-shadow: 0 0 0 2px rgba(92, 107, 192, 0.1);
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-edit {
    background: #fef3c7;
    color: #92400e;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin: 0 5px;
}

.btn-success {
    background: #16a34a;
    color: white;
}

.btn-success:hover {
    background: #15803d;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.text-center {
    text-align: center;
}

.mt-3 {
    margin-top: 20px;
}

/* Tablet adjustments */
@media (min-width: 768px) {
    .mobile-content {
        padding: 0 20px;
    }
    
    .info-card {
        padding: 25px;
        max-width: 600px;
        margin: 0 auto 20px auto;
    }
    
    .value-input {
        max-width: 300px;
    }
}
</style>
@endsection
