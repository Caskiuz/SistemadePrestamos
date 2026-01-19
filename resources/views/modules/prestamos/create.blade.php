@extends('layouts.main')

@section('content')
<header class="yp-header" style="background: #546e7a;">
    <h1>
        <a href="{{ route('clientes.show', $cliente_id ?? '') }}" style="color: white; text-decoration: none;">
            <i class="fa fa-arrow-left"></i>
        </a>
        <span>Nuevo préstamo</span>
    </h1>
</header>

<section class="content" style="background: #1e1e1e; min-height: calc(100vh - 120px); padding: 20px;">
    <form action="{{ route('prestamos.store') }}" method="POST" id="formPrestamo" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="cliente_id" value="{{ $cliente_id ?? '' }}">
        
        <div style="max-width: 800px; margin: 0 auto;">
            <!-- Selector de Cliente -->
            @if(!isset($cliente_id))
            <div style="margin-bottom: 20px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control" style="background: #2c2c2c; color: white; border: 1px solid #444; padding: 10px;" required>
                    <option value="">Seleccione un cliente...</option>
                    @foreach(\App\Models\Cliente::all() as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }} - {{ $cliente->documento }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            
            <!-- Selector de Almacén -->
            <div style="margin-bottom: 20px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Almacén</label>
                <select name="almacen_id" id="almacen_id" class="form-control" style="background: #2c2c2c; color: white; border: 1px solid #444; padding: 10px;" required>
                    <option value="">Seleccione un almacén...</option>
                    @foreach(\App\Models\Almacen::all() as $almacen)
                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }} - {{ $almacen->direccion }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Resumen -->
            <div style="margin-bottom: 20px; padding: 15px; background: #2c2c2c; border-radius: 4px;">
                <div style="color: #2196f3; font-weight: bold; margin-bottom: 5px;">Resumen</div>
                <div id="resumenInteres" style="color: white; font-size: 14px;">10% de interés mensual durante 1 mes (vehículos: libre del 1% al 10%)</div>
            </div>

            <!-- Fecha -->
            <div style="margin-bottom: 20px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Fecha de préstamo</label>
                <input type="date" name="fecha_prestamo" id="fecha_prestamo" value="{{ date('Y-m-d') }}" onchange="actualizarResumen()" class="form-control" style="background: #2c2c2c; color: white; border: 1px solid #444; padding: 10px;" required>
            </div>

            <!-- Prendas en garantía -->
            <div style="margin-bottom: 20px;">
                <label style="color: white; display: block; margin-bottom: 10px; font-size: 16px;">Prendas en garantía</label>
                <div id="prendasContainer"></div>
                <button type="button" onclick="agregarPrenda()" style="background: #4caf50; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; margin-top: 10px;">
                    <i class="fa fa-plus"></i> Agregar prenda
                </button>
            </div>

            <!-- Monto total -->
            <div style="background: #2c2c2c; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                <div style="color: #999; font-size: 14px; margin-bottom: 5px;">Préstamo total</div>
                <h3 style="color: white; margin: 0 0 15px 0; font-size: 32px;" id="montoTotal">Bs 0.00</h3>
                <div style="color: #999; font-size: 14px; margin-bottom: 5px;">Interés al finalizar el plazo</div>
                <h4 style="color: white; margin: 0 0 15px 0; font-size: 24px;" id="montoInteres">Bs 0.00</h4>
                <div style="color: #999; font-size: 14px; margin-bottom: 5px;">Total a pagar al finalizar el plazo</div>
                <h4 style="color: white; margin: 0; font-size: 24px;" id="montoTotalConInteres">Bs 0.00</h4>
            </div>

            <!-- Botones -->
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="flex: 1; background: #2196f3; color: white; border: none; padding: 15px; border-radius: 4px; cursor: pointer; font-size: 16px;">
                    Guardar préstamo
                </button>
                <a href="{{ route('clientes.show', $cliente_id ?? '') }}" style="flex: 1; background: #757575; color: white; border: none; padding: 15px; border-radius: 4px; cursor: pointer; font-size: 16px; text-align: center; text-decoration: none; display: block;">
                    Cancelar
                </a>
            </div>
        </div>
    </form>
</section>

<script>
let prendaCount = 0;

function agregarPrenda() {
    prendaCount++;
    const container = document.getElementById('prendasContainer');
    const prendaDiv = document.createElement('div');
    prendaDiv.id = 'prenda' + prendaCount;
    prendaDiv.style.cssText = 'background: #2c2c2c; padding: 20px; border-radius: 8px; margin-bottom: 15px; position: relative;';
    
    prendaDiv.innerHTML = `
        <button type="button" onclick="eliminarPrenda(${prendaCount})" style="position: absolute; top: 10px; right: 10px; background: #f44336; color: white; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer;">
            <i class="fa fa-times"></i>
        </button>
        
        <div style="margin-bottom: 15px;">
            <label style="color: white; display: block; margin-bottom: 5px;">Tipo</label>
            <select name="prendas[${prendaCount}][tipo]" onchange="cambiarTipoPrenda(${prendaCount}, this.value)" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;" required>
                <option value="">Selecciona el tipo de prenda</option>
                <option value="articulo">Artículo</option>
                <option value="joya">Joya</option>
                <option value="vehiculo">Vehículo</option>
                <option value="garrafa">Garrafa</option>
            </select>
        </div>
        
        <div id="camposPrenda${prendaCount}"></div>
    `;
    
    container.appendChild(prendaDiv);
}

function eliminarPrenda(id) {
    document.getElementById('prenda' + id).remove();
    calcularTotal();
}

function cambiarTipoPrenda(id, tipo) {
    const camposDiv = document.getElementById('camposPrenda' + id);
    let html = '';
    
    if (tipo === 'articulo') {
        html = `
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Descripción</label>
                <input type="text" name="prendas[${id}][descripcion]" placeholder="Descripción del artículo" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;" required>
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Marca</label>
                <input type="text" name="prendas[${id}][marca]" placeholder="Nombre del fabricante" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Modelo</label>
                <input type="text" name="prendas[${id}][modelo]" placeholder="Nombre del producto" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Serie</label>
                <input type="text" name="prendas[${id}][numero_serie]" placeholder="Número de serie" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Observaciones</label>
                <textarea name="prendas[${id}][observaciones]" placeholder="Estado actual, marcas de deterioro, defectos." class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px; min-height: 80px;"></textarea>
            </div>
            
            <!-- Sistema de subida de fotos -->
            <div style="margin-bottom: 15px;">
                <label style="color: white; display: block; margin-bottom: 10px;">Fotos del Artículo</label>
                <div class="foto-upload-area" id="fotoUploadArea${id}" style="border: 2px dashed #dc2626; border-radius: 8px; padding: 30px; text-align: center; background: #2c2c2c; cursor: pointer; margin-bottom: 10px;">
                    <i class="fa fa-camera" style="font-size: 36px; color: #dc2626; margin-bottom: 10px;"></i>
                    <div style="color: white; margin-bottom: 5px;">Subir Fotos</div>
                    <div style="color: #999; font-size: 12px;">Desde PC, galería o cámara</div>
                    <input type="file" id="fotoInput${id}" name="prendas[${id}][fotos][]" multiple accept="image/*" capture="environment" style="display: none;">
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <button type="button" onclick="document.getElementById('fotoInput${id}').click();" style="background: #2196f3; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 12px;">
                        <i class="fa fa-folder-open"></i> Galería
                    </button>
                    <button type="button" onclick="abrirCamara(${id})" style="background: #4caf50; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 12px;">
                        <i class="fa fa-camera"></i> Cámara
                    </button>
                </div>
                <div class="fotos-preview" id="fotosPreview${id}" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px;"></div>
            </div>
            
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Avalúo</label>
                <input type="number" name="prendas[${id}][avaluo]" step="0.01" placeholder="Valor comercial del artículo" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Valuación</label>
                <input type="number" name="prendas[${id}][valuacion]" step="0.01" class="form-control valuacion" onchange="calcularTotal()" placeholder="Monto a prestar por esta prenda" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;" required>
            </div>
        `;
    } else if (tipo === 'joya') {
        html = `
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Descripción</label>
                <input type="text" name="prendas[${id}][descripcion]" placeholder="Descripción de la joya" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 10px;">
                <div>
                    <label style="color: white; display: block; margin-bottom: 5px;">Peso (gramos)</label>
                    <input type="number" name="prendas[${id}][peso]" step="0.01" placeholder="0.00" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
                </div>
                <div>
                    <label style="color: white; display: block; margin-bottom: 5px;">Quilates</label>
                    <input type="text" name="prendas[${id}][quilates]" placeholder="10k, 14k, 18k, 24k" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
                </div>
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Observaciones</label>
                <textarea name="prendas[${id}][observaciones]" placeholder="Estado actual, marcas de deterioro, defectos." class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px; min-height: 80px;"></textarea>
            </div>
            
            <!-- Sistema de subida de fotos -->
            <div style="margin-bottom: 15px;">
                <label style="color: white; display: block; margin-bottom: 10px;">Fotos de la Joya</label>
                <div class="foto-upload-area" id="fotoUploadArea${id}" style="border: 2px dashed #dc2626; border-radius: 8px; padding: 30px; text-align: center; background: #2c2c2c; cursor: pointer; margin-bottom: 10px;">
                    <i class="fa fa-camera" style="font-size: 36px; color: #dc2626; margin-bottom: 10px;"></i>
                    <div style="color: white; margin-bottom: 5px;">Subir Fotos</div>
                    <div style="color: #999; font-size: 12px;">Desde PC, galería o cámara</div>
                    <input type="file" id="fotoInput${id}" name="prendas[${id}][fotos][]" multiple accept="image/*" capture="environment" style="display: none;">
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <button type="button" onclick="document.getElementById('fotoInput${id}').click();" style="background: #2196f3; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 12px;">
                        <i class="fa fa-folder-open"></i> Galería
                    </button>
                    <button type="button" onclick="abrirCamara(${id})" style="background: #4caf50; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 12px;">
                        <i class="fa fa-camera"></i> Cámara
                    </button>
                </div>
                <div class="fotos-preview" id="fotosPreview${id}" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px;"></div>
            </div>
            
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Avalúo</label>
                <input type="number" name="prendas[${id}][avaluo]" step="0.01" placeholder="Valor de apreciación de la prenda" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Valuación</label>
                <input type="number" name="prendas[${id}][valuacion]" step="0.01" class="form-control valuacion" onchange="calcularTotal()" placeholder="Monto a prestar por esta prenda" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;" required>
            </div>
        `;
    } else if (tipo === 'vehiculo') {
        html = `
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Marca</label>
                <input type="text" name="prendas[${id}][marca]" placeholder="Ford, Toyota, Chevrolet, etc." class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;" required>
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Línea</label>
                <input type="text" name="prendas[${id}][linea]" placeholder="Focus, Corolla, Silverado, etc" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Modelo</label>
                <input type="text" name="prendas[${id}][modelo]" placeholder="Año del vehículo" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;" required>
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Serie</label>
                <input type="text" name="prendas[${id}][numero_serie]" placeholder="Número de serie" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Kilometraje</label>
                <input type="text" name="prendas[${id}][kilometraje]" placeholder="Como lo marca el tablero" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Interés (%)</label>
                <input type="number" name="prendas[${id}][interes_personalizado]" step="0.01" min="1" max="10" placeholder="Ej: 5.5" class="form-control interes-vehiculo" onchange="calcularTotalVehiculo(${id})" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;" required>
                <small style="color: #999; font-size: 11px;">Para vehículos el interés es libre del 1% al 10%</small>
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Observaciones</label>
                <textarea name="prendas[${id}][observaciones]" placeholder="Estado actual, marcas de deterioro, defectos." class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px; min-height: 80px;"></textarea>
            </div>
            
            <!-- Sistema de subida de fotos -->
            <div style="margin-bottom: 15px;">
                <label style="color: white; display: block; margin-bottom: 10px;">Fotos del Vehículo</label>
                <div class="foto-upload-area" id="fotoUploadArea${id}" style="border: 2px dashed #dc2626; border-radius: 8px; padding: 30px; text-align: center; background: #2c2c2c; cursor: pointer; margin-bottom: 10px;">
                    <i class="fa fa-camera" style="font-size: 36px; color: #dc2626; margin-bottom: 10px;"></i>
                    <div style="color: white; margin-bottom: 5px;">Subir Fotos</div>
                    <div style="color: #999; font-size: 12px;">Desde PC, galería o cámara</div>
                    <input type="file" id="fotoInput${id}" name="prendas[${id}][fotos][]" multiple accept="image/*" capture="environment" style="display: none;">
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <button type="button" onclick="document.getElementById('fotoInput${id}').click();" style="background: #2196f3; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 12px;">
                        <i class="fa fa-folder-open"></i> Galería
                    </button>
                    <button type="button" onclick="abrirCamara(${id})" style="background: #4caf50; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 12px;">
                        <i class="fa fa-camera"></i> Cámara
                    </button>
                </div>
                <div class="fotos-preview" id="fotosPreview${id}" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px;"></div>
            </div>
            
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Avalúo</label>
                <input type="number" name="prendas[${id}][avaluo]" step="0.01" placeholder="Valor de apreciación de la prenda" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Valuación</label>
                <input type="number" name="prendas[${id}][valuacion]" step="0.01" class="form-control valuacion" onchange="calcularTotal()" placeholder="Monto a prestar por esta prenda" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;" required>
            </div>
        `;
    } else if (tipo === 'garrafa') {
        html = `
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Descripción</label>
                <textarea name="prendas[${id}][descripcion]" placeholder="Descripción de la garrafa" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px; min-height: 80px;" required></textarea>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="color: white; display: block; margin-bottom: 10px;">Fotos de la Garrafa</label>
                <div class="foto-upload-area" id="fotoUploadArea${id}" style="border: 2px dashed #dc2626; border-radius: 8px; padding: 30px; text-align: center; background: #2c2c2c; cursor: pointer; margin-bottom: 10px;">
                    <i class="fa fa-camera" style="font-size: 36px; color: #dc2626; margin-bottom: 10px;"></i>
                    <div style="color: white; margin-bottom: 5px;">Subir Fotos</div>
                    <div style="color: #999; font-size: 12px;">Desde PC, galería o cámara</div>
                    <input type="file" id="fotoInput${id}" name="prendas[${id}][fotos][]" multiple accept="image/*" capture="environment" style="display: none;">
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <button type="button" onclick="document.getElementById('fotoInput${id}').click();" style="background: #2196f3; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 12px;">
                        <i class="fa fa-folder-open"></i> Galería
                    </button>
                    <button type="button" onclick="abrirCamara(${id})" style="background: #4caf50; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 12px;">
                        <i class="fa fa-camera"></i> Cámara
                    </button>
                </div>
                <div class="fotos-preview" id="fotosPreview${id}" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px;"></div>
            </div>
            
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Avalúo</label>
                <input type="number" name="prendas[${id}][avaluo]" step="0.01" placeholder="Valor de apreciación de la garrafa" class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;">
            </div>
            <div style="margin-bottom: 10px;">
                <label style="color: white; display: block; margin-bottom: 5px;">Valuación</label>
                <input type="number" name="prendas[${id}][valuacion]" step="0.01" class="form-control valuacion" onchange="calcularTotal()" placeholder="Monto a prestar por esta prenda" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px;" required>
            </div>
        `;
    }
    
    camposDiv.innerHTML = html;
    
    // Configurar eventos de subida de fotos
    if (tipo) {
        configurarSubidaFotos(id);
    }
}

function calcularTotalVehiculo(id) {
    const interesInput = document.querySelector(`input[name="prendas[${id}][interes_personalizado]"]`);
    const valuacionInput = document.querySelector(`input[name="prendas[${id}][valuacion]"]`);
    
    if (interesInput && valuacionInput && interesInput.value && valuacionInput.value) {
        const interes = parseFloat(interesInput.value);
        const valuacion = parseFloat(valuacionInput.value);
        
        // Actualizar resumen para vehículos
        const resumenDiv = document.getElementById('resumenInteres');
        resumenDiv.textContent = `${interes}% de interés mensual para vehículo (libre del 1% al 10%) durante 1 mes`;
    }
    
    calcularTotal();
}

function calcularTotal() {
    const valuaciones = document.querySelectorAll('.valuacion');
    const interesesVehiculos = document.querySelectorAll('.interes-vehiculo');
    
    let total = 0;
    let interesTotal = 0;
    
    // Calcular total de valuaciones
    valuaciones.forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    
    // Calcular interés (usar personalizado para vehículos, 10% para otros)
    valuaciones.forEach((valuacionInput, index) => {
        const valuacion = parseFloat(valuacionInput.value) || 0;
        const interesVehiculoInput = interesesVehiculos[index];
        
        if (interesVehiculoInput && interesVehiculoInput.value) {
            // Usar interés personalizado para vehículos
            const interesPersonalizado = parseFloat(interesVehiculoInput.value) || 10;
            interesTotal += valuacion * (interesPersonalizado / 100);
        } else {
            // Usar 10% para otros tipos de prendas
            interesTotal += valuacion * 0.10;
        }
    });
    
    const totalConInteres = total + interesTotal;
    
    document.getElementById('montoTotal').textContent = 'Bs ' + total.toFixed(2);
    document.getElementById('montoInteres').textContent = 'Bs ' + interesTotal.toFixed(2);
    document.getElementById('montoTotalConInteres').textContent = 'Bs ' + totalConInteres.toFixed(2);
    
    actualizarResumen();
}

function actualizarResumen() {
    const porcentaje = 10; // Interés fijo del 10%
    const fechaPrestamo = document.getElementById('fecha_prestamo').value;
    
    if (fechaPrestamo) {
        const fecha = new Date(fechaPrestamo + 'T00:00:00');
        fecha.setMonth(fecha.getMonth() + 1);
        
        const dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        
        const diaSemana = dias[fecha.getDay()];
        const dia = fecha.getDate();
        const mes = meses[fecha.getMonth()];
        const año = fecha.getFullYear();
        
        const resumen = `${porcentaje}% de interés mensual durante 1 mes, finalizando el ${diaSemana}, ${dia} de ${mes} de ${año} (vehículos: libre del 1% al 10%)`;
        document.getElementById('resumenInteres').textContent = resumen;
    }
}

// Agregar primera prenda automáticamente
window.addEventListener('load', function() {
    agregarPrenda();
    actualizarResumen();
});

// Funciones para manejo de fotos
function configurarSubidaFotos(id) {
    const uploadArea = document.getElementById('fotoUploadArea' + id);
    const fotoInput = document.getElementById('fotoInput' + id);
    
    if (!uploadArea || !fotoInput) return;
    
    // Click en área de upload
    uploadArea.addEventListener('click', function() {
        fotoInput.click();
    });
    
    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#991b1b';
        uploadArea.style.backgroundColor = '#3c2c2c';
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#dc2626';
        uploadArea.style.backgroundColor = '#2c2c2c';
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = '#dc2626';
        uploadArea.style.backgroundColor = '#2c2c2c';
        const files = e.dataTransfer.files;
        procesarArchivos(id, files);
    });
    
    // Input file change
    fotoInput.addEventListener('change', function(e) {
        procesarArchivos(id, e.target.files);
    });
}

function procesarArchivos(id, files) {
    for (let file of files) {
        if (file.type.startsWith('image/')) {
            mostrarPreview(id, file);
        }
    }
}

function mostrarPreview(id, file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('fotosPreview' + id);
        
        const item = document.createElement('div');
        item.style.cssText = 'position: relative; border-radius: 4px; overflow: hidden; background: #1e1e1e;';
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

function abrirCamara(id) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.capture = 'environment'; // Cámara trasera en móvil
    input.onchange = function(e) {
        procesarArchivos(id, e.target.files);
    };
    input.click();
}
</script>
@endsection
