<section class="toolbar">
    <div class="tool-group">
        <span class="group-name">Desde</span>
        <p class="input-group">
            <input type="text" class="form-control input-sm" id="fecha_desde" name="fecha_desde" value="{{ $fecha_desde ?? date('Y-m-d') }}">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default btn-sm" onclick="openDatePicker('fecha_desde')">
                    <i class="glyphicon glyphicon-calendar"></i>
                </button>
            </span>
        </p>
    </div>
    
    <div class="tool-group">
        <span class="group-name">Hasta</span>
        <p class="input-group">
            <input type="text" class="form-control input-sm" id="fecha_hasta" name="fecha_hasta" value="{{ $fecha_hasta ?? date('Y-m-d') }}">
            <span class="input-group-btn">
                <button type="button" class="btn btn-default btn-sm" onclick="openDatePicker('fecha_hasta')">
                    <i class="glyphicon glyphicon-calendar"></i>
                </button>
            </span>
        </p>
    </div>
    
    <div class="tool-group">
        <span class="group-name">Tipo</span>
        <select id="tipo_concepto" name="tipo_concepto" class="form-control input-sm" onchange="filtrarConcepto()">
            <option value="">Todos</option>
            <option value="0">Préstamo</option>
            <option value="1">Pago de interés extemporáneo</option>
            <option value="2">Pago de intereses</option>
            <option value="3">Abono a capital</option>
            <option value="4">Abono a apartado</option>
            <option value="5">Venta</option>
            <option value="6">Compra</option>
            <option value="7">Cancelación de préstamo</option>
            <option value="8">Depósito</option>
            <option value="9">Retiro</option>
            <option value="10">Cancelación de compra</option>
            <option value="11">Apartado expirado</option>
            <option value="12">Cancelación de venta</option>
            <option value="13">Gasto</option>
            <option value="14">Reposición de boleta</option>
        </select>
    </div>
    
    <div class="save-buttons">
        <a href="{{ route('reportes.index') }}" class="btn btn-default btn-sm">Volver</a>
        <button class="btn btn-success btn-sm" onclick="imprimirReporte()">Imprimir</button>
    </div>
</section>
