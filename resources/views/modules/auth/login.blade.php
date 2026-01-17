@extends('layouts.login')
@section('contenido')

<section class="section">
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
          <img src="{{ asset('img/logo.jpeg') }}" alt="HC Servicios Logo" width="300">
        </div>
        <div class="card card-secondary">
          <div class="card-header">
            <h4>Inicio de sesión</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('logear') }}" class="needs-validation" novalidate="">
              @csrf
              <div class="form-group">
                <label for="email">Correo</label>
                <input id="email" type="email" class="form-control" name="email" tabindex="1"
                  placeholder="Por favor coloque su correo" required autofocus>
                <div class="invalid-feedback">
                  Por favor coloca tu email
                </div>
              </div>
              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Contraseña</label>
                </div>
                <input id="password" type="password" class="form-control" name="password" tabindex="2"
                  placeholder="Por favor coloque su contraseña" required>
                <div class="invalid-feedback">
                  Por favor coloca tu contraseña
                </div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                  Ingresar
                </button>
              </div>
            </form>
            <div>
              @if ($errors->any())
                <div class="alert alert-danger mt-2">
                  <ul>
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
          Copyright &copy; Design By Software Production
        </div>
      </div>
    </div>
  </div>
</section>

<!-- YoPresto CSS Integration -->
<link rel="stylesheet" href="{{ asset('login_files/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('login_files/bundle.css') }}">
<link rel="stylesheet" href="{{ asset('login_files/font-awesome.min.css') }}">
<link href="{{ asset('login_files/css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('login_files/css(1)') }}" rel="stylesheet" type="text/css">

<style>
/* Integración de estilos YoPresto con HC Servicios */
.login-page {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.card-secondary {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border: none;
  border-radius: 15px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.card-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 15px 15px 0 0 !important;
  text-align: center;
  padding: 20px;
}

.form-control {
  border-radius: 10px;
  border: 2px solid #e1e5e9;
  padding: 12px 15px;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
  border-radius: 10px;
  padding: 12px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.login-brand {
  text-align: center;
  margin-bottom: 30px;
}

.login-brand img {
  border-radius: 15px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.simple-footer {
  text-align: center;
  margin-top: 20px;
  color: rgba(255, 255, 255, 0.8);
  font-size: 14px;
}

/* Conservar estilos globales existentes */
@import url('{{ asset('css/yopresto-global.css') }}');
</style>

@endsection