@extends('layouts.main')

@section('content')
<x-mobile-header title="Reportes" />

<div class="mobile-content">
    <div class="section-title">
        <h3>Caja</h3>
    </div>
    <div class="reports-grid">
        <a href="{{ route('reportes.cashflow') }}" class="report-card">
            <i class="fa fa-exchange"></i>
            <h5>Flujo de Caja</h5>
        </a>
        <a href="{{ route('reportes.summary') }}" class="report-card">
            <i class="fa fa-book"></i>
            <h5>Resumen de Caja</h5>
        </a>
        <button class="report-card" onclick="openModal('deposito')">
            <i class="fa fa-long-arrow-right"></i>
            <h5>Registrar depósito</h5>
        </button>
        <button class="report-card" onclick="openModal('retiro')">
            <i class="fa fa-long-arrow-left"></i>
            <h5>Registrar retiro</h5>
        </button>
        <button class="report-card" onclick="openModal('gasto')">
            <i class="fa fa-money"></i>
            <h5>Registrar gasto</h5>
        </button>
    </div>

    <div class="section-title">
        <h3>Clientes</h3>
    </div>
    <div class="reports-grid">
        <a href="{{ route('clientes.index', ['sort' => 'az']) }}" class="report-card">
            <i class="fa fa-sort-alpha-asc"></i>
            <h5>Por orden alfabético</h5>
        </a>
        <a href="{{ route('clientes.index', ['sort' => 'score']) }}" class="report-card">
            <i class="fa fa-star"></i>
            <h5>Por mejor puntuación</h5>
        </a>
        <a href="{{ route('clientes.index', ['filter' => 'birthday']) }}" class="report-card">
            <i class="fa fa-calendar"></i>
            <h5>Cumpleañeros del mes</h5>
        </a>
        <a href="{{ route('clientes.index', ['filter' => 'inactive']) }}" class="report-card">
            <i class="fa fa-user-times"></i>
            <h5>Sin actividad reciente</h5>
        </a>
    </div>

    <div class="section-title">
        <h3>Préstamos</h3>
    </div>
    <div class="reports-grid">
        <a href="{{ route('reportes.prestamos.vigentes') }}" class="report-card">
            <i class="fa fa-calendar-check-o"></i>
            <h5>Préstamos vigentes</h5>
        </a>
        <a href="{{ route('reportes.prestamos.por-vencer') }}" class="report-card">
            <i class="fa fa-calendar-minus-o"></i>
            <h5>Préstamos por vencer</h5>
        </a>
        <a href="{{ route('reportes.prestamos.vencidos') }}" class="report-card">
            <i class="fa fa-calendar-times-o"></i>
            <h5>Préstamos vencidos</h5>
        </a>
        <a href="{{ route('reportes.prestamos.expirados') }}" class="report-card">
            <i class="fa fa-tag"></i>
            <h5>Préstamos expirados</h5>
        </a>
        <a href="{{ route('reportes.prestamos.liquidados') }}" class="report-card">
            <i class="fa fa-legal"></i>
            <h5>Préstamos liquidados</h5>
        </a>
    </div>

    <div class="section-title">
        <h3>Compras, ventas y apartados</h3>
    </div>
    <div class="reports-grid">
        <a href="{{ route('compras.index') }}" class="report-card">
            <i class="fa fa-shopping-cart"></i>
            <h5>Compras</h5>
        </a>
        <a href="{{ route('ventas.index') }}" class="report-card">
            <i class="fa fa-credit-card"></i>
            <h5>Ventas</h5>
        </a>
        <a href="{{ route('reportes.apartados.vigentes') }}" class="report-card">
            <i class="fa fa-bookmark"></i>
            <h5>Apartados vigentes</h5>
        </a>
        <a href="{{ route('reportes.apartados.vencidos') }}" class="report-card">
            <i class="fa fa-bookmark-o"></i>
            <h5>Apartados vencidos</h5>
        </a>
    </div>

    <div class="section-title">
        <h3>Inventario</h3>
    </div>
    <div class="reports-grid">
        <a href="{{ route('inventario.index', ['status' => 'loan']) }}" class="report-card">
            <i class="fa fa-archive"></i>
            <h5>Prendas empeñadas</h5>
        </a>
        <a href="{{ route('inventario.index', ['status' => 'loan', 'type' => 'jewl']) }}" class="report-card">
            <i class="fa fa-star"></i>
            <h5>Joyas empeñadas</h5>
        </a>
        <a href="{{ route('inventario.index', ['status' => 'forSale']) }}" class="report-card">
            <i class="fa fa-star"></i>
            <h5>Prendas en venta</h5>
        </a>
        <a href="{{ route('inventario.index', ['status' => 'forSale', 'type' => 'jewl']) }}" class="report-card">
            <i class="fa fa-star"></i>
            <h5>Joyas en venta</h5>
        </a>
        <a href="{{ route('inventario.index', ['status' => 'layaway']) }}" class="report-card">
            <i class="fa fa-bookmark"></i>
            <h5>Prendas apartadas</h5>
        </a>
    </div>

    <div class="section-title">
        <h3>Respaldo</h3>
    </div>
    <div class="reports-grid">
        <a href="{{ route('reportes.excel') }}" target="_blank" class="report-card">
            <i class="fa fa-file-excel-o"></i>
            <h5>Respaldo en Excel</h5>
        </a>
    </div>
</div>

<style>
.section-title {
    margin: 30px 0 15px 0;
}

.section-title:first-child {
    margin-top: 0;
}

.section-title h3 {
    font-size: 18px;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
    padding-bottom: 8px;
    border-bottom: 2px solid var(--primary-color);
}

.reports-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.report-card {
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: var(--border-radius);
    padding: 20px 15px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.report-card:hover {
    background: var(--gray-50);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    text-decoration: none;
}

.report-card i {
    font-size: 32px;
    color: var(--primary-color);
    margin-bottom: 10px;
    display: block;
}

.report-card h5 {
    color: var(--gray-800);
    margin: 0;
    font-size: 12px;
    font-weight: 500;
    line-height: 1.3;
}

@media (max-width: 768px) {
    .reports-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
    }
    
    .report-card {
        padding: 15px 10px;
        min-height: 80px;
    }
    
    .report-card i {
        font-size: 24px;
        margin-bottom: 8px;
    }
    
    .report-card h5 {
        font-size: 11px;
    }
}
</style>
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
