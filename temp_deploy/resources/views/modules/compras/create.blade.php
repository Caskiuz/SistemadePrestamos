@extends('layouts.main')

@section('content')
<header class="yp-header">
    <h1>
        <i class="fa fa-shopping-cart"></i>
        <span>Nueva Compra</span>
    </h1>
</header>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('compras.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cliente_id">Cliente <span class="text-danger">*</span></label>
                                <select name="cliente_id" id="cliente_id" class="form-control select2" required>
                                    <option value="">Seleccione un cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="almacen_id">Almacén/Sucursal <span class="text-danger">*</span></label>
                                <select name="almacen_id" id="almacen_id" class="form-control" required>
                                    <option value="">Seleccione un almacén</option>
                                    @foreach($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-3">Información del Producto</h5>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_producto">Nombre del Producto <span class="text-danger">*</span></label>
                                <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo">Tipo <span class="text-danger">*</span></label>
                                <select name="tipo" id="tipo" class="form-control" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="electrodomestico">Electrodoméstico</option>
                                    <option value="vehiculo">Vehículo</option>
                                    <option value="linea_blanca">Línea Blanca</option>
                                    <option value="linea_negra">Línea Negra</option>
                                    <option value="joya">Joya</option>
                                    <option value="celular">Celular</option>
                                    <option value="electronico">Electrónico</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="marca">Marca</label>
                                <input type="text" name="marca" id="marca" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="modelo">Modelo</label>
                                <input type="text" name="modelo" id="modelo" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="precio_compra">Precio de Compra <span class="text-danger">*</span></label>
                                <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="precio_venta">Precio de Venta (Sugerido)</label>
                                <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.01">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Registrar Compra
                            </button>
                            <a href="{{ route('compras.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: 'Seleccione una opción',
        allowClear: true
    });
});
</script>
@endpush
