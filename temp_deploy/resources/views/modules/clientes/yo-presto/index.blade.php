@extends('layouts.main')
@section('content')
<header class="yp-header">
    <h1><i class="fa fa-user"></i> <span>Clientes</span></h1>
</header>

<section class="content">
    <button onclick="openModal()" class="action red" title="Nuevo cliente" style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; background: #e74c3c; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 4px 8px rgba(0,0,0,0.3); z-index: 999; border: none; cursor: pointer;">
        <i class="fa fa-plus"></i>
    </button>
    
    <form class="input-group search" method="GET" action="{{ route('clientes.index') }}" style="margin-bottom: 20px;">
        <input type="search" class="search-query form-control" placeholder="Buscar" name="q" value="{{ request('q') }}">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
        </span>
    </form>
    
    @if(request('q'))
        <h6 class="query-label">Resultados de la búsqueda "{{ request('q') }}"</h6>
    @else
        <h6 class="query-label">Todos los clientes</h6>
    @endif
    
    @if($clientes->isEmpty())
        <div class="first-action" style="text-align: center; padding: 50px;">
            <div class="prompt">
                <i class="fa fa-user-plus" style="font-size: 48px; color: #ccc;"></i>
                <h5>Añade un nuevo cliente para registrar un préstamo</h5>
            </div>
        </div>
    @endif
    
    <ul class="clients search-results" style="list-style: none; padding: 0;">
        @foreach($clientes as $cliente)
            <li class="card" style="margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">
                <a href="{{ route('clientes.show', $cliente) }}" style="display: flex; align-items: center; padding: 15px; text-decoration: none; color: inherit;">
                    <div class="picture" style="width: 50px; height: 50px; background: #3498db; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; margin-right: 15px;">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="info" style="flex: 1;">
                        <h4 class="name" style="margin: 0 0 5px; font-size: 16px; font-weight: 500;">{{ $cliente->nombre }}</h4>
                        @if($cliente->telefono_1)
                            <span class="more" style="font-size: 14px; color: #666;"><i class="fa fa-phone"></i> {{ $cliente->telefono_1 }}</span>
                        @elseif($cliente->email)
                            <span class="more" style="font-size: 14px; color: #666;"><i class="fa fa-envelope"></i> {{ $cliente->email }}</span>
                        @elseif($cliente->direccion)
                            <span class="more" style="font-size: 14px; color: #666;"><i class="fa fa-home"></i> {{ $cliente->direccion }}</span>
                        @endif
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
    
    @if($clientes->hasPages())
    <ul class="pagination" style="display: flex; justify-content: center; list-style: none; padding: 0;">
        <li class="{{ $clientes->onFirstPage() ? 'disabled' : '' }}" style="margin: 0 5px;">
            <a href="{{ $clientes->previousPageUrl() ?: '#' }}" aria-label="Previous" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;"><span aria-hidden="true">«</span></a>
        </li>
        @foreach ($clientes->getUrlRange(1, $clientes->lastPage()) as $page => $url)
            <li class="{{ $clientes->currentPage() == $page ? 'active' : '' }}" style="margin: 0 5px;">
                <a href="{{ $url }}" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; {{ $clientes->currentPage() == $page ? 'background: #3498db; color: white;' : '' }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="{{ $clientes->currentPage() == $clientes->lastPage() ? 'disabled' : '' }}" style="margin: 0 5px;">
            <a href="{{ $clientes->nextPageUrl() ?: '#' }}" aria-label="Next" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none;"><span aria-hidden="true">»</span></a>
        </li>
    </ul>
    @endif
</section>

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
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Nombre</label>
                <input type="text" name="nombre" required style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="Nombre(s) del cliente">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Apellidos</label>
                <input type="text" name="apellidos" style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="Apellidos del cliente">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Correo electrónico</label>
                <input type="email" name="email" style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="correo@ejemplo.com">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Teléfono</label>
                <input type="tel" name="telefono_1" style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="5 (555) 555-5555">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Domicilio</label>
                <input type="text" name="direccion" style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="Calle, número, colonia">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px;">Código postal</label>
                <input type="text" name="codigo_postal" style="width: 100%; padding: 10px; border: 1px solid #555; border-radius: 4px; background: #34495e; color: white;" placeholder="Código postal">
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeModal()" style="padding: 10px 20px; background: #7f8c8d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cancelar</button>
                <button type="submit" style="padding: 10px 20px; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer;">Guardar</button>
            </div>
        </form>
    </div>
</div>

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
