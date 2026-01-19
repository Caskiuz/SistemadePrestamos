@extends('layouts.main')

@section('content')
<header class="yp-header">
    <h1>
        <a href="{{ route('compras.index') }}" style="color: white; text-decoration: none;">
            <i class="fa fa-arrow-left"></i>
        </a>
        <i class="fa fa-shopping-cart"></i>
        <span>Nueva Compra</span>
    </h1>
</header>

<section class="content">
    <div class="container-fluid">
        <!-- Explicación del proceso -->
        <div class="alert alert-info">
            <h5><i class="fa fa-info-circle"></i> ¿Qué es una compra?</h5>
            <p class="mb-1"><strong>Una compra puede ser:</strong></p>
            <ul class="mb-0">
                <li><strong>Venta directa:</strong> Cliente vende su producto definitivamente a la casa de empeño</li>
                <li><strong>Liquidación:</strong> Préstamo vencido donde el cliente pierde la prenda</li>
                <li><strong>Adquisición:</strong> Compra de productos para inventario y reventa</li>
            </ul>
        </div>
        
        <div class="card">
            <div class="card-body">
                <form action="{{ route('compras.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipo_compra">Tipo de Compra <span class="text-danger">*</span></label>
                                <select name="tipo_compra" id="tipo_compra" class="form-control" required>
                                    <option value="">Seleccione el tipo de compra</option>
                                    <option value="venta_directa">Venta Directa - Cliente vende su producto</option>
                                    <option value="liquidacion">Liquidación - Préstamo vencido</option>
                                    <option value="adquisicion">Adquisición - Compra para inventario</option>
                                </select>
                                <small class="text-muted">Especifique el motivo de esta compra</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cliente_id">Cliente (Vendedor) <span class="text-danger">*</span></label>
                                @if($cliente_id)
                                    @php $clienteSeleccionado = $clientes->find($cliente_id) @endphp
                                    <input type="hidden" name="cliente_id" value="{{ $cliente_id }}">
                                    <input type="text" class="form-control" value="{{ $clienteSeleccionado->nombre }} - {{ $clienteSeleccionado->numero_documento }}" readonly>
                                    <small class="text-muted">Cliente preseleccionado. <a href="{{ route('compras.create') }}">Cambiar cliente</a></small>
                                @else
                                    <select name="cliente_id" id="cliente_id" class="form-control" required>
                                        <option value="">Seleccione el cliente que vende el producto</option>
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
                                <label for="almacen_id">Sucursal/Ubicación <span class="text-danger">*</span></label>
                                <select name="almacen_id" id="almacen_id" class="form-control" required>
                                    <option value="">Seleccione la sucursal donde se registra</option>
                                    @foreach($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}" {{ $almacen->id == 1 ? 'selected' : '' }}>
                                            {{ $almacen->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Sucursal donde se almacenará el producto</small>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-3">Información del Producto/Prenda</h5>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_producto">Nombre del Producto <span class="text-danger">*</span></label>
                                <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" required placeholder="Ej: iPhone 12, Anillo de oro, Televisor Samsung">
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
                                    <option value="herramienta">Herramienta</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="marca">Marca</label>
                                <input type="text" name="marca" id="marca" class="form-control" placeholder="Ej: Samsung, Apple, Sony">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="modelo">Modelo</label>
                                <input type="text" name="modelo" id="modelo" class="form-control" placeholder="Ej: Galaxy S21, iPhone 12">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numero_serie">Número de Serie</label>
                                <input type="text" name="numero_serie" id="numero_serie" class="form-control" placeholder="Número de serie o IMEI">
                            </div>
                        </div>
                    </div>

                    <div class="row" id="joya_fields" style="display: none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="peso">Peso (gramos)</label>
                                <input type="number" name="peso" id="peso" class="form-control" step="0.01" placeholder="Peso en gramos">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quilates">Quilates</label>
                                <select name="quilates" id="quilates" class="form-control">
                                    <option value="">Seleccionar...</option>
                                    <option value="10k">10k</option>
                                    <option value="14k">14k</option>
                                    <option value="18k">18k</option>
                                    <option value="22k">22k</option>
                                    <option value="24k">24k</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="precio_compra">Precio de Compra <span class="text-danger">*</span></label>
                                <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.01" required placeholder="0.00">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="precio_venta">Precio de Venta (Sugerido)</label>
                                <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.01" placeholder="0.00">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="categoria">Categoría</label>
                                <input type="text" name="categoria" id="categoria" class="form-control" placeholder="Ej: Oro, Plata, Electrónico">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Descripción detallada del producto, estado, características especiales..."></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control" rows="3" placeholder="Observaciones adicionales sobre la compra..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="fotos">Fotografías del Producto</label>
                                <div class="foto-upload-area" id="fotoUploadArea" style="border: 2px dashed #dc2626; border-radius: 8px; padding: 30px; text-align: center; background: #f8f9fa; cursor: pointer; margin-bottom: 10px;">
                                    <i class="fa fa-camera" style="font-size: 36px; color: #dc2626; margin-bottom: 10px;"></i>
                                    <div style="color: #333; margin-bottom: 5px; font-weight: bold;">Subir Fotos</div>
                                    <div style="color: #666; font-size: 12px;">Desde PC, galería o cámara</div>
                                    <input type="file" id="fotoInput" name="fotos[]" multiple accept="image/*" capture="environment" style="display: none;">
                                </div>
                                <div style="display: flex; gap: 10px; margin-bottom: 15px; justify-content: center;">
                                    <button type="button" onclick="document.getElementById('fotoInput').click();" class="btn btn-primary btn-sm">
                                        <i class="fa fa-folder-open"></i> Galería
                                    </button>
                                    <button type="button" onclick="abrirCamara()" class="btn btn-success btn-sm">
                                        <i class="fa fa-camera"></i> Cámara
                                    </button>
                                </div>
                                <div class="fotos-preview" id="fotosPreview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px;"></div>
                                <small class="form-text text-muted">Puede subir múltiples fotos. Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB por foto.</small>
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
<style>
.preview-image {
    max-width: 150px;
    max-height: 150px;
    margin: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.foto-upload-area {
    transition: all 0.3s ease;
}

.foto-upload-area:hover {
    border-color: #991b1b !important;
    background-color: #f1f5f9 !important;
}

.fotos-preview {
    min-height: 50px;
}

.fotos-preview > div {
    transition: transform 0.2s ease;
}

.fotos-preview > div:hover {
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .foto-upload-area {
        padding: 20px;
    }
    
    .foto-upload-area i {
        font-size: 24px !important;
    }
    
    .fotos-preview {
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)) !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Mostrar campos especiales para joyas
    $('#tipo').change(function() {
        if ($(this).val() === 'joya') {
            $('#joya_fields').show();
        } else {
            $('#joya_fields').hide();
        }
    });
    
    // Calcular precio de venta sugerido
    $('#precio_compra').on('input', function() {
        var precioCompra = parseFloat($(this).val()) || 0;
        var precioVentaSugerido = precioCompra * 1.3; // 30% de ganancia
        $('#precio_venta').val(precioVentaSugerido.toFixed(2));
    });
    
    // Configurar sistema de subida de fotos
    configurarSubidaFotos();
});

// Funciones para manejo de fotos
function configurarSubidaFotos() {
    const uploadArea = document.getElementById('fotoUploadArea');
    const fotoInput = document.getElementById('fotoInput');
    
    if (!uploadArea || !fotoInput) return;
    
    // Click en área de upload
    uploadArea.addEventListener('click', function() {
        fotoInput.click();
    });
    
    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#991b1b';
        uploadArea.style.backgroundColor = '#f1f5f9';
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#dc2626';
        uploadArea.style.backgroundColor = '#f8f9fa';
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#dc2626';
        uploadArea.style.backgroundColor = '#f8f9fa';
        const files = e.dataTransfer.files;
        procesarArchivos(files);
    });
    
    // Input file change
    fotoInput.addEventListener('change', function(e) {
        procesarArchivos(e.target.files);
    });
}

function procesarArchivos(files) {
    for (let file of files) {
        if (file.type.startsWith('image/')) {
            mostrarPreview(file);
        }
    }
}

function mostrarPreview(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('fotosPreview');
        
        const item = document.createElement('div');
        item.style.cssText = 'position: relative; border-radius: 8px; overflow: hidden; background: #f8f9fa; border: 1px solid #dee2e6;';
        item.innerHTML = `
            <img src="${e.target.result}" style="width: 100%; height: 120px; object-fit: cover;">
            <button type="button" onclick="this.parentElement.remove()" style="position: absolute; top: 5px; right: 5px; background: #dc2626; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; cursor: pointer; font-size: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                ×
            </button>
            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); color: white; padding: 5px; font-size: 11px; text-align: center;">
                ${file.name}
            </div>
        `;
        
        preview.appendChild(item);
    };
    reader.readAsDataURL(file);
}

function abrirCamara() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.capture = 'environment'; // Cámara trasera en móvil
    input.onchange = function(e) {
        procesarArchivos(e.target.files);
    };
    input.click();
}
</script>
@endpush
