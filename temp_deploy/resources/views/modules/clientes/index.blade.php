@extends('layouts.main')

@section('content')
<header class="yp-header">
    <h1>
        <i class="fa fa-user"></i>
        <span>Clientes</span>
    </h1>
</header>

<section class="content">
    <button onclick="window.location='{{ route('clientes.create') }}'" class="action red" data-intro="Antes de registrar un préstamo, primero debemos registrar un cliente" data-position="left" data-step="1">
        <i class="fa fa-plus"></i>
    </button>

    <form class="input-group search" action="{{ route('clientes.index') }}" method="GET">
        <input type="search" class="search-query form-control" placeholder="Buscar" name="q" value="{{ request('q') }}">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </span>
    </form>

    @if(request('q'))
        <h6 class="query-label">Resultados de la búsqueda "{{ request('q') }}"</h6>
    @else
        <h6 class="query-label">Todos los clientes</h6>
    @endif

    @if($clientes->isEmpty() && !request('q'))
        <div class="first-action">
            <div class="arrow"></div>
            <div class="prompt">
                <i class="fa fa-user-plus"></i>
                <h5>Añade un nuevo cliente para registrar un préstamo</h5>
            </div>
        </div>
    @endif

    <ul class="clients search-results">
        @foreach($clientes as $cliente)
            <li>
                <div class="card">
                    <a href="{{ route('clientes.show', $cliente->id) }}">
                        <div class="picture">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="info">
                            <h4>{{ $cliente->nombre }}</h4>
                            <span class="more">
                                <i class="fa fa-phone"></i> {{ $cliente->telefono }}
                                <i class="fa fa-map-marker"></i> {{ $cliente->direccion }}
                            </span>
                        </div>
                        <div class="score">
                            @for($i = 0; $i < 5; $i++)
                                @if($i < $cliente->puntuacion)
                                    <span class="ball green"></span>
                                @else
                                    <span class="ball red"></span>
                                @endif
                            @endfor
                        </div>
                    </a>
                </div>
            </li>
        @endforeach
    </ul>

    {{ $clientes->links() }}
</section>
@endsection

@push('styles')
<style>
.clients.search-results .card {
    padding: 0;
}

.clients.search-results .card a {
    display: block;
    height: 72px;
    padding: 10px;
    color: inherit;
}

.clients.search-results .card .picture {
    float: left;
}

.clients.search-results .card .picture i {
    text-align: center;
    width: 50px;
    height: 50px;
    line-height: 50px;
    background-color: #ccc;
    border-radius: 50px;
    font-size: 25px;
    color: #fff;
}

.clients.search-results .card .info {
    padding-left: 60px;
    padding-right: 30px;
}

.clients.search-results .card .info h4 {
    padding: 3px 0 5px;
    margin: 0;
}

.clients.search-results .card .info .more {
    color: #888;
    line-height: 22px;
    width: 100%;
    display: inline-block;
}

.clients.search-results .card .info .more i {
    margin-right: 3px;
    margin-left: 10px;
}

.clients.search-results .card .info .more i:first-child {
    margin-left: 0;
}

.clients.search-results .card .score {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #888;
    font-size: 12px;
}

.score .ball {
    border-radius: 10px;
    width: 10px;
    height: 10px;
    display: inline-block;
    margin-left: 3px;
}

.score .ball.green {
    background-color: #55C13A;
}

.score .ball.red {
    background-color: #f33;
}

.first-action {
    position: relative;
    color: #aaa;
    text-align: center;
    padding-top: 160px;
}

.first-action .prompt {
    margin: 0 auto;
    max-width: 200px;
}

.first-action .prompt h5 {
    font-weight: 400;
}

.first-action i {
    font-size: 40px;
    color: #bbb;
}

.first-action .arrow {
    height: 130px;
    width: 130px;
    background-image: url(/img/arrow-up.png);
    background-size: contain;
    background-repeat: no-repeat;
    background-position: top right;
    opacity: .2;
    position: absolute;
    right: 55px;
    top: 0;
}
</style>
@endpush
