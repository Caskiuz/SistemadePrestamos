@extends('layouts.main')

@section('content')
<header class="yp-header brown">
    <h1>
        <a href="{{ route('reportes.index') }}">
            <i class="fa fa-chevron-left"></i>
        </a>
        <span>{{ $titulo }}</span>
    </h1>
</header>

<section class="content" style="background-color: #444 !important; padding: 30px !important;">
    <div class="container-fluid">
        @if($apartados->count() > 0)
            <div class="table-responsive">
                <table class="table" style="background: #2a2a2a; color: #fff;">
                    <thead>
                        <tr style="border-bottom: 1px solid #3a3a3a;">
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Monto Total</th>
                            <th>Anticipo</th>
                            <th>Saldo</th>
                            <th>Fecha Apartado</th>
                            <th>Fecha Vencimiento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($apartados as $apartado)
                        <tr style="border-bottom: 1px solid #3a3a3a;">
                            <td>{{ $apartado->id }}</td>
                            <td>{{ $apartado->cliente->nombre }}</td>
                            <td>{{ $apartado->producto->nombre }}</td>
                            <td>${{ number_format($apartado->monto_total, 2) }}</td>
                            <td>${{ number_format($apartado->anticipo, 2) }}</td>
                            <td>${{ number_format($apartado->saldo, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($apartado->fecha_apartado)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($apartado->fecha_vencimiento)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $apartado->estado == 'activo' ? 'success' : 'danger' }}">
                                    {{ ucfirst($apartado->estado) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('apartados.show', $apartado->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info" style="background: #2a2a2a; border: 1px solid #3a3a3a; color: #ccc;">
                No hay apartados en esta categoría
            </div>
        @endif
    </div>
</section>
@endsection
