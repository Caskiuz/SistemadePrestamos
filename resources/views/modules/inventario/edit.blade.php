@extends('layouts.main')

@section('content')
<div class="mobile-header">
    <div class="mobile-header-content">
        <a href="{{ route('inventario.show', $producto->id) }}" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>
        <div class="header-info">
            <h1>Editar Producto</h1>
            <p>{{ $producto->nombre }}</p>
        </div>
        <div class="status-badge status-{{ $producto->estado }}">
            {{ ucfirst($producto->estado) }}
        </div>
    </div>
</div>

<div class="mobile-content">
    <!-- Información Principal -->
    <div class="info-card">
        <form action="{{ route('inventario.update', $producto->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="info-row">
                <span class="label">Nombre:</span>
                <input type="text" name="nombre" class="value-input" value="{{ $producto->nombre }}" required>
            </div>
            <div class="info-row">
                <span class="label">Tipo:</span>
                <select name="tipo" class="value-input" required onchange="toggleJoyaFields(this.value)">
                    <option value="joya" {{ $producto->tipo == 'joya' ? 'selected' : '' }}>Joya</option>
                    <option value="articulo" {{ $producto->tipo == 'articulo' ? 'selected' : '' }}>Artículo</option>
                    <option value="garrafa" {{ $producto->tipo == 'garrafa' ? 'selected' : '' }}>Garrafa</option>
                    <option value="vehiculo" {{ $producto->tipo == 'vehiculo' ? 'selected' : '' }}>Vehículo</option>
                </select>
            </div>
            <div class="info-row">
                <span class="label">Marca:</span>
                <input type="text" name="marca" class="value-input" value="{{ $producto->marca }}">
            </div>
            <div class="info-row">
                <span class="label">Modelo:</span>
                <input type="text" name="modelo" class="value-input" value="{{ $producto->modelo }}">
            </div>
            <div class="info-row">
                <span class="label">Serie:</span>
                <input type="text" name="numero_serie" class="value-input" value="{{ $producto->numero_serie }}">
            </div>
            <div class="info-row" id="pesoRow" style="{{ $producto->tipo == 'joya' ? '' : 'display: none;' }}">
                <span class="label">Peso (gr):</span>
                <input type="number" name="peso" class="value-input" step="0.01" value="{{ $producto->peso }}">
            </div>
            <div class="info-row" id="quilatesRow" style="{{ $producto->tipo == 'joya' ? '' : 'display: none;' }}">
                <span class="label">Quilates:</span>
                <input type="number" name="quilates" class="value-input" step="0.01" value="{{ $producto->quilates }}">
            </div>
            <div class="info-row">
                <span class="label">Valuación:</span>
                <input type="number" name="valuacion" class="value-input money" step="0.01" value="{{ $producto->valuacion }}" required>
            </div>
            <div class="info-row">
                <span class="label">Estado:</span>
                <select name="estado" class="value-input" required>
                    <option value="disponible" {{ $producto->estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="en_venta" {{ $producto->estado == 'en_venta' ? 'selected' : '' }}>En Venta</option>
                    <option value="empeñado" {{ $producto->estado == 'empeñado' ? 'selected' : '' }}>Empeñado</option>
                    <option value="apartado" {{ $producto->estado == 'apartado' ? 'selected' : '' }}>Apartado</option>
                    <option value="vendido" {{ $producto->estado == 'vendido' ? 'selected' : '' }}>Vendido</option>
                </select>
            </div>
            <div class="info-row">
                <span class="label">Almacén:</span>
                <select name="almacen_id" class="value-input" required>
                    @foreach($almacenes as $almacen)
                        <option value="{{ $almacen->id }}" {{ $producto->almacen_id == $almacen->id ? 'selected' : '' }}>
                            {{ $almacen->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <!-- Foto del Producto -->
    <div class="section">
        <h3>Foto del Producto</h3>
        <div class="prenda-card">
            <div class="prenda-header">
                <h4>Imagen</h4>
                <div style="display: flex; gap: 5px;">
                    <input type="file" id="foto-producto" accept="image/*" capture="environment" style="display: none;" onchange="subirFotoProducto(this)">
                    <button onclick="document.getElementById('foto-producto').click()" class="btn-icon" title="Tomar foto">
                        <i class="fa fa-camera"></i>
                    </button>
                    <input type="file" id="galeria-producto" accept="image/*" style="display: none;" onchange="subirFotoProducto(this)">
                    <button onclick="document.getElementById('galeria-producto').click()" class="btn-icon" style="background: #2196f3;" title="Seleccionar de galería">
                        <i class="fa fa-folder-open"></i>
                    </button>
                </div>
            </div>
            
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
                        <div class="foto-container">
                            <img id="imagenProducto" src="{{ asset($fotoReal) }}" 
                                 onclick="mostrarImagenCompleta('{{ asset($fotoReal) }}', '{{ $producto->nombre }}')"
                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer;">
                            <button onclick="eliminarFotoProducto()" class="delete-btn" title="Eliminar foto">×</button>
                        </div>
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
                        <img id="imagenProducto" src="{{ asset('images/svg/' . $svg) }}" alt="{{ $producto->tipo }}" 
                             style="width: 80px; height: 80px; object-fit: contain; border-radius: 8px;">
                        <span style="color: #999; font-style: italic; font-size: 14px;">Sin foto</span>
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
                    <img id="imagenProducto" src="{{ asset('images/svg/' . $svg) }}" alt="{{ $producto->tipo }}" 
                         style="width: 80px; height: 80px; object-fit: contain; border-radius: 8px;">
                    <span style="color: #999; font-style: italic; font-size: 14px;">Sin foto</span>
                @endif
            </div>
        </div>
    </div>
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
    min-width: 100px;
}

.value {
    font-weight: 600;
    color: #333;
}

.value-input {
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 14px;
    width: 60%;
    max-width: 200px;
}

.value-input:focus {
    outline: none;
    border-color: #dc2626;
    box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.1);
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
    flex-wrap: wrap;
}

.foto-container {
    position: relative;
    display: inline-block;
}

.foto-container:hover .delete-btn {
    opacity: 1;
    visibility: visible;
}

.delete-btn {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #dc2626;
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    z-index: 10;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.delete-btn:hover {
    background: #b91c1c;
    transform: scale(1.1);
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

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-success {
    background: #16a34a;
    color: white;
}

.btn-success:hover {
    background: #15803d;
}

/* Tablet adjustments */
@media (min-width: 768px) {
    .mobile-content {
        padding: 0 20px;
    }
    
    .info-card {
        padding: 25px;
    }
}
</style>

<script>
function toggleJoyaFields(tipo) {
    const pesoRow = document.getElementById('pesoRow');
    const quilatesRow = document.getElementById('quilatesRow');
    
    if (tipo === 'joya') {
        pesoRow.style.display = '';
        quilatesRow.style.display = '';
    } else {
        pesoRow.style.display = 'none';
        quilatesRow.style.display = 'none';
    }
}

function subirFotoProducto(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const formData = new FormData();
        formData.append('foto', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        // Mostrar loading
        const btn = input.previousElementSibling;
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        btn.disabled = true;
        
        fetch(`/inventario/{{ $producto->id }}/foto`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar imagen
                const img = document.getElementById('imagenProducto');
                img.src = data.foto_url;
                img.onclick = function() {
                    mostrarImagenCompleta(data.foto_url, '{{ $producto->nombre }}');
                };
                img.style.cursor = 'pointer';
                
                // Agregar botón de eliminar si no existe
                if (!document.querySelector('.delete-btn')) {
                    const container = document.querySelector('.foto-container');
                    if (!container) {
                        const newContainer = document.createElement('div');
                        newContainer.className = 'foto-container';
                        img.parentNode.insertBefore(newContainer, img);
                        newContainer.appendChild(img);
                    }
                    
                    const deleteBtn = document.createElement('button');
                    deleteBtn.className = 'delete-btn';
                    deleteBtn.title = 'Eliminar foto';
                    deleteBtn.innerHTML = '×';
                    deleteBtn.onclick = eliminarFotoProducto;
                    document.querySelector('.foto-container').appendChild(deleteBtn);
                }
                
                alert('Foto actualizada exitosamente');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al subir la foto');
        })
        .finally(() => {
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        });
    }
}

function eliminarFotoProducto() {
    if (confirm('¿Estás seguro de que quieres eliminar esta foto?')) {
        fetch(`/inventario/{{ $producto->id }}/foto`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                restaurarImagenPorDefecto();
                alert('Foto eliminada exitosamente');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar la foto');
        });
    }
}

function restaurarImagenPorDefecto() {
    const tipo = '{{ $producto->tipo }}';
    const svgMap = {
        'joya': 'joya.svg',
        'articulo': 'articulo.svg',
        'garrafa': 'garrafa.svg',
        'vehiculo': 'vehiculo.svg'
    };
    const svg = svgMap[tipo] || 'articulo.svg';
    
    const img = document.getElementById('imagenProducto');
    img.src = `/images/svg/${svg}`;
    img.onclick = null;
    img.style.cursor = 'default';
    
    // Remover botón de eliminar
    const deleteBtn = document.querySelector('.delete-btn');
    if (deleteBtn) {
        deleteBtn.remove();
    }
}

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