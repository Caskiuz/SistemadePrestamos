@extends('layouts.main')

@section('content')
<x-mobile-header title="Documentación" />

<div class="mobile-content">
    <div class="card-mobile">
        <div class="section">
            <h3>Préstamos Santa Ana</h3>
            <p class="text-center">Sistema de Gestión Integral</p>
            <p class="text-center"><strong>Software Productions</strong></p>
        </div>
    </div>

    <div class="card-mobile">
        <div class="section">
            <h3><i class="fa fa-rocket"></i> Introducción</h3>
            <p>Bienvenido al sistema de gestión integral de Préstamos Santa Ana. Esta plataforma te permite administrar de manera eficiente todos los aspectos de tu negocio de préstamos prendarios.</p>
        </div>
    </div>

    <div class="card-mobile">
        <div class="section">
            <h3><i class="fa fa-star"></i> Características Principales</h3>
            <div class="action-grid">
                <div class="action-btn">
                    <i class="fa fa-users"></i>
                    <span>Gestión de Clientes</span>
                </div>
                <div class="action-btn">
                    <i class="fa fa-money"></i>
                    <span>Préstamos Inteligentes</span>
                </div>
                <div class="action-btn">
                    <i class="fa fa-list-alt"></i>
                    <span>Inventario de Prendas</span>
                </div>
                <div class="action-btn">
                    <i class="fa fa-gavel"></i>
                    <span>Sistema de Subastas</span>
                </div>
                <div class="action-btn">
                    <i class="fa fa-bookmark"></i>
                    <span>Apartados</span>
                </div>
                <div class="action-btn">
                    <i class="fa fa-exchange"></i>
                    <span>Transferencias</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card-mobile">
        <div class="section">
            <h3><i class="fa fa-cogs"></i> Módulos del Sistema</h3>
            <div class="list-mobile">
                <div class="list-item">
                    <div class="list-item-header">
                        <div>
                            <h4 class="list-item-title"><i class="fa fa-user"></i> Clientes</h4>
                            <span class="list-item-subtitle">Registro completo de clientes</span>
                        </div>
                    </div>
                </div>
                <div class="list-item">
                    <div class="list-item-header">
                        <div>
                            <h4 class="list-item-title"><i class="fa fa-money"></i> Préstamos</h4>
                            <span class="list-item-subtitle">Gestión completa del ciclo de vida</span>
                        </div>
                    </div>
                </div>
                <div class="list-item">
                    <div class="list-item-header">
                        <div>
                            <h4 class="list-item-title"><i class="fa fa-shopping-cart"></i> Compras</h4>
                            <span class="list-item-subtitle">Registro de compras de productos</span>
                        </div>
                    </div>
                </div>
                <div class="list-item">
                    <div class="list-item-header">
                        <div>
                            <h4 class="list-item-title"><i class="fa fa-shopping-bag"></i> Ventas</h4>
                            <span class="list-item-subtitle">Sistema de ventas con control</span>
                        </div>
                    </div>
                </div>
                <div class="list-item">
                    <div class="list-item-header">
                        <div>
                            <h4 class="list-item-title"><i class="fa fa-file-text"></i> Reportes</h4>
                            <span class="list-item-subtitle">Reportes avanzados de rentabilidad</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-mobile">
        <div class="section">
            <h3><i class="fa fa-shield"></i> Roles y Permisos</h3>
            <div class="action-grid">
                <div class="action-btn primary">
                    <i class="fa fa-user-tie"></i>
                    <span>Gerente</span>
                </div>
                <div class="action-btn secondary">
                    <i class="fa fa-calculator"></i>
                    <span>Contabilidad</span>
                </div>
                <div class="action-btn success">
                    <i class="fa fa-user"></i>
                    <span>Operario</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card-mobile">
        <div class="section">
            <h3><i class="fa fa-mobile"></i> Características Técnicas</h3>
            <div class="info-card">
                <div class="info-row">
                    <span class="label">Responsive Design:</span>
                    <span class="value">Móvil, tablet y escritorio</span>
                </div>
                <div class="info-row">
                    <span class="label">Seguridad:</span>
                    <span class="value">Autenticación robusta</span>
                </div>
                <div class="info-row">
                    <span class="label">Base de Datos:</span>
                    <span class="value">MySQL con respaldos</span>
                </div>
                <div class="info-row">
                    <span class="label">Reportes:</span>
                    <span class="value">Excel y PDF</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card-mobile">
        <div class="section">
            <h3><i class="fa fa-question-circle"></i> Soporte</h3>
            <p>Para soporte técnico o consultas sobre el sistema:</p>
            <div class="info-card">
                <div class="info-row">
                    <span class="label">Desarrollador:</span>
                    <span class="value">Software Productions</span>
                </div>
                <div class="info-row">
                    <span class="label">Sistema:</span>
                    <span class="value">Préstamos Santa Ana</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection