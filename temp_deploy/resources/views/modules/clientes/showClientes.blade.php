@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header bg-primary text-white rounded shadow-sm py-3 px-4 mb-4 align-items-center d-flex justify-content-between">
                <h1 class="mb-0" style="font-weight: 700; letter-spacing: 1px;"><i class="fas fa-users mr-2"></i>Clientes</h1>
                <a href="{{ route('clientes.create') }}" class="btn btn-success btn-lg shadow-sm"><i class="fas fa-user-plus"></i> Nuevo Cliente</a>
            </div>
            <div class="section-body">
                <div class="card shadow-sm">
                    <div class="card-header bg-light border-bottom-0">
                        <h4 class="mb-0" style="font-size:21px; color:#151414"><i class="fas fa-address-book mr-2"></i>Lista de clientes</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('clientes.index') }}" class="form-row align-items-center mb-4">
                            <div class="col-md-6 col-12 mb-2 mb-md-0">
                                <input type="text" name="buscar" class="form-control input-lg" placeholder="Buscar clientes por nombre, teléfono o documento" value="{{ request('buscar') }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-search"></i> Buscar</button>
                            </div>
                            @if(request('buscar'))
                                <div class="col-auto">
                                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-lg ml-2">Limpiar</a>
                                </div>
                            @endif
                        </form>
                        <!-- Tabla para pantallas medianas y grandes -->
                        <div class="d-none d-md-block">
                            <table class="table table-hover table-bordered bg-white rounded shadow-sm" id="table-1">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:40px">#</th>
                                        <th>Nombre</th>
                                        <th>N° Documento</th>
                                        <th>Teléfonos</th>
                                        <th>Correo</th>
                                        <th>Dirección</th>
                                        <th style="width:120px">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($clientes as $cliente)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="font-weight-bold">{{ $cliente->nombre }}</span>
                                                <br><small class="text-muted">{{ Str::title($cliente->tipo) }}</small>
                                            </td>
                                            <td>{{ $cliente->tipo_documento}}-{{ $cliente->numero_documento }}</td>
                                            <td>{{ $cliente->telefono_1 }}{{ $cliente->telefono_2 ? ' - ' . $cliente->telefono_2 : '' }}{{ $cliente->telefono_3 ? ' - ' . $cliente->telefono_3 : '' }}</td>
                                            <td>{{ $cliente->email }}</td>
                                            <td>{{ $cliente->ciudad }}-{{ $cliente->direccion }}</td>
                                            <td>
                                                <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-info btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No hay clientes registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $clientes->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        <!-- Tarjetas para pantallas pequeñas -->
                        <div class="d-block d-md-none">
                            @forelse($clientes as $cliente)
                                <div class="card mb-3 shadow-sm border-primary">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; font-size: 1.3rem;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-0 font-weight-bold">{{ $cliente->nombre }}</h5>
                                                <small class="text-muted">{{ Str::title($cliente->tipo) }}</small>
                                            </div>
                                        </div>
                                        <p class="mb-1"><strong>N° Documento:</strong> {{ $cliente->tipo_documento}}-{{ $cliente->numero_documento }}</p>
                                        <p class="mb-1"><strong>Teléfonos:</strong> {{ $cliente->telefono_1 }}{{ $cliente->telefono_2 ? ' - ' . $cliente->telefono_2 : '' }}{{ $cliente->telefono_3 ? ' - ' . $cliente->telefono_3 : '' }}</p>
                                        <p class="mb-1"><strong>Correo:</strong> {{ $cliente->email }}</p>
                                        <p class="mb-1"><strong>Dirección:</strong> {{ $cliente->ciudad }}-{{ $cliente->direccion }}</p>
                                        <div class="mt-2">
                                            <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-info btn-sm mr-1" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info text-center">No hay clientes registrados.</div>
                            @endforelse
                            <div class="d-flex justify-content-center">
                                {{ $clientes->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    @if($clientes->isEmpty() && request('buscar'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin resultados',
                    text: 'No se encontraron clientes que coincidan con la búsqueda.',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

@endsection