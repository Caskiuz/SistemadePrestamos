@extends('layouts.main')

@section('content')
<x-mobile-header title="Dashboard Ejecutivo" />

<div class="dashboard-avanzado">
    <!-- KPIs Cards -->
    <div class="kpis-grid">
        <div class="kpi-card primary">
            <div class="kpi-icon"><i class="fa fa-money"></i></div>
            <div class="kpi-content">
                <h3 id="prestamos-activos">{{ $kpis['prestamos_activos'] }}</h3>
                <p>Préstamos Activos</p>
            </div>
        </div>
        
        <div class="kpi-card success">
            <div class="kpi-icon"><i class="fa fa-dollar"></i></div>
            <div class="kpi-content">
                <h3 id="monto-mes">{{ formatCurrency($kpis['monto_prestado_mes']) }}</h3>
                <p>Prestado Este Mes</p>
            </div>
        </div>
        
        <div class="kpi-card info">
            <div class="kpi-icon"><i class="fa fa-users"></i></div>
            <div class="kpi-content">
                <h3 id="clientes-activos">{{ $kpis['clientes_activos'] }}</h3>
                <p>Clientes Activos</p>
            </div>
        </div>
        
        <div class="kpi-card warning">
            <div class="kpi-icon"><i class="fa fa-exclamation-triangle"></i></div>
            <div class="kpi-content">
                <h3 id="prestamos-vencidos">{{ $kpis['prestamos_vencidos'] }}</h3>
                <p>Préstamos Vencidos</p>
            </div>
        </div>
        
        <div class="kpi-card secondary">
            <div class="kpi-icon"><i class="fa fa-bank"></i></div>
            <div class="kpi-content">
                <h3 id="efectivo-caja">{{ formatCurrency($kpis['efectivo_caja']) }}</h3>
                <p>Efectivo en Caja</p>
            </div>
        </div>
        
        <div class="kpi-card success">
            <div class="kpi-icon"><i class="fa fa-percent"></i></div>
            <div class="kpi-content">
                <h3 id="tasa-recuperacion">{{ $kpis['tasa_recuperacion'] }}%</h3>
                <p>Tasa Recuperación</p>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="charts-grid">
        <!-- Préstamos por Mes -->
        <div class="chart-card">
            <div class="chart-header">
                <h4>Préstamos por Mes</h4>
            </div>
            <div class="data-table">
                @forelse($graficos['prestamos_por_mes'] as $item)
                <div class="data-row">
                    <span class="data-label">Mes {{ $item->mes }}</span>
                    <div class="data-bar">
                        <div class="bar-fill" style="width: {{ ($item->cantidad / 10) * 100 }}%"></div>
                        <span class="data-value">{{ $item->cantidad }} préstamos</span>
                    </div>
                </div>
                @empty
                <div class="no-data">No hay datos disponibles</div>
                @endforelse
            </div>
        </div>

        <!-- Estados de Préstamos -->
        <div class="chart-card">
            <div class="chart-header">
                <h4>Estados de Préstamos</h4>
            </div>
            <div class="data-table">
                @forelse($graficos['estados_prestamos'] as $item)
                <div class="data-row">
                    <span class="data-label">{{ ucfirst($item->estado) }}</span>
                    <div class="data-bar">
                        <div class="bar-fill estado-{{ $item->estado }}" style="width: {{ ($item->cantidad / 10) * 100 }}%"></div>
                        <span class="data-value">{{ $item->cantidad }}</span>
                    </div>
                </div>
                @empty
                <div class="no-data">No hay datos disponibles</div>
                @endforelse
            </div>
        </div>

        <!-- Flujo de Caja -->
        <div class="chart-card full-width">
            <div class="chart-header">
                <h4>Flujo de Caja Diario</h4>
            </div>
            <div class="data-table">
                @forelse($graficos['flujo_caja_semanal'] as $item)
                <div class="data-row">
                    <span class="data-label">{{ $item->fecha }}</span>
                    <div class="data-bar">
                        <div class="bar-fill {{ $item->flujo >= 0 ? 'positive' : 'negative' }}" 
                             style="width: {{ (abs($item->flujo) / 25000) * 100 }}%"></div>
                        <span class="data-value">{{ formatCurrency($item->flujo) }}</span>
                    </div>
                </div>
                @empty
                <div class="no-data">No hay datos disponibles</div>
                @endforelse
            </div>
        </div>

        <!-- Préstamos Recientes -->
        <div class="chart-card">
            <div class="chart-header">
                <h4>Préstamos Recientes</h4>
            </div>
            <div class="prestamos-recientes-list">
                @forelse($graficos['prestamos_recientes'] as $prestamo)
                <div class="prestamo-item">
                    <div class="prestamo-info">
                        <span class="folio">{{ $prestamo->folio }}</span>
                        <span class="cliente">{{ $prestamo->cliente->nombre ?? 'N/A' }}</span>
                    </div>
                    <div class="prestamo-details">
                        <span class="monto">{{ formatCurrency($prestamo->monto) }}</span>
                        <span class="estado badge-{{ $prestamo->estado == 'activo' ? 'success' : 'secondary' }}">{{ ucfirst($prestamo->estado) }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted">No hay préstamos recientes</div>
                @endforelse
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="chart-card">
            <div class="chart-header">
                <h4>Accesos Rápidos</h4>
            </div>
            <div class="quick-actions">
                <a href="{{ route('prestamos.create') }}" class="quick-action-btn primary">
                    <i class="fa fa-plus"></i>
                    <span>Nuevo Préstamo</span>
                </a>
                <a href="#" onclick="mostrarModalCliente()" class="quick-action-btn info">
                    <i class="fa fa-user-plus"></i>
                    <span>Nuevo Cliente</span>
                </a>
                <a href="{{ route('prestamos.index') }}" class="quick-action-btn success">
                    <i class="fa fa-list"></i>
                    <span>Ver Préstamos</span>
                </a>
                <a href="{{ route('reportes.cashflow') }}" class="quick-action-btn warning">
                    <i class="fa fa-chart-line"></i>
                    <span>Reportes</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-avanzado {
    padding: 15px;
    background: #f8f9fa;
    min-height: calc(100vh - 70px);
}

.kpis-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.kpi-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.kpi-card:hover {
    transform: translateY(-5px);
}

.kpi-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 24px;
    color: white;
}

