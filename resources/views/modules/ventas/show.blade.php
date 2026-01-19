@extends('layouts.app')

@section('title', 'Detalle de Venta')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shopping-bag"></i>
                        Venta #{{ $venta->id }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <button type="button" onclick="mostrarVisorFactura({{ $venta->id }})" class="btn btn-success">
                            <i class="fas fa-file-invoice"></i> Ver Factura
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Información del Cliente -->
                        <div class="col-md-6">
                            <h5><i class="fas fa-user"></i> Información del Cliente</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Nombre:</strong></td>
                                    <td>{{ $venta->cliente->nombre }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Documento:</strong></td>
                                    <td>{{ $venta->cliente->numero_documento }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Teléfono:</strong></td>
                                    <td>{{ $venta->cliente->telefono_1 ?? 'No especificado' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dirección:</strong></td>
                                    <td>{{ $venta->cliente->direccion ?? 'No especificada' }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Información de la Venta -->
                        <div class="col-md-6">
                            <h5><i class="fas fa-receipt"></i> Información de la Venta</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Fecha:</strong></td>
                                    <td>{{ $venta->fecha_venta->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Monto:</strong></td>
                                    <td><span class="badge badge-success">Bs. {{ number_format($venta->monto, 2) }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Estado:</strong></td>
                                    <td><span class="badge badge-primary">{{ $venta->estado }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Almacén:</strong></td>
                                    <td>{{ $venta->almacen->nombre }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <!-- Información del Producto -->
                    <div class="row">
                        <div class="col-12">
                            <h5><i class="fas fa-box"></i> Producto Vendido</h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table class="table table-sm">
                                                <tr>
                                                    <td><strong>Nombre:</strong></td>
                                                    <td>{{ $venta->producto->nombre }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tipo:</strong></td>
                                                    <td>{{ $venta->producto->tipo }}</td>
                                                </tr>
                                                @if($venta->producto->marca)
                                                <tr>
                                                    <td><strong>Marca:</strong></td>
                                                    <td>{{ $venta->producto->marca }}</td>
                                                </tr>
                                                @endif
                                                @if($venta->producto->modelo)
                                                <tr>
                                                    <td><strong>Modelo:</strong></td>
                                                    <td>{{ $venta->producto->modelo }}</td>
                                                </tr>
                                                @endif
                                                @if($venta->producto->numero_serie)
                                                <tr>
                                                    <td><strong>Número de Serie:</strong></td>
                                                    <td>{{ $venta->producto->numero_serie }}</td>
                                                </tr>
                                                @endif
                                                @if($venta->producto->descripcion)
                                                <tr>
                                                    <td><strong>Descripción:</strong></td>
                                                    <td>{{ $venta->producto->descripcion }}</td>
                                                </tr>
                                                @endif
                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            @if($venta->producto->fotos->count() > 0)
                                                <h6>Fotos del Producto:</h6>
                                                <div class="row">
                                                    @foreach($venta->producto->fotos as $foto)
                                                    <div class="col-6 mb-2">
                                                        <img src="{{ asset('storage/' . $foto->ruta) }}" 
                                                             class="img-fluid img-thumbnail" 
                                                             style="max-height: 100px;">
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($venta->observaciones)
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h5><i class="fas fa-sticky-note"></i> Observaciones</h5>
                            <p class="text-muted">{{ $venta->observaciones }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Visor de PDF -->
<div id="modalVisorPDF" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 3000;">
    <div style="position: relative; width: 100%; height: 100%; display: flex; flex-direction: column;">
        <div style="background: #333; color: white; padding: 10px 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; min-height: 60px;">
            <h4 style="margin: 0; font-size: 16px; flex: 1; min-width: 150px;">Vista Previa de la Factura</h4>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <button onclick="descargarFacturaPDF()" style="background: #28a745; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 14px; min-height: 44px;">
                    <i class="fa fa-download"></i> Descargar
                </button>
                <button onclick="abrirFacturaNuevaVentana()" style="background: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 14px; min-height: 44px;">
                    <i class="fa fa-external-link"></i> Abrir
                </button>
                <button onclick="cerrarVisorPDF()" style="background: #dc3545; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 14px; min-height: 44px;">
                    <i class="fa fa-times"></i> Cerrar
                </button>
            </div>
        </div>
        <div style="flex: 1; position: relative; background: white;">
            <iframe id="pdfFrame" src="" style="width: 100%; height: 100%; border: none; background: white;"></iframe>
            <div id="pdfFallback" style="display: none; padding: 20px; text-align: center; background: white; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <i class="fa fa-file-invoice" style="font-size: 48px; color: #28a745; margin-bottom: 20px;"></i>
                <h5 style="margin-bottom: 15px;">Factura Generada</h5>
                <p style="margin-bottom: 20px; color: #666;">La factura está lista para descargar o abrir.</p>
                <div style="display: flex; flex-direction: column; gap: 10px; width: 100%; max-width: 300px;">
                    <button onclick="descargarFacturaPDF()" style="background: #28a745; color: white; border: none; padding: 15px 20px; border-radius: 8px; cursor: pointer; font-size: 16px; width: 100%;">
                        <i class="fa fa-download"></i> Descargar PDF
                    </button>
                    <button onclick="abrirFacturaNuevaVentana()" style="background: #007bff; color: white; border: none; padding: 15px 20px; border-radius: 8px; cursor: pointer; font-size: 16px; width: 100%;">
                        <i class="fa fa-external-link"></i> Abrir en Nueva Ventana
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let ventaId = null;

function mostrarVisorFactura(id) {
    ventaId = id;
    const iframe = document.getElementById('pdfFrame');
    const fallback = document.getElementById('pdfFallback');
    
    const isMobile = window.innerWidth <= 768 || /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if (isMobile) {
        iframe.style.display = 'none';
        fallback.style.display = 'flex';
    } else {
        iframe.style.display = 'block';
        fallback.style.display = 'none';
        iframe.src = `/ventas/${id}/factura`;
    }
    
    document.getElementById('modalVisorPDF').style.display = 'block';
}

function cerrarVisorPDF() {
    document.getElementById('modalVisorPDF').style.display = 'none';
    document.getElementById('pdfFrame').src = '';
    ventaId = null;
}

function descargarFacturaPDF() {
    if (ventaId) {
        const link = document.createElement('a');
        link.href = `/ventas/${ventaId}/factura/download`;
        link.download = `Factura_Venta_${ventaId}.pdf`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

function abrirFacturaNuevaVentana() {
    if (ventaId) {
        window.open(`/ventas/${ventaId}/factura`, '_blank');
    }
}
</script>
@endsection