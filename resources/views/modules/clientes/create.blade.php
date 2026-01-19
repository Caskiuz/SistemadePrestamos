<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo cliente</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
    <div class="container">
        <h1>Nuevo cliente</h1>
        <form action="{{ route('clientes.store') }}" method="POST" id="createClient">
            @csrf
            <div class="form-group">
                <label for="tipo">Tipo de cliente</label>
                <select id="tipo" name="tipo" class="form-control" required>
                    <option value="">Seleccionar...</option>
                    <option value="PERSONA">Persona</option>
                    <option value="EMPRESA">Empresa</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input required type="text" id="nombre" name="nombre" placeholder="Nombre completo del cliente" class="form-control">
            </div>
            <div class="form-group">
                <label for="tipo_documento">Tipo de documento</label>
                <select id="tipo_documento" name="tipo_documento" class="form-control" required>
                    <option value="">Seleccionar...</option>
                    <option value="CI">Cédula de Identidad (CI)</option>
                    <option value="NIT">NIT</option>
                    <option value="PASAPORTE">Pasaporte</option>
                    <option value="OTRO">Otro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="numero_documento">Número de documento</label>
                <input type="text" id="numero_documento" name="numero_documento" placeholder="Número de documento" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="telefono_1">Teléfono principal</label>
                <input type="text" id="telefono_1" name="telefono_1" placeholder="Teléfono principal" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="telefono_2">Teléfono secundario</label>
                <input type="text" id="telefono_2" name="telefono_2" placeholder="Teléfono secundario (opcional)" class="form-control">
            </div>
            <div class="form-group">
                <label for="telefono_3">Teléfono adicional</label>
                <input type="text" id="telefono_3" name="telefono_3" placeholder="Teléfono adicional (opcional)" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" class="form-control">
            </div>
            <div class="form-group">
                <label for="ciudad">Ciudad</label>
                <input type="text" id="ciudad" name="ciudad" placeholder="Ciudad" class="form-control" value="Santa Cruz">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" placeholder="Dirección completa" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('clientes.index') }}" class="btn btn-default">Cancelar</a>
        </form>
    </div>
</body>
</html>