.kpi-card.primary .kpi-icon { background: #007bff; }
.kpi-card.success .kpi-icon { background: #28a745; }
.kpi-card.info .kpi-icon { background: #17a2b8; }
.kpi-card.warning .kpi-icon { background: #ffc107; }
.kpi-card.secondary .kpi-icon { background: #6c757d; }

.kpi-content h3 {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    color: #333;
}

.kpi-content p {
    margin: 5px 0 0 0;
    color: #666;
    font-size: 14px;
}

.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 20px;
}

.chart-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.chart-card.full-width {
    grid-column: 1 / -1;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}

.chart-header h4 {
    margin: 0;
    color: #333;
    font-weight: 600;
}

.chart-controls {
    display: flex;
    gap: 10px;
}

.btn-chart {
    padding: 5px 15px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 12px;
}

.btn-chart.active {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.btn-refresh {
    padding: 8px 12px;
    border: none;
    background: #f8f9fa;
    border-radius: 6px;
    cursor: pointer;
    color: #666;
    transition: all 0.3s;
}

.btn-refresh:hover {
    background: #e9ecef;
}

.prestamos-recientes-list {
    max-height: 300px;
    overflow-y: auto;
}

.prestamo-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.prestamo-item:last-child {
    border-bottom: none;
}

.prestamo-info .folio {
    font-weight: 600;
    color: #333;
    display: block;
}

.prestamo-info .cliente {
    font-size: 12px;
    color: #666;
}

.prestamo-details {
    text-align: right;
}

.prestamo-details .monto {
    font-weight: 600;
    color: #28a745;
    display: block;
}

.prestamo-details .estado {
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 10px;
    color: white;
}

.badge-success { background: #28a745; }
.badge-secondary { background: #6c757d; }

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 15px;
}

.quick-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px 15px;
    border-radius: 8px;
    text-decoration: none;
    color: white;
    transition: all 0.3s;
    text-align: center;
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    text-decoration: none;
    color: white;
}

.quick-action-btn.primary { background: #007bff; }
.quick-action-btn.info { background: #17a2b8; }
.quick-action-btn.success { background: #28a745; }
.quick-action-btn.warning { background: #ffc107; color: #333; }

.quick-action-btn i {
    font-size: 24px;
    margin-bottom: 8px;
}

.quick-action-btn span {
    font-size: 12px;
    font-weight: 500;
}

/* Estilos para tablas de datos */
.data-table {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.data-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.data-row:last-child {
    border-bottom: none;
}

.data-label {
    font-weight: 500;
    color: #333;
    min-width: 100px;
}

.data-bar {
    flex: 1;
    display: flex;
    align-items: center;
    margin-left: 15px;
    position: relative;
}

.bar-fill {
    height: 20px;
    border-radius: 10px;
    background: #007bff;
    min-width: 2px;
    transition: width 0.3s ease;
}

.bar-fill.estado-activo { background: #28a745; }
.bar-fill.estado-vencido { background: #dc3545; }
.bar-fill.estado-liquidado { background: #6c757d; }
.bar-fill.positive { background: #28a745; }
.bar-fill.negative { background: #dc3545; }

.data-value {
    margin-left: 10px;
    font-weight: 600;
    color: #333;
    min-width: 80px;
    text-align: right;
}

.no-data {
    text-align: center;
    color: #666;
    font-style: italic;
    padding: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-avanzado {
        padding: 10px;
    }
    
    .kpis-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }
    
    .charts-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .kpi-card {
        padding: 15px;
    }
    
    .kpi-content h3 {
        font-size: 24px;
    }
    
    .chart-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .quick-actions {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .kpis-grid {
        grid-template-columns: 1fr;
    }
    
    .kpi-card {
        padding: 12px;
    }
    
    .kpi-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
    
    .kpi-content h3 {
        font-size: 20px;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function mostrarModalCliente() {
    document.getElementById('modalCliente').style.display = 'block';
}

function cerrarModalCliente() {
    document.getElementById('modalCliente').style.display = 'none';
    document.getElementById('formCliente').reset();
}

// Manejar envío del formulario de cliente
document.addEventListener('DOMContentLoaded', function() {
    const formCliente = document.getElementById('formCliente');
    if (formCliente) {
        formCliente.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(formCliente);
            
            fetch('/clientes', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cerrarModalCliente();
                    alert('Cliente creado exitosamente');
                    location.reload();
                } else {
                    alert('Error al crear cliente');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al crear cliente');
            });
        });
    }
});

function actualizarFlujo() {
    const btn = document.querySelector('.btn-refresh');
    if (btn) {
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        setTimeout(() => btn.innerHTML = '<i class="fa fa-refresh"></i>', 2000);
    }
}
</script>
@endsection

<!-- Modal para crear cliente -->
<div id="modalCliente" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; overflow-y: auto;">
    <div style="position: relative; top: 20px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; max-width: 600px; margin-bottom: 40px;">
        <h4>Nuevo Cliente</h4>
        <form id="formCliente">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre completo *</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo *</label>
                        <select name="tipo" class="form-control" required>
                            <option value="PERSONA">Persona</option>
                            <option value="EMPRESA">Empresa</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo de documento *</label>
                        <select name="tipo_documento" class="form-control" required>
                            <option value="CI">Cédula de Identidad (CI)</option>
                            <option value="NIT">NIT</option>
                            <option value="PASAPORTE">Pasaporte</option>
                            <option value="OTRO">Otro</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Número de documento *</label>
                        <input type="text" name="numero_documento" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Teléfono principal *</label>
                        <input type="text" name="telefono_1" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección *</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ciudad</label>
                        <input type="text" name="ciudad" class="form-control" value="Santa Cruz">
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                <button type="button" onclick="cerrarModalCliente()" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
</div>