@extends('layouts.main')
@section('content')
<header class="yp-header" style="background: #5c6bc0;">
  <h1>
    <a href="{{ route('clientes.index') }}" style="color: white; text-decoration: none;">
      <i class="fa fa-arrow-left"></i>
    </a>
    <span style="color: white;">Información del cliente</span>
  </h1>
</header>

<!-- Botón flotante principal -->
<button type="button" class="action" id="mainActionBtn" style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; border-radius: 50%; background: #f44336; border: none; color: white; font-size: 24px; cursor: pointer; z-index: 1000; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">
    <i class="fa fa-plus"></i>
</button>

<!-- Sub-acciones -->
<ul id="subActions" style="display: none; position: fixed; bottom: 90px; right: 20px; list-style: none; padding: 0; z-index: 999;">
    <li style="margin-bottom: 10px; text-align: right;">
        <span style="background: white; padding: 8px 12px; border-radius: 4px; margin-right: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); display: inline-block;">Nuevo préstamo</span>
        <a href="{{ route('prestamos.create') }}?cliente_id={{ $cliente->id }}" style="display: inline-block; width: 50px; height: 50px; border-radius: 50%; background: #f44336; border: none; color: white; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.3); text-align: center; line-height: 50px; text-decoration: none;">
            <i class="fa fa-money"></i>
        </a>
    </li>
    <li style="margin-bottom: 10px; text-align: right;">
        <span style="background: white; padding: 8px 12px; border-radius: 4px; margin-right: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); display: inline-block;">Nueva compra</span>
        <a href="{{ route('compras.create') }}?cliente_id={{ $cliente->id }}" style="display: inline-block; width: 50px; height: 50px; border-radius: 50%; background: #f44336; border: none; color: white; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.3); text-align: center; line-height: 50px; text-decoration: none;">
            <i class="fa fa-shopping-cart"></i>
        </a>
    </li>
</ul>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card" style="margin-bottom: 20px;">
          <div style="padding: 20px; border-bottom: 1px solid #ddd;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <div>
                <h3 style="margin: 0;">{{ $cliente->nombre }}</h3>
              </div>
              <div>
                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning" title="Editar información">
                  <i class="fa fa-pencil"></i>
                </a>
              </div>
            </div>
          </div>
          <div style="padding: 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
              <div>
                <strong>E-mail</strong>
                <div>{{ $cliente->email ?? '-' }}</div>
              </div>
              <div>
                <strong>Teléfono</strong>
                <div>{{ $cliente->telefono_1 ?? '-' }}</div>
              </div>
              <div>
                <strong>Domicilio</strong>
                <div>{{ $cliente->direccion ?? '-' }}</div>
              </div>
              <div>
                <strong>Identificación oficial</strong>
                <div>{{ $cliente->numero_documento ?? '-' }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <h6 style="margin: 20px 0 10px 0; font-weight: bold;">Préstamos</h6>
        <div class="card" style="margin-bottom: 20px; background: {{ $cliente->estadisticas['activos'] > 0 ? '#4caf50' : '#f44336' }}; color: white;">
          <div style="padding: 20px; display: flex; justify-content: space-around; text-align: center;">
            <div>
              <h6 style="margin: 0 0 5px 0;">Activos</h6>
              <strong style="font-size: 24px;">{{ $cliente->estadisticas['activos'] }}</strong>
            </div>
            <div>
              <h6 style="margin: 0 0 5px 0;">Expirados</h6>
              <strong style="font-size: 24px;">{{ $cliente->estadisticas['expirados'] }}</strong>
            </div>
            <div>
              <h6 style="margin: 0 0 5px 0;">Liquidados</h6>
              <strong style="font-size: 24px;">{{ $cliente->estadisticas['liquidados'] }}</strong>
            </div>
            <div>
              <h6 style="margin: 0 0 5px 0;">% de Liquidación</h6>
              <strong style="font-size: 24px;">{{ $cliente->estadisticas['porcentaje_liquidacion'] }}%</strong>
            </div>
          </div>
        </div>

        @if($cliente->prestamos->isNotEmpty())
        <ul style="list-style: none; padding: 0;">
          @foreach($cliente->prestamos as $prestamo)
          <li class="card" style="margin-bottom: 10px;">
            <a href="{{ route('prestamos.show', $prestamo->id) }}" style="display: block; padding: 15px; text-decoration: none; color: inherit;">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                  <strong>{{ $prestamo->folio }}</strong>
                  <div style="color: #666; font-size: 14px;">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</div>
                </div>
                <div style="text-align: right;">
                  <div style="font-size: 18px; font-weight: bold;">${{ number_format($prestamo->monto, 2) }}</div>
                  <span class="badge badge-{{ $prestamo->estado === 'activo' ? 'success' : ($prestamo->estado === 'liquidado' ? 'primary' : 'danger') }}">
                    {{ ucfirst($prestamo->estado) }}
                  </span>
                </div>
              </div>
            </a>
          </li>
          @endforeach
        </ul>
        @endif
      </div>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainBtn = document.getElementById('mainActionBtn');
    const subActions = document.getElementById('subActions');
    
    if (mainBtn && subActions) {
        mainBtn.addEventListener('click', function() {
            const isVisible = subActions.style.display === 'block';
            subActions.style.display = isVisible ? 'none' : 'block';
            this.innerHTML = isVisible ? '<i class="fa fa-plus"></i>' : '<i class="fa fa-times"></i>';
        });
        
        // Cerrar al hacer clic fuera
        document.addEventListener('click', function(event) {
            if (!mainBtn.contains(event.target) && !subActions.contains(event.target)) {
                subActions.style.display = 'none';
                mainBtn.innerHTML = '<i class="fa fa-plus"></i>';
            }
        });
    }
});
</script>
@endsection
