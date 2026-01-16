@extends('layouts.main')

@section('content')
<header class="yp-header">
    <h1>
        <i class="fa fa-cube"></i>
        <span>{{ $producto->nombre }}</span>
    </h1>
    <div class="actions">
        <a href="{{ route('inventario.edit', $producto->id) }}" class="btn btn-warning">
            <i class="fa fa-edit"></i> Editar
        </a>
        <a href="{{ route('inventario.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Volver
        </a>
    </div>
</header>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if($producto->foto)
                            <img src="{{ asset('storage/' . $producto->foto) }}" alt="{{ $producto->nombre }}" class="img-fluid" style="max-height: 300px;">
                        @else
                            <i class="fa fa-image" style="font-size: 150px; color: #ccc;"></i>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Información del Producto</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nombre:</strong> {{ $producto->nombre }}
                            </div>
                            <div class="col-md-6">
                                <strong>Tipo:</strong> {{ ucfirst($producto->tipo) }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Categoría:</strong> {{ $producto->categoria ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Estado:</strong>
                                <span class="badge 
                                    @if($producto->estado == 'disponible') badge-success
                                    @elseif($producto->estado == 'empeñado') badge-warning
                                    @elseif($producto->estado == 'vendido') badge-secondary
                                    @elseif($producto->estado == 'apartado') badge-info
                                    @elseif($producto->estado == 'en_venta') badge-primary
                                    @endif">
                                    {{ ucfirst($producto->estado) }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Marca:</strong> {{ $producto->marca ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Modelo:</strong> {{ $producto->modelo ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Número de Serie:</strong> {{ $producto->numero_serie ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Almacén:</strong> {{ $producto->almacen->nombre }}
                            </div>
                        </div>

                        @if($producto->tipo == 'joya')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Peso:</strong> {{ $producto->peso ?? 'N/A' }} gramos
                            </div>
                            <div class="col-md-6">
                                <strong>Quilates:</strong> {{ $producto->quilates ?? 'N/A' }}
                            </div>
                        </div>
                        @endif

                        <hr>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Precio Compra:</strong><br>
                                <h4 class="text-info">${{ number_format($producto->precio_compra ?? 0, 2) }}</h4>
                            </div>
                            <div class="col-md-4">
                                <strong>Precio Venta:</strong><br>
                                <h4 class="text-success">${{ number_format($producto->precio_venta ?? 0, 2) }}</h4>
                            </div>
                            <div class="col-md-4">
                                <strong>Valuación:</strong><br>
                                <h4 class="text-primary">${{ number_format($producto->valuacion ?? 0, 2) }}</h4>
                            </div>
                        </div>

                        @if($producto->descripcion)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <strong>Descripción:</strong>
                                <p>{{ $producto->descripcion }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                @if($producto->prestamos->count() > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Historial de Préstamos</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Monto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($producto->prestamos as $prestamo)
                                    <tr>
                                        <td>
                                            <a href="{{ route('prestamos.show', $prestamo->id) }}">
                                                {{ $prestamo->folio }}
                                            </a>
                                        </td>
                                        <td>{{ $prestamo->cliente->nombre }}</td>
                                        <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                                        <td>${{ number_format($prestamo->monto, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $prestamo->estado == 'activo' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($prestamo->estado) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.yp-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.yp-header h1 {
    margin: 0;
}
.actions {
    display: flex;
    gap: 10px;
}
</style>
@endpush
