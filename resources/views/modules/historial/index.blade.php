@extends('layouts.main')

@section('content')
<header class="yp-header purple">
    <h1>
        <i class="fa fa-clock-o"></i>
        <span>Historial de prendas</span>
    </h1>
    <ul class="nav nav-tabs">
        <li class="{{ $status === 'sold' ? 'active' : '' }}">
            <a href="{{ route('historial.index', ['status' => 'sold']) }}">Vendidos</a>
        </li>
        <li class="{{ $status === 'settled' ? 'active' : '' }}">
            <a href="{{ route('historial.index', ['status' => 'settled']) }}">Liquidados</a>
        </li>
        <li class="{{ $status === 'cancelled' ? 'active' : '' }}">
            <a href="{{ route('historial.index', ['status' => 'cancelled']) }}">Cancelados</a>
        </li>
    </ul>
</header>

<section class="content">
    <form class="input-group search" method="GET" action="{{ route('historial.index') }}">
        <input type="hidden" name="status" value="{{ $status }}">
        <input type="search" class="search-query form-control" placeholder="Buscar" name="q" value="{{ request('q') }}">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </span>
    </form>

    @if(request('q'))
        <h6 class="query-label">Resultados de la búsqueda "{{ request('q') }}" de prendas {{ $statusLabel }}</h6>
    @else
        <h6 class="query-label">Todas las prendas {{ $statusLabel }}</h6>
    @endif

    <ul class="items search-results">
        @forelse($prendas as $prenda)
            <li>
                <div class="card">
                    <div class="contract" style="background-color: {{ $prenda->color ?? '#9C27B0' }};">
                        {{ $prenda->folio ?? 'N/A' }}
                    </div>
                    <div class="info">
                        <h4>{{ $prenda->descripcion }}</h4>
                        <h5>
                            <i class="fa fa-calendar"></i> {{ $prenda->fecha_formateada }}
                            <i class="fa fa-clock-o"></i> {{ $prenda->hora_formateada }}
                        </h5>
                    </div>
                    <div class="money">
                        <h5 class="status">{{ $prenda->monto_formateado }}</h5>
                    </div>
                    <span class="tag" style="background-color: {{ $prenda->color ?? '#9C27B0' }};">{{ $prenda->tipo_label }}</span>
                </div>
            </li>
        @empty
            <li>No se encontraron resultados</li>
        @endforelse
    </ul>
</section>
@endsection

@push('styles')
<style>
.search-results {
    margin: 0;
    padding: 0;
    list-style: none;
}

.search-results li {
    margin-bottom: 10px;
}

.search-results .card {
    position: relative;
    padding: 0;
    overflow: hidden;
}

.search-results .contract {
    float: left;
    width: 90px;
    height: 70px;
    line-height: 70px;
    text-align: center;
    color: white;
    font-weight: 500;
}

.search-results .info {
    padding: 10px 10px 10px 100px;
}

.search-results .info h4 {
    margin: 0 0 5px;
    font-size: 15px;
    color: #666;
}

.search-results .info h5 {
    margin: 0;
    color: #888;
    font-size: 13px;
    font-weight: normal;
}

.search-results .info h5 i {
    margin-right: 5px;
    margin-left: 10px;
}

.search-results .info h5 i:first-child {
    margin-left: 0;
}

.search-results .money {
    position: absolute;
    right: 10px;
    top: 10px;
}

.search-results .money .status {
    color: #888;
    font-size: 12px;
    margin: 0;
}

.search-results .tag {
    position: absolute;
    right: 0;
    bottom: 0;
    color: white;
    font-size: 10px;
    padding: 1px 8px;
}
</style>
@endpush
