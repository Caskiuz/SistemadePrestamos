@extends('layouts.login-simple')
@section('content')

<div class="login-wrapper">
    <div class="login-container">
        <div class="login-brand">
            <img src="{{ asset('images/prestamos-santana-neon.svg') }}" alt="Préstamos Santa Ana Logo">
        </div>
        
        <div class="login-card">
            <div class="card-header">
                <h4>Préstamos Santa Ana</h4>
                <p class="subtitle">Sistema de Gestión</p>
            </div>
            
            <div class="card-body">
                <form method="POST" action="{{ route('logear') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input id="email" type="email" class="form-control" name="email" 
                               placeholder="Ingresa tu correo electrónico" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password" 
                               placeholder="Ingresa tu contraseña" required>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn-login">
                            <i class="fa fa-sign-in"></i> Iniciar Sesión
                        </button>
                    </div>
                </form>
                
                @if ($errors->any())
                    <div class="alert-danger">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="simple-footer">
            <p>&copy; {{ date('Y') }} Préstamos Santa Ana - Sistema de Gestión</p>
            <small>Desarrollado por Software Productions</small>
        </div>
    </div>
</div>

@endsection