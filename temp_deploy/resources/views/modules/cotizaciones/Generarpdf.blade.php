<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cotización {{ $recepcion->numero_recepcion }}</title>
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
            padding: 2px 4px;
            /* pequeño padding para separar del borde */
        }

        .direccion span {
            display: block;
            /* que ocupe toda la línea */
            font-size: 9px;
            /* tamaño de letra más pequeño */
            line-height: 1.2;
            /* interlineado ajustado */
            text-align: justify;
            /* justificado */
            color: #000000;
            /* color del texto */
            margin-top: 2px;
            /* margen superior */
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
            width: 248px;
            /* ancho del contenedor */
            height: 85px;
            /* alto del contenedor */
            margin: 0 auto;
            border: 1px solid #999;
            display: flex;
            align-items: center;
            /* centrado vertical */
            justify-content: center;
            /* centrado horizontal */
            overflow: hidden;
            padding: 2px;
            box-sizing: border-box;
        }

        .imagen-equipo {
            width: auto;
            /* ancho automático para respetar proporción */
            max-width: 150px;
            /* ancho máximo de la imagen */
            height: 100%;
            /* altura se ajusta al contenedor */
            object-fit: contain;
            /* mantiene proporción de la imagen */
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

        .fila-bloques>.bloque {
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

        .tabla-datos th,
        .tabla-equipos td {
            text-align: left;
            width: 30%;
            min-height: 25px;
            vertical-align: middle;
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
            font-size: 11px;
            /* Tamaño de letra */
            color: #1b1b1b;
            /* Color rojo suave (puedes poner el que quieras) */
            font-weight: bold;
            /* Negrita opcional */
            line-height: 1.4;
            /* Espaciado de líneas */
            margin-top: 15px;
            /* Espacio superior */
        }
    </style>
</head>

<body class="body-recepcion">

    <!-- CABECERA -->
    <div class="cabecera">
        <table width="100%">
            <tr>
                <td class="logo">
                    <center><img src="{{ url('img/logo.jpeg') }}" alt="logo" width="120">
                    </center>
                </td>
                <td class="titulo">
                    <h1>COTIZACIÓN DE EQUIPOS</h1>
                    <h2>N° {{ $cod_cotizar ?? ($recepcion->numero_recepcion ?? 'N/A') }}</h2>
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
                        <th style="background-color:#d5e9f5;">Empresa:</th>
                        <td style="background-color:#d5e9f5;">{{ $recepcion->cliente->nombre_empresa ?? 'Particular' }}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color:#ffffff;">Nombre:</th>
                        <td style="background-color:#ffffff;">{{ $recepcion->cliente->nombre }}</td>
                    </tr>
                    <tr>
                        <th style="background-color:#d5e9f5;">
                            {{ ucfirst(strtolower($recepcion->cliente->tipo_documento)) }}:</th>
                        <td style="background-color:#d5e9f5;">{{ $recepcion->cliente->numero_documento }}</td>
                    </tr>
                    <tr>
                        <th style="background-color:#ffffff;">Teléfono:</th>
                        <td style="background-color:#ffffff;">{{ $recepcion->cliente->telefono_1 ?? 'N/A' }} -
                            {{ $recepcion->cliente->telefono_2 ?? '' }}
                        </td>
                    </tr>
                </table>
            </td>

            <!-- BLOQUE 2: DATOS DE RECEPCIÓN -->
            <td class="bloque">
                <div class="titulo-bloque">DATOS DE RECEPCIÓN</div>
                <table class="tabla-datos">
                    <tr>
                        <th style="background-color:#d5e9f5;">Fecha:</th>
                        <td style="background-color:#d5e9f5;">
                            {{ \Carbon\Carbon::parse($recepcion->fecha_ingreso)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th style="background-color:#ffffff;">Hora:</th>
                        <td style="background-color:#ffffff;">
                            {{ \Carbon\Carbon::parse($recepcion->hora_ingreso)->format('H:i') }}</td>
                    </tr>
                    <tr>
                        <th style="background-color:#d5e9f5;">Usuario:</th>
                        <td style="background-color:#d5e9f5;">{{ optional($recepcion->usuario)->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th style="background-color:#ffffff;">Tipo Serv:</th>
                        <td style="background-color:#ffffff;">{{ $recepcion->tipo_recepcion ?? 'N/A' }}</td>
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
                                    $rutaArchivo =
                                        $_SERVER['DOCUMENT_ROOT'] . '/equipos_fotos/' . basename($foto->ruta);

                                    if (file_exists($rutaArchivo)) {
                                        $fotoBase64 = base64_encode(file_get_contents($rutaArchivo));
                                        $extension = pathinfo($rutaArchivo, PATHINFO_EXTENSION);
                                    }
                                    break; // Solo la primera foto
                                }
                            }
                        @endphp

                        @if ($fotoBase64)
                            <img src="data:image/{{ $extension }};base64,{{ $fotoBase64 }}" alt="Foto del equipo"
                                style="max-width:100px; max-height:100px; height:auto; width:auto;">
                        @else
                            <span>No hay foto disponible</span>
                        @endif

                    </center>
                </div>
            </td>
        </tr>
    </table>
    <!-- Equipos, repuestos y fotos: cada bloque protegido -->
    @foreach ($cotizacion->equipos as $cotizacionEquipo)
        @php
            $equipo = $cotizacionEquipo->equipo;
            $fotosSeleccionadas = $cotizacionEquipo->fotos ?? collect();
            $repuestos = $cotizacionEquipo->repuestos ?? collect();
            $servicios = $cotizacionEquipo->servicios ?? collect();
        @endphp

        <div style="page-break-inside: avoid; margin-top:5px; margin-bottom:-6px;">

            <!-- Detalles del equipo -->
            <table style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #524f4f;">
                <tr style="height: 20px;">
                    <td colspan="5"
                        style="background-color:#2574a8; color:#fff; font-weight:bold; text-align:center; padding:4px;">
                        DETALLES DEL EQUIPO: {{ $equipo ? Str::upper($equipo->nombre) : 'N/A' }}
                    </td>
                </tr>

                <!-- FILA 1 -->
                <tr style="border-bottom:1px solid #000; background-color:#e3f2fd;">
                    <td style="padding:4px;"><strong>Categoria:</strong>
                        {{ $equipo ? Str::title(str_replace('_', ' ', $equipo->tipo)) : 'N/A' }}</td>
                    <td style="padding:4px;"><strong>Marca:</strong> {{ $equipo->marca ?? 'N/A' }}</td>
                    <td style="padding:4px;"><strong>Modelo:</strong> {{ $equipo->modelo ?? 'N/A' }}</td>
                    <td style="padding:4px;"><strong>Color:</strong> {{ $equipo->color ?? 'N/A' }}</td>
                    <td style="padding:4px;">-</td>
                </tr>

                <!-- FILA 2 -->
                <tr style="border-bottom:1px solid #000; background-color:white;">
                    <td colspan="5" style="padding:4px;"><strong>Descripción del trabajo:</strong>
                        {{ $cotizacionEquipo->trabajo_realizar ?? 'N/A' }}</td>
                </tr>

                <!-- FILA 3 -->
                <tr style="border-bottom:1px solid #000; background-color:#e3f2fd;">
                    <td colspan="2" style="padding:4px;"><strong>Precio del trabajo:</strong> Bs.
                        {{ number_format($cotizacionEquipo->precio_trabajo ?? 0, 2) }}</td>
                    <td colspan="3" style="padding:4px;"><strong>Total repuestos:</strong> Bs.
                        {{ number_format($cotizacionEquipo->total_repuestos ?? 0, 2) }}</td>
                </tr>
            </table>

            <!-- Repuestos -->
            <table
                style="width:100%; border-collapse:collapse; font-size:11px; border:1px solid #000; margin-top:-3px;">
                <tr style="background-color:#9fbbcf; color:#313131; font-weight:bold; text-align:center;">
                    <th style="padding:4px;">DESCRIPCIÓN DE LOS REPUESTOS</th>
                    <th style="padding:4px;">CANT</th>
                    <th style="padding:4px;">U. UNITARIO</th>
                    <th style="padding:4px;">TOTAL</th>
                </tr>

                @forelse($repuestos as $repuesto)
                    <tr
                        style="border-bottom:1px solid #000; background-color:{{ $loop->iteration % 2 == 0 ? '#e3f2fd' : 'white' }};">
                        <td style="padding:4px;">{{ $repuesto->nombre }}</td>
                        <td style="padding:4px;">{{ $repuesto->cantidad ?? 0 }}</td>
                        <td style="padding:4px;">Bs. {{ number_format($repuesto->precio_unitario ?? 0, 2) }}</td>
                        <td style="padding:4px;">Bs.
                            {{ number_format(($repuesto->cantidad ?? 0) * ($repuesto->precio_unitario ?? 0), 2) }}</td>
                    </tr>
                @empty
                    <tr style="background-color:white;">
                        <td colspan="4" style="text-align:center; padding:6px;">No se especificaron repuestos</td>
                    </tr>
                @endforelse
            </table>

            <!-- Servicios realizados -->
            <table
                style="width:100%; border-collapse:collapse; margin-top:-3px; font-family:Arial, sans-serif; font-size:11px; border:1px solid #000;">
                <tr style="background-color:#9fbbcf; color:#313131; font-weight:bold; text-align:center;">
                    <th style="padding:4px;">SERVICIOS REALIZADOS</th>
                </tr>

                @forelse($servicios as $i => $servicio)
                    <tr
                        style="border-bottom:1px solid #000; background-color:{{ $i % 2 == 0 ? '#e3f2fd' : 'white' }};">
                        <td style="padding:4px;">{{ $i + 1 }}.- {{ $servicio->nombre }}</td>
                    </tr>
                @empty
                    <tr style="background-color:white;">
                        <td style="padding:4px;">No se especificaron servicios</td>
                    </tr>
                @endforelse
            </table>
        </div>
    @endforeach
    <!-- Totales y condiciones en una sola tabla protegida -->
    <div style="page-break-inside: avoid;">
        <table
            style="width:100%; border-collapse:collapse; margin-top:5px; font-family:Arial, sans-serif; font-size:11px; background-color:#e0eff8;">
            <tr>
                <td style="width:60%; vertical-align:top; padding:6px; border:1px solid #000;">
                    <strong>Esta cotización está sujeta a los términos y condiciones que se enuncian a
                        continuación:</strong><br>
                    1. Tiempo de entrega 2 a 3 días hábiles<br>
                    2. Vigencia de la oferta 15 días hábiles<br>
                    3. Forma de pago 50% por adelantado y saldo contra entrega<br>
                    4. Garantía del servicio 3 meses<br>
                    5. Taller HC no se responsabiliza por el equipo dejado más de 90 días<br><br>
                <td style="width:40%; vertical-align:top; padding:6px; border:1px solid #000;">
                    <table style="width:100%; border-collapse:collapse; font-size:11px;">
                        <tr>
                            <td style="padding:4px;">Sub Total Bs</td>
                            <td style="padding:4px; text-align:right;">Bs. {{ number_format($subtotal ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding:4px;">Descuento Bs</td>
                            <td style="padding:4px; text-align:right;">Bs. {{ number_format($descuento ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding:4px;"><strong>Total Bs</strong></td>
                            <td style="padding:4px; text-align:right;"><strong>Bs.
                                    {{ number_format($total ?? 0, 2) }}</strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer" style="margin-top:10px; text-align:center; font-size:10px;">
        Agradecemos su preferencia y quedamos a su disposición para cualquier consulta adicional.<br>
        HC INDUSTRIAL - Mantenimiento y Reparación de Maquinaria Eléctrica Industrial
    </div>

</body>

</html>
