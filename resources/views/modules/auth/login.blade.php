@extends('layouts.login')
@section('contenido')

<section class="section">
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
          <img src="{{ asset('images/prestamos-santana-neon.svg') }}" alt="Préstamos Santa Ana Logo" width="250" style="filter: drop-shadow(0 5px 15px rgba(220, 38, 38, 0.3));">
        </div>
        <div class="card card-primary">
          <div class="card-header">
            <h4>Préstamos Santa Ana</h4>
            <p class="subtitle">Sistema de Gestión</p>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('logear') }}" class="needs-validation" novalidate="">
              @csrf
              <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1"
                  placeholder="Ingresa tu correo electrónico" required autofocus>
                <div class="invalid-feedback">
                  Por favor ingresa tu correo electrónico
                </div>
              </div>
              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Contraseña</label>
                </div>
                <input id="password" type="password" class="form-control" name="password" tabindex="2"
                  placeholder="Ingresa tu contraseña" required>
                <div class="invalid-feedback">
                  Por favor ingresa tu contraseña
                </div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-danger btn-lg btn-block" tabindex="4">
                  <i class="fa fa-sign-in"></i> Iniciar Sesión
                </button>
              </div>
            </form>
            <div>
              @if ($errors->any())
                <div class="alert alert-danger mt-2">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
            </div>
          </div>
        </div>
        <div class="simple-footer">
          <p>&copy; {{ date('Y') }} Préstamos Santa Ana - Sistema de Gestión</p>
          <small>Desarrollado por Software Productions</small>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
/* Tema corporativo: Blanco, Rojo y Negro */
body {
  background: linear-gradient(135deg, #ffffff 0%, #dc2626 50%, #111827 100%);
  min-height: 100vh;
  font-family: 'Roboto', Arial, sans-serif;
}

.section {
  min-height: 100vh;
  display: flex;
  align-items: center;
  padding: 20px 0;
}

.login-brand {
  text-align: center;
  margin-bottom: 30px;
}

.login-brand img {
  max-width: 100%;
  height: auto;
}

.card-primary {
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(15px);
  border: none;
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  overflow: hidden;
}

.card-header {
  background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
  color: white;
  border-radius: 0;
  text-align: center;
  padding: 25px 20px;
  border-bottom: none;
}

.card-header h4 {
  margin: 0 0 5px 0;
  font-size: 24px;
  font-weight: 700;
  text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.card-header .subtitle {
  margin: 0;
  font-size: 14px;
  opacity: 0.9;
  font-weight: 400;
}

.card-body {
  padding: 30px;
}

.form-group label {
  color: #374151;
  font-weight: 600;
  margin-bottom: 8px;
}

.form-control {
  border-radius: 12px;
  border: 2px solid #e5e7eb;
  padding: 15px 18px;
  font-size: 16px;
  transition: all 0.3s ease;
  background: #ffffff;
}

.form-control:focus {
  border-color: #dc2626;
  box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
  background: #ffffff;
}

.form-control::placeholder {
  color: #9ca3af;
}

.btn-danger {
  background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
  border: none;
  border-radius: 12px;
  padding: 15px;
  font-weight: 700;
  font-size: 16px;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn-danger:hover {
  background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
}

.btn-danger:active {
  transform: translateY(0);
}

.alert-danger {
  background: rgba(220, 38, 38, 0.1);
  border: 1px solid rgba(220, 38, 38, 0.3);
  color: #991b1b;
  border-radius: 10px;
}

.alert-danger ul {
  list-style: none;
  padding: 0;
}

.alert-danger li {
  padding: 2px 0;
}

.simple-footer {
  text-align: center;
  margin-top: 25px;
  color: rgba(255, 255, 255, 0.9);
}

.simple-footer p {
  margin: 0 0 5px 0;
  font-size: 14px;
  font-weight: 500;
}

.simple-footer small {
  font-size: 12px;
  opacity: 0.8;
}

.invalid-feedback {
  color: #dc2626;
  font-size: 14px;
  margin-top: 5px;
}

/* Responsive */
@media (max-width: 768px) {
  .card-body {
    padding: 20px;
  }
  
  .login-brand img {
    width: 200px;
  }
  
  .card-header h4 {
    font-size: 20px;
  }
  
  .form-control {
    padding: 12px 15px;
    font-size: 14px;
  }
  
  .btn-danger {
    padding: 12px;
    font-size: 14px;
  }
}

/* Animaciones */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.card-primary {
  animation: fadeInUp 0.6s ease-out;
}

.login-brand {
  animation: fadeInUp 0.4s ease-out;
}
</style>

@endsection