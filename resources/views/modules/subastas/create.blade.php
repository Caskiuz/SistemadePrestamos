@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Crear Subasta - Préstamo {{ $prestamo->folio }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Información del Préstamo</h5>
                            <p><strong>Cliente:</strong> {{ $prestamo->cliente->nombre }}</p>
                            <p><strong>Monto:</strong> {{ formatCurrency($prestamo->monto) }}</p>
                            <p><strong>Fecha Vencimiento:</strong> {{ $prestamo->fecha_vencimiento->format('d/m/Y') }}</p>
                            
                            <h6>Prendas:</h6>
                            <ul>
                                @foreach($prestamo->productos as $producto)
                                <li>{{ $producto->nombre }} - {{ formatCurrency($producto->pivot->valuacion) }}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="col-md-6">
                            <form action="{{ route('subastas.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="prestamo_id" value="{{ $prestamo->id }}">
                                
                                <div class="form-group">
                                    <label>Precio Base</label>
                                    <input type="number" name="precio_base" step="0.01" class="form-control" 
                                           value="{{ $prestamo->monto * 0.7 }}" required>
                                    <small class="text-muted">Sugerido: 70% del monto del préstamo</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Fecha de Inicio</label>
                                    <input type="datetime-local" name="fecha_inicio" class="form-control" 
                                           value="{{ now()->addHour()->format('Y-m-d\TH:i') }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Fecha de Fin</label>
                                    <input type="datetime-local" name="fecha_fin" class="form-control" 
                                           value="{{ now()->addDays(7)->format('Y-m-d\TH:i') }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <textarea name="descripcion" class="form-control" rows="3" 
                                              placeholder="Descripción adicional de la subasta..."></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Crear Subasta</button>
                                <a href="{{ route('prestamos.show', $prestamo->id) }}" class="btn btn-secondary">Cancelar</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection