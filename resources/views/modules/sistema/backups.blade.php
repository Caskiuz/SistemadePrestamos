@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Gestión de Backups</h4>
                    <div class="card-header-action">
                        <form action="{{ route('sistema.backup.generar') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-download"></i> Generar Backup
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Tamaño</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($backups as $backup)
                                <tr>
                                    <td>{{ $backup->id }}</td>
                                    <td>{{ $backup->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $backup->tipo == 'manual' ? 'primary' : 'secondary' }}">
                                            {{ ucfirst($backup->tipo) }}
                                        </span>
                                    </td>
                                    <td>{{ $backup->tamaño ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $backup->estado == 'completado' ? 'success' : 'warning' }}">
                                            {{ ucfirst($backup->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($backup->estado == 'completado')
                                            <a href="#" class="btn btn-sm btn-success">
                                                <i class="fa fa-download"></i> Descargar
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay backups disponibles</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($backups->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $backups->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection