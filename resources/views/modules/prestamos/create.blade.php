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
    <form action="{{ route('prestamos.store') }}" method="POST" id="formPrestamo">
        @csrf
        <input type="hidden" name="cliente_id" value="{{ $cliente_id ?? '' }}">
        
        <div style="max-width: 800px; margin: 0 auto;">
            <!-- Categoría -->
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                    <label style="color: white;">Categoría</label>
                    <a href="#" onclick="alert('Funcionalidad de editar categorías en desarrollo'); return false;" style="color: #2196f3; text-decoration: none; font-size: 14px;">Editar categorías</a>
                </div>
                <select name="interes_id" id="interes_id" class="form-control" onchange="actualizarResumen()" style="background: #2c2c2c; color: white; border: 1px solid #444; padding: 10px;">
                    @foreach($intereses as $interes)
                        <option value="{{ $interes->id }}" data-porcentaje="{{ $interes->porcentaje }}" {{ $interes->nombre == 'General' || $interes->porcentaje == 10 ? 'selected' : '' }}>{{ $interes->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Resumen -->
            <div style="margin-bottom: 20px; padding: 15px; background: #2c2c2c; border-radius: 4px;">
                <div style="color: #2196f3; font-weight: bold; margin-bottom: 5px;">Resumen</div>
                <div id="resumenInteres" style="color: white; font-size: 14px;"></div>
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
                <h3 style="color: white; margin: 0 0 15px 0; font-size: 32px;" id="montoTotal">$0.00</h3>
                <div style="color: #999; font-size: 14px; margin-bottom: 5px;">Interés al finalizar el plazo</div>
                <h4 style="color: white; margin: 0 0 15px 0; font-size: 24px;" id="montoInteres">$0.00</h4>
                <div style="color: #999; font-size: 14px; margin-bottom: 5px;">Total a pagar al finalizar el plazo</div>
                <h4 style="color: white; margin: 0; font-size: 24px;" id="montoTotalConInteres">$0.00</h4>
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
                <label style="color: white; display: block; margin-bottom: 5px;">Observaciones</label>
                <textarea name="prendas[${id}][observaciones]" placeholder="Estado actual, marcas de deterioro, defectos." class="form-control" style="background: #1e1e1e; color: white; border: 1px solid #444; padding: 10px; min-height: 80px;"></textarea>
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
    }
    
    camposDiv.innerHTML = html;
}

function calcularTotal() {
    const valuaciones = document.querySelectorAll('.valuacion');
    let total = 0;
    valuaciones.forEach(input => {
        total += parseFloat(input.value) || 0;
    });
    document.getElementById('montoTotal').textContent = '$' + total.toFixed(2);
    
    // Calcular interés
    const selectInteres = document.getElementById('interes_id');
    const porcentaje = parseFloat(selectInteres.options[selectInteres.selectedIndex].dataset.porcentaje) || 0;
    const interes = total * (porcentaje / 100);
    const totalConInteres = total + interes;
    
    document.getElementById('montoInteres').textContent = '$' + interes.toFixed(2);
    document.getElementById('montoTotalConInteres').textContent = '$' + totalConInteres.toFixed(2);
    
    actualizarResumen();
}

function actualizarResumen() {
    const selectInteres = document.getElementById('interes_id');
    const porcentaje = parseFloat(selectInteres.options[selectInteres.selectedIndex].dataset.porcentaje) || 0;
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
        
        const resumen = `${porcentaje}% de interés mensual durante 1 mes, finalizando el ${diaSemana}, ${dia} de ${mes} de ${año}`;
        document.getElementById('resumenInteres').textContent = resumen;
    }
}

// Agregar primera prenda automáticamente
window.addEventListener('load', function() {
    agregarPrenda();
    actualizarResumen();
});
</script>
@endsection
