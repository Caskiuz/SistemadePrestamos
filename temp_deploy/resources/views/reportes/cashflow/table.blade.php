<section class="content">
    <div class="printed-only">
        <h3>{{ $company->name ?? 'hola' }}</h3>
        <h4>{{ $branch->name ?? 'Matriz' }}</h4>
        <h5>
            Flujo de Caja
            @if(isset($fecha_desde) && isset($fecha_hasta))
                <span>
                    Desde {{ \Carbon\Carbon::parse($fecha_desde)->format('d/m/Y') }}
                    Hasta {{ \Carbon\Carbon::parse($fecha_hasta)->format('d/m/Y') }}
                </span>
            @endif
        </h5>
        <hr>
    </div>
    
    <table class="table table-striped card">
        <thead>
            <tr>
                <th class="text-left">Fecha</th>
                <th class="text-left">Usuario</th>
                <th class="text-left">Concepto</th>
                <th class="text-left">Detalles</th>
                <th class="text-right">Entradas</th>
                <th class="text-right">Salidas</th>
                <th class="text-right">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr class="summary">
                <td colspan="2"></td>
                <td colspan="4">Fondo inicial</td>
                <td class="text-right">${{ number_format($fondo_inicial ?? 0, 2) }}</td>
            </tr>
            
            @php $saldo = $fondo_inicial ?? 0; @endphp
            @foreach($cashflow ?? [] as $entry)
                @php
                    if($entry->tipo_movimiento == 'entrada') {
                        $saldo += $entry->monto;
                    } else {
                        $saldo -= $entry->monto;
                    }
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($entry->fecha)->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $entry->usuario->name ?? '' }}</td>
                    <td>{{ $entry->concepto }}</td>
                    <td>{{ $entry->detalles }}</td>
                    @if($entry->tipo_movimiento == 'entrada')
                        <td class="text-right" colspan="2">${{ number_format($entry->monto, 2) }}</td>
                        <td class="text-right" colspan="1">${{ number_format($saldo, 2) }}</td>
                    @else
                        <td class="text-right" colspan="1"></td>
                        <td class="text-right" colspan="1">${{ number_format($entry->monto, 2) }}</td>
                        <td class="text-right" colspan="1">${{ number_format($saldo, 2) }}</td>
                    @endif
                </tr>
            @endforeach
            
            <tr class="summary">
                <td colspan="2"></td>
                <td colspan="4">Disponible en caja</td>
                <td class="text-right">${{ number_format($saldo, 2) }}</td>
            </tr>
        </tbody>
    </table>
</section>
