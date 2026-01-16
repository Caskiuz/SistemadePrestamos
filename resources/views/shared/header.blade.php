
<nav class="navbar navbar-inverse" style="margin-bottom:0; border-radius:0; background:#7BB33A; color:#fff;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img alt="YoPresto" src="{{ asset('dist/assets/img/logo.png') }}" style="height:40px; margin-top:-10px;">
            </a>
        </div>
        <div class="collapse navbar-collapse" id="main-navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="status-icon"><i class="fa fa-user"></i></span>
                        <span class="name">{{ Auth::user()->nombre }}</span>
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a><i class="fa fa-user"></i> {{ Auth::user()->nombre }}</a></li>
                        <li><a><i class="fa fa-cog"></i> {{ Auth::user()->rol }}</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ asset('logout') }}"><i class="fa fa-sign-out"></i> Salir</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>