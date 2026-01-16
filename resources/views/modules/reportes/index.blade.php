@extends('layouts.main')

@section('content')
<header class="yp-header brown">
    <h1>
        <i class="fa fa-file-text"></i>
        <span>Reportes</span>
    </h1>
</header>

<section class="content" style="background-color: #444 !important; padding: 15px !important;">
    <div class="container-fluid" style="max-width: 100%; overflow-x: hidden;">
        <h5 style="color: #fff !important; font-size: 16px !important; font-weight: 400 !important; margin-bottom: 10px !important; margin-top: 20px !important;">Caja</h5>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('reportes.cashflow') }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-exchange card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Flujo de Caja</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('reportes.summary') }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-book card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Resumen de Caja</h5>
                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12 mb-3">
                <button class="card card-menu" onclick="openModal('deposito')" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; cursor: pointer !important; width: 100% !important;">
                    <i class="fa fa-long-arrow-right card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Registrar depósito</h5>
                </button>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12 mb-3">
                <button class="card card-menu" onclick="openModal('retiro')" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; cursor: pointer !important; width: 100% !important;">
                    <i class="fa fa-long-arrow-left card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Registrar retiro</h5>
                </button>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12 mb-3">
                <button class="card card-menu" onclick="openModal('gasto')" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; cursor: pointer !important; width: 100% !important;">
                    <i class="fa fa-money card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Registrar gasto</h5>
                </button>
            </div>
        </div>

        <h5 class="mt-4" style="color: #fff !important; font-size: 16px !important; font-weight: 400 !important; margin-bottom: 10px !important; margin-top: 20px !important;">Clientes</h5>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('clientes.index', ['sort' => 'az']) }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-sort-alpha-asc card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Por orden alfabético</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('clientes.index', ['sort' => 'score']) }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-star card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Por mejor puntuación</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('clientes.index', ['filter' => 'birthday']) }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-calendar card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Cumpleañeros del mes</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('clientes.index', ['filter' => 'inactive']) }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-user-times card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Sin actividad reciente</h5>
                </a>
            </div>
        </div>

        <h5 class="mt-4" style="color: #fff !important; font-size: 16px !important; font-weight: 400 !important; margin-bottom: 10px !important; margin-top: 20px !important;">Préstamos</h5>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('reportes.prestamos.vigentes') }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-calendar-check-o card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Préstamos vigentes</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('reportes.prestamos.por-vencer') }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-calendar-minus-o card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Préstamos por vencer</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('reportes.prestamos.vencidos') }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-calendar-times-o card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Préstamos vencidos</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('reportes.prestamos.expirados') }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-tag card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Préstamos expirados</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('reportes.prestamos.liquidados') }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-legal card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Préstamos liquidados</h5>
                </a>
            </div>
        </div>

        <h5 class="mt-4" style="color: #fff !important; font-size: 16px !important; font-weight: 400 !important; margin-bottom: 10px !important; margin-top: 20px !important;">Compras, ventas y apartados</h5>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('compras.index') }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-shopping-cart card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Compras</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('ventas.index') }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-credit-card card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Ventas</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('reportes.apartados.vigentes') }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-bookmark card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Apartados vigentes</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('reportes.apartados.vencidos') }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-bookmark-o card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Apartados vencidos</h5>
                </a>
            </div>
        </div>

        <h5 class="mt-4" style="color: #fff !important; font-size: 16px !important; font-weight: 400 !important; margin-bottom: 10px !important; margin-top: 20px !important;">Inventario</h5>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('inventario.index', ['status' => 'loan']) }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-archive card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Prendas empeñadas</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('inventario.index', ['status' => 'loan', 'type' => 'jewl']) }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-star card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Joyas empeñadas</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('inventario.index', ['status' => 'forSale']) }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-star card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Prendas en venta</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('inventario.index', ['status' => 'forSale', 'type' => 'jewl']) }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-star card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Joyas en venta</h5>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                <a href="{{ route('inventario.index', ['status' => 'layaway']) }}" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-bookmark card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Prendas apartadas</h5>
                </a>
            </div>
        </div>

        <h5 class="mt-4" style="color: #fff !important; font-size: 16px !important; font-weight: 400 !important; margin-bottom: 10px !important; margin-top: 20px !important;">Respaldo</h5>
        <div class="row">
            <div class="col-12 mb-3">
                <a href="{{ route('reportes.excel') }}" target="_blank" class="card card-menu" style="background: #2a2a2a !important; border: 1px solid #3a3a3a !important; border-radius: 4px !important; padding: 40px 20px !important; text-align: center !important; display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: center !important; min-height: 140px !important; text-decoration: none !important;">
                    <i class="fa fa-file-excel-o card-picture" style="font-size: 48px !important; color: #999 !important; margin-bottom: 15px !important; display: block !important;"></i>
                    <h5 style="color: #ccc !important; margin: 0 !important; font-size: 14px !important; font-weight: 400 !important;">Respaldo en Excel</h5>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function openModal(tipo) {
    const titulos = {
        'deposito': 'Depósito de caja',
        'retiro': 'Retiro de caja',
        'gasto': 'Gasto'
    };
    
    Swal.fire({
        title: titulos[tipo],
        html: `
            <form id="cashForm">
                <div class="form-group text-left">
                    <label>Cantidad</label>
                    <input type="number" class="form-control" id="monto" step="0.01" required>
                </div>
                <div class="form-group text-left">
                    <label>Descripción</label>
                    <textarea class="form-control" id="descripcion" rows="3"></textarea>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: tipo === 'deposito' ? 'Depositar' : (tipo === 'retiro' ? 'Retirar' : 'Registrar'),
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#3085d6',
        preConfirm: () => {
            const monto = document.getElementById('monto').value;
            const descripcion = document.getElementById('descripcion').value;
            
            if (!monto || monto <= 0) {
                Swal.showValidationMessage('Ingrese una cantidad válida');
                return false;
            }
            
            return { monto, descripcion, tipo };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            registrarMovimiento(result.value);
        }
    });
}

function registrarMovimiento(data) {
    fetch('{{ route("reportes.registrar-movimiento") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            Swal.fire('Registrado', result.message, 'success').then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error', result.message, 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Ocurrió un error al registrar', 'error');
    });
}
</script>
@endpush
