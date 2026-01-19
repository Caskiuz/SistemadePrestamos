@extends('layouts.main')

@section('content')
<x-mobile-header title="Clientes" />

<div class="mobile-content">
    @if($clientes->isEmpty() && !request('q'))
        <div class="empty-state">
            <i class="fa fa-user-plus"></i>
            <h4>Registra tu primer cliente</h4>
            <p>Para poder crear préstamos necesitas clientes</p>
            <button onclick="openModal()" class="action-btn primary">
                <i class="fa fa-plus"></i>
                <span>Nuevo Cliente</span>
            </button>
        </div>
    @else
        <x-search-box 
            placeholder="Buscar cliente"
            route="clientes.index"
            :value="request('q')" />

        <div class="list-mobile">
            @foreach($clientes as $cliente)
            <a href="{{ route('clientes.show', $cliente->id) }}" class="list-item">
                <div class="list-item-header">
                    <div>
                        <h4 class="list-item-title">{{ $cliente->nombre }}</h4>
                        <span class="list-item-subtitle">{{ $cliente->tipo ?? 'Cliente' }}</span>
                    </div>
                    <div class="client-score">
                        @for($i = 0; $i < 5; $i++)
                            @if($i < ($cliente->puntuacion ?? 5))
                                <span class="ball green"></span>
                            @else
                                <span class="ball gray"></span>
                            @endif
                        @endfor
                    </div>
                </div>
                
                <div class="client-info">
                    <div class="info-item">
                        <i class="fa fa-phone"></i>
                        <span>{{ $cliente->telefono_1 ?? 'Sin teléfono' }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fa fa-map-marker"></i>
                        <span>{{ $cliente->direccion ?? 'Sin dirección' }}</span>
                    </div>
                </div>

                <div class="list-item-footer">
                    <i class="fa fa-id-card"></i>
                    <span>{{ $cliente->tipo_documento ?? 'CI' }}: {{ $cliente->numero_documento ?? 'Sin documento' }}</span>
                </div>
            </a>
            @endforeach
        </div>

        @if($clientes->hasPages())
        <div class="pagination-wrapper">
            {{ $clientes->links() }}
        </div>
        @endif
    @endif
</div>

<!-- Modal Nuevo Cliente -->
<div id="modalCliente" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: #2c3e50; color: white; width: 90%; max-width: 600px; border-radius: 8px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0;">Nuevo cliente</h3>
            <button onclick="closeModal()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
        </div>
        <form action="{{ route('clientes.store') }}" method="POST" style="padding: 20px;">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Tipo de cliente</label>
                <select name="tipo" required style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;">
                    <option value="">Seleccionar...</option>
                    <option value="PERSONA">Persona</option>
                    <option value="EMPRESA">Empresa</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Nombre completo</label>
                <input type="text" name="nombre" required style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="Nombre completo del cliente">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Tipo de documento</label>
                <select name="tipo_documento" required style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;">
                    <option value="">Seleccionar...</option>
                    <option value="CI">Cédula de Identidad (CI)</option>
                    <option value="NIT">NIT</option>
                    <option value="PASAPORTE">Pasaporte</option>
                    <option value="OTRO">Otro</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Número de documento</label>
                <input type="text" name="numero_documento" required style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="Número de documento">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Correo electrónico</label>
                <input type="email" name="email" style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="correo@ejemplo.com">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Teléfono principal</label>
                <input type="tel" name="telefono_1" required style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="Teléfono principal">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Teléfono secundario</label>
                <input type="tel" name="telefono_2" style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="Teléfono secundario (opcional)">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Teléfono adicional</label>
                <input type="tel" name="telefono_3" style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="Teléfono adicional (opcional)">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Ciudad</label>
                <input type="text" name="ciudad" style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="Ciudad" value="Santa Cruz">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Dirección</label>
                <input type="text" name="direccion" required style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="Dirección completa">
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeModal()" style="padding: 10px 20px; background: #7f8c8d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                <button type="submit" style="padding: 10px 20px; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar</button>
            </div>
        </form>
    </div>
</div>

<style>
.client-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 15px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: var(--gray-600);
}

.info-item i {
    width: 16px;
    color: var(--gray-500);
}

.client-score {
    display: flex;
    gap: 3px;
    align-items: center;
}

.ball {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
}

.ball.green {
    background-color: #10b981;
}

.ball.gray {
    background-color: #d1d5db;
}

.pagination-wrapper {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}
</style>

<script>
function openModal() {
    document.getElementById('modalCliente').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modalCliente').style.display = 'none';
}

// Cerrar modal al hacer clic fuera
document.getElementById('modalCliente').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection
