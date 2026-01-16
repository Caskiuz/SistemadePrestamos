<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recepción {{ $recepcion->numero_recepcion }}</title>
    <style>
    /* --Estilos generales del body-- */
.body-recepcion {
    margin: -30px -25px -30px -25px;
    padding: 0;
    font-family: Arial, sans-serif;
    font-size: 10px;
    line-height: 1.2;
    color: #333;
}

/* --Cabecera del PDF-- */
.cabecera {
    width: 100%;
    padding: 0;
    margin-bottom: 5px;
}

.tabla-cabecera {
    width: 100%;
    border-collapse: collapse;
}

.logo {
    width: 30%;
    vertical-align: top;
    padding: 0;
}

.imagen-logo {
    width: 95px;
    max-height: 80px;
    height: auto;
}

.titulo {
    text-align: center;
    vertical-align: middle;
    padding: 0;
}

.titulo h1 {
    margin: 0;
    font-size: 14px;
    font-weight: bold;
}

.titulo h2 {
    margin: 0;
    font-size: 11px;
}

.direccion {
    width: 30%;
    text-align: center;
    padding: 2px 4px; /* pequeño padding para separar del borde */
}

.direccion span {
    display: block;            /* que ocupe toda la línea */
    font-size: 9px;            /* tamaño de letra más pequeño */
    line-height: 1.2;          /* interlineado ajustado */
    text-align: justify;       /* justificado */
    color: #000000;               /* color del texto */
    margin-top: 2px;           /* margen superior */
}

.clear {
    clear: both;
}

/* --Bloques de datos cliente y foto-- */
.tabla-cliente-foto {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.datos-cliente,
.foto-equipo {
    vertical-align: top;
    padding: 2px;
    box-sizing: border-box;
}

.datos-cliente {
    width: 50%;
}

.foto-equipo {
    width: 25%;
    text-align: center;
    height: 80px;
}

.titulo-bloque {
    background-color: #2574a8;
    color: #fff;
    padding: 4px 6px;
    font-size: 12px;
    font-weight: bold;
    margin-bottom: 3px;
    text-align: center;
}

/* --Tabla de datos de cliente o recepción-- */
.tabla-datos {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #000;
}

.tabla-datos th,
.tabla-datos td {
    border: 1px solid #000;
    padding: 4px;
    text-align: left;
    background-color: #ddedf5;
}

/* --Contenedor y estilos de las fotos-- */
.contenedor-foto {
    width: 248px;       /* ancho del contenedor */
    height: 85px;       /* alto del contenedor */
    margin: 0 auto;
    border: 1px solid #999;
    display: flex;
    align-items: center;  /* centrado vertical */
    justify-content: center; /* centrado horizontal */
    overflow: hidden;
    padding: 2px;
    box-sizing: border-box;
}

.imagen-equipo {
    width: auto;          /* ancho automático para respetar proporción */
    max-width: 150px;     /* ancho máximo de la imagen */
    height: 100%;         /* altura se ajusta al contenedor */
    object-fit: contain;  /* mantiene proporción de la imagen */
}

/* --Datos de recepción-- */
.datos-recepcion {
    vertical-align: top;
    padding: 2px;
    box-sizing: border-box;
}

/* --Mensaje importante al inicio-- */
.importante {
    font-size: 9px;
    margin-top: 5px;
    text-align: justify;
    line-height: 1.2;
    font-weight: bold;
    color: #000;
}

/* --Título de tablas de equipos-- */
.titulo-tabla {
    background-color: #2574a8;
    color: #fff;
    padding: 4px 6px;
    font-size: 12px;
    font-weight: bold;
    margin-top: 10px;
}

/* --Tabla de equipos-- */
.tabla-equipos {
    width: 100%;
    border-collapse: collapse;
    margin-top: 5px;
    font-size: 8px;
}

.tabla-equipos th,
.tabla-equipos td {
    border: 1px solid #000;
    padding: 3px;
    text-align: center;
    background-color: #ddedf5;
}

/* --Filas de imágenes de los equipos-- */
.tabla-equipos .imagenes-equipo-table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
}

.tabla-equipos .imagenes-equipo-table td {
    padding: 2px;
    border: none;
}

.tabla-equipos .imagenes-equipo-table img {
    width: 90px;
    height: 65px;
    object-fit: contain;
}

/* --Firmas al final del PDF-- */
.firmas {
    width: 100%;
    text-align: center;
    margin-top: 100px;
    border-collapse: collapse;
}

.firmas td {
    width: 50%;
    text-align: center;
    border: none;
}

.linea-firma {
    border-top: 1px solid #000;
    width: 80%;
    margin: 0 auto;
    height: 2px;
}

.texto-firma {
    margin-top: 4px;
    font-size: 10px;
    font-weight: bold;
}

/* --Pie de página con texto importante-- */
.pie-importante {
    font-size: 9px;
    margin-top: 10px;
    text-align: justify;
    line-height: 1.2;
    font-weight: bold;
    color: #000;
}

        .tabla-cliente-foto {
    width: 100%;
    border-collapse: collapse;
}

.fila-bloques > .bloque {
    width: 10%;
    vertical-align: top;
    padding: 1px;
    border: 1px solid #ffffff;
}

.titulo-bloque {
    font-weight: bold;
    margin-bottom: 8px;
    text-align: center;
}

.tabla-datos th {
    text-align: left;
    width: 40%;
}

.contenedor-foto {
    text-align: center;
    padding: 1px;
}

.imagen-equipo {
    width: 100%;
    max-width: 100px;
    height: auto;
    border-radius: 5px;
    object-fit: cover;
}
.pie-importante {
    font-size: 11px;      /* Tamaño de letra */
    color: #1b1b1b;       /* Color rojo suave (puedes poner el que quieras) */
    font-weight: bold;    /* Negrita opcional */
    line-height: 1.4;     /* Espaciado de líneas */
    margin-top: 15px;     /* Espacio superior */
}
    </style>
</head>

<body class="body-recepcion">

    <!-- CABECERA -->
    <div class="cabecera">
        <table width="100%">
            <tr>
                <td class="logo">
                    <center><img src="{{ url('img/logo.jpeg') }}" alt="logo" width="160">
                    </center>
                </td>
                <td class="titulo">
                    <h1>RECEPCIÓN DE EQUIPOS</h1>
                    <h2>N° {{ $recepcion->numero_recepcion }}</h2>
                </td>
                <td class="direccion">
                    <h4 style="caret-color: black">
                        <center>Dir: 4to Anillo entre Av.Alemana <br> Y Av. Costanera <br>
                            Cel: 76578154 / 72868051</center>
                    </h4>
                </td>
            </tr>
        </table>
    </div>


    <!-- BLOQUES CLIENTE / FOTO -->
    <table class="tabla-cliente-foto">
    <tr class="fila-bloques">
        
        <!-- BLOQUE 1: DATOS DEL CLIENTE -->
        <td class="bloque">
            <div class="titulo-bloque">DATOS DEL CLIENTE</div>
            <table class="tabla-datos">
                <tr>
                    <th>Empresa:</th>
                    <td>{{ $recepcion->cliente->nombre_empresa ?? 'Particular' }}</td>
                </tr>
                <tr>
                    <th>Nombre:</th>
                    <td>{{ $recepcion->cliente->nombre }}</td>
                </tr>
                <tr>
                    <th>{{ ucfirst(strtolower($recepcion->cliente->tipo_documento)) }}:</th>
                    <td>{{ $recepcion->cliente->numero_documento }}</td>
                </tr>
                <tr>
                    <th>Teléfono:</th>
                    <td>{{ $recepcion->cliente->telefono_1 ?? 'N/A' }} - {{ $recepcion->cliente->telefono_2 ?? '' }}</td>
                </tr>
            </table>
        </td>

        <!-- BLOQUE 2: DATOS DE RECEPCIÓN -->
        <td class="bloque">
            <div class="titulo-bloque">DATOS DE RECEPCIÓN</div>
            <table class="tabla-datos">
                <tr>
                    <th>Fecha:</th>
                    <td>{{ \Carbon\Carbon::parse($recepcion->fecha_ingreso)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Hora:</th>
                    <td>{{ \Carbon\Carbon::parse($recepcion->hora_ingreso)->format('H:i') }}</td>
                </tr>
                <tr>
                    <th>Usuario:</th>
                    <td>{{ optional($recepcion->usuario)->nombre ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Tipo servicio:</th>
                    <td>{{ $recepcion->tipo_recepcion ?? 'N/A' }}</td>
                </tr>
            </table>
        </td>

        <!-- BLOQUE 3: FOTO DEL EQUIPO -->
        <td class="bloque">
            <div class="titulo-bloque">FOTO DEL EQUIPO</div>
            
            <div>
                <center>
                    @php
    $fotoBase64 = null;
    $extension = null;

    // Recorremos los equipos
    foreach ($recepcion->equipos as $equipo) {
        if ($equipo->fotos->count() > 0) {
            $foto = $equipo->fotos->first();

            // Construimos la ruta física correcta
            $rutaArchivo = $_SERVER['DOCUMENT_ROOT'] . '/equipos_fotos/' . basename($foto->ruta);

            if (file_exists($rutaArchivo)) {
                $fotoBase64 = base64_encode(file_get_contents($rutaArchivo));
                $extension = pathinfo($rutaArchivo, PATHINFO_EXTENSION);
            }
            break; // Solo la primera foto
        }
    }
@endphp

@if ($fotoBase64)
    <img src="data:image/{{ $extension }};base64,{{ $fotoBase64 }}" 
         alt="Foto del equipo" 
         style="max-width:160px; max-height:140px; height:auto; width:auto;">
@else
    <span>No hay foto disponible</span>
@endif

                     </center>
            </div>
        </td>
    </tr>
</table>
<!-- IMPORTANTE -->
    <div class="importante">
        Importante: {{ $importante->importante ?? '-' }}
    </div>

    <!-- TABLA DE EQUIPOS RECEPCIONADOS -->
    <div class="titulo-tabla">EQUIPOS RECEPCIONADOS</div>
    <table class="tabla-equipos">
        <thead>
            <tr>
                <th>#</th>
                <th>Artículo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Categoria</th>
                <th>Color(es)</th>
                <th>Monto</th>
                <th>Voltaje</th>
                <th>HP</th>
                <th>RPM</th>
                <th>Hz</th>
                <th>AMP</th>
                <th>Cable +</th>
                <th>Cable -</th>
                <th>KVA/<br>KW</th>
                <th>Potencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recepcion->equipos as $index => $equipo)
                <!-- FILA DE DATOS DEL EQUIPO -->
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $equipo->nombre }}</td>
                    <td>{{ $equipo->marca }}</td>
                    <td>{{ $equipo->modelo ?? '-' }}</td>
                    <td>{{ $equipo->tipo }}</td>
                    <td>{{ $equipo->color ?? '-' }}</td>
                    <td>Bs. {{ number_format($equipo->monto, 2) }}</td>
                    <td>{{ $equipo->voltaje ?? '-' }}</td>
                    <td>{{ $equipo->hp ?? '-' }}</td>
                    <td>{{ $equipo->rpm ?? '-' }}</td>
                    <td>{{ $equipo->hz ?? '-' }}</td>
                    <td>{{ $equipo->amperaje ?? '-' }}</td>
                    <td>{{ $equipo->cable_positivo ?? '-' }}</td>
                    <td>{{ $equipo->cable_negativo ?? '-' }}</td>
                    <td>{{ $equipo->kva_kw ?? '-' }}</td>
                    <td>{{ $equipo->potencia ? $equipo->potencia . ' ' . ($equipo->potencia_unidad ?? '') : '-' }}</td>
                </tr>

                {{-- <!-- FILA DE IMÁGENES DEL EQUIPO (IMÁGENES EN FILA) -->
                @if ($equipo->fotos->count() > 0)
                    <tr>
                        <td colspan="16">
                            <table class="imagenes-equipo-table">
                                <tr>
                                    @foreach ($equipo->fotos as $foto)
                                        @php
                                            $ruta = public_path($foto->ruta);
                                            $base64 = file_exists($ruta) ? base64_encode(file_get_contents($ruta)) : null;
                                            $extension = pathinfo($ruta, PATHINFO_EXTENSION);
                                        @endphp
                                        @if ($base64)
                                            <td>
                                                <img src="data:image/{{ $extension }};base64,{{ $base64 }}">
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif --}}
            @endforeach
        </tbody>
    </table>

    <!-- FIRMAS -->
    <table class="firmas">
        <tr>
            <td>
                <div class="linea-firma"></div>
                <div class="texto-firma">Firma HC</div>
            </td>
            <td>
                <div class="linea-firma"></div>
                <div class="texto-firma">Firma Cliente</div>
            </td>
        </tr>
    </table>
<br><br>
    <!-- PIE IMPORTANTE -->
    <div class="pie-importante">
        IMPORTANTE: La presente maquinaria deberá ser retirada en el término de 90 días. A partir de la fecha,
        pasado dicho tiempo la obligación será considerada de plazo vencido y exigible por el monto líquido,
        que arroja valor en mano de obra, materiales y repuestos. BOBINADO INDUSTRIAL HC se reserva con el
        derecho de proceder con la venta directa del equipo dentro del plazo. En conformidad con lo dispuesto
        por el artículo 812 del código civil de Bolivia.
    </div>

</body>

</html>