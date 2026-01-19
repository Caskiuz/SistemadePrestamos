@extends('layouts.main')

@section('content')
<header class="yp-header">
    <h1>
        <a href="{{ route('usuarios.index') }}" style="color: white; text-decoration: none;">
            <i class="fa fa-arrow-left"></i>
        </a>
        <span>Editar Perfil</span>
    </h1>
</header>

<section class="content">
    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header">
            <h4>Editar Mi Perfil</h4>
            <small class="text-muted">Actualiza tu información personal (Usuario ID: {{ $user->id }})</small>
            <div class="mt-2">
                <span class="badge badge-info">{{ $user->email }}</span>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre', $user->nombre) }}" required>
                    @error('nombre')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select name="rol" class="form-control @error('rol') is-invalid @enderror" required>
                        <option value="Gerente" {{ $user->rol == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                        <option value="Contabilidad" {{ $user->rol == 'Contabilidad' ? 'selected' : '' }}>Contabilidad</option>
                        <option value="Operario" {{ $user->rol == 'Operario' ? 'selected' : '' }}>Operario</option>
                    </select>
                    @error('rol')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <hr>
                <h5>Cambiar Contraseña (Opcional)</h5>
                <small class="text-muted">Deja en blanco si no deseas cambiar la contraseña</small>
                
                <div class="form-group mt-3">
                    <label for="password">Nueva Contraseña</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                
                <div class="form-group text-right">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mr-2">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('swal'))
        Swal.fire({
            icon: '{{ session('swal')['icon'] }}',
            title: '{{ session('swal')['title'] }}',
            text: '{{ session('swal')['text'] }}',
            confirmButtonColor: '#3085d6',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: true
        });
    @endif
});
</script>
@endpush