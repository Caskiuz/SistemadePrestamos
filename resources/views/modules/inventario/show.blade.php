@extends('layouts.main')

@section('content')
<div class="mobile-header">
    <div class="mobile-header-content">
        <a href="{{ route('inventario.index') }}" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>
        <div class="header-info">
            <h1>{{ $producto->nombre }}</h1>
            <p>{{ ucfirst($producto->tipo) }}</p>
        </div>
        <div class="status-badge status-{{ $producto->estado }}">
            {{ ucfirst($producto->estado) }}
        </div>
    </div>
</div>

<div class="mobile-content">
    <!-- Información Principal -->
    <div class="info-card">
        <div class="info-row">
            <span class="label">Nombre:</span>
            <span class="value">{{ $producto->nombre }}</span>
        </div>
        <div class="info-row">
            <span class="label">Tipo:</span>
            <span class="value">{{ ucfirst($producto->tipo) }}</span>
        </div>
        <div class="info-row">
            <span class="label">Marca:</span>
            <span class="value">{{ $producto->marca ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Modelo:</span>
            <span class="value">{{ $producto->modelo ?? 'N/A' }}</span>
        </div>
        @if($producto->numero_serie)
        <div class="info-row">
            <span class="label">Serie:</span>
            <span class="value">{{ $producto->numero_serie }}</span>
        </div>
        @endif
        @if($producto->tipo == 'joya')
        <div class="info-row">
            <span class="label">Peso:</span>
            <span class="value">{{ $producto->peso ?? 'N/A' }} gr</span>
        </div>
        <div class="info-row">
            <span class="label">Quilates:</span>
            <span class="value">{{ $producto->quilates ?? 'N/A' }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="label">Almacén:</span>
            <span class="value">{{ $producto->almacen->nombre }}</span>
        </div>
    </div>

    <!-- Precios -->
    <div class="info-card">
        <div class="info-row">
            <span class="label">Precio Compra:</span>
            <span class="value money">{{ formatCurrency($producto->precio_compra ?? 0) }}</span>
        </div>
        <div class="info-row">
            <span class="label">Precio Venta:</span>
            <span class="value money">{{ formatCurrency($producto->precio_venta ?? 0) }}</span>
        </div>
        <div class="info-row">
            <span class="label">Valuación:</span>
            <span class="value money">{{ formatCurrency($producto->valuacion ?? 0) }}</span>
        </div>
    </div>

    <!-- Foto del Producto -->
    <div class="section">
        <h3>Imagen del Producto</h3>
        <div class="prenda-card">
            <div class="fotos-mini">
                @if($producto->fotos && $producto->fotos->count() > 0)
                    @php $fotoReal = null; @endphp
                    @foreach($producto->fotos as $foto)
                        @php
                            $rutaFoto = $foto->ruta;
                            $rutaFoto = str_replace(['\\', '//'], '/', $rutaFoto);
                            if (!str_starts_with($rutaFoto, 'fotos/')) {
                                $rutaFoto = 'fotos/' . basename($rutaFoto);
                            }
                            $archivoExiste = file_exists(public_path($rutaFoto));
                            if ($archivoExiste && !$fotoReal) {
                                $fotoReal = $rutaFoto;
                                break;
                            }
                        @endphp
                    @endforeach
                    
                    @if($fotoReal)
                        <img src="{{ asset($fotoReal) }}" 
                             onclick="mostrarImagenCompleta('{{ asset($fotoReal) }}', '{{ $producto->nombre }}')"
                             style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; cursor: pointer;">
                    @else
                        @php
                            $tipo = strtolower($producto->tipo);
                            $svgMap = [
                                'joya' => 'joya.svg', 'joyas' => 'joya.svg',
                                'articulo' => 'articulo.svg', 'articulos' => 'articulo.svg',
                                'garrafa' => 'garrafa.svg', 'garrafas' => 'garrafa.svg',
                                'vehiculo' => 'vehiculo.svg', 'vehiculos' => 'vehiculo.svg',
                                'auto' => 'vehiculo.svg', 'carro' => 'vehiculo.svg', 'moto' => 'vehiculo.svg'
                            ];
                            $svg = $svgMap[$tipo] ?? 'articulo.svg';
                        @endphp
                        <img src="{{ asset('images/svg/' . $svg) }}" alt="{{ $producto->tipo }}" 
                             style="width: 120px; height: 120px; object-fit: contain; border-radius: 8px;">
                        <span style="color: #999; font-style: italic; font-size: 14px; margin-left: 10px;">Sin foto</span>
                    @endif
                @else
                    @php
                        $tipo = strtolower($producto->tipo);
                        $svgMap = [
                            'joya' => 'joya.svg', 'joyas' => 'joya.svg',
                            'articulo' => 'articulo.svg', 'articulos' => 'articulo.svg',
                            'garrafa' => 'garrafa.svg', 'garrafas' => 'garrafa.svg',
                            'vehiculo' => 'vehiculo.svg', 'vehiculos' => 'vehiculo.svg',
                            'auto' => 'vehiculo.svg', 'carro' => 'vehiculo.svg', 'moto' => 'vehiculo.svg'
                        ];
                        $svg = $svgMap[$tipo] ?? 'articulo.svg';
                    @endphp
                    <img src="{{ asset('images/svg/' . $svg) }}" alt="{{ $producto->tipo }}" 
                         style="width: 120px; height: 120px; object-fit: contain; border-radius: 8px;">
                    <span style="color: #999; font-style: italic; font-size: 14px; margin-left: 10px;">Sin foto</span>
                @endif
            </div>
        </div>
    </div>

    @if($producto->descripcion)
    <!-- Descripción -->
    <div class="info-card">
        <div class="info-row" style="flex-direction: column; align-items: flex-start;">
            <span class="label">Descripción:</span>
            <p style="margin: 8px 0 0 0; color: #333; line-height: 1.4;">{{ $producto->descripcion }}</p>
        </div>
    </div>
    @endif

    <!-- Acciones Principales -->
    <div class="actions-section">
        <h3>Acciones</h3>
        <div class="action-grid">
            <a href="{{ route('inventario.edit', $producto->id) }}" class="action-btn warning">
                <i class="fa fa-edit"></i>
                <span>Editar</span>
            </a>
            <a href="{{ route('inventario.index') }}" class="action-btn secondary">
                <i class="fa fa-list"></i>
                <span>Inventario</span>
            </a>
        </div>
    </div>

    @if($producto->prestamos->count() > 0)
    <!-- Historial de Préstamos -->
    <div class="section">
        <h3>Historial de Préstamos</h3>
        <div class="historial-list">
            @foreach($producto->prestamos->take(5) as $prestamo)
            <div class="historial-item">
                <div class="historial-date">{{ $prestamo->fecha_prestamo->format('d/m/y') }}</div>
                <div class="historial-desc">
                    <a href="{{ route('prestamos.show', $prestamo->id) }}" style="color: #dc2626; text-decoration: none;">
                        {{ $prestamo->folio }}
                    </a>
                    <br>
                    <small>{{ $prestamo->cliente->nombre }}</small>
                </div>
                <div class="historial-amount">
                    <span class="badge status-{{ $prestamo->estado }}">{{ ucfirst($prestamo->estado) }}</span>
                    <br>
                    <small>{{ formatCurrency($prestamo->monto) }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Modal para mostrar imagen completa -->
<div id="modalImagen" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 3000; cursor: pointer;" onclick="cerrarModalImagen()">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 90%; max-height: 90%;">
        <img id="imagenCompleta" src="" alt="" style="max-width: 100%; max-height: 100%; border-radius: 8px;">
        <div style="text-align: center; color: white; margin-top: 10px; font-size: 16px;" id="tituloImagen"></div>
    </div>
</div>

<style>
/* Mobile-First Design - Copiado de préstamos */
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
    font-size: 16px;
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

.fotos-mini {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
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

.action-btn.warning {
    border-color: #f59e0b;
    color: #f59e0b;
}

.action-btn.secondary {
    border-color: #6b7280;
    color: #6b7280;
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
    font-size: 12px;
    text-align: right;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-disponible { background: #dcfce7; color: #166534; }
.status-en_venta { background: #dbeafe; color: #1e40af; }
.status-empeñado { background: #fef3c7; color: #92400e; }
.status-apartado { background: #e0f2fe; color: #0277bd; }
.status-vendido { background: #e5e7eb; color: #374151; }
.status-activo { background: #dcfce7; color: #166534; }
.status-vencido { background: #fef3c7; color: #92400e; }
.status-liquidado { background: #e5e7eb; color: #374151; }

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

<script>
function mostrarImagenCompleta(src, titulo) {
    document.getElementById('imagenCompleta').src = src;
    document.getElementById('tituloImagen').textContent = titulo;
    document.getElementById('modalImagen').style.display = 'block';
}

function cerrarModalImagen() {
    document.getElementById('modalImagen').style.display = 'none';
}
</script>
@endsection
