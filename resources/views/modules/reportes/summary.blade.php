@extends('layouts.main')

@section('content')
<x-mobile-header title="Resumen de Caja" backUrl="{{ route('reportes.index') }}" />

<div class="mobile-content">
    <div class="card-mobile">
        <div class="section">
            <h3>Resumen General</h3>
            <div class="info-card">
                <div class="info-row">
                    <span class="label">Total en Caja:</span>
                    <span class="value money">Bs. {{ number_format($totalCaja ?? 0, 2, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Ingresos del Día:</span>
                    <span class="value">Bs. {{ number_format($ingresosDia ?? 0, 2, ',', '.') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Egresos del Día:</span>
                    <span class="value pending">Bs. {{ number_format($egresosDia ?? 0, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card-mobile">
        <div class="section">
            <h3>Préstamos</h3>
            <div class="info-card">
                <div class="info-row">
                    <span class="label">Activos:</span>
                    <span class="value">{{ $prestamosActivos ?? 0 }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Vencidos:</span>
                    <span class="value pending">{{ $prestamosVencidos ?? 0 }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Total Prestado:</span>
                    <span class="value money">Bs. {{ number_format($totalPrestado ?? 0, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card-mobile">
        <div class="section">
            <h3>Inventario</h3>
            <div class="info-card">
                <div class="info-row">
                    <span class="label">Prendas Empeñadas:</span>
                    <span class="value">{{ $prendasEmpenadas ?? 0 }}</span>
                </div>
                <div class="info-row">
                    <span class="label">En Venta:</span>
                    <span class="value">{{ $prendasVenta ?? 0 }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Valor Inventario:</span>
                    <span class="value money">Bs. {{ number_format($valorInventario ?? 0, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection