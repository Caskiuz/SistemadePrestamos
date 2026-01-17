<!-- Sidebar YoPresto style -->
<section class="side-menu">
  <div class="current-branch" style="padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
    <div class="company-logo" style="width: 80px; height: 80px; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
      <img src="{{ asset('clientes-yo-presto/logo-white.png') }}" alt="Logo" style="max-width: 70px; max-height: 70px;" onerror="this.style.display='none';">
    </div>
  </div>
  <ul class="menu">
    <li>
      <a href="{{ route('clientes.index') }}" class="@if(request()->routeIs('clientes.*')) active @endif">
        <i class="fa fa-user"></i> Clientes
      </a>
    </li>
    <li>
      <a href="{{ route('prestamos.index') }}" class="@if(request()->routeIs('prestamos.*')) active @endif">
        <i class="fa fa-money"></i> Préstamos
      </a>
    </li>
    <li>
      <a href="{{ route('inventario.index') }}" class="@if(request()->routeIs('inventario.*')) active @endif">
        <i class="fa fa-list-alt"></i> Prendas
      </a>
    </li>
    <li>
      <a href="{{ route('historial.index') }}" class="@if(request()->routeIs('historial.*')) active @endif">
        <i class="fa fa-clock-o"></i> Historial
      </a>
    </li>
    <li>
      <a href="{{ route('reportes.index') }}" class="@if(request()->routeIs('reportes.*')) active @endif">
        <i class="fa fa-file-text"></i> Reportes
      </a>
    </li>
    <li>
      <a href="{{ route('configuracion.index') }}" class="@if(request()->routeIs('configuracion.*')) active @endif">
        <i class="fa fa-cog"></i> Configuración
      </a>
    </li>
    <li style="border-top: 1px solid rgba(255,255,255,0.1); margin-top: 20px; padding-top: 20px;">
      <a href="{{ route('logout') }}">
        <i class="fa fa-sign-out"></i> Cerrar Sesión
      </a>
    </li>
  </ul>
</section>
