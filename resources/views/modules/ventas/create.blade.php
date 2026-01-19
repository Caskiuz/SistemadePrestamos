@extends('layouts.main')

@section('content')
<header class="yp-header">
    <h1>
        <a href="{{ route('ventas.index') }}" style="color: white; text-decoration: none;">
            <i class="fa fa-arrow-left"></i>
        </a>
        <i class="fa fa-credit-card"></i>
        <span>Nueva Venta</span>
    </h1>
</header>

<section class="content">
    <div class="container-fluid">
        <!-- Explicación del proceso -->
        <div class="alert alert-info">
            <h5><i class="fa fa-info-circle"></i> Proceso de Venta</h5>
            <p class="mb-0">Seleccione un producto disponible en inventario y un cliente comprador. El sistema calculará automáticamente la ganancia obtenida.</p>
        </div>
        
        <div class="card">
            <div class="card-body">
                <form action="{{ route('ventas.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cliente_id">Cliente Comprador <span class="text-danger">*</span></label>
                                @if($cliente_id)
                                    @php $clienteSeleccionado = $clientes->find($cliente_id) @endphp
                                    <input type="hidden" name="cliente_id" value="{{ $cliente_id }}">
                                    <input type="text" class="form-control" value="{{ $clienteSeleccionado->nombre }} - {{ $clienteSeleccionado->numero_documento }}" readonly>
                                    <small class="text-muted">Cliente preseleccionado. <a href="{{ route('ventas.create') }}">Cambiar cliente</a></small>
                                @else
                                    <select name="cliente_id" id="cliente_id" class="form-control" required>
                                        <option value="">Seleccione el cliente que compra</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">
                                                {{ $cliente->nombre }} - {{ $cliente->numero_documento }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="producto_id">Producto Disponible <span class="text-danger">*</span></label>
                                <select name="producto_id" id="producto_id" class="form-control" required>
                                    <option value="">Seleccione un producto para vender</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" 
                                                data-precio-venta="{{ $producto->precio_venta }}" 
                                                data-precio-compra="{{ $producto->precio_compra }}" 
                                                data-almacen="{{ $producto->almacen->nombre ?? 'N/A' }}">
                                            {{ $producto->nombre }} 
                                            @if($producto->marca) - {{ $producto->marca }}@endif
                                            ({{ $producto->almacen->nombre ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Solo se muestran productos disponibles para venta</small>
                            </div>
                        </div>
                    </div>

                    <!-- Información del producto seleccionado -->
                    <div id="producto-info" class="row" style="display: none;">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Información del Producto</h6>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Almacén:</strong>
                                            <div id="info-almacen">-</div>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Precio de Compra:</strong>
                                            <div id="info-precio-compra">{{ formatCurrency(0) }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Precio Sugerido:</strong>
                                            <div id="info-precio-sugerido">{{ formatCurrency(0) }}</div>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Ganancia Estimada:</strong>
                                            <div id="info-ganancia" class="text-success">{{ formatCurrency(0) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="monto">Precio de Venta Final <span class="text-danger">*</span></label>
                                <input type="number" name="monto" id="monto" class="form-control" step="0.01" required placeholder="0.00">
                                <small class="text-muted">Puede ajustar el precio según negociación</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control" rows="3" placeholder="Detalles de la venta, descuentos aplicados, etc."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de la venta -->
                    <div id="resumen-venta" class="row" style="display: none;">
                        <div class="col-md-12">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6>Resumen de la Venta</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Precio de Venta:</strong>
                                            <div id="resumen-venta-precio">{{ formatCurrency(0) }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Costo del Producto:</strong>
                                            <div id="resumen-compra-precio">{{ formatCurrency(0) }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Ganancia Final:</strong>
                                            <div id="resumen-ganancia-final">{{ formatCurrency(0) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Registrar Venta
                            </button>
                            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
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
    $('#producto_id').on('change', function() {
        const option = $(this).find(':selected');
        const precioVenta = parseFloat(option.data('precio-venta')) || 0;
        const precioCompra = parseFloat(option.data('precio-compra')) || 0;
        const almacen = option.data('almacen') || 'N/A';
        const ganancia = precioVenta - precioCompra;
        
        if (option.val()) {
            // Mostrar información del producto
            $('#info-almacen').text(almacen);
            $('#info-precio-compra').text('$' + precioCompra.toFixed(2));
            $('#info-precio-sugerido').text('$' + precioVenta.toFixed(2));
            $('#info-ganancia').text('$' + ganancia.toFixed(2));
            $('#producto-info').show();
            
            // Establecer precio sugerido
            $('#monto').val(precioVenta.toFixed(2));
            
            // Actualizar resumen
            actualizarResumen();
        } else {
            $('#producto-info').hide();
            $('#resumen-venta').hide();
            $('#monto').val('');
        }
    });
    
    $('#monto').on('input', function() {
        actualizarResumen();
    });
    
    function actualizarResumen() {
        const option = $('#producto_id').find(':selected');
        const precioCompra = parseFloat(option.data('precio-compra')) || 0;
        const precioVenta = parseFloat($('#monto').val()) || 0;
        const gananciaFinal = precioVenta - precioCompra;
        
        if (precioVenta > 0 && option.val()) {
            $('#resumen-venta-precio').text('$' + precioVenta.toFixed(2));
            $('#resumen-compra-precio').text('$' + precioCompra.toFixed(2));
            $('#resumen-ganancia-final').text('$' + gananciaFinal.toFixed(2));
            
            // Cambiar color según ganancia
            const card = $('#resumen-venta .card');
            if (gananciaFinal >= 0) {
                card.removeClass('bg-danger').addClass('bg-success');
            } else {
                card.removeClass('bg-success').addClass('bg-danger');
            }
            
            $('#resumen-venta').show();
        } else {
            $('#resumen-venta').hide();
        }
    }
});
</script>
@endpush
