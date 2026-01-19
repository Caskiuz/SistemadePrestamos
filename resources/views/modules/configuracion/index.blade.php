@extends('layouts.main')

@section('content')
<x-mobile-header title="Configuración" />

<div class="mobile-content">
    <div class="section-title">
        <h3>Configuración General</h3>
    </div>
    <div class="config-grid">
        <a href="{{ route('configuracion.empresa') }}" class="config-card">
            <i class="fa fa-building"></i>
            <h5>Empresa</h5>
            <p>Información corporativa</p>
        </a>
        <a href="{{ route('configuracion.prestamos') }}" class="config-card">
            <i class="fa fa-money"></i>
            <h5>Préstamos</h5>
            <p>Tasas e intereses</p>
        </a>
        <a href="{{ route('configuracion.tarifas') }}" class="config-card">
            <i class="fa fa-percent"></i>
            <h5>Tarifas</h5>
            <p>Comisiones y cargos</p>
        </a>
        <a href="{{ route('configuracion.notificaciones') }}" class="config-card">
            <i class="fa fa-bell"></i>
            <h5>Notificaciones</h5>
            <p>Alertas y avisos</p>
        </a>
    </div>

    <div class="section-title">
        <h3>Sistema y Seguridad</h3>
    </div>
    <div class="config-grid">
        <a href="{{ route('almacenes.index') }}" class="config-card">
            <i class="fa fa-map-marker"></i>
            <h5>Sucursales</h5>
            <p>Almacenes y ubicaciones</p>
        </a>
        <a href="{{ route('configuracion.sistema') }}" class="config-card">
            <i class="fa fa-server"></i>
            <h5>Sistema</h5>
            <p>Configuración general</p>
        </a>
        <a href="{{ route('configuracion.seguridad') }}" class="config-card">
            <i class="fa fa-shield"></i>
            <h5>Seguridad</h5>
            <p>Acceso y auditoría</p>
        </a>
        <a href="{{ route('configuracion.reportes') }}" class="config-card">
            <i class="fa fa-file-text"></i>
            <h5>Reportes</h5>
            <p>Formatos y automatización</p>
        </a>
    </div>

    @if(auth()->user()->rol === 'Gerente')
    <div class="section-title">
        <h3>Administración</h3>
    </div>
    <div class="config-grid">
        <a href="{{ route('usuarios.index') }}" class="config-card">
            <i class="fa fa-users"></i>
            <h5>Usuarios</h5>
            <p>Gestión de cuentas</p>
        </a>
        <a href="{{ route('sistema.backups') }}" class="config-card">
            <i class="fa fa-database"></i>
            <h5>Respaldos</h5>
            <p>Backup y restauración</p>
        </a>
        <a href="{{ route('sistema.auditoria') }}" class="config-card">
            <i class="fa fa-history"></i>
            <h5>Auditoría</h5>
            <p>Registro de actividades</p>
        </a>
    </div>
    @endif
</div>

<style>
.section-title {
    margin: 30px 0 15px 0;
}

.section-title:first-child {
    margin-top: 0;
}

.section-title h3 {
    font-size: 18px;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
    padding-bottom: 8px;
    border-bottom: 2px solid var(--primary-color);
}

.config-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.config-card {
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: var(--border-radius);
    padding: 25px 20px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 140px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.config-card:hover {
    background: var(--gray-50);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
}

.config-card i {
    font-size: 36px;
    color: var(--primary-color);
    margin-bottom: 15px;
    display: block;
}

.config-card h5 {
    color: var(--gray-800);
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.3;
}

.config-card p {
    color: var(--gray-600);
    margin: 0;
    font-size: 12px;
    font-weight: 400;
    line-height: 1.3;
}

@media (max-width: 768px) {
    .config-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
    }
    
    .config-card {
        padding: 20px 15px;
        min-height: 120px;
    }
    
    .config-card i {
        font-size: 28px;
        margin-bottom: 12px;
    }
    
    .config-card h5 {
        font-size: 14px;
    }
    
    .config-card p {
        font-size: 11px;
    }
}

@media (max-width: 480px) {
    .config-grid {
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    }
    
    .config-card {
        padding: 15px 10px;
        min-height: 100px;
    }
    
    .config-card i {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .config-card h5 {
        font-size: 13px;
        margin-bottom: 5px;
    }
    
    .config-card p {
        font-size: 10px;
    }
}
</style>
@endsection