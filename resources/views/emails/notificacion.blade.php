<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $notificacion->titulo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .prestamo-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #dc2626;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            background: #dc2626;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Préstamos Santa Ana</h1>
        <p>{{ $notificacion->titulo }}</p>
    </div>
    
    <div class="content">
        <h2>Estimado/a {{ $cliente->nombre }}</h2>
        
        <p>{{ $notificacion->mensaje }}</p>
        
        @if($prestamo)
        <div class="prestamo-info">
            <h3>Información del Préstamo</h3>
            <p><strong>Folio:</strong> {{ $prestamo->folio }}</p>
            <p><strong>Monto:</strong> {{ formatCurrency($prestamo->monto) }}</p>
            <p><strong>Fecha de vencimiento:</strong> {{ $prestamo->fecha_vencimiento->format('d/m/Y') }}</p>
            <p><strong>Monto pendiente:</strong> {{ formatCurrency($prestamo->monto_pendiente) }}</p>
        </div>
        @endif
        
        <p>Si tiene alguna pregunta o necesita más información, no dude en contactarnos.</p>
        
        <a href="tel:+1234567890" class="btn">Llamar ahora</a>
    </div>
    
    <div class="footer">
        <p>Este es un mensaje automático, por favor no responda a este correo.</p>
        <p>Préstamos Santa Ana - Su casa de empeño de confianza</p>
    </div>
</body>
</html>