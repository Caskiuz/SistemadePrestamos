@extends('layouts.main')

@section('content')
    <div class="main-content fade-in">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414; font-size: 24px; margin-bottom: 20px;">Panel de Control - Préstamos Santa Ana</h1>
            </div>

            <!-- Panel de Alertas y Notificaciones -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5><i class="fa fa-bell"></i> Centro de Alertas</h5>
                        </div>
                        <div class="card-body" id="alertasContainer">
                            <div class="text-center">
                                <i class="fa fa-spinner fa-spin"></i> Cargando alertas...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas Principales -->
            <div class="responsive-grid">
                <div class="card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Clientes</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($totalClientes ?? 0) }}
                        </div>
                    </div>
                </div>
                
                <div class="card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fa fa-money"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Préstamos Activos</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($prestamosActivos ?? 0) }}
                        </div>
                    </div>
                </div>
                
                <div class="card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Por Vencer (3 días)</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($prestamosPorVencer ?? 0) }}
                        </div>
                    </div>
                </div>
                
                <div class="card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Vencidos</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($prestamosVencidos ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Métricas Financieras -->
            <div class="responsive-grid">
                <div class="card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fa fa-arrow-up"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Ingresos Totales</h4>
                        </div>
                        <div class="card-body">
                            Bs. {{ number_format($totalIngresos ?? 0, 2) }}
                        </div>
                    </div>
                </div>
                
                <div class="card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fa fa-gavel"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Subastas Activas</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($subastasActivas ?? 0) }}
                        </div>
                    </div>
                </div>
                
                <div class="card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fa fa-exchange"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Transferencias Pendientes</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($transferenciasPendientes ?? 0) }}
                        </div>
                    </div>
                </div>
                
                <div class="card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Aprobaciones Pendientes</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($aprobacionesPendientes ?? 0) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Préstamos Recientes</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                            <th>Vencimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($prestamosRecientes ?? [] as $prestamo)
                                            <tr>
                                                <td>{{ $prestamo->folio }}</td>
                                                <td>{{ $prestamo->cliente->nombre ?? 'N/A' }}</td>
                                                <td>${{ number_format($prestamo->monto, 2) }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $prestamo->estado == 'activo' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($prestamo->estado) }}
                                                    </span>
                                                </td>
                                                <td>{{ $prestamo->fecha_vencimiento->format('d/m/Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No hay préstamos recientes</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Accesos Rápidos</h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('prestamos.create') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-plus text-success"></i> Nuevo Préstamo
                                </a>
                                <a href="{{ route('clientes.create') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-user-plus text-primary"></i> Nuevo Cliente
                                </a>
                                <a href="{{ route('subastas.index') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-gavel text-warning"></i> Ver Subastas
                                </a>
                                <a href="{{ route('reportes.rentabilidad') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-chart-line text-info"></i> Reporte Rentabilidad
                                </a>
                                <a href="{{ route('workflows.pendientes') }}" class="list-group-item list-group-item-action">
                                    <i class="fa fa-tasks text-danger"></i> Aprobaciones
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<script>
// Cargar alertas al iniciar la página
document.addEventListener('DOMContentLoaded', function() {
    cargarAlertas();
    // Actualizar alertas cada 5 minutos
    setInterval(cargarAlertas, 300000);
});

function cargarAlertas() {
    fetch('/notificaciones/alertas')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('alertasContainer');
            if (data.length === 0) {
                container.innerHTML = '<div class="text-center text-success"><i class="fa fa-check-circle"></i> No hay alertas pendientes</div>';
            } else {
                let html = '<div class="row">';
                data.forEach(alerta => {
                    html += `
                        <div class="col-md-6 mb-2">
                            <div class="alert alert-${alerta.tipo === 'vencimiento' ? 'warning' : 'danger'} alert-dismissible fade show" role="alert">
                                <strong>${alerta.titulo}</strong><br>
                                <small>${alerta.mensaje}</small>
                                <button type="button" class="close" onclick="marcarLeida(${alerta.id})">
                                    <span>&times;</span>
                                </button>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            }
        })
        .catch(error => {
            console.error('Error cargando alertas:', error);
            document.getElementById('alertasContainer').innerHTML = '<div class="text-center text-muted"><i class="fa fa-exclamation-triangle"></i> Error cargando alertas</div>';
        });
}

function marcarLeida(id) {
    fetch(`/notificaciones/${id}/marcar-leida`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(() => cargarAlertas());
}
</script>
@endsection