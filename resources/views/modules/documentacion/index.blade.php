@extends('layouts.main')

@section('content')
<header class="yp-header">
    <h1>
        <i class="fa fa-book"></i>
        <span>Documentación</span>
    </h1>
</header>

<section class="content">
    <div class="documentation-container">
        <div class="doc-header">
            <h1>Préstamos Santa Ana</h1>
            <p class="subtitle">Sistema de Gestión Integral</p>
            <p class="version">Desarrollado por <strong>Software Productions</strong></p>
        </div>

        <div class="doc-section">
            <h2><i class="fa fa-rocket"></i> Introducción</h2>
            <p>Bienvenido al sistema de gestión integral de Préstamos Santa Ana. Esta plataforma te permite administrar de manera eficiente todos los aspectos de tu negocio de préstamos prendarios.</p>
        </div>

        <div class="doc-section">
            <h2><i class="fa fa-star"></i> Características Principales</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fa fa-users"></i>
                    <h3>Gestión de Clientes</h3>
                    <p>Administra la información completa de tus clientes con historial de transacciones.</p>
                </div>
                <div class="feature-card">
                    <i class="fa fa-money"></i>
                    <h3>Préstamos Inteligentes</h3>
                    <p>Sistema completo con 5 estados: Activos, Vencidos, Expirados, Liquidados y Cancelados.</p>
                </div>
                <div class="feature-card">
                    <i class="fa fa-list-alt"></i>
                    <h3>Inventario de Prendas</h3>
                    <p>Control total del inventario con fotos, valuaciones y seguimiento de estado.</p>
                </div>
                <div class="feature-card">
                    <i class="fa fa-gavel"></i>
                    <h3>Sistema de Subastas</h3>
                    <p>Gestiona subastas para prendas expiradas con ofertas y seguimiento.</p>
                </div>
                <div class="feature-card">
                    <i class="fa fa-bookmark"></i>
                    <h3>Apartados</h3>
                    <p>Sistema de apartados para ventas con pagos parciales y seguimiento.</p>
                </div>
                <div class="feature-card">
                    <i class="fa fa-exchange"></i>
                    <h3>Transferencias</h3>
                    <p>Transfiere productos entre sucursales con control de inventario.</p>
                </div>
            </div>
        </div>

        <div class="doc-section">
            <h2><i class="fa fa-cogs"></i> Módulos del Sistema</h2>
            <div class="modules-list">
                <div class="module-item">
                    <h4><i class="fa fa-user"></i> Clientes</h4>
                    <p>Registro completo de clientes con documentos, fotos y historial crediticio.</p>
                </div>
                <div class="module-item">
                    <h4><i class="fa fa-money"></i> Préstamos</h4>
                    <p>Gestión completa del ciclo de vida de préstamos con intereses automáticos.</p>
                </div>
                <div class="module-item">
                    <h4><i class="fa fa-shopping-cart"></i> Compras</h4>
                    <p>Registro de compras de productos para inventario.</p>
                </div>
                <div class="module-item">
                    <h4><i class="fa fa-shopping-bag"></i> Ventas</h4>
                    <p>Sistema de ventas con control de inventario y facturación.</p>
                </div>
                <div class="module-item">
                    <h4><i class="fa fa-file-text"></i> Reportes</h4>
                    <p>Reportes avanzados de rentabilidad, riesgo crediticio y flujo de efectivo.</p>
                </div>
                <div class="module-item">
                    <h4><i class="fa fa-bell"></i> Notificaciones</h4>
                    <p>Sistema de alertas automáticas para vencimientos y eventos importantes.</p>
                </div>
            </div>
        </div>

        <div class="doc-section">
            <h2><i class="fa fa-shield"></i> Roles y Permisos</h2>
            <div class="roles-grid">
                <div class="role-card">
                    <h4>Gerente</h4>
                    <p>Acceso completo al sistema, gestión de usuarios y configuraciones avanzadas.</p>
                </div>
                <div class="role-card">
                    <h4>Contabilidad</h4>
                    <p>Acceso a módulos contables, reportes financieros y flujo de caja.</p>
                </div>
                <div class="role-card">
                    <h4>Operario</h4>
                    <p>Operaciones diarias de préstamos, clientes e inventario.</p>
                </div>
            </div>
        </div>

        <div class="doc-section">
            <h2><i class="fa fa-mobile"></i> Características Técnicas</h2>
            <ul class="tech-list">
                <li><strong>Responsive Design:</strong> Funciona perfectamente en móviles, tablets y escritorio</li>
                <li><strong>Seguridad Avanzada:</strong> Autenticación robusta y control de acceso por roles</li>
                <li><strong>Base de Datos:</strong> MySQL con respaldos automáticos</li>
                <li><strong>Interfaz Moderna:</strong> Diseño intuitivo inspirado en las mejores prácticas</li>
                <li><strong>Reportes Avanzados:</strong> Exportación a Excel y PDF</li>
                <li><strong>Notificaciones:</strong> Alertas automáticas y recordatorios</li>
            </ul>
        </div>

        <div class="doc-section">
            <h2><i class="fa fa-question-circle"></i> Soporte</h2>
            <p>Para soporte técnico o consultas sobre el sistema, contacta a:</p>
            <div class="support-info">
                <p><strong>Software Productions</strong></p>
                <p>Desarrolladores del Sistema Préstamos Santa Ana</p>
            </div>
        </div>
    </div>
</section>

<style>
.documentation-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.doc-header {
    text-align: center;
    margin-bottom: 40px;
    padding: 30px;
    background: linear-gradient(135deg, #dc2626, #7c2d12);
    color: white;
    border-radius: 10px;
}

.doc-header h1 {
    font-size: 2.5em;
    margin-bottom: 10px;
}

.subtitle {
    font-size: 1.2em;
    opacity: 0.9;
    margin-bottom: 5px;
}

.version {
    opacity: 0.8;
    font-size: 0.9em;
}

.doc-section {
    margin-bottom: 40px;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.doc-section h2 {
    color: #dc2626;
    margin-bottom: 20px;
    font-size: 1.8em;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.feature-card {
    padding: 20px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    text-align: center;
    transition: transform 0.3s;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.feature-card i {
    font-size: 2em;
    color: #dc2626;
    margin-bottom: 15px;
}

.feature-card h3 {
    margin-bottom: 10px;
    color: #374151;
}

.modules-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 15px;
}

.module-item {
    padding: 15px;
    border-left: 4px solid #dc2626;
    background: #f9fafb;
    border-radius: 0 8px 8px 0;
}

.module-item h4 {
    color: #dc2626;
    margin-bottom: 8px;
}

.roles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.role-card {
    padding: 20px;
    background: #f3f4f6;
    border-radius: 8px;
    border-top: 4px solid #dc2626;
}

.role-card h4 {
    color: #dc2626;
    margin-bottom: 10px;
}

.tech-list {
    list-style: none;
    padding: 0;
}

.tech-list li {
    padding: 10px 0;
    border-bottom: 1px solid #e5e7eb;
}

.tech-list li:last-child {
    border-bottom: none;
}

.support-info {
    background: #f3f4f6;
    padding: 20px;
    border-radius: 8px;
    margin-top: 15px;
}

@media (max-width: 768px) {
    .documentation-container {
        padding: 10px;
    }
    
    .doc-section {
        padding: 20px;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .modules-list {
        grid-template-columns: 1fr;
    }
    
    .roles-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection