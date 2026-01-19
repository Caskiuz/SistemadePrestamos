@extends('layouts.main')

@section('content')
<x-mobile-header title="Prendas" />

<x-horizontal-filters 
    :filters="[
        'forSale' => ['label' => 'En venta'],
        'layaway' => ['label' => 'Apartadas'],
        'loan' => ['label' => 'Empeñadas'],
        'available' => ['label' => 'Disponibles']
    ]"
    :current-filter="request('status')"
    route="inventario.index"
    parameter="status" />

<div class="mobile-content">
    @if($productos->isEmpty())
        <div class="empty-state">
            <i class="fa fa-archive"></i>
            <h4>Registra tu primera prenda</h4>
            <p>Agrega productos al inventario</p>
            <a href="{{ route('inventario.create') }}" class="action-btn primary">
                <i class="fa fa-plus"></i>
                <span>Nueva Prenda</span>
            </a>
        </div>
    @else
        <x-search-box 
            placeholder="Buscar prenda o tipo"
            route="inventario.index"
            :value="request('q')" />

        <div class="list-mobile">
            @foreach($productos as $producto)
            <a href="{{ route('inventario.show', $producto->id) }}" class="list-item">
                <div class="list-item-header">
                    <div>
                        <h4 class="list-item-title">{{ $producto->nombre }}</h4>
                        <span class="list-item-subtitle">{{ $producto->tipo ?? 'Producto' }}</span>
                    </div>
                    <div class="status-badge status-{{ strtolower(str_replace('_', '-', $producto->estado)) }}">
                        {{ ucfirst(str_replace('_', ' ', $producto->estado)) }}
                    </div>
                </div>
                
                <div class="prenda-info">
                    @if($producto->fotos && $producto->fotos->count() > 0)
                    <div class="prenda-image">
                        <img src="{{ asset($producto->fotos->first()->ruta) }}" alt="{{ $producto->nombre }}">
                    </div>
                    @else
                    <div class="prenda-image">
                        @php
                            $tipo = strtolower($producto->tipo ?? 'articulo');
                            $svgMap = [
                                'joya' => 'joya.svg', 'joyas' => 'joya.svg',
                                'articulo' => 'articulo.svg', 'articulos' => 'articulo.svg',
                                'garrafa' => 'garrafa.svg', 'garrafas' => 'garrafa.svg',
                                'vehiculo' => 'vehiculo.svg', 'vehiculos' => 'vehiculo.svg',
                                'auto' => 'vehiculo.svg', 'carro' => 'vehiculo.svg', 'moto' => 'vehiculo.svg'
                            ];
                            $svg = isset($svgMap[$tipo]) ? $svgMap[$tipo] : 'articulo.svg';
                        @endphp
                        <img src="{{ asset('images/svg/' . $svg) }}" alt="{{ $producto->tipo }}" class="svg-icon">
                    </div>
                    @endif
                    
                    <div class="prenda-details">
                        <div class="detail-item">
                            <span class="label">Almacén:</span>
                            <span class="value">{{ $producto->almacen->nombre ?? 'Sin almacén' }}</span>
                        </div>
                        @if($producto->valuacion)
                        <div class="detail-item">
                            <span class="label">Valuación:</span>
                            <span class="value">{{ formatCurrency($producto->valuacion) }}</span>
                        </div>
                        @endif
                        @if($producto->peso && $producto->quilates)
                        <div class="detail-item">
                            <span class="label">Peso/Quilates:</span>
                            <span class="value">{{ $producto->peso }}g {{ $producto->quilates }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                @if($producto->descripcion)
                <div class="prenda-description">
                    <p>{{ Str::limit($producto->descripcion, 100) }}</p>
                </div>
                @endif

                <div class="list-item-footer">
                    <i class="fa fa-calendar"></i>
                    <span>Registrado: {{ optional($producto->created_at)->format('d/m/Y') ?? 'Sin fecha' }}</span>
                </div>
            </a>
            @endforeach
        </div>

        @if($productos->hasPages())
        <div class="pagination-wrapper">
            {{ $productos->links() }}
        </div>
        @endif
    @endif
</div>

<style>
.prenda-info {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}

.prenda-image {
    width: 60px;
    height: 60px;
    border-radius: var(--border-radius);
    overflow: hidden;
    background: var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
}

.prenda-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.prenda-image img.svg-icon {
    width: 40px;
    height: 40px;
    object-fit: contain;
}

.prenda-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-item .label {
    font-size: 12px;
    color: var(--gray-500);
    font-weight: 500;
}

.detail-item .value {
    font-size: 14px;
    font-weight: 600;
    color: var(--gray-800);
}

.prenda-description {
    margin-bottom: 15px;
}

.prenda-description p {
    font-size: 13px;
    color: var(--gray-600);
    margin: 0;
    line-height: 1.4;
}

.status-badge.status-en-venta {
    background-color: #10b981;
    color: white;
}

.status-badge.status-loan {
    background-color: #f59e0b;
    color: white;
}

.status-badge.status-layaway {
    background-color: #8b5cf6;
    color: white;
}

.status-badge.status-available {
    background-color: #6b7280;
    color: white;
}

.pagination-wrapper {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}
</style>
@endsection