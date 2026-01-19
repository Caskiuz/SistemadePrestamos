@extends('layouts.main')

@section('content')
<header class="yp-header">
    <h1>
        <i class="fa fa-users"></i>
        <span>Usuarios</span>
    </h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#usuarioModal">
        <i class="fa fa-plus"></i> Nuevo Usuario
    </button>
</header>

<section class="content">
    @if($users->isEmpty())
        <div class="text-center mt-5">
            <h4>
                <i class="fa fa-info-circle"></i>
                No hay usuarios registrados
            </h4>
            <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#usuarioModal">
                Crear primer usuario
            </button>
        </div>
    @else
        <div class="list-group">
            @foreach($users as $user)
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $user->nombre }}</h5>
                        <span class="badge badge-{{ $user->activo ? 'success' : 'secondary' }}">
                            {{ $user->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    <p class="mb-1">
                        <strong>Email:</strong> {{ $user->email }}
                        <strong class="ml-3">Rol:</strong> {{ $user->rol }}
                    </p>
                    <div class="mt-2">
                        <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i> Editar
                        </a>
                        @if(auth()->user()->rol === 'Gerente' && $user->rol !== 'Gerente')
                            <form action="{{ route('usuarios.toggle', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-{{ $user->activo ? 'secondary' : 'success' }}">
                                    <i class="fa fa-toggle-{{ $user->activo ? 'on' : 'off' }}"></i>
                                    {{ $user->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        @endif
                        @if($user->id !== auth()->id())
                            <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-btn" data-name="{{ $user->nombre }}">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $users->links() }}
        </div>
    @endif
</section>

<!-- Modal -->
<div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="usuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="usuarioModalLabel">Registrar Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="usuarioForm" action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" required value="{{ old('nombre') }}">
                        @error('nombre')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="rol">Rol</label>
                        <select class="form-control @error('rol') is-invalid @enderror" name="rol" required>
                            <option value="Gerente" {{ old('rol') == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                            <option value="Contabilidad" {{ old('rol') == 'Contabilidad' ? 'selected' : '' }}>Contabilidad</option>
                            <option value="Operario" {{ old('rol') == 'Operario' || !old('rol') ? 'selected' : '' }}>Operario</option>
                        </select>
                        @error('rol')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="usuarioForm" class="btn btn-primary">
                    <i class="fa fa-save"></i> Registrar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Mostrar alertas de sesión
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

    // Confirmación para eliminar usuarios
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const userName = this.getAttribute('data-name');

            Swal.fire({
                title: '¿Estás seguro?',
                text: `Vas a eliminar a ${userName}. Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Abrir modal si hay errores
    @if($errors->any())
        $('#usuarioModal').modal('show');
    @endif
});
</script>
@endpush