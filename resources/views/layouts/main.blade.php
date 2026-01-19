<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PRÉSTAMOS SANTA ANA</title>
    <link rel="icon" href="{{ asset('img/logoICO.ico') }}" type="image/x-icon">

    <!-- CSS Responsive Global -->
    <link rel="stylesheet" href="{{ asset('css/responsive-global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global-mobile-components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/desktop-optimization.css') }}">
    <link rel="stylesheet" href="{{ asset('css/desktop-sidebar.css') }}">
    
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('dist/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <!-- FontAwesome 4.4.0 igual que YoPresto -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Roboto Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700&display=swap" rel="stylesheet">
    <style>body, html { font-family: 'Roboto', Arial, sans-serif !important; }</style>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('dist/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/modules/summernote/summernote-bs4.css') }}">

    <!-- Selec2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Lightbox2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <!-- icon bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <!-- CSS de Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('dist/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/css/components.css') }}">
    <!-- Sidebar YoPresto CSS -->
    <link rel="stylesheet" href="{{ asset('css/yopresto-sidebar.css') }}">
    <!-- YoPresto Global CSS -->
    <link rel="stylesheet" href="{{ asset('css/yopresto-global.css') }}">
    <!-- Sidebar Override CSS -->
    <link rel="stylesheet" href="{{ asset('css/sidebar-override.css') }}">
    <!-- Reportes Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('css/reportes-responsive.css') }}">
    
    <style>
    /* Mobile-first responsive navbar */
    .navbar-yopresto {
        background: linear-gradient(135deg, #ffffff 0%, #dc2626 50%, #111827 100%);
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 70px;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(220, 38, 38, 0.2);
        border-bottom: 2px solid #dc2626;
    }
    
    .menu-toggle {
        display: none;
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        padding: 8px;
        border-radius: 4px;
        transition: background 0.3s;
    }
    
    .menu-toggle:hover {
        background: rgba(255,255,255,0.2);
    }
    
    /* Mobile styles */
    @media (max-width: 768px) {
        .menu-toggle {
            display: block;
        }
        
        .side-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            position: fixed;
            top: 70px;
            left: 0;
            height: calc(100vh - 70px);
            z-index: 999;
            overflow-y: auto;
            background-color: #ffffff;
        }
        
        .side-menu.active {
            transform: translateX(0);
        }
        
        .main-content {
            margin-left: 0 !important;
            padding: 10px;
            margin-top: 70px;
        }
        
        .navbar-user .user-name {
            display: none;
        }
        
        .navbar-user .doc-btn {
            display: block;
        }
    }
    
    /* Tablet styles */
    @media (min-width: 769px) and (max-width: 1024px) {
        .main-content {
            padding: 15px;
        }
    }
    
    .navbar-user {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .navbar-user .doc-btn {
        color: white;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 4px;
        transition: background 0.3s;
        font-size: 16px;
    }
    
    .navbar-user .doc-btn:hover {
        background: rgba(255,255,255,0.2);
        text-decoration: none;
        color: white;
    }
    
    .navbar-user .user-icon {
        color: white;
        font-size: 16px;
    }
    
    .navbar-user .user-name {
        color: white;
        font-weight: 500;
    }
    
    .navbar-user .logout-btn {
        color: white;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 4px;
        transition: background 0.3s;
        font-size: 16px;
    }
    
    .navbar-user .logout-btn:hover {
        background: rgba(255,255,255,0.2);
        text-decoration: none;
        color: white;
    }
    
    /* User Dropdown Styles */
    .user-dropdown {
        position: relative;
    }
    
    .user-toggle {
        background: none;
        border: none;
        color: white;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
        font-size: 14px;
    }
    
    .user-toggle:hover {
        background: rgba(255,255,255,0.2);
    }
    
    .user-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        min-width: 200px;
        z-index: 1001;
        display: none;
        margin-top: 5px;
    }
    
    .user-menu.show {
        display: block;
    }
    
    .user-info {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .user-info strong {
        display: block;
        color: #333;
        font-size: 14px;
    }
    
    .user-info small {
        color: #666;
        font-size: 12px;
    }
    
    .user-menu hr {
        margin: 0;
        border-color: #eee;
    }
    
    .user-menu-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        color: #333;
        text-decoration: none;
        transition: background 0.3s;
        font-size: 14px;
    }
    
    .user-menu-item:hover {
        background: #f8f9fa;
        text-decoration: none;
        color: #333;
    }
    
    .user-menu-item.logout {
        color: #dc2626;
        border-top: 1px solid #eee;
    }
    
    .user-menu-item.logout:hover {
        background: #fef2f2;
        color: #dc2626;
    }
    </style>
