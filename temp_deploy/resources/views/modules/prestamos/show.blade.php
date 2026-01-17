@extends('layouts.main')

@section('content')
<header class="yp-header" style="background: #7cb342;">
    <h1>
        <a href="{{ route('clientes.show', $prestamo->cliente_id) }}" style="color: white; text-decoration: none;">
            <i class="fa fa-arrow-left"></i>
        </a>
        <span style="color: white;">Detalles del préstamo</span>
    </h1>
</header>

<section class="content" style="padding: 20px; position: relative;">
    <!-- Botón flotante principal -->
    <button type="button" class="action" id="mainActionBtn" style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; border-radius: 50%; background: #ff9800; border: none; color: white; font-size: 24px; cursor: pointer; z-index: 1000; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">
        <i class="fa fa-plus"></i>
    </button>

    <!-- Sub-acciones -->
    <ul id="subActions" style="display: none; position: fixed; bottom: 90px; right: 20px; list-style: none; padding: 0; z-index: 999;">
        @if($prestamo->estado === 'activo')
        <li style="margin-bottom: 10px; text-align: right;">
            <span style="background: white; padding: 8px 12px; border-radius: 4px; margin-right: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">Refrendar</span>
            <button type="button" onclick="mostrarModalPago('refrendo')" style="width: 50px; height: 50px; border-radius: 50%; background: #ff9800; border: none; color: white; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                <i class="fa fa-dollar"></i>
            </button>
        </li>
        <li style="margin-bottom: 10px; text-align: right;">
            <span style="background: white; padding: 8px 12px; border-radius: 4px; margin-right: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">Abonar a capital</span>
            <button type="button" onclick="mostrarModalPago('abono_capital')" style="width: 50px; height: 50px; border-radius: 50%; background: #ff9800; border: none; color: white; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                <i class="fa fa-money"></i>
            </button>
        </li>
        <li style="margin-bottom: 10px; text-align: right;">
            <span style="background: white; padding: 8px 12px; border-radius: 4px; margin-right: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">Liquidar</span>
            <button type="button" onclick="mostrarModalPago('liquidacion')" style="width: 50px; height: 50px; border-radius: 50%; background: #ff9800; border: none; color: white; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                <i class="fa fa-check"></i>
            </button>
        </li>
        @endif
    </ul>

    <div class="card" style="margin-bottom: 20px;">
        <div style="padding: 20px; border-bottom: 1px solid #ddd;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin: 0;">{{ $prestamo->folio }}</h3>
                    <h5 style="margin: 5px 0 0 0;">
                        <a href="{{ route('clientes.show', $prestamo->cliente_id) }}">{{ $prestamo->cliente->nombre }}</a>
                    </h5>
                </div>
                <div style="display: flex; gap: 10px;">
                    @if($prestamo->estado === 'activo')
                    <button onclick="if(confirm('¿Aplicar descuento?')) document.getElementById('formDescuento').style.display='block'" class="btn btn-sm btn-warning" title="Aplicar descuento">
                        <i class="fa fa-minus-circle"></i>
                    </button>
                    <form action="{{ route('prestamos.cancelar', $prestamo->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" onclick="return confirm('¿Cancelar préstamo?')" class="btn btn-sm btn-danger" title="Cancelar">
                            <i class="fa fa-times-circle"></i>
                        </button>
                    </form>
                    <form action="{{ route('prestamos.expirar', $prestamo->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" onclick="return confirm('¿Marcar como expirado?')" class="btn btn-sm btn-secondary" title="Marcar expirado">
                            <i class="fa fa-tag"></i>
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('prestamos.pdf', $prestamo->id) }}" class="btn btn-sm btn-primary" title="Boleta">
                        <i class="fa fa-file-text"></i>
                    </a>
                </div>
            </div>
        </div>

        <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <div>
                    <strong>Prenda(s)</strong>
                    <ul style="margin: 5px 0; padding-left: 20px;">
                        @foreach($prestamo->productos as $producto)
                        <li>{{ $producto->nombre }}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <strong>Monto del préstamo</strong>
                    <div>${{ number_format($prestamo->monto, 2) }}</div>
                </div>
                <div>
                    <strong>Fecha de préstamo</strong>
                    <div>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</div>
                </div>
                <div>
                    <strong>Fecha de vencimiento</strong>
                    <div>{{ $prestamo->fecha_vencimiento->format('d/m/Y') }}</div>
                </div>
                <div>
                    <strong>Interés</strong>
                    <div>{{ $prestamo->interes_mensual }}%</div>
                </div>
                <div>
                    <strong>Plazo</strong>
                    <div>{{ $prestamo->plazo_dias }} días</div>
                </div>
                <div>
                    <strong>Estado</strong>
                    <div>
                        <span class="badge badge-{{ $prestamo->estado === 'activo' ? 'success' : ($prestamo->estado === 'liquidado' ? 'primary' : 'danger') }}">
                            {{ ucfirst($prestamo->estado) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial -->
    <h6 style="margin: 20px 0 10px 0; font-weight: bold;">Historial</h6>
    <div class="card">
        <table class="table table-condensed" style="margin: 0;">
            <thead>
                <tr>
                    <th></th>
                    <th>Fecha</th>
                    <th>Operación</th>
                    <th style="text-align: right;">Cargo</th>
                    <th style="text-align: right;">Abono</th>
                    <th style="text-align: right;">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prestamo->operaciones as $operacion)
                <tr>
                    <td>
                        @if($operacion->usuario_id)
                        <i class="fa fa-user" title="{{ $operacion->usuario->name ?? '' }}"></i>
                        @endif
                    </td>
                    <td>{{ $operacion->created_at->format('d/m/y H:i') }}</td>
                    <td>{{ $operacion->descripcion }}</td>
                    <td style="text-align: right;">${{ number_format($operacion->cargo, 2) }}</td>
                    <td style="text-align: right;">${{ number_format($operacion->abono, 2) }}</td>
                    <td style="text-align: right;">${{ number_format($operacion->saldo, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 15px;">
                        @if($prestamo->estado === 'activo')
                        <h4 style="margin: 0;">${{ number_format($prestamo->monto_pendiente, 2) }}</h4>
                        @elseif($prestamo->estado === 'liquidado')
                        <h4 style="margin: 0;">Liquidado</h4>
                        @else
                        <h4 style="margin: 0;">{{ ucfirst($prestamo->estado) }}</h4>
                        @endif
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Form descuento oculto -->
    <div id="formDescuento" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); z-index: 2000;">
        <h4>Aplicar Descuento</h4>
        <form action="{{ route('prestamos.descuento', $prestamo->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Monto del descuento</label>
                <input type="number" name="monto" step="0.01" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Aplicar</button>
            <button type="button" onclick="document.getElementById('formDescuento').style.display='none'" class="btn btn-secondary">Cancelar</button>
        </form>
    </div>
</section>

<!-- Modal de Pago -->
<div id="modalPago" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; min-width: 400px;">
        <h4 id="modalTitulo">Registrar Pago</h4>
        <form action="{{ route('prestamos.pagar', $prestamo->id) }}" method="POST">
            @csrf
            <input type="hidden" name="tipo" id="tipoPago">
            <div class="form-group">
                <label id="labelMonto">Monto</label>
                <input type="number" name="monto" id="montoPago" step="0.01" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Notas</label>
                <textarea name="notas" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
            <button type="button" onclick="cerrarModalPago()" class="btn btn-secondary">Cancelar</button>
        </form>
    </div>
</div>

<script>
document.getElementById('mainActionBtn').addEventListener('click', function() {
    const subActions = document.getElementById('subActions');
    subActions.style.display = subActions.style.display === 'none' ? 'block' : 'none';
});

function mostrarModalPago(tipo) {
    const modal = document.getElementById('modalPago');
    const titulo = document.getElementById('modalTitulo');
    const tipoPago = document.getElementById('tipoPago');
    const labelMonto = document.getElementById('labelMonto');
    const montoPago = document.getElementById('montoPago');
    
    tipoPago.value = tipo;
    
    if (tipo === 'refrendo') {
        titulo.textContent = 'Refrendar';
        labelMonto.textContent = 'Intereses';
        montoPago.value = {{ $prestamo->monto_total - $prestamo->monto }};
    } else if (tipo === 'abono_capital') {
        titulo.textContent = 'Abonar a Capital';
        labelMonto.textContent = 'Monto';
        montoPago.value = '';
    } else {
        titulo.textContent = 'Liquidar';
        labelMonto.textContent = 'Cantidad a pagar';
        montoPago.value = {{ $prestamo->monto_pendiente }};
    }
    
    modal.style.display = 'block';
}

function cerrarModalPago() {
    document.getElementById('modalPago').style.display = 'none';
}
</script>
@endsection
