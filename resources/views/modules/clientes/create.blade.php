@extends('layouts.main')
@section('content')

<style>
/* Mobile-first responsive para formulario de cliente */
.client-form-container {
    padding: 15px;
    max-width: 100%;
}

.client-form-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    padding: 20px;
    margin-bottom: 20px;
}

.client-form-header {
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
    color: white;
    padding: 20px;
    border-radius: 15px 15px 0 0;
    margin: -20px -20px 20px -20px;
    text-align: center;
}

.client-form-header h1 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: #ffffff;
    box-sizing: border-box;
}

.form-control:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
    outline: none;
}

.form-control::placeholder {
    color: #9ca3af;
}

select.form-control {
    appearance: none;
    background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%23666" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 12px;
    padding-right: 40px;
}

.btn-group {
    display: flex;
    gap: 10px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.btn {
    flex: 1;
    min-width: 120px;
    padding: 12px 20px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
    display: inline-block;
}

.btn-primary {
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
}

.btn-default {
    background: #f3f4f6;
    color: #374151;
    border: 2px solid #e5e7eb;
}

.btn-default:hover {
    background: #e5e7eb;
    text-decoration: none;
    color: #374151;
}

/* Responsive */
@media (max-width: 768px) {
    .client-form-container {
        padding: 10px;
    }
    
    .client-form-card {
        padding: 15px;
        border-radius: 10px;
    }
    
    .client-form-header {
        padding: 15px;
        margin: -15px -15px 15px -15px;
    }
    
    .client-form-header h1 {
        font-size: 20px;
    }
    
    .form-control {
        padding: 10px 12px;
        font-size: 16px; /* Evita zoom en iOS */
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}

@media (min-width: 769px) {
    .client-form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 30px;
    }
    
    .client-form-card {
        padding: 30px;
    }
    
    .btn-group {
        justify-content: flex-end;
    }
    
    .btn {
        flex: none;
        min-width: 140px;
    }
}
</style>

<div class="client-form-container">
    <div class="client-form-card">
        <div class="client-form-header">
            <h1><i class="fa fa-user-plus"></i> Nuevo Cliente</h1>
        </div>
        
        <form action="{{ route('clientes.store') }}" method="POST" id="createClient">
            @csrf
            
            <div class="form-group">
                <label for="tipo">Tipo de cliente *</label>
                <select id="tipo" name="tipo" class="form-control" required>
                    <option value="">Seleccionar tipo...</option>
                    <option value="PERSONA">Persona</option>
                    <option value="EMPRESA">Empresa</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="nombre">Nombre completo *</label>
                <input required type="text" id="nombre" name="nombre" 
                       placeholder="Nombre completo del cliente" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="tipo_documento">Tipo de documento *</label>
                <select id="tipo_documento" name="tipo_documento" class="form-control" required>
                    <option value="">Seleccionar documento...</option>
                    <option value="CI">Cédula de Identidad (CI)</option>
                    <option value="NIT">NIT</option>
                    <option value="PASAPORTE">Pasaporte</option>
                    <option value="OTRO">Otro</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="numero_documento">Número de documento *</label>
                <input type="text" id="numero_documento" name="numero_documento" 
                       placeholder="Número de documento" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="telefono_1">Teléfono principal *</label>
                <input type="tel" id="telefono_1" name="telefono_1" 
                       placeholder="Teléfono principal" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="telefono_2">Teléfono secundario</label>
                <input type="tel" id="telefono_2" name="telefono_2" 
                       placeholder="Teléfono secundario (opcional)" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="telefono_3">Teléfono adicional</label>
                <input type="tel" id="telefono_3" name="telefono_3" 
                       placeholder="Teléfono adicional (opcional)" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" 
                       placeholder="correo@ejemplo.com" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <input type="text" id="ciudad" name="ciudad" 
                       placeholder="Ciudad" class="form-control" value="Santa Cruz">
            </div>
            
            <div class="form-group">
                <label for="direccion">Dirección *</label>
                <input type="text" id="direccion" name="direccion" 
                       placeholder="Dirección completa" class="form-control" required>
            </div>
            
            <div class="btn-group">
                <a href="{{ route('clientes.index') }}" class="btn btn-default">
                    <i class="fa fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
