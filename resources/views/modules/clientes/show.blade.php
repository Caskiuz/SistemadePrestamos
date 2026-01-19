@extends('layouts.main')

@section('content')
<div class="mobile-header">
    <div class="mobile-header-content">
        <a href="{{ route('clientes.index') }}" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>
        <div class="header-info">
            <h1>{{ $cliente->nombre }}</h1>
            <p>{{ $cliente->tipo ?? 'Cliente' }}</p>
        </div>
        <div class="status-badge status-{{ $cliente->estadisticas['activos'] > 0 ? 'activo' : 'inactivo' }}">
            {{ $cliente->estadisticas['activos'] > 0 ? 'Activo' : 'Inactivo' }}
        </div>
    </div>
</div>

<div class="mobile-content">
    <!-- Información Principal -->
    <div class="info-card">
        <div class="info-row">
            <span class="label">Nombre:</span>
            <span class="value">{{ $cliente->nombre }}</span>
        </div>
        <div class="info-row">
            <span class="label">Documento:</span>
            <span class="value">{{ $cliente->tipo_documento ?? 'CI' }}: {{ $cliente->numero_documento ?? 'Sin documento' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Teléfono:</span>
            <span class="value">{{ $cliente->telefono_1 ?? 'Sin teléfono' }}</span>
        </div>
        @if($cliente->telefono_2)
        <div class="info-row">
            <span class="label">Teléfono 2:</span>
            <span class="value">{{ $cliente->telefono_2 }}</span>
        </div>
        @endif
        @if($cliente->email)
        <div class="info-row">
            <span class="label">Email:</span>
            <span class="value">{{ $cliente->email }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="label">Dirección:</span>
            <span class="value">{{ $cliente->direccion ?? 'Sin dirección' }}</span>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="info-card">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number activo">{{ $cliente->estadisticas['activos'] }}</span>
                <span class="stat-label">Activos</span>
            </div>
            <div class="stat-item">
                <span class="stat-number expirado">{{ $cliente->estadisticas['expirados'] }}</span>
                <span class="stat-label">Expirados</span>
            </div>
            <div class="stat-item">
                <span class="stat-number liquidado">{{ $cliente->estadisticas['liquidados'] }}</span>
                <span class="stat-label">Liquidados</span>
            </div>
            <div class="stat-item">
                <span class="stat-number porcentaje">{{ $cliente->estadisticas['porcentaje_liquidacion'] }}%</span>
                <span class="stat-label">Liquidación</span>
            </div>
        </div>
    </div>

    <!-- Acciones Principales -->
    <div class="actions-section">
        <h3>Acciones</h3>
        <div class="action-grid">
            <a href="{{ route('prestamos.create') }}?cliente_id={{ $cliente->id }}" class="action-btn primary">
                <i class="fa fa-money"></i>
                <span>Nuevo Préstamo</span>
            </a>
            <a href="{{ route('compras.create') }}?cliente_id={{ $cliente->id }}" class="action-btn success">
                <i class="fa fa-shopping-cart"></i>
                <span>Nueva Compra</span>
            </a>
            <a href="{{ route('clientes.edit', $cliente) }}" class="action-btn warning">
                <i class="fa fa-edit"></i>
                <span>Editar</span>
            </a>
            <a href="{{ route('clientes.index') }}" class="action-btn secondary">
                <i class="fa fa-list"></i>
                <span>Clientes</span>
            </a>
        </div>
    </div>

    @if($cliente->prestamos->isNotEmpty())
    <!-- Historial de Préstamos -->
    <div class="section">
        <h3>Historial de Préstamos</h3>
        <div class="historial-list">
            @foreach($cliente->prestamos->take(10) as $prestamo)
            <div class="historial-item">
                <div class="historial-date">{{ $prestamo->fecha_prestamo->format('d/m/y') }}</div>
                <div class="historial-desc">
                    <a href="{{ route('prestamos.show', $prestamo->id) }}" style="color: #dc2626; text-decoration: none;">
                        {{ $prestamo->folio }}
                    </a>
                    <br>
                    <small>Vence: {{ $prestamo->fecha_vencimiento->format('d/m/Y') }}</small>
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

<style>
/* Mobile-First Design - Copiado de préstamos */
.mobile-header {
    background: linear-gradient(135deg, #5c6bc0 0%, #3f51b5 100%);
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

.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.stat-item {
    text-align: center;
    padding: 15px;
    background: #f8fafc;
    border-radius: 8px;
}

.stat-number {
    display: block;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 5px;
}

.stat-number.activo { color: #16a34a; }
.stat-number.expirado { color: #dc2626; }
.stat-number.liquidado { color: #3b82f6; }
.stat-number.porcentaje { color: #f59e0b; }

.stat-label {
    font-size: 12px;
    color: #666;
    text-transform: uppercase;
    font-weight: 500;
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
    border-color: #6b7280;
    color: #6b7280;
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

.status-activo { background: #dcfce7; color: #166534; }
.status-inactivo { background: #fee2e2; color: #991b1b; }
.status-vencido { background: #fef3c7; color: #92400e; }
.status-liquidado { background: #dbeafe; color: #1e40af; }
.status-expirado { background: #fee2e2; color: #991b1b; }

/* Tablet adjustments */
@media (min-width: 768px) {
    .action-grid {
        grid-template-columns: repeat(4, 1fr);
    }
    
    .stats-grid {
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
@endsection
