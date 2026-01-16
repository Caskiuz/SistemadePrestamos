@extends('layouts.main')

@section('content')
<header class="yp-header brown">
    <h1>
        <a href="{{ route('reportes.index') }}">
            <i class="fa fa-chevron-left"></i>
        </a>
        <span>Resumen de Caja</span>
    </h1>
</header>

<section class="content" style="background-color: #444 !important; padding: 30px !important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card" style="background: #2a2a2a; border: 1px solid #3a3a3a; padding: 20px;">
                    <h5 style="color: #999; font-size: 14px; margin-bottom: 10px;">Préstamos Activos</h5>
                    <h2 style="color: #fff; font-size: 32px; margin: 0;">${{ number_format($totalPrestamos, 2) }}</h2>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card" style="background: #2a2a2a; border: 1px solid #3a3a3a; padding: 20px;">
                    <h5 style="color: #999; font-size: 14px; margin-bottom: 10px;">Total Ventas</h5>
                    <h2 style="color: #fff; font-size: 32px; margin: 0;">${{ number_format($totalVentas, 2) }}</h2>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card" style="background: #2a2a2a; border: 1px solid #3a3a3a; padding: 20px;">
                    <h5 style="color: #999; font-size: 14px; margin-bottom: 10px;">Total Compras</h5>
                    <h2 style="color: #fff; font-size: 32px; margin: 0;">${{ number_format($totalCompras, 2) }}</h2>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card" style="background: #2a2a2a; border: 1px solid #3a3a3a; padding: 20px;">
                    <h5 style="color: #999; font-size: 14px; margin-bottom: 10px;">Saldo en Caja</h5>
                    <h2 style="color: {{ $saldoCaja >= 0 ? '#4CAF50' : '#f44336' }}; font-size: 32px; margin: 0;">${{ number_format($saldoCaja, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
