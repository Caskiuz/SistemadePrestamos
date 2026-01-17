@extends('layouts.main')
@section('contenido')
<div class="main-content">
	<section class="section">
		<div class="section-header bg-primary text-white rounded shadow-sm py-3 px-4 mb-4 align-items-center d-flex justify-content-between">
			<h1 class="mb-0" style="font-weight: 700; letter-spacing: 1px;"><i class="fas fa-user-plus mr-2"></i>Registrar Cliente</h1>
			<a href="{{ route('clientes.index') }}" class="btn btn-light btn-lg shadow-sm"><i class="fas fa-arrow-left"></i> Volver</a>
		</div>
		<div class="section-body">
			<div class="card shadow-sm">
				<div class="card-body">
					<form method="POST" action="{{ isset($cliente) ? route('clientes.update', $cliente->id) : route('clientes.store') }}" enctype="multipart/form-data" autocomplete="off">
						@csrf
						@if(isset($cliente))
							@method('PUT')
						@endif
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label><strong>Nombre completo</strong> <span class="text-danger">*</span></label>
									<input type="text" name="nombre" class="form-control input-lg" value="{{ old('nombre', $cliente->nombre ?? '') }}" required maxlength="100">
								</div>
								<div class="form-group">
									<label><strong>Tipo de cliente</strong> <span class="text-danger">*</span></label>
									<select name="tipo" class="form-control selectric" required>
										<option value="">Seleccione...</option>
										<option value="persona" {{ old('tipo', $cliente->tipo ?? '') == 'persona' ? 'selected' : '' }}>Persona</option>
										<option value="empresa" {{ old('tipo', $cliente->tipo ?? '') == 'empresa' ? 'selected' : '' }}>Empresa</option>
									</select>
								</div>
								<div class="form-group">
									<label><strong>Tipo de documento</strong> <span class="text-danger">*</span></label>
									<select name="tipo_documento" class="form-control selectric" required>
										<option value="">Seleccione...</option>
										<option value="DNI" {{ old('tipo_documento', $cliente->tipo_documento ?? '') == 'DNI' ? 'selected' : '' }}>DNI</option>
										<option value="RUC" {{ old('tipo_documento', $cliente->tipo_documento ?? '') == 'RUC' ? 'selected' : '' }}>RUC</option>
										<option value="PASAPORTE" {{ old('tipo_documento', $cliente->tipo_documento ?? '') == 'PASAPORTE' ? 'selected' : '' }}>Pasaporte</option>
									</select>
								</div>
								<div class="form-group">
									<label><strong>Número de documento</strong> <span class="text-danger">*</span></label>
									<input type="text" name="numero_documento" class="form-control input-lg" value="{{ old('numero_documento', $cliente->numero_documento ?? '') }}" required maxlength="20">
								</div>
								<div class="form-group">
									<label><strong>Correo electrónico</strong></label>
									<input type="email" name="email" class="form-control input-lg" value="{{ old('email', $cliente->email ?? '') }}" maxlength="100">
								</div>
								<div class="form-group">
									<label><strong>Ciudad</strong></label>
									<input type="text" name="ciudad" class="form-control input-lg" value="{{ old('ciudad', $cliente->ciudad ?? '') }}" maxlength="50">
								</div>
								<div class="form-group">
									<label><strong>Dirección</strong></label>
									<input type="text" name="direccion" class="form-control input-lg" value="{{ old('direccion', $cliente->direccion ?? '') }}" maxlength="150">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label><strong>Teléfono 1</strong> <span class="text-danger">*</span></label>
									<input type="text" name="telefono_1" class="form-control input-lg" value="{{ old('telefono_1', $cliente->telefono_1 ?? '') }}" required maxlength="20">
								</div>
								<div class="form-group">
									<label><strong>Teléfono 2</strong></label>
									<input type="text" name="telefono_2" class="form-control input-lg" value="{{ old('telefono_2', $cliente->telefono_2 ?? '') }}" maxlength="20">
								</div>
								<div class="form-group">
									<label><strong>Teléfono 3</strong></label>
									<input type="text" name="telefono_3" class="form-control input-lg" value="{{ old('telefono_3', $cliente->telefono_3 ?? '') }}" maxlength="20">
								</div>
								<div class="form-group">
									<label><strong>Fotografía</strong></label>
									<input type="file" name="foto" class="form-control-file" accept="image/*">
									@if(isset($cliente) && $cliente->foto)
										<div class="mt-2">
											<img src="{{ asset($cliente->foto) }}" alt="Foto del cliente" class="img-thumbnail" width="120">
										</div>
									@endif
								</div>
								<div class="form-group">
									<label><strong>Cotitular</strong></label>
									<input type="text" name="cotitular" class="form-control input-lg" value="{{ old('cotitular', $cliente->cotitular ?? '') }}" maxlength="100">
								</div>
								<div class="form-group">
									<label><strong>Puntuación</strong></label>
									<input type="number" name="puntuacion" class="form-control input-lg" value="{{ old('puntuacion', $cliente->puntuacion ?? 0) }}" min="0" max="100">
									<small class="form-text text-muted">La puntuación se calcula según el comportamiento del cliente (refrendos, liquidaciones, expirados).</small>
								</div>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-12 text-right">
								<button type="submit" class="btn btn-success btn-lg shadow"><i class="fas fa-save"></i> Guardar Cliente</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
