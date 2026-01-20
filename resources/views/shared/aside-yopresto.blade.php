<!-- Sidebar YoPresto style -->
<section class="side-menu">
  <div class="current-branch" style="padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
    <a href="{{ route('dashboard.index') }}" class="company-logo" style="width: 120px; height: 80px; margin: 0 auto; display: flex; align-items: center; justify-content: center; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-decoration: none;">
      <img src="{{ asset('images/santa-ana-logo.jpeg') }}" alt="Santa Ana Logo" style="max-width: 100px; max-height: 70px; object-fit: contain;" onerror="this.style.display='none';">
    </a>
  </div>
  <ul class="menu">
    <li>
      <a href="{{ route('dashboard.index') }}" class="@if(request()->routeIs('dashboard.*')) active @endif">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
    </li>
    <li>
      <a href="{{ route('clientes.index') }}" class="@if(request()->routeIs('clientes.*')) active @endif">
        <i class="fa fa-user"></i> <span>Clientes</span>
      </a>
    </li>
    <li>
      <a href="{{ route('prestamos.index') }}" class="@if(request()->routeIs('prestamos.*')) active @endif">
        <i class="fa fa-money"></i> <span>Préstamos</span>
      </a>
    </li>
    <li>
      <a href="{{ route('inventario.index') }}" class="@if(request()->routeIs('inventario.*')) active @endif">
        <i class="fa fa-list-alt"></i> <span>Prendas</span>
      </a>
    </li>
    <li>
      <a href="{{ route('historial.index') }}" class="@if(request()->routeIs('historial.*')) active @endif">
        <i class="fa fa-clock-o"></i> <span>Historial</span>
      </a>
    </li>
    <li>
      <a href="{{ route('reportes.index') }}" class="@if(request()->routeIs('reportes.*')) active @endif">
        <i class="fa fa-file-text"></i> <span>Reportes</span>
      </a>
    </li>
    <li>
      <a href="{{ route('configuracion.index') }}" class="@if(request()->routeIs('configuracion.*')) active @endif">
        <i class="fa fa-cog"></i> <span>Configuración</span>
      </a>
    </li>
    @if(auth()->check() && auth()->user() && (auth()->user()->rol === 'Gerente' || auth()->user()->rol === 'Admin'))
    <li>
      <a href="{{ route('usuarios.index') }}" class="@if(request()->routeIs('usuarios.*')) active @endif">
        <i class="fa fa-users"></i> <span>Usuarios</span>
      </a>
    </li>
    @endif
    <li style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 20px; padding-top: 20px;">
      <a href="{{ route('logout') }}">
        <i class="fa fa-sign-out"></i> <span>Cerrar Sesión</span>
      </a>
    </li>
  </ul>
</section>
