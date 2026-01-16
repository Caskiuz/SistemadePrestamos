<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Boleta de Empeño - {{ $prestamo->folio }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .info-section {
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .totals {
            margin-top: 20px;
            text-align: right;
        }
        .totals div {
            margin: 5px 0;
        }
        .total-final {
            font-size: 16px;
            font-weight: bold;
            color: #d9534f;
        }
        .footer {
            margin-top: 40px;
            border-top: 1px solid #333;
            padding-top: 20px;
        }
        .signature {
            margin-top: 50px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin: 0 auto;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BOLETA DE EMPEÑO</h1>
        <p>{{ $prestamo->almacen->nombre }}</p>
        <p>{{ $prestamo->almacen->direccion }}</p>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Folio:</div>
            <div>{{ $prestamo->folio }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Fecha:</div>
            <div>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Fecha de Vencimiento:</div>
            <div>{{ $prestamo->fecha_vencimiento->format('d/m/Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Cliente:</div>
            <div>{{ $prestamo->cliente->nombre }}</div>
        </div>
        @if($prestamo->cliente->telefono_1)
        <div class="info-row">
            <div class="info-label">Teléfono:</div>
            <div>{{ $prestamo->cliente->telefono_1 }}</div>
        </div>
        @endif
    </div>

    <h3>Productos Empeñados</h3>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Valuación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestamo->productos as $producto)
            <tr>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->tipo }}</td>
                <td>{{ $producto->marca ?? 'N/A' }}</td>
                <td>{{ $producto->modelo ?? 'N/A' }}</td>
                <td>${{ number_format($producto->pivot->valuacion, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div><strong>Monto Prestado:</strong> ${{ number_format($prestamo->monto, 2) }}</div>
        <div><strong>Interés ({{ $prestamo->interes_mensual }}%):</strong> ${{ number_format($prestamo->monto_total - $prestamo->monto, 2) }}</div>
        <div class="total-final"><strong>Total a Pagar:</strong> ${{ number_format($prestamo->monto_total, 2) }}</div>
    </div>

    @if($prestamo->observaciones)
    <div class="info-section">
        <div class="info-label">Observaciones:</div>
        <p>{{ $prestamo->observaciones }}</p>
    </div>
    @endif

    <div class="footer">
        <p><strong>Términos y Condiciones:</strong></p>
        <ul>
            <li>El cliente se compromete a pagar el monto total antes de la fecha de vencimiento.</li>
            <li>En caso de no liquidar el préstamo, los productos quedarán en propiedad del establecimiento.</li>
            <li>El cliente puede refrendar el préstamo pagando los intereses correspondientes.</li>
        </ul>
    </div>

    <div class="signature">
        <div class="signature-line">
            Firma del Cliente
        </div>
    </div>
</body>
</html>
