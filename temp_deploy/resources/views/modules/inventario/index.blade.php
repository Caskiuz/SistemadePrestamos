@extends('layouts.main')

@section('content')
<header class="yp-header" style="background: #673AB7;">
    <h1>
        <i class="fa fa-list-alt"></i>
        <span style="color: white;">Prendas</span>
    </h1>
</header>

<section class="content" style="background: #2c2c2c; min-height: calc(100vh - 60px); padding: 20px;">
    <button onclick="window.location='{{ route('inventario.create') }}'" class="action" style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; border-radius: 50%; background: #f44336; border: none; color: white; font-size: 24px; cursor: pointer; z-index: 1000; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">
        <i class="fa fa-plus"></i>
    </button>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('inventario.index', ['status' => 'forSale']) }}" style="color: {{ request('status') == 'forSale' || !request('status') ? '#fff' : '#999' }}; text-decoration: none; margin-right: 20px; padding-bottom: 5px; border-bottom: {{ request('status') == 'forSale' || !request('status') ? '2px solid #fff' : 'none' }};">En venta</a>
        <a href="{{ route('inventario.index', ['status' => 'layaway']) }}" style="color: {{ request('status') == 'layaway' ? '#fff' : '#999' }}; text-decoration: none; margin-right: 20px; padding-bottom: 5px; border-bottom: {{ request('status') == 'layaway' ? '2px solid #fff' : 'none' }};">Apartados</a>
        <a href="{{ route('inventario.index', ['status' => 'loan']) }}" style="color: {{ request('status') == 'loan' ? '#2196f3' : '#999' }}; text-decoration: none; padding-bottom: 5px; border-bottom: {{ request('status') == 'loan' ? '2px solid #2196f3' : 'none' }};">Empeñados</a>
    </div>

    <form class="input-group" action="{{ route('inventario.index') }}" method="GET" style="margin-bottom: 20px; max-width: 600px;">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input type="search" class="form-control" placeholder="Buscar" name="q" value="{{ request('q') }}" style="background: #1e1e1e; color: white; border: 1px solid #444;">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit" style="background: #444; color: white; border: 1px solid #444;">
                <i class="fa fa-search"></i>
            </button>
        </span>
    </form>

    <h6 style="color: white; margin-bottom: 20px; text-transform: uppercase; font-size: 12px;">
        @if(request('status') == 'forSale' || !request('status'))
            TODAS LAS PRENDAS EN VENTA
        @elseif(request('status') == 'layaway')
            TODAS LAS PRENDAS APARTADAS
        @elseif(request('status') == 'loan')
            TODAS LAS PRENDAS EMPEÑADAS
        @endif
    </h6>

    @if($productos->isEmpty())
        <div style="color: white; padding: 20px; text-align: center;">
            <p>No se encontraron prendas</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
            @foreach($productos as $producto)
                <a href="{{ route('inventario.show', $producto->id) }}" style="text-decoration: none; color: inherit;">
                    <div style="background: #1e1e1e; border-radius: 8px; padding: 20px; position: relative; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="position: absolute; top: 10px; left: 10px; background: #444; color: white; padding: 5px 10px; border-radius: 4px; font-size: 14px; font-weight: bold;">
                            {{ $producto->id }}-1
                        </div>
                        <div style="position: absolute; top: 10px; right: 10px; background: #4caf50; color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px;">
                            Empeño
                        </div>
                        <div style="margin-top: 50px;">
                            <h4 style="color: white; margin: 0 0 10px 0; font-size: 18px;">{{ $producto->nombre }}</h4>
                            <p style="color: #999; margin: 0 0 5px 0; font-size: 14px;">
                                @if($producto->peso && $producto->quilates)
                                    {{ $producto->peso }} g {{ $producto->quilates }}
                                @else
                                    {{ $producto->descripcion ?? 'Sin descripción' }}
                                @endif
                            </p>
                            <p style="color: #666; margin: 0; font-size: 12px;">{{ $producto->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div style="margin-top: 30px;">
            {{ $productos->links() }}
        </div>
    @endif
</section>
@endsection