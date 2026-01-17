@extends('layouts.main')

@section('content')
<header class="yp-header">
    <h1>
        <i class="fa fa-plus-circle"></i>
        <span>Nuevo Producto/Prenda</span>
    </h1>
</header>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('inventario.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="categoria">Categoría</label>
                                <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Ej: Oro, Plata, etc.">
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
                                <label for="numero_serie">Número de Serie</label>
                                <input type="text" name="numero_serie" id="numero_serie" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row" id="joya_fields" style="display: none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="peso">Peso (gramos)</label>
                                <input type="number" name="peso" id="peso" class="form-control" step="0.01">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quilates">Quilates</label>
                                <input type="text" name="quilates" id="quilates" class="form-control" placeholder="Ej: 18k, 24k">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="precio_compra">Precio de Compra</label>
                                <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.01">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="precio_venta">Precio de Venta</label>
                                <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.01">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="valuacion">Valuación <span class="text-danger">*</span></label>
                                <input type="number" name="valuacion" id="valuacion" class="form-control" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado">Estado <span class="text-danger">*</span></label>
                                <select name="estado" id="estado" class="form-control" required>
                                    <option value="disponible">Disponible</option>
                                    <option value="en_venta">En Venta</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto">Foto del Producto</label>
                                <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Guardar Producto
                            </button>
                            <a href="{{ route('inventario.index') }}" class="btn btn-secondary">
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

@push('scripts')
<script>
$(document).ready(function() {
    $('#tipo').on('change', function() {
        if ($(this).val() === 'joya') {
            $('#joya_fields').show();
        } else {
            $('#joya_fields').hide();
        }
    });
});
</script>
@endpush
