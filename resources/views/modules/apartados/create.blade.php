@extends('layouts.main')

@section('content')
<header class="yp-header">
    <h1><i class="fa fa-bookmark"></i> <span>Nuevo Apartado</span></h1>
</header>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('apartados.store') }}" method="POST">
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
                                <label for="producto_id">Producto <span class="text-danger">*</span></label>
                                <select name="producto_id" id="producto_id" class="form-control select2" required>
                                    <option value="">Seleccione un producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_venta }}">
                                            {{ $producto->nombre }} - ${{ number_format($producto->precio_venta, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="monto_total">Monto Total <span class="text-danger">*</span></label>
                                <input type="number" name="monto_total" id="monto_total" class="form-control" step="0.01" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="anticipo">Anticipo <span class="text-danger">*</span></label>
                                <input type="number" name="anticipo" id="anticipo" class="form-control" step="0.01" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="plazo_dias">Plazo (días) <span class="text-danger">*</span></label>
                                <input type="number" name="plazo_dias" id="plazo_dias" class="form-control" value="30" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <strong>Saldo pendiente:</strong> $<span id="saldo">0.00</span>
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
                                <i class="fa fa-save"></i> Registrar Apartado
                            </button>
                            <a href="{{ route('apartados.index') }}" class="btn btn-secondary">
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
    $('.select2').select2();
    
    $('#producto_id').on('change', function() {
        const precio = $(this).find(':selected').data('precio');
        $('#monto_total').val(precio);
        calcularSaldo();
    });

    $('#monto_total, #anticipo').on('keyup change', calcularSaldo);

    function calcularSaldo() {
        const total = parseFloat($('#monto_total').val()) || 0;
        const anticipo = parseFloat($('#anticipo').val()) || 0;
        const saldo = total - anticipo;
        $('#saldo').text(saldo.toFixed(2));
    }
});
</script>
@endpush
