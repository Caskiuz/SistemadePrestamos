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
                <label for="first">Nombre</label>
                <input required type="text" id="first" name="first" placeholder="Nombre(s) del cliente" class="form-control">
            </div>
            <div class="form-group">
                <label for="last">Apellidos</label>
                <input required type="text" id="last" name="last" placeholder="Apellidos del cliente" class="form-control">
            </div>
            <div class="form-group">
                <label for="birth">Fecha de nacimiento</label>
                <input type="date" id="birth" name="birth" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" class="form-control">
            </div>
            <div class="form-group">
                <label for="phone">Teléfono</label>
                <input type="text" id="phone" name="phone" placeholder="5 (555) 555-5555" class="form-control">
            </div>
            <div class="form-group">
                <label for="address">Domicilio</label>
                <input type="text" id="address" name="address" placeholder="Calle, número, colonia" class="form-control">
            </div>
            <div class="form-group">
                <label for="zip">Código postal</label>
                <input type="text" id="zip" name="zip" placeholder="Código postal" class="form-control">
            </div>
            <div class="form-group">
                <label for="city">Ciudad</label>
                <input type="text" id="city" name="city" placeholder="Ciudad y estado/provincia" class="form-control">
            </div>
            <div class="form-group">
                <label for="typeOfId">Tipo de ID</label>
                <select id="typeOfId" name="typeOfId" class="form-control">
                    <option value="">Selecciona una opción</option>
                    <option value="id">Identificación oficial</option>
                    <option value="license">Licencia de conducir</option>
                    <option value="passport">Pasaporte</option>
                </select>
            </div>
            <div class="form-group">
                <label for="personalId">ID</label>
                <input type="text" id="personalId" name="personalId" placeholder="Número de identificación oficial" class="form-control">
            </div>
            <div class="form-group">
                <label for="coOwner">Cotitular</label>
                <input type="text" id="coOwner" name="coOwner" placeholder="Cotitular (opcional)" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</body>
</html>
