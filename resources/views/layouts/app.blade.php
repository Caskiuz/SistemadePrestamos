<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'YoPresto')</title>
    
    <link rel="stylesheet" href="{{ asset('dist/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('dist/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/yopresto-sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/yopresto-global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bundle.css') }}">
    
    @stack('styles')
</head>
<body>
    @include('partials.navbar')
    
    <div class="branch-content">
        @include('shared.aside-yopresto')
        
        <div class="main">
            <div class="reveal-menu" onclick="toggleMenu()">
                <i class="fa fa-bars"></i>
            </div>
            
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/bundle.js') }}"></script>
    <script>
    function toggleMenu() {
        document.querySelector('.side-menu').classList.toggle('active');
    }
    </script>
    @stack('scripts')
</body>
</html>
