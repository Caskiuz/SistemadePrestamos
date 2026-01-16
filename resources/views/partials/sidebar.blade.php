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
            <a href="{{ route('historial.index') }}" class="{{ request()->routeIs('historial.*') ? 'active' : '' }}">
                <i class="fa fa-clock-o"></i>
                Historial
            </a>
        </li>
        <li>
            <a href="{{ route('reportes.index') }}" class="{{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                <i class="fa fa-file-text"></i>
                Reportes
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
