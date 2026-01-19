@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Subasta {{ $subasta->codigo }}</h4>
                    <span class="badge badge-{{ $subasta->estado == 'activa' ? 'success' : ($subasta->estado == 'finalizada' ? 'primary' : 'secondary') }} badge-lg">
                        {{ ucfirst($subasta->estado) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Información de la Subasta</h5>
                            <p><strong>Precio Base:</strong> {{ formatCurrency($subasta->precio_base) }}</p>
                            <p><strong>Precio Actual:</strong> {{ formatCurrency($subasta->precio_actual) }}</p>
                            <p><strong>Fecha Inicio:</strong> {{ $subasta->fecha_inicio->format('d/m/Y H:i') }}</p>
                            <p><strong>Fecha Fin:</strong> {{ $subasta->fecha_fin->format('d/m/Y H:i') }}</p>
                            @if($subasta->ganador)
                            <p><strong>Ganador:</strong> {{ $subasta->ganador->nombre }}</p>
                            @endif
                            
                            <h6>Préstamo Asociado</h6>
                            <p><strong>Folio:</strong> {{ $subasta->prestamo->folio }}</p>
                            <p><strong>Cliente:</strong> {{ $subasta->prestamo->cliente->nombre }}</p>
                            
                            <h6>Prendas en Subasta</h6>
                            <ul>
                                @foreach($subasta->prestamo->productos as $producto)
                                <li>{{ $producto->nombre }} - {{ formatCurrency($producto->pivot->valuacion) }}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="col-md-6">
                            @if($subasta->estado == 'activa')
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6>Realizar Oferta</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('subastas.ofertar', $subasta->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Cliente</label>
                                            <select name="cliente_id" class="form-control" required>
                                                <option value="">Seleccionar cliente...</option>
                                                @foreach(\App\Models\Cliente::orderBy('nombre')->get() as $cliente)
                                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Monto de Oferta</label>
                                            <input type="number" name="monto" step="0.01" class="form-control" 
                                                   min="{{ $subasta->precio_actual + 1 }}" required>
                                            <small class="text-muted">Mínimo: {{ formatCurrency($subasta->precio_actual + 1) }}</small>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-success">Realizar Oferta</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <form action="{{ route('subastas.finalizar', $subasta->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning" onclick="return confirm('¿Finalizar subasta?')">
                                        Finalizar Subasta
                                    </button>
                                </form>
                            </div>
                            @endif
                            
                            <h6 class="mt-4">Historial de Ofertas</h6>
                            @if($subasta->ofertas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Monto</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subasta->ofertas as $oferta)
                                        <tr class="{{ $loop->first ? 'table-success' : '' }}">
                                            <td>{{ $oferta->cliente->nombre }}</td>
                                            <td>{{ formatCurrency($oferta->monto) }}</td>
                                            <td>{{ $oferta->fecha_oferta->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <p class="text-muted">No hay ofertas registradas</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection