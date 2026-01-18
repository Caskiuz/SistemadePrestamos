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

<section class="content fade-in" style="background-color: #f5f6fa !important; padding: 15px !important;">
    <div class="container-fluid">
        <div class="responsive-grid">
            <div class="card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fa fa-money"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Préstamos Activos</h4>
                    </div>
                    <div class="card-body">
                        ${{ number_format($totalPrestamos, 2) }}
                    </div>
                </div>
            </div>
            
            <div class="card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Ventas</h4>
                    </div>
                    <div class="card-body">
                        ${{ number_format($totalVentas, 2) }}
                    </div>
                </div>
            </div>
            
            <div class="card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fa fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Compras</h4>
                    </div>
                    <div class="card-body">
                        ${{ number_format($totalCompras, 2) }}
                    </div>
                </div>
            </div>
            
            <div class="card-statistic-1">
                <div class="card-icon" style="background-color: {{ $saldoCaja >= 0 ? '#4CAF50' : '#f44336' }}">
                    <i class="fa fa-bank"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Saldo en Caja</h4>
                    </div>
                    <div class="card-body" style="color: {{ $saldoCaja >= 0 ? '#4CAF50' : '#f44336' }}">
                        ${{ number_format($saldoCaja, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
