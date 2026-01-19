@extends('layouts.main')

@section('content')
<x-mobile-header title="Historial de prendas" />

<x-horizontal-filters 
    :filters="[
        'sold' => ['label' => 'Vendidos'],
        'settled' => ['label' => 'Liquidados'],
        'cancelled' => ['label' => 'Cancelados']
    ]"
    :current-filter="$status"
    route="historial.index"
    parameter="status" />

<div class="mobile-content">
    <x-search-box 
        placeholder="Buscar"
        route="historial.index"
        :value="request('q')" />

    @if(request('q'))
        <h6 class="query-label">Resultados de la búsqueda "{{ request('q') }}" de prendas {{ $statusLabel }}</h6>
    @else
        <h6 class="query-label">Todas las prendas {{ $statusLabel }}</h6>
    @endif

    <div class="list-mobile">
        @forelse($prendas as $prenda)
            <div class="list-item">
                <div class="list-item-header">
                    <div>
                        <h4 class="list-item-title">{{ $prenda->descripcion }}</h4>
                        <span class="list-item-subtitle">{{ $prenda->fecha_formateada }} - {{ $prenda->hora_formateada }}</span>
                    </div>
                    <div class="status-badge" style="background-color: {{ $prenda->color ?? '#9C27B0' }};">
                        {{ $prenda->tipo_label }}
                    </div>
                </div>
                
                <div class="prestamo-amounts">
                    <div class="amount-item">
                        <span class="label">Folio:</span>
                        <span class="value">{{ $prenda->folio ?? 'N/A' }}</span>
                    </div>
                    <div class="amount-item">
                        <span class="label">Monto:</span>
                        <span class="value">{{ $prenda->monto_formateado }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fa fa-info-circle"></i>
                <h4>No se encontraron resultados</h4>
                <p>No hay prendas {{ $statusLabel }} para mostrar</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
.query-label {
    font-size: 12px;
    color: var(--gray-500);
    font-weight: 500;
    margin-bottom: 15px;
    text-transform: uppercase;
}

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

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    color: white;
}
</style>
@endpush
