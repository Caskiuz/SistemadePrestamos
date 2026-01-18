@extends('layouts.main')

@section('content')
<div class="main-content fade-in">
    <section class="section">
        <div class="section-header">
            <h1>Configuración de Empresa</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('configuracion.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Información Corporativa</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('configuracion.actualizar') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombre de la Empresa</label>
                                        <input type="text" name="empresa_nombre" class="form-control" 
                                               value="{{ $configuraciones['empresa_nombre']->valor ?? '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>RIF/NIT</label>
                                        <input type="text" name="empresa_rif" class="form-control" 
                                               value="{{ $configuraciones['empresa_rif']->valor ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Dirección Principal</label>
                                <textarea name="empresa_direccion" class="form-control" rows="3">{{ $configuraciones['empresa_direccion']->valor ?? '' }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Teléfono Principal</label>
                                        <input type="text" name="empresa_telefono" class="form-control" 
                                               value="{{ $configuraciones['empresa_telefono']->valor ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Corporativo</label>
                                        <input type="email" name="empresa_email" class="form-control" 
                                               value="{{ $configuraciones['empresa_email']->valor ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection