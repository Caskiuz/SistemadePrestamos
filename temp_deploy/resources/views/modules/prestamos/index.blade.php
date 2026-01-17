@extends('layouts.main')

@section('content')
<header class="yp-header">
    <h1>
        <i class="fa fa-money"></i>
        <span>Préstamos</span>
    </h1>
    <ul class="nav nav-tabs">
        <li class="{{ request('status') == 'activo' || !request('status') ? 'active' : '' }}">
            <a href="{{ route('prestamos.index', ['status' => 'activo']) }}">Vigentes</a>
        </li>
        <li class="{{ request('status') == 'por_vencer' ? 'active' : '' }}">
            <a href="{{ route('prestamos.index', ['status' => 'por_vencer']) }}">Por vencer</a>
        </li>
        <li class="{{ request('status') == 'vencido' ? 'active' : '' }}">
            <a href="{{ route('prestamos.index', ['status' => 'vencido']) }}">Vencidos</a>
        </li>
        <li class="{{ request('status') == 'liquidado' ? 'active' : '' }}">
            <a href="{{ route('prestamos.index', ['status' => 'liquidado']) }}">Liquidados</a>
        </li>
    </ul>
</header>

<section class="content">
    @if($prestamos->isEmpty())
        <div class="text-center mt-5">
            <h4>
                <i class="fa fa-info-circle"></i>
                Registra tu primer préstamo desde la ventana de detalle del cliente
            </h4>
            <a href="{{ route('clientes.index') }}" class="btn btn-primary mt-3">
                Ir a Clientes
            </a>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Buscar cliente o monto" id="searchInput">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="searchButton">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="list-group">
            @foreach($prestamos as $prestamo)
                <a href="{{ route('prestamos.show', $prestamo->id) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            {{ optional($prestamo->cliente)->nombre ?? 'Sin cliente' }}
                            <small class="text-muted ml-2">
                                {{ optional($prestamo->created_at)->format('h:i A') ?? 'Sin hora' }}
                            </small>
                        </h5>
                        <span class="badge 
                            @if($prestamo->estado == 'activo') badge-success 
                            @elseif($prestamo->estado == 'por_vencer') badge-warning 
                            @elseif($prestamo->estado == 'vencido') badge-danger 
                            @elseif($prestamo->estado == 'liquidado') badge-secondary 
                            @endif">
                            {{ ucfirst($prestamo->estado) }}
                        </span>
                    </div>
                    <p class="mb-1">
                        <strong>Monto:</strong> {{ number_format($prestamo->monto, 2) }}
                        <strong class="ml-3">Pendiente:</strong> {{ number_format($prestamo->monto_pendiente, 2) }}
                    </p>
                    <small class="text-muted">
                        <i class="fa fa-calendar"></i> 
                        {{ optional($prestamo->fecha_vencimiento)->format('d/m/Y') ?? 'Sin fecha' }}
                    </small>
                </a>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $prestamos->links() }}
        </div>
    @endif
</section>
@endsection

@push('styles')
<style>
.nav-tabs {
    margin-bottom: 20px;
}

.list-group-item {
    transition: all 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
    transform: translateY(-3px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.badge {
    font-size: 0.8em;
    padding: 0.4em 0.6em;
}

.input-group .form-control {
    border-right: none;
}

.input-group .input-group-append .btn {
    border-left: none;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');

    searchButton.addEventListener('click', function() {
        const searchTerm = searchInput.value;
        window.location.href = "{{ route('prestamos.index') }}?q=" + encodeURIComponent(searchTerm);
    });

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchButton.click();
        }
    });
});
</script>
@endpush
