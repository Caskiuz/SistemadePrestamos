@extends('layouts.main')

@section('content')
<div class="mobile-header">
    <div class="mobile-header-content">
        <a href="{{ route('clientes.show', $prestamo->cliente_id) }}" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>
        <div class="header-info">
            <h1>{{ $prestamo->folio }}</h1>
            <p>{{ $prestamo->cliente->nombre }}</p>
        </div>
        <div class="status-badge status-{{ $prestamo->estado }}">
            {{ ucfirst($prestamo->estado) }}
        </div>
    </div>
</div>

<div class="mobile-content">
    <!-- Información Principal -->
    <div class="info-card">
        <div class="info-row">
            <span class="label">Monto:</span>
            <span class="value money">{{ formatCurrency($prestamo->monto) }}</span>
        </div>
        <div class="info-row">
            <span class="label">Fecha:</span>
            <span class="value">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Vencimiento:</span>
            <span class="value">{{ $prestamo->fecha_vencimiento->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Interés:</span>
            <span class="value">{{ $prestamo->interes_mensual }}%</span>
        </div>
    </div>

    <!-- Prendas -->
    <div class="section">
        <h3>Prendas Empeñadas</h3>
        @foreach($prestamo->productos as $producto)
        <div class="prenda-card">
            <div class="prenda-header">
                <h4>{{ $producto->nombre }}</h4>
                <div style="display: flex; gap: 5px;">
                    <input type="file" id="foto-{{ $producto->id }}" accept="image/*" capture="environment" style="display: none;" onchange="subirFotoDirecta({{ $producto->id }}, this)">
                    <button onclick="document.getElementById('foto-{{ $producto->id }}').click()" class="btn-icon" title="Tomar foto">
                        <i class="fa fa-camera"></i>
                    </button>
                    <input type="file" id="galeria-{{ $producto->id }}" accept="image/*" multiple style="display: none;" onchange="subirFotoDirecta({{ $producto->id }}, this)">
                    <button onclick="document.getElementById('galeria-{{ $producto->id }}').click()" class="btn-icon" style="background: #2196f3;" title="Seleccionar de galería">
                        <i class="fa fa-folder-open"></i>
                    </button>
                </div>
            </div>
            @if($producto->fotos->count() > 0)
            <div class="fotos-mini">
                @foreach($producto->fotos->take(3) as $foto)
                    @if(file_exists(public_path($foto->ruta)))
                    <img src="{{ asset($foto->ruta) }}" onclick="mostrarImagenCompleta('{{ asset($foto->ruta) }}', '{{ $producto->nombre }}')">
                    @endif
                @endforeach
                @if($producto->fotos->count() > 3)
                <div class="more-photos">+{{ $producto->fotos->count() - 3 }}</div>
                @endif
            </div>
            @else
            <div class="fotos-mini">
                @php
                    $tipo = strtolower($producto->tipo);
                    $svgMap = [
                        'joya' => 'joya.svg', 'joyas' => 'joya.svg',
                        'articulo' => 'articulo.svg', 'articulos' => 'articulo.svg',
                        'garrafa' => 'garrafa.svg', 'garrafas' => 'garrafa.svg',
                        'vehiculo' => 'vehiculo.svg', 'vehiculos' => 'vehiculo.svg',
                        'auto' => 'vehiculo.svg', 'carro' => 'vehiculo.svg', 'moto' => 'vehiculo.svg'
                    ];
                    $svg = isset($svgMap[$tipo]) ? $svgMap[$tipo] : 'articulo.svg';
                @endphp
                <img src="{{ asset('images/svg/' . $svg) }}" alt="{{ $producto->tipo }}" class="svg-icon" style="width: 50px; height: 50px; object-fit: contain; border-radius: 8px;">
                <span style="color: #999; font-style: italic; font-size: 14px;">{{ ucfirst($producto->tipo) }}</span>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Acciones Principales -->
    <div class="actions-section">
        <h3>Acciones</h3>
        <div class="action-grid">
            <button onclick="mostrarVisorContrato({{ $prestamo->id }})" class="action-btn primary">
                <i class="fa fa-file-pdf-o"></i>
                <span>Ver Contrato</span>
            </button>
            <a href="{{ route('prestamos.pdf', $prestamo->id) }}" class="action-btn secondary">
                <i class="fa fa-file-text"></i>
                <span>Boleta</span>
            </a>
            @if($prestamo->estado === 'activo' || $prestamo->estado === 'vencido')
            <button onclick="mostrarModalPago('refrendo')" class="action-btn success">
                <i class="fa fa-dollar"></i>
                <span>Refrendar</span>
            </button>
            <button onclick="mostrarModalPago('liquidacion')" class="action-btn warning">
                <i class="fa fa-check"></i>
                <span>Liquidar</span>
            </button>
            @endif
        </div>
    </div>

    <!-- Historial -->
    <div class="section">
        <h3>Historial</h3>
        <div class="historial-list">
            @foreach($prestamo->operaciones->take(5) as $operacion)
            <div class="historial-item">
                <div class="historial-date">{{ $operacion->created_at->format('d/m/y') }}</div>
                <div class="historial-desc">{{ $operacion->descripcion }}</div>
                <div class="historial-amount">
                    @if($operacion->cargo > 0)
                        <span class="cargo">+{{ formatCurrency($operacion->cargo) }}</span>
                    @endif
                    @if($operacion->abono > 0)
                        <span class="abono">-{{ formatCurrency($operacion->abono) }}</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="saldo-total">
            <strong>Saldo: {{ formatCurrency($prestamo->monto_pendiente) }}</strong>
        </div>
    </div>
</div>

<style>
/* Mobile-First Design */
.mobile-header {
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
    color: white;
    padding: 15px;
    margin: -20px -20px 20px -20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.mobile-header-content {
    display: flex;
    align-items: center;
    gap: 15px;
}

.back-btn {
    color: white;
    font-size: 20px;
    text-decoration: none;
    padding: 8px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.header-info {
    flex: 1;
}

.header-info h1 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.header-info p {
    margin: 2px 0 0 0;
    opacity: 0.9;
    font-size: 14px;
}

.mobile-content {
    padding: 0 5px;
}

.info-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-row:last-child {
    border-bottom: none;
}

.label {
    font-weight: 500;
    color: #666;
}

.value {
    font-weight: 600;
    color: #333;
}

.value.money {
    color: #16a34a;
    font-size: 18px;
}

.section {
    margin-bottom: 25px;
}

.section h3 {
    font-size: 18px;
    margin-bottom: 15px;
    color: #333;
    font-weight: 600;
}

.prenda-card {
    background: white;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.prenda-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.prenda-header h4 {
    margin: 0;
    font-size: 16px;
    color: #333;
}

.btn-icon {
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.fotos-mini {
    display: flex;
    gap: 8px;
    align-items: center;
}

.fotos-mini img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
}

.more-photos {
    background: #f3f4f6;
    color: #666;
    padding: 15px 10px;
    border-radius: 8px;
    font-size: 12px;
    text-align: center;
    min-width: 50px;
}

.no-photos {
    color: #999;
    font-style: italic;
    margin: 0;
    font-size: 14px;
}

.actions-section {
    margin-bottom: 25px;
}

.action-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.action-btn {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px 15px;
    text-decoration: none;
    color: #374151;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.action-btn i {
    font-size: 24px;
}

.action-btn span {
    font-size: 14px;
    font-weight: 500;
}

.action-btn.primary {
    border-color: #dc2626;
    color: #dc2626;
}

.action-btn.secondary {
    border-color: #3b82f6;
    color: #3b82f6;
}

.action-btn.success {
    border-color: #16a34a;
    color: #16a34a;
}

.action-btn.warning {
    border-color: #f59e0b;
    color: #f59e0b;
}

.action-btn:active {
    transform: scale(0.98);
}

.historial-list {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.historial-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.historial-item:last-child {
    border-bottom: none;
}

.historial-date {
    font-size: 12px;
    color: #666;
    min-width: 50px;
}

.historial-desc {
    flex: 1;
    margin: 0 10px;
    font-size: 14px;
}

.historial-amount {
    font-size: 14px;
    font-weight: 600;
}

.cargo {
    color: #dc2626;
}

.abono {
    color: #16a34a;
}

.saldo-total {
    background: #f8fafc;
    padding: 15px;
    text-align: center;
    border-radius: 12px;
    margin-top: 10px;
    font-size: 16px;
    color: #333;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-activo { background: #dcfce7; color: #166534; }
.status-vencido { background: #fef3c7; color: #92400e; }
.status-expirado { background: #fee2e2; color: #991b1b; }
.status-liquidado { background: #e5e7eb; color: #374151; }
.status-cancelado { background: #f3f4f6; color: #6b7280; }

/* Tablet adjustments */
@media (min-width: 768px) {
    .action-grid {
        grid-template-columns: repeat(4, 1fr);
    }
    
    .mobile-content {
        padding: 0 20px;
    }
    
    .info-card {
        padding: 25px;
    }
}
</style>

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

<!-- Modal de Renovación -->
<div id="modalRenovacion" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; min-width: 400px;">
        <h4>Renovar Préstamo</h4>
        <form action="{{ route('renovaciones.renovar', $prestamo->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Intereses Pagados</label>
                <input type="number" name="intereses_pagados" step="0.01" class="form-control" value="{{ $prestamo->monto_total - $prestamo->monto }}" required>
            </div>
            <div class="form-group">
                <label>Días de Extensión</label>
                <input type="number" name="dias_extension" class="form-control" value="30" min="1" max="365" required>
            </div>
            <div class="form-group">
                <label>Observaciones</label>
                <textarea name="observaciones" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Renovar</button>
            <button type="button" onclick="cerrarModalRenovacion()" class="btn btn-secondary">Cancelar</button>
        </form>
    </div>
</div>

<!-- Modal de Comisión -->
<div id="modalComision" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; min-width: 400px;">
        <h4>Aplicar Comisión</h4>
        <form action="{{ route('tarifas.aplicar-comision', $prestamo->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Tipo de Comisión</label>
                <select name="tarifa_id" class="form-control" required>
                    <option value="">Seleccionar...</option>
                    <!-- Aquí se cargarían las tarifas disponibles -->
                </select>
            </div>
            <div class="form-group">
                <label>Concepto</label>
                <input type="text" name="concepto" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Aplicar</button>
            <button type="button" onclick="cerrarModalComision()" class="btn btn-secondary">Cancelar</button>
        </form>
    </div>
</div>

<!-- Modal para editar fotos -->
<div id="modalFotos" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; overflow-y: auto;">
    <div style="position: relative; top: 20px; margin: 0 auto 40px; background: white; padding: 20px; border-radius: 8px; max-width: 90%; width: 400px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h4 id="modalFotosTitulo" style="margin: 0;">Editar Fotos</h4>
            <button onclick="cerrarModalFotos()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #666;">&times;</button>
        </div>
        
        <form id="formFotos" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                    <button type="button" onclick="abrirGaleria()" style="background: #2196f3; color: white; border: none; padding: 15px; border-radius: 8px; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 5px;">
                        <i class="fa fa-folder-open" style="font-size: 24px;"></i>
                        <span>Galería</span>
                    </button>
                    <button type="button" onclick="abrirCamara()" style="background: #4caf50; color: white; border: none; padding: 15px; border-radius: 8px; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 5px;">
                        <i class="fa fa-camera" style="font-size: 24px;"></i>
                        <span>Cámara</span>
                    </button>
                </div>
                
                <input type="file" id="fotosInput" name="fotos[]" multiple accept="image/*" style="display: none;">
                <input type="file" id="camaraInput" name="camara" accept="image/*" capture="environment" style="display: none;">
                
                <div id="fotosPreviewModal" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px; margin-top: 15px;"></div>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="cerrarModalFotos()" style="background: #757575; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Cancelar</button>
                <button type="submit" style="background: #4caf50; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer;">Subir Fotos</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para mostrar imagen completa -->
<div id="modalImagen" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 3000; cursor: pointer;" onclick="cerrarModalImagen()">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 90%; max-height: 90%;">
        <img id="imagenCompleta" src="" alt="" style="max-width: 100%; max-height: 100%; border-radius: 8px;">
        <div style="text-align: center; color: white; margin-top: 10px; font-size: 16px;" id="tituloImagen"></div>
    </div>
</div>

<!-- Modal Visor de PDF -->
<div id="modalVisorPDF" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 3000;">
    <div style="position: relative; width: 100%; height: 100%; display: flex; flex-direction: column;">
        <div style="background: #333; color: white; padding: 10px 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; min-height: 60px;">
            <h4 style="margin: 0; font-size: 16px; flex: 1; min-width: 150px;">Vista Previa del Contrato</h4>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <button onclick="descargarContratoPDF()" style="background: #28a745; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 14px; min-height: 44px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa fa-download"></i> <span class="hide-mobile">Descargar</span>
                </button>
                <button onclick="abrirPDFNuevaVentana()" style="background: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 14px; min-height: 44px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa fa-external-link"></i> <span class="hide-mobile">Abrir</span>
                </button>
                <button onclick="cerrarVisorPDF()" style="background: #dc3545; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 14px; min-height: 44px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa fa-times"></i> <span class="hide-mobile">Cerrar</span>
                </button>
            </div>
        </div>
        <div style="flex: 1; position: relative; background: white;">
            <iframe id="pdfFrame" src="" style="width: 100%; height: 100%; border: none; background: white;"></iframe>
            <!-- Fallback para móviles que no soportan iframe -->
            <div id="pdfFallback" style="display: none; padding: 20px; text-align: center; background: white; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <i class="fa fa-file-pdf-o" style="font-size: 48px; color: #dc2626; margin-bottom: 20px;"></i>
                <h5 style="margin-bottom: 15px;">Contrato Generado</h5>
                <p style="margin-bottom: 20px; color: #666;">El PDF está listo para descargar o abrir en una nueva ventana.</p>
                <div style="display: flex; flex-direction: column; gap: 10px; width: 100%; max-width: 300px;">
                    <button onclick="descargarContratoPDF()" style="background: #28a745; color: white; border: none; padding: 15px 20px; border-radius: 8px; cursor: pointer; font-size: 16px; width: 100%;">
                        <i class="fa fa-download"></i> Descargar PDF
                    </button>
                    <button onclick="abrirPDFNuevaVentana()" style="background: #007bff; color: white; border: none; padding: 15px 20px; border-radius: 8px; cursor: pointer; font-size: 16px; width: 100%;">
                        <i class="fa fa-external-link"></i> Abrir en Nueva Ventana
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let contratoPrestamoId = null;

function mostrarVisorContrato(prestamoId) {
    contratoPrestamoId = prestamoId;
    const iframe = document.getElementById('pdfFrame');
    const fallback = document.getElementById('pdfFallback');
    
    // Detectar si es móvil
    const isMobile = window.innerWidth <= 768 || /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if (isMobile) {
        // En móvil, mostrar fallback con botones grandes
        iframe.style.display = 'none';
        fallback.style.display = 'flex';
    } else {
        // En desktop, mostrar iframe
        iframe.style.display = 'block';
        fallback.style.display = 'none';
        iframe.src = `/prestamos/${prestamoId}/contrato`;
    }
    
    document.getElementById('modalVisorPDF').style.display = 'block';
}

function cerrarVisorPDF() {
    document.getElementById('modalVisorPDF').style.display = 'none';
    document.getElementById('pdfFrame').src = '';
    contratoPrestamoId = null;
}

function descargarContratoPDF() {
    if (contratoPrestamoId) {
        // Crear enlace temporal para descarga
        const link = document.createElement('a');
        link.href = `/prestamos/${contratoPrestamoId}/contrato/download`;
        link.download = `Contrato_Prestamo_${contratoPrestamoId}.pdf`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

function abrirPDFNuevaVentana() {
    if (contratoPrestamoId) {
        window.open(`/prestamos/${contratoPrestamoId}/contrato`, '_blank');
    }
}

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

function mostrarModalRenovacion() {
    document.getElementById('modalRenovacion').style.display = 'block';
}

function cerrarModalRenovacion() {
    document.getElementById('modalRenovacion').style.display = 'none';
}

function mostrarModalComision() {
    document.getElementById('modalComision').style.display = 'block';
}

function cerrarModalComision() {
    document.getElementById('modalComision').style.display = 'none';
}

function mostrarImagenCompleta(src, titulo) {
    document.getElementById('imagenCompleta').src = src;
    document.getElementById('tituloImagen').textContent = titulo;
    document.getElementById('modalImagen').style.display = 'block';
}

function cerrarModalImagen() {
    document.getElementById('modalImagen').style.display = 'none';
}

function subirFotoDirecta(productoId, input) {
    if (input.files && input.files.length > 0) {
        const button = input.previousElementSibling || input.nextElementSibling;
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        // Comprimir y subir cada foto
        const promesas = [];
        for (let i = 0; i < input.files.length; i++) {
            promesas.push(comprimirYSubirFoto(input.files[i], productoId));
        }
        
        Promise.all(promesas)
            .then(() => {
                alert('Fotos subidas exitosamente');
                location.reload();
            })
            .catch(error => {
                alert('Error: ' + error.message);
                button.innerHTML = originalHTML;
                button.disabled = false;
            });
    }
}

function comprimirYSubirFoto(archivo, productoId) {
    return new Promise((resolve, reject) => {
        // Si el archivo es menor a 1MB, subirlo directamente
        if (archivo.size < 1024 * 1024) {
            subirArchivoDirecto(archivo, productoId).then(resolve).catch(reject);
            return;
        }
        
        // Comprimir foto grande
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const img = new Image();
        
        img.onload = function() {
            // Redimensionar manteniendo proporción
            const maxWidth = 1200;
            const maxHeight = 1200;
            let { width, height } = img;
            
            if (width > height) {
                if (width > maxWidth) {
                    height = (height * maxWidth) / width;
                    width = maxWidth;
                }
            } else {
                if (height > maxHeight) {
                    width = (width * maxHeight) / height;
                    height = maxHeight;
                }
            }
            
            canvas.width = width;
            canvas.height = height;
            
            // Dibujar imagen redimensionada
            ctx.drawImage(img, 0, 0, width, height);
            
            // Convertir a blob comprimido
            canvas.toBlob(function(blob) {
                if (blob) {
                    // Crear archivo comprimido
                    const archivoComprimido = new File([blob], archivo.name, {
                        type: 'image/jpeg',
                        lastModified: Date.now()
                    });
                    
                    subirArchivoDirecto(archivoComprimido, productoId).then(resolve).catch(reject);
                } else {
                    reject(new Error('Error al comprimir imagen'));
                }
            }, 'image/jpeg', 0.8); // Calidad 80%
        };
        
        img.onerror = function() {
            reject(new Error('Error al cargar imagen'));
        };
        
        img.src = URL.createObjectURL(archivo);
    });
}

function subirArchivoDirecto(archivo, productoId) {
    const formData = new FormData();
    formData.append('fotos[]', archivo);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    return fetch(`/prestamos/productos/${productoId}/fotos`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            throw new Error('Error del servidor');
        }
    })
    .then(data => {
        if (!data.success) {
            throw new Error(data.message || 'Error desconocido');
        }
        return data;
    });
}

function mostrarModalFotos(productoId, nombreProducto) {
    productoIdActual = productoId;
    document.getElementById('modalFotosTitulo').textContent = 'Editar Fotos - ' + nombreProducto;
    document.getElementById('modalFotos').style.display = 'block';
    document.getElementById('fotosPreviewModal').innerHTML = '';
    document.getElementById('fotosInput').value = '';
    document.getElementById('camaraInput').value = '';
}

function cerrarModalFotos() {
    document.getElementById('modalFotos').style.display = 'none';
    document.getElementById('fotosPreviewModal').innerHTML = '';
    document.getElementById('fotosInput').value = '';
    document.getElementById('camaraInput').value = '';
    productoIdActual = null;
}

function abrirGaleria() {
    document.getElementById('fotosInput').click();
}

function abrirCamara() {
    document.getElementById('camaraInput').click();
}

function abrirCamaraModal() {
    // Función legacy - redirigir a la nueva función
    abrirCamara();
}

function procesarArchivosModal(files) {
    for (let file of files) {
        if (file.type.startsWith('image/')) {
            mostrarPreviewModal(file);
        }
    }
}

function mostrarPreviewModal(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('fotosPreviewModal');
        
        const item = document.createElement('div');
        item.style.cssText = 'position: relative; border-radius: 4px; overflow: hidden; background: #f0f0f0;';
        item.innerHTML = `
            <img src="${e.target.result}" style="width: 100%; height: 80px; object-fit: cover;">
            <button type="button" onclick="this.parentElement.remove()" style="position: absolute; top: 2px; right: 2px; background: #dc2626; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 10px; display: flex; align-items: center; justify-content: center;">
                ×
            </button>
        `;
        
        preview.appendChild(item);
    };
    reader.readAsDataURL(file);
}

function eliminarFoto(fotoId) {
    if (confirm('¿Estás seguro de que quieres eliminar esta foto?')) {
        fetch(`/prestamos/fotos/${fotoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'No se pudo eliminar la foto'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión al eliminar la foto');
        });
    }
}

function limpiarFotosRotas(productoId) {
    if (confirm('¿Estás seguro de que quieres limpiar todos los registros de fotos que no tienen archivo físico?')) {
        fetch(`/prestamos/productos/${productoId}/limpiar-fotos-rotas`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'No se pudieron limpiar las fotos'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión al limpiar fotos');
        });
    }
}

// Configurar eventos del modal de fotos
document.addEventListener('DOMContentLoaded', function() {
    const fotosInput = document.getElementById('fotosInput');
    const camaraInput = document.getElementById('camaraInput');
    const formFotos = document.getElementById('formFotos');
    
    if (fotosInput) {
        fotosInput.addEventListener('change', function(e) {
            procesarArchivosModal(e.target.files);
        });
    }
    
    if (camaraInput) {
        camaraInput.addEventListener('change', function(e) {
            procesarArchivosModal(e.target.files);
        });
    }
    
    if (formFotos) {
        formFotos.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!productoIdActual) {
                alert('Error: No se ha seleccionado un producto');
                return;
            }
            
            // Combinar archivos de ambos inputs
            const formData = new FormData();
            const fotosFiles = fotosInput.files;
            const camaraFiles = camaraInput.files;
            
            // Agregar archivos de galería
            for (let i = 0; i < fotosFiles.length; i++) {
                formData.append('fotos[]', fotosFiles[i]);
            }
            
            // Agregar archivos de cámara
            for (let i = 0; i < camaraFiles.length; i++) {
                formData.append('fotos[]', camaraFiles[i]);
            }
            
            // Agregar token CSRF
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch(`/prestamos/productos/${productoIdActual}/fotos`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Error al subir las fotos');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al subir las fotos');
            });
        });
    }
});
</script>
@endsection
