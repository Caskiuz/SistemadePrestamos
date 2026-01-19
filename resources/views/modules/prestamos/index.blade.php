@extends('layouts.main')

@section('content')
<x-mobile-header title="Préstamos" />

<x-horizontal-filters 
    :filters="[
        'activo' => ['label' => 'Activos'],
        'vencido' => ['label' => 'Vencidos'],
        'expirado' => ['label' => 'Expirados'],
        'liquidado' => ['label' => 'Liquidados'],
        'cancelado' => ['label' => 'Cancelados']
    ]"
    :current-filter="request('status')"
    route="prestamos.index"
    parameter="status" />

<div class="mobile-content">
    @if($prestamos->isEmpty())
        <div class="empty-state">
            <i class="fa fa-info-circle"></i>
            <h4>Registra tu primer préstamo</h4>
            <p>Desde la ventana de detalle del cliente</p>
            <a href="{{ route('clientes.index') }}" class="action-btn primary">
                <i class="fa fa-users"></i>
                <span>Ir a Clientes</span>
            </a>
        </div>
    @else
        <x-search-box 
            placeholder="Buscar cliente o monto"
            route="prestamos.index"
            :value="request('q')" />

        <div class="list-mobile">
            @foreach($prestamos as $prestamo)
            <a href="{{ route('prestamos.show', $prestamo->id) }}" class="list-item">
                <div class="list-item-header">
                    <div>
                        <h4 class="list-item-title">{{ optional($prestamo->cliente)->nombre ?? 'Sin cliente' }}</h4>
                        <span class="list-item-subtitle">{{ optional($prestamo->created_at)->format('h:i A') ?? 'Sin hora' }}</span>
                    </div>
                    <div class="status-badge status-{{ $prestamo->estado }}">
                        {{ ucfirst($prestamo->estado) }}
                    </div>
                </div>
                
                <div class="prestamo-amounts">
                    <div class="amount-item">
                        <span class="label">Monto:</span>
                        <span class="value">{{ formatCurrency($prestamo->monto) }}</span>
                    </div>
                    <div class="amount-item">
                        <span class="label">Pendiente:</span>
                        <span class="value pending">{{ formatCurrency($prestamo->monto_pendiente) }}</span>
                    </div>
                </div>

                @if($prestamo->productos->count() > 0)
                <div class="prendas-preview">
                    <span class="prendas-label">Prendas:</span>
                    <div class="prendas-list">
                        @php $hayFotosReales = false; @endphp
                        @foreach($prestamo->productos->take(3) as $producto)
                        @php
                            $tienefotos = false;
                            if($producto->fotos->count() > 0) {
                                foreach($producto->fotos as $foto) {
                                    $rutaFoto = str_replace(['\\', '//'], '/', $foto->ruta);
                                    if (!str_starts_with($rutaFoto, 'fotos/')) {
                                        $rutaFoto = 'fotos/' . basename($rutaFoto);
                                    }
                                    if(file_exists(public_path($rutaFoto))) {
                                        $tienefotos = true;
                                        $hayFotosReales = true;
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <div class="prenda-item">
                            @if($tienefotos)
                            @php
                                $foto = $producto->fotos->first();
                                $rutaFoto = str_replace(['\\', '//'], '/', $foto->ruta);
                                if (!str_starts_with($rutaFoto, 'fotos/')) {
                                    $rutaFoto = 'fotos/' . basename($rutaFoto);
                                }
                            @endphp
                            <img src="{{ asset($rutaFoto) }}" alt="{{ $producto->nombre }}" 
                                 style="width: 24px; height: 24px; object-fit: cover; border-radius: 4px;">
                            @else
                            @php
                                $tipo = strtolower($producto->tipo ?? 'articulo');
                                $svgMap = [
                                    'joya' => 'joya.svg', 'joyas' => 'joya.svg',
                                    'articulo' => 'articulo.svg', 'articulos' => 'articulo.svg',
                                    'garrafa' => 'garrafa.svg', 'garrafas' => 'garrafa.svg',
                                    'vehiculo' => 'vehiculo.svg', 'vehiculos' => 'vehiculo.svg',
                                    'auto' => 'vehiculo.svg', 'carro' => 'vehiculo.svg', 'moto' => 'vehiculo.svg'
                                ];
                                $svg = $svgMap[$tipo] ?? 'articulo.svg';
                            @endphp
                            <img src="{{ asset('images/svg/' . $svg) }}" alt="{{ $producto->tipo }}" class="svg-icon">
                            @endif
                            <span>{{ $producto->nombre }}</span>
                        </div>
                        @endforeach
                        @if($prestamo->productos->count() > 3)
                        <div class="more-items">+{{ $prestamo->productos->count() - 3 }}</div>
                        @endif
                    </div>
                </div>
                @endif

                <div class="list-item-footer">
                    <i class="fa fa-calendar"></i>
                    <span>Vence: {{ optional($prestamo->fecha_vencimiento)->format('d/m/Y') ?? 'Sin fecha' }}</span>
                </div>
            </a>
            @endforeach
        </div>

        @if($prestamos->hasPages())
        <div class="pagination-wrapper">
            {{ $prestamos->links() }}
        </div>
        @endif
    @endif
</div>

<style>
.prestamo-amounts {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.amount-item {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.amount-item .label {
    font-size: 12px;
    color: var(--gray-500);
    font-weight: 500;
}

.amount-item .value {
    font-size: 16px;
    font-weight: 600;
    color: var(--gray-800);
}

.amount-item .value.pending {
    color: var(--danger-color);
}

.prendas-preview {
    margin-bottom: 15px;
}

.prendas-label {
    font-size: 12px;
    color: var(--gray-500);
    font-weight: 500;
    display: block;
    margin-bottom: 8px;
}

.prendas-list {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.prenda-item {
    display: flex;
    align-items: center;
    gap: 6px;
    background: var(--gray-50);
    padding: 6px 10px;
    border-radius: var(--border-radius);
    font-size: 12px;
}

.prenda-item img {
    width: 24px;
    height: 24px;
    object-fit: cover;
    border-radius: 4px;
}

.prenda-item img.svg-icon {
    width: 24px;
    height: 24px;
    object-fit: contain;
    border-radius: 0;
}

.no-image {
    width: 24px;
    height: 24px;
    background: var(--gray-200);
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
    font-size: 10px;
}

.more-items {
    background: var(--gray-200);
    color: var(--gray-500);
    padding: 6px 10px;
    border-radius: var(--border-radius);
    font-size: 12px;
    font-weight: 500;
}

.pagination-wrapper {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}
</style>
@endsection