</head>

<body>
    <!-- Navbar YoPresto -->
    <nav class="navbar-yopresto">
        <div class="d-flex align-items-center">
            <button class="menu-toggle" onclick="toggleMenu()">
                <i class="fa fa-bars"></i>
            </button>
            <a href="{{ route('dashboard.index') }}" class="navbar-brand ml-2">
                <img src="{{ asset('images/prestamos-santana-neon.svg') }}" alt="Préstamos Santa Ana" style="height: 40px;">
            </a>
        </div>
        <div class="navbar-user">
            <a href="{{ route('documentacion.index') }}" class="doc-btn" title="Documentación">
                <i class="fa fa-book"></i>
            </a>
            <div class="user-dropdown">
                <button class="user-toggle" onclick="toggleUserMenu()">
                    <i class="fa fa-user"></i>
                    <span class="user-name">{{ Auth::user()->nombre ?? Auth::user()->name ?? 'Usuario' }}</span>
                    <i class="fa fa-chevron-down"></i>
                </button>
                <div class="user-menu" id="userMenu">
                    <div class="user-info">
                        <strong>{{ Auth::user()->nombre ?? Auth::user()->name ?? 'Usuario' }}</strong>
                        <small>{{ Auth::user()->rol ?? 'Sin rol' }}</small>
                    </div>
                    <hr>
                    <a href="{{ route('usuarios.edit', Auth::id()) }}" class="user-menu-item">
                        <i class="fa fa-edit"></i> Mi Perfil (ID: {{ Auth::id() }})
                    </a>
                    <a href="{{ route('logout') }}" class="user-menu-item logout">
                        <i class="fa fa-sign-out"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div id="app">
        <div class="main-wrapper main-wrapper-1">

            <!-- Sidebar -->
            @include('shared.aside-yopresto')
            <!--end Sidebar-->
            
            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            <!--End Main Content -->

        </div>
    </div>

    <script>
    function toggleMenu() {
        document.querySelector('.side-menu').classList.toggle('active');
    }
    
    function toggleUserMenu() {
        document.getElementById('userMenu').classList.toggle('show');
    }
    
    // Cerrar menú al hacer clic fuera en móvil
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.side-menu');
        const toggle = document.querySelector('.menu-toggle');
        const userMenu = document.getElementById('userMenu');
        const userToggle = document.querySelector('.user-toggle');
        
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
        
        // Cerrar dropdown de usuario al hacer clic fuera
        if (!userMenu.contains(event.target) && !userToggle.contains(event.target)) {
            userMenu.classList.remove('show');
        }
    });
    
    // Responsive behavior on window resize
    window.addEventListener('resize', function() {
        const sidebar = document.querySelector('.side-menu');
        if (window.innerWidth > 768) {
            sidebar.classList.remove('active');
        }
    });
    </script>


    <!-- General JS Scripts: jQuery debe ir primero -->
    <!-- jQuery desde CDN para máxima compatibilidad con plugins -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Plugins que dependen de jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- Otros plugins y scripts -->
    <script src="{{ asset(path: 'dist/assets/modules/popper.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/js/stisla.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset(path: 'dist/assets/js/page/index-0.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset(path: 'dist/assets/js/scripts.js') }}"></script>
    <script src="{{ asset(path: 'dist/assets/js/custom.js') }}"></script>

    <!-- Swet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JS de Cropper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        if (typeof lightbox !== 'undefined') {
            lightbox.option({
                'albumLabel': 'Foto %1 de %2',  // Personaliza el texto aquí
            });
        }
    </script>

    @yield('scripts')

    @stack('scripts')


</body>

</html>
