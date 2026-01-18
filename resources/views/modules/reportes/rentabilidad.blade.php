@extends('layouts.main')

@section('content')
<div class="main-content fade-in">
    <section class="section">
        <div class="section-header">
            <h1>Reporte de Rentabilidad</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" class="row mb-4">
                            <div class="col-md-3">
                                <label>Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio', now()->startOfMonth()->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3">
                                <label>Fecha Fin</label>
                                <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin', now()->endOfMonth()->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Consultar
                                </button>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5>Ingresos por Intereses</h5>
                                        <h3>${{ number_format($data['ingresos_intereses'] ?? 0, 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h5>Préstamos Otorgados</h5>
                                        <h3>${{ number_format($data['prestamos_otorgados'] ?? 0, 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h5>Rentabilidad</h5>
                                        <h3>{{ $data['rentabilidad_porcentaje'] ?? 0 }}%</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Análisis del Período</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Período analizado:</strong> {{ request('fecha_inicio', now()->startOfMonth()->format('d/m/Y')) }} - {{ request('fecha_fin', now()->endOfMonth()->format('d/m/Y')) }}</p>
                                        
                                        @php $rentabilidad = $data['rentabilidad_porcentaje'] ?? 0; @endphp
                                        @if($rentabilidad > 15)
                                            <div class="alert alert-success">
                                                <i class="fa fa-check-circle"></i> Excelente rentabilidad. El negocio está generando buenos retornos.
                                            </div>
                                        @elseif($rentabilidad > 8)
                                            <div class="alert alert-warning">
                                                <i class="fa fa-exclamation-triangle"></i> Rentabilidad moderada. Considere revisar las tasas de interés.
                                            </div>
                                        @else
                                            <div class="alert alert-danger">
                                                <i class="fa fa-times-circle"></i> Rentabilidad baja. Es necesario revisar la estrategia de precios.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection