<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura de Venta - {{ $venta->id }}</title>
    <style>
        @page {
            margin: 15px;
            size: letter;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        
        .logo {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 80px;
            height: auto;
        }
        
        .header {
            text-align: center;
            font-weight: bold;
            margin: 60px 0 30px 0;
            font-size: 18px;
        }
        
        .numero-documento {
            text-align: right;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        .seccion {
            margin-bottom: 15px;
        }
        
        .titulo {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 8px;
            font-size: 12px;
        }
        
        .datos-tabla {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .datos-tabla td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
        
        .datos-tabla .label {
            font-weight: bold;
            width: 150px;
        }
        
        .producto-tabla {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .producto-tabla th,
        .producto-tabla td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        
        .producto-tabla th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 14px;
        }
        
        .total-monto {
            font-size: 16px;
            font-weight: bold;
            color: #2c5aa0;
        }
        
        .firma-section {
            margin-top: 50px;
            text-align: center;
        }
        
        .firma-container {
            display: inline-block;
            width: 100%;
            text-align: center;
        }
        
        .firma-box {
            display: inline-block;
            width: 40%;
            margin: 0 5%;
            vertical-align: top;
        }
        
        .linea-firma {
            border-bottom: 1px solid #000;
            height: 1px;
            margin: 30px auto 10px auto;
            width: 200px;
        }
        
        .firma-texto {
            font-size: 9px;
            text-align: center;
            line-height: 1.2;
        }
        
        .fecha {
            text-align: center;
            margin-top: 30px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('images/santa-ana-logo.jpeg') }}" alt="Logo" class="logo">
    
    <div class="numero-documento">
        Factura No. {{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}
    </div>
    
    <div class="header">
        FACTURA DE VENTA<br>
        PRESTAMOS SANTA ANA
    </div>
    
    <div class="seccion">
        <div class="titulo">DATOS DEL CLIENTE:</div>
        <table class="datos-tabla">
            <tr>
                <td class="label">Nombre:</td>
                <td>{{ strtoupper($venta->cliente->nombre) }}</td>
            </tr>
            <tr>
                <td class="label">C.I.:</td>
                <td>{{ $venta->cliente->numero_documento }}</td>
            </tr>
            <tr>
                <td class="label">Teléfono:</td>
                <td>{{ $venta->cliente->telefono_1 ?? 'NO ESPECIFICADO' }}</td>
            </tr>
            <tr>
                <td class="label">Dirección:</td>
                <td>{{ $venta->cliente->direccion ?? 'NO ESPECIFICADO' }}</td>
            </tr>
        </table>
    </div>
    
    <div class="seccion">
        <div class="titulo">PRODUCTO VENDIDO:</div>
        <table class="producto-tabla">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ strtoupper($venta->producto->nombre) }}</td>
                    <td>{{ strtoupper($venta->producto->tipo) }}</td>
                    <td>{{ strtoupper($venta->producto->marca ?? 'N/A') }}</td>
                    <td>{{ strtoupper($venta->producto->modelo ?? 'N/A') }}</td>
                    <td>{{ $venta->producto->numero_serie ?? 'N/A' }}</td>
                    <td>Bs. {{ number_format($venta->monto, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="total">
        <div class="total-monto">
            TOTAL: Bs. {{ number_format($venta->monto, 2) }}<br>
            ({{ numeroALetras($venta->monto) }} BOLIVIANOS)
        </div>
    </div>
    
    @if($venta->observaciones)
    <div class="seccion">
        <div class="titulo">OBSERVACIONES:</div>
        <p>{{ $venta->observaciones }}</p>
    </div>
    @endif
    
    <div class="fecha">
        Santa Cruz, {{ $venta->fecha_venta->format('d') }} de {{ mesEnEspanol($venta->fecha_venta->format('n')) }} del {{ $venta->fecha_venta->format('Y') }}
    </div>
    
    <div class="firma-section">
        <div class="firma-container">
            <div class="firma-box">
                <div class="linea-firma"></div>
                <div class="firma-texto">
                    <strong>PRESTAMOS SANTA ANA</strong><br>
                    VENDEDOR
                </div>
            </div>
            <div class="firma-box">
                <div class="linea-firma"></div>
                <div class="firma-texto">
                    <strong>{{ strtoupper($venta->cliente->nombre) }}</strong><br>
                    C.I.: {{ $venta->cliente->numero_documento }}<br>
                    COMPRADOR
                </div>
            </div>
        </div>
    </div>
</body>
</html>

@php
function numeroALetras($numero) {
    $unidades = ['', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
    $decenas = ['', '', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
    $centenas = ['', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'];
    
    if ($numero == 0) return 'CERO';
    if ($numero < 10) return $unidades[$numero];
    if ($numero < 100) {
        if ($numero < 20) {
            $especiales = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
            return $especiales[$numero - 10];
        }
        return $decenas[intval($numero / 10)] . ($numero % 10 ? ' Y ' . $unidades[$numero % 10] : '');
    }
    if ($numero < 1000) {
        return $centenas[intval($numero / 100)] . ($numero % 100 ? ' ' . numeroALetras($numero % 100) : '');
    }
    
    return 'MIL'; // Simplificado para montos típicos
}

function mesEnEspanol($mes) {
    $meses = ['', 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];
    return $meses[$mes];
}
@endphp