<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/home') }}">
                <img alt="YoPresto" src="{{ asset('images/logo-white.png') }}">
            </a>
        </div>
        
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="status-icon"><i class="fa fa-building"></i></span>
                        <span class="name">Matriz</span>
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fa fa-cog"></i> Configuración de empresa</a></li>
                        <li><a href="#"><i class="fa fa-cog"></i> Configuración de sucursal</a></li>
                    </ul>
                </li>
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="status-icon"><i class="fa fa-user"></i></span>
                        <span class="name">{{ auth()->user()->name }}</span>
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="fa fa-sign-out"></i> Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li><a href="#"><span class="status-icon"><i class="fa fa-lock"></i></span></a></li>
            </ul>
        </div>
    </div>
</nav>
