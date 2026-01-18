@extends('layouts.main')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fa fa-plus-circle"></i> Registrar Nuevo Equipo</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('equipos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Información básica -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cliente_id">Cliente</label>
                                <select name="cliente_id" id="cliente_id" class="form-control" required>
                                    <option value="">Seleccione un cliente...</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            @include('components.almacen-selector')
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre del Equipo</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select name="tipo" id="tipo" class="form-control" required>
                                    <option value="">Seleccione tipo...</option>
                                    <option value="MOTOR_ELECTRICO">Motor Eléctrico</option>
                                    <option value="MAQUINA_SOLDADORA">Máquina Soldadora</option>
                                    <option value="GENERADOR_DINAMO">Generador/Dinamo</option>
                                    <option value="OTROS">Otros</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="marca">Marca</label>
                                <input type="text" name="marca" id="marca" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="modelo">Modelo</label>
                                <input type="text" name="modelo" id="modelo" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" name="color" id="color" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="numero_serie">Número de Serie</label>
                                <input type="text" name="numero_serie" id="numero_serie" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="monto">Monto (Bs.)</label>
                                <input type="number" name="monto" id="monto" class="form-control" step="0.01">
                            </div>
                        </div>
                    </div>

                    <!-- Campos específicos por tipo -->
                    <div id="campos-especificos"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="partes_faltantes">Partes Faltantes</label>
                                <textarea name="partes_faltantes" id="partes_faltantes" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Componente de subida de fotos -->
                    @include('components.foto-upload')

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa fa-save"></i> Registrar Equipo
                        </button>
                        <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fa fa-arrow-left"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
document.getElementById('tipo').addEventListener('change', function() {
    const tipo = this.value;
    const container = document.getElementById('campos-especificos');
    
    let campos = '';
    
    switch(tipo) {
        case 'MOTOR_ELECTRICO':
            campos = `
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="potencia">Potencia</label>
                            <input type="text" name="potencia" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="voltaje">Voltaje</label>
                            <input type="text" name="voltaje" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="hp">HP</label>
                            <input type="text" name="hp" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="rpm">RPM</label>
                            <input type="text" name="rpm" class="form-control">
                        </div>
                    </div>
                </div>
            `;
            break;
        case 'MAQUINA_SOLDADORA':
            campos = `
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amperaje">Amperaje</label>
                            <input type="text" name="amperaje" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cable_positivo">Cable Positivo</label>
                            <input type="text" name="cable_positivo" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="cable_negativo">Cable Negativo</label>
                            <input type="text" name="cable_negativo" class="form-control">
                        </div>
                    </div>
                </div>
            `;
            break;
        case 'GENERADOR_DINAMO':
            campos = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kva_kw">KVA/KW</label>
                            <input type="text" name="kva_kw" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="voltaje">Voltaje</label>
                            <input type="text" name="voltaje" class="form-control">
                        </div>
                    </div>
                </div>
            `;
            break;
    }
    
    container.innerHTML = campos;
});
</script>
@endsection