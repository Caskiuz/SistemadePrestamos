<section class="side-menu">
    <div class="hide-menu" onclick="revealMenu()">
        <i class="fa fa-chevron-left"></i>
    </div>
    
    <div class="current-branch">
        <div class="company-logo">
            <div class="logo"></div>
        </div>
    </div>
    
    <ul class="menu">
        <li>
            <a href="{{ route('dashboard.avanzado') }}" class="{{ request()->routeIs('dashboard.avanzado') ? 'active' : '' }}">
                <i class="fa fa-dashboard"></i>
                Dashboard Ejecutivo
            </a>
        </li>
        <li>
            <a href="{{ route('clientes.index') }}" class="{{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                <i class="fa fa-user"></i>
                Clientes
            </a>
        </li>
        <li>
            <a href="{{ route('prestamos.index') }}" class="{{ request()->routeIs('prestamos.*') ? 'active' : '' }}">
                <i class="fa fa-money"></i>
                Préstamos
            </a>
        </li>
        <li>
            <a href="{{ route('inventario.index') }}" class="{{ request()->routeIs('inventario.*') ? 'active' : '' }}">
                <i class="fa fa-list-alt"></i>
                Prendas
            </a>
        </li>
        <li>
            <a href="{{ route('subastas.index') }}" class="{{ request()->routeIs('subastas.*') ? 'active' : '' }}">
                <i class="fa fa-gavel"></i>
                Subastas
            </a>
        </li>
        <li>
            <a href="{{ route('apartados.index') }}" class="{{ request()->routeIs('apartados.*') ? 'active' : '' }}">
                <i class="fa fa-bookmark"></i>
                Apartados
            </a>
        </li>
        <li>
            <a href="{{ route('compras.index') }}" class="{{ request()->routeIs('compras.*') ? 'active' : '' }}">
                <i class="fa fa-shopping-cart"></i>
                Compras
            </a>
        </li>
        <li>
            <a href="{{ route('ventas.index') }}" class="{{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                <i class="fa fa-shopping-bag"></i>
                Ventas
            </a>
        </li>
        <li>
            <a href="{{ route('transferencias.index') }}" class="{{ request()->routeIs('transferencias.*') ? 'active' : '' }}">
                <i class="fa fa-exchange"></i>
                Transferencias
            </a>
        </li>
        <li>
            <a href="{{ route('notificaciones.index') }}" class="{{ request()->routeIs('notificaciones.*') ? 'active' : '' }}">
                <i class="fa fa-bell"></i>
                Notificaciones
            </a>
        </li>
        <li>
            <a href="{{ route('tarifas.index') }}" class="{{ request()->routeIs('tarifas.*') ? 'active' : '' }}">
                <i class="fa fa-percent"></i>
                Tarifas
            </a>
        </li>
        <li>
            <a href="{{ route('workflows.pendientes') }}" class="{{ request()->routeIs('workflows.*') ? 'active' : '' }}">
                <i class="fa fa-tasks"></i>
                Aprobaciones
            </a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                <i class="fa fa-file-text"></i>
                Reportes
                <i class="fa fa-chevron-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('reportes.index') }}">Básicos</a></li>
                <li><a href="{{ route('reportes.rentabilidad') }}">Rentabilidad</a></li>
                <li><a href="{{ route('reportes.riesgo-crediticio') }}">Riesgo Crediticio</a></li>
                <li><a href="{{ route('reportes.recuperacion') }}">Recuperación</a></li>
                <li><a href="{{ route('reportes.flujo-efectivo') }}">Flujo Efectivo</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('historial.index') }}" class="{{ request()->routeIs('historial.*') ? 'active' : '' }}">
                <i class="fa fa-clock-o"></i>
                Historial
            </a>
        </li>
        <li>
            <a href="#" target="_blank">
                <i class="fa fa-question-circle"></i>
                Ayuda
            </a>
        </li>
    </ul>
</section>
