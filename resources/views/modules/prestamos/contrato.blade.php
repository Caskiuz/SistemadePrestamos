<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Documento Privado de Compra - Préstamo #{{ $prestamo->id }}</title>
    <style>
        @page {
            margin: 15px;
            size: letter;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            text-align: justify;
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
            font-size: 16px;
            text-decoration: underline;
        }
        
        .numero-documento {
            text-align: right;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        .intro {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        .clausula {
            margin-bottom: 12px;
            text-align: justify;
        }
        
        .clausula-titulo {
            font-weight: bold;
            text-decoration: underline;
        }
        
        .datos-cliente {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 150px;
            padding-bottom: 1px;
            text-align: center;
        }
        
        .monto {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 200px;
            padding-bottom: 1px;
            font-weight: bold;
            text-align: center;
        }
        
        .descripcion {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 250px;
            padding-bottom: 1px;
            text-align: center;
        }
        
        .fecha-firma {
            margin-top: 30px;
            text-align: center;
        }
        
        .linea-fecha {
            border-bottom: 1px solid #000;
            display: inline-block;
            width: 60px;
            margin: 0 3px;
            text-align: center;
        }
        
        .nota {
            margin-top: 25px;
            font-weight: bold;
            text-align: center;
            font-size: 9px;
        }
        
        .firma-section {
            margin-top: 40px;
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
    </style>
</head>
<body>
    <img src="{{ public_path('images/santa-ana-logo.jpeg') }}" alt="Logo" class="logo">
    
    <div class="numero-documento">
        No. {{ str_pad($prestamo->id, 6, '0', STR_PAD_LEFT) }}
    </div>
    
    <div class="header">
        DOCUMENTO PRIVADO DE COMPRA CON PACTO DE RESCATE
    </div>
    
    <div class="intro">
        Consta por el presente Documento Privado, que al solo reconocimiento de firma y rúbricas podrá ser<br>
        Elevado a instrumento público suscrito al tenor de las siguientes.
    </div>
    
    <div class="clausula">
        <span class="clausula-titulo">PRIMERA.-</span> Yo <span class="datos-cliente">{{ strtoupper($prestamo->cliente->nombre) }}</span> con C.I.: <span class="datos-cliente">{{ $prestamo->cliente->numero_documento }}</span><br>
        Domicilio: <span class="datos-cliente">{{ $prestamo->cliente->direccion ?? 'NO ESPECIFICADO' }}</span> Telf.: <span class="datos-cliente">{{ $prestamo->cliente->telefono_1 ?? 'NO ESPECIFICADO' }}</span><br>
        En la fecha, declaro ser único y exclusivo propietario de las joyas y/o artículos que describo a continuación.<br>
        Descripción prenda: <span class="descripcion">
            @foreach($prestamo->productos as $index => $producto)
                {{ strtoupper($producto->nombre) }}
                @if($producto->marca) - {{ strtoupper($producto->marca) }}@endif
                @if($producto->modelo) {{ strtoupper($producto->modelo) }}@endif
                @if($producto->numero_serie) (SERIE: {{ $producto->numero_serie }})@endif
                @if(!$loop->last), @endif
            @endforeach
        </span>
    </div>
    
    <div class="clausula">
        <span class="clausula-titulo">SEGUNDA.- Transferencia de derechos.-</span> Al presente por así convenir a mis intereses, al amparo del Art. 105 del Código Civil, de mi libre y espontánea voluntad sin que medie violencia, error ni dolo de ninguna naturaleza, que pueda invalidar mi consentimiento, transfiero bajo la modalidad de compra con pacto de rescate y enajenación perpetua de los bienes especificados en la cláusula anterior por el precio libremente convenido y pactado de: <span class="monto">Bs. {{ number_format($prestamo->monto, 2) }} ({{ numeroALetras($prestamo->monto) }} BOLIVIANOS)</span>
    </div>
    
    <div class="clausula">
        <span class="clausula-titulo">TERCERA.-</span> Por común acuerdo de partes, se conviene que el presente contrato de venta se sujeta a la modalidad de venta con pacto de rescate, con sujeción a lo determinado en el Art. 641 del Código Civil por lo que el vendedor puede recuperar el derecho propietario de los bienes en el término máximo de los {{ $prestamo->plazo_dias }} días, plazo a partir de la fecha de suscripción del presente contrato. Vencido el mismo, el comprador no tendrá ninguna obligación de devolución ya que por el solo vencimiento del término se formaliza y convalida la venta sin ningún reclamo posterior.
    </div>
    
    <div class="clausula">
        <span class="clausula-titulo">CUARTA.-</span> Nosotros PRESTAMOS SANTA ANA en calidad de comprador y el (la) Señor(a): <span class="datos-cliente">{{ strtoupper($prestamo->cliente->nombre) }}</span> propietario(a) vendedor(a), damos nuestra conformidad con toda y cada una de las cláusulas que anteceden; por el resultado de lo pactado y por convenir a nuestros intereses.
    </div>
    
    <div class="nota">
        <p><strong>NOTA: RECUERDE SE LE RUEGA TOMAR EN CUENTA LA FECHA DE VENCIMIENTO</strong></p>
        <p><strong>No se aceptan reclamos posteriores</strong></p>
        <p><strong>SEÑOR CLIENTE EL RECOJO ES PERSONAL CON CARNET DE IDENTIDAD</strong></p>
    </div>
    
    <div class="fecha-firma">
        Santa Cruz, <span class="linea-fecha">{{ $prestamo->fecha_prestamo->format('d') }}</span> de <span class="linea-fecha">{{ mesEnEspanol($prestamo->fecha_prestamo->format('n')) }}</span> del <span class="linea-fecha">{{ $prestamo->fecha_prestamo->format('Y') }}</span>
    </div>
    
    <div class="firma-section">
        <div class="firma-container">
            <div class="firma-box">
                <div class="linea-firma"></div>
                <div class="firma-texto">
                    <strong>PRESTAMOS SANTA ANA</strong><br>
                    COMPRADOR
                </div>
            </div>
            <div class="firma-box">
                <div class="linea-firma"></div>
                <div class="firma-texto">
                    <strong>{{ strtoupper($prestamo->cliente->nombre) }}</strong><br>
                    C.I.: {{ $prestamo->cliente->numero_documento }}<br>
                    VENDEDOR
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