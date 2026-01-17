@extends('layouts.main')

@section('content')
<header class="yp-header" style="background: #5c6bc0;">
    <h1>
        <a href="{{ route('clientes.show', $cliente->id) }}" style="color: white; text-decoration: none;">
            <i class="fa fa-arrow-left"></i>
        </a>
        <span style="color: white;">Editar cliente</span>
    </h1>
</header>

<section class="content" style="padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto;">
        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ $cliente->nombre }}" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $cliente->email }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Teléfono 1</label>
                <input type="text" name="telefono_1" value="{{ $cliente->telefono_1 }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Teléfono 2</label>
                <input type="text" name="telefono_2" value="{{ $cliente->telefono_2 }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" value="{{ $cliente->direccion }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Ciudad</label>
                <input type="text" name="ciudad" value="{{ $cliente->ciudad }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Tipo de documento</label>
                <select name="tipo_documento" class="form-control">
                    <option value="">Seleccionar</option>
                    <option value="DNI" {{ $cliente->tipo_documento == 'DNI' ? 'selected' : '' }}>DNI</option>
                    <option value="Pasaporte" {{ $cliente->tipo_documento == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                    <option value="Licencia" {{ $cliente->tipo_documento == 'Licencia' ? 'selected' : '' }}>Licencia</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Número de documento</label>
                <input type="text" name="numero_documento" value="{{ $cliente->numero_documento }}" class="form-control">
            </div>
            
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Guardar cambios</button>
                <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-secondary" style="flex: 1;">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection
