@extends('layouts.main')

@section('contenido')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Crear Nuevo Producto</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventario.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre del Producto</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Categoría</label>
                                    <input type="text" class="form-control" name="categoria" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Precio</label>
                                    <input type="number" step="0.01" class="form-control" name="precio" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="number" class="form-control" name="stock" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Guardar Producto</button>
                            <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Validaciones adicionales si son necesarias
</script>
@endsection
