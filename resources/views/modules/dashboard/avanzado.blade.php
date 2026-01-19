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
                <div class="chart-controls">
                    <button class="btn-chart active" data-chart="cantidad">Cantidad</button>
                    <button class="btn-chart" data-chart="monto">Monto</button>
                </div>
            </div>
            <canvas id="prestamos-mes-chart"></canvas>
        </div>

        <!-- Estados de Préstamos -->
        <div class="chart-card">
            <div class="chart-header">
                <h4>Estados de Préstamos</h4>
            </div>
            <canvas id="estados-chart"></canvas>
        </div>

        <!-- Flujo de Caja -->
        <div class="chart-card full-width">
            <div class="chart-header">
                <h4>Flujo de Caja Semanal</h4>
                <div class="chart-controls">
                    <button class="btn-refresh" onclick="actualizarFlujo()">
                        <i class="fa fa-refresh"></i>
                    </button>
                </div>
            </div>
            <canvas id="flujo-caja-chart"></canvas>
        </div>

        <!-- Top Clientes -->
        <div class="chart-card">
            <div class="chart-header">
                <h4>Top 10 Clientes</h4>
            </div>
            <div class="top-clientes-list">
                @foreach($graficos['top_clientes'] as $index => $cliente)
                <div class="cliente-item">
                    <span class="posicion">{{ $index + 1 }}</span>
                    <span class="nombre">{{ $cliente->nombre }}</span>
                    <span class="prestamos">{{ $cliente->total_prestamos }} préstamos</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tipos de Productos -->
        <div class="chart-card">
            <div class="chart-header">
                <h4>Inventario por Tipo</h4>
            </div>
            <canvas id="productos-chart"></canvas>
        </div>
    </div>
</div>

<style>
.dashboard-avanzado {
    padding: 20px;
    background: #f8f9fa;
    min-height: calc(100vh - 70px);
}

.kpis-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
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

.top-clientes-list {
    max-height: 300px;
    overflow-y: auto;
}

.cliente-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.cliente-item:last-child {
    border-bottom: none;
}

.posicion {
    width: 30px;
    height: 30px;
    background: #007bff;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 12px;
    margin-right: 15px;
}

.nombre {
    flex: 1;
    font-weight: 500;
}

.prestamos {
    color: #666;
    font-size: 12px;
}

@media (max-width: 768px) {
    .dashboard-avanzado {
        padding: 10px;
    }
    
    .kpis-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Datos desde PHP
const datosGraficos = @json($graficos);

// Configuración de colores
const colores = {
    primary: '#007bff',
    success: '#28a745',
    warning: '#ffc107',
    danger: '#dc3545',
    info: '#17a2b8'
};

// Gráfico de Préstamos por Mes
const ctxPrestamosMes = document.getElementById('prestamos-mes-chart').getContext('2d');
let chartPrestamosMes = new Chart(ctxPrestamosMes, {
    type: 'line',
    data: {
        labels: datosGraficos.prestamos_por_mes.map(item => `Mes ${item.mes}`),
        datasets: [{
            label: 'Cantidad de Préstamos',
            data: datosGraficos.prestamos_por_mes.map(item => item.cantidad),
            borderColor: colores.primary,
            backgroundColor: colores.primary + '20',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Gráfico de Estados
const ctxEstados = document.getElementById('estados-chart').getContext('2d');
new Chart(ctxEstados, {
    type: 'doughnut',
    data: {
        labels: datosGraficos.estados_prestamos.map(item => item.estado.charAt(0).toUpperCase() + item.estado.slice(1)),
        datasets: [{
            data: datosGraficos.estados_prestamos.map(item => item.cantidad),
            backgroundColor: [
                colores.success,
                colores.warning,
                colores.danger,
                colores.info,
                '#6c757d'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Gráfico de Flujo de Caja
const ctxFlujo = document.getElementById('flujo-caja-chart').getContext('2d');
new Chart(ctxFlujo, {
    type: 'bar',
    data: {
        labels: datosGraficos.flujo_caja_semanal.map(item => `Semana ${item.semana}`),
        datasets: [{
            label: 'Flujo de Caja',
            data: datosGraficos.flujo_caja_semanal.map(item => item.flujo),
            backgroundColor: datosGraficos.flujo_caja_semanal.map(item => 
                item.flujo >= 0 ? colores.success : colores.danger
            )
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Gráfico de Productos
const ctxProductos = document.getElementById('productos-chart').getContext('2d');
new Chart(ctxProductos, {
    type: 'pie',
    data: {
        labels: datosGraficos.tipos_productos.map(item => item.tipo.charAt(0).toUpperCase() + item.tipo.slice(1)),
        datasets: [{
            data: datosGraficos.tipos_productos.map(item => item.cantidad),
            backgroundColor: [
                colores.primary,
                colores.success,
                colores.warning,
                colores.info,
                colores.danger
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Controles de gráficos
document.querySelectorAll('.btn-chart').forEach(btn => {
    btn.addEventListener('click', function() {
        const chart = this.dataset.chart;
        const parent = this.closest('.chart-card');
        
        // Actualizar botones activos
        parent.querySelectorAll('.btn-chart').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Actualizar datos del gráfico
        if (chart === 'monto') {
            chartPrestamosMes.data.datasets[0].data = datosGraficos.prestamos_por_mes.map(item => item.monto_total);
            chartPrestamosMes.data.datasets[0].label = 'Monto Total';
        } else {
            chartPrestamosMes.data.datasets[0].data = datosGraficos.prestamos_por_mes.map(item => item.cantidad);
            chartPrestamosMes.data.datasets[0].label = 'Cantidad de Préstamos';
        }
        chartPrestamosMes.update();
    });
});

// Actualización automática cada 5 minutos
setInterval(actualizarKPIs, 300000);

function actualizarKPIs() {
    fetch('/dashboard-avanzado/data?tipo=kpis')
        .then(response => response.json())
        .then(data => {
            document.getElementById('prestamos-activos').textContent = data.prestamos_activos;
            document.getElementById('monto-mes').textContent = '$' + new Intl.NumberFormat().format(data.monto_prestado_mes);
            document.getElementById('clientes-activos').textContent = data.clientes_activos;
            document.getElementById('prestamos-vencidos').textContent = data.prestamos_vencidos;
            document.getElementById('efectivo-caja').textContent = '$' + new Intl.NumberFormat().format(data.efectivo_caja);
            document.getElementById('tasa-recuperacion').textContent = data.tasa_recuperacion + '%';
        });
}

function actualizarFlujo() {
    const btn = document.querySelector('.btn-refresh');
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
    
    setTimeout(() => {
        btn.innerHTML = '<i class="fa fa-refresh"></i>';
        // Aquí iría la lógica real de actualización
    }, 2000);
}
</script>
@endsection