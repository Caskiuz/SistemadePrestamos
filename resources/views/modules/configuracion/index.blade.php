@extends('layouts.main')
@section('contenido')
<div class="section-header bg-primary text-white rounded shadow-sm py-3 px-4 mb-4 align-items-center d-flex justify-content-between">
    <h1 class="mb-0" style="font-weight: 700; letter-spacing: 1px;"><i class="fas fa-cogs mr-2"></i>Configuración avanzada</h1>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom-0">
                    <h4 class="mb-0" style="font-size:21px; color:#151414"><i class="fas fa-sliders-h mr-2"></i>Configuración de empresa, sucursal, empleados, intereses, recibos, región, roles y seguridad</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('configuracion.empresa') }}" class="btn btn-block btn-lg btn-info shadow-sm"><i class="fas fa-building mr-2"></i> Empresa</a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('configuracion.sucursal') }}" class="btn btn-block btn-lg btn-primary shadow-sm"><i class="fas fa-warehouse mr-2"></i> Sucursal</a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('configuracion.empleados') }}" class="btn btn-block btn-lg btn-success shadow-sm"><i class="fas fa-user-tie mr-2"></i> Empleados</a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('configuracion.intereses') }}" class="btn btn-block btn-lg btn-warning shadow-sm"><i class="fas fa-percent mr-2"></i> Intereses</a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('configuracion.recibos') }}" class="btn btn-block btn-lg btn-secondary shadow-sm"><i class="fas fa-file-invoice mr-2"></i> Recibos</a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('configuracion.region') }}" class="btn btn-block btn-lg btn-info shadow-sm"><i class="fas fa-globe-americas mr-2"></i> Región</a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('configuracion.roles') }}" class="btn btn-block btn-lg btn-dark shadow-sm"><i class="fas fa-user-shield mr-2"></i> Roles y Seguridad</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
