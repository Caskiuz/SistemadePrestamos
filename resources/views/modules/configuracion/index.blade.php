@extends('layouts.main')

@section('content')
<div class="main-content fade-in">
    <section class="section">
        <div class="section-header">
            <h1>Panel de Configuración</h1>
            <div class="section-header-breadcrumb">
                <span class="badge badge-primary">Solo Gerentes</span>
            </div>
        </div>

        <div class="row">
            <!-- Configuración de Empresa -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fa fa-building"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Empresa</h4>
                        </div>
                        <div class="card-body">
                            Información corporativa
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('configuracion.empresa') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-cog"></i> Configurar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuración de Préstamos -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fa fa-money"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Préstamos</h4>
                        </div>
                        <div class="card-body">
                            Tasas e intereses
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('configuracion.prestamos') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-cog"></i> Configurar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuración de Tarifas -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fa fa-percent"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tarifas</h4>
                        </div>
                        <div class="card-body">
                            Comisiones y cargos
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('configuracion.tarifas') }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-cog"></i> Configurar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuración de Notificaciones -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fa fa-bell"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Notificaciones</h4>
                        </div>
                        <div class="card-body">
                            Alertas y avisos
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('configuracion.notificaciones') }}" class="btn btn-info btn-sm">
                                <i class="fa fa-cog"></i> Configurar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuración de Sucursales -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-secondary">
                        <i class="fa fa-map-marker"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Sucursales</h4>
                        </div>
                        <div class="card-body">
                            Almacenes y ubicaciones
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('almacenes.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-cog"></i> Configurar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuración del Sistema -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-dark">
                        <i class="fa fa-server"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Sistema</h4>
                        </div>
                        <div class="card-body">
                            Configuración general
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('configuracion.sistema') }}" class="btn btn-dark btn-sm">
                                <i class="fa fa-cog"></i> Configurar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuración de Seguridad -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fa fa-shield"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Seguridad</h4>
                        </div>
                        <div class="card-body">
                            Acceso y auditoría
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('configuracion.seguridad') }}" class="btn btn-danger btn-sm">
                                <i class="fa fa-cog"></i> Configurar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuración de Reportes -->
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-purple">
                        <i class="fa fa-file-text"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Reportes</h4>
                        </div>
                        <div class="card-body">
                            Formatos y automatización
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('configuracion.reportes') }}" class="btn btn-purple btn-sm">
                                <i class="fa fa-cog"></i> Configurar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.btn-purple {
    background-color: #6f42c1;
    border-color: #6f42c1;
    color: #fff;
}
.btn-purple:hover {
    background-color: #5a32a3;
    border-color: #5a32a3;
    color: #fff;
}
.bg-purple {
    background-color: #6f42c1 !important;
}
</style>
@endsection