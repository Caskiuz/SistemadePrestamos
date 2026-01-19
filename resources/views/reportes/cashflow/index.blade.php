@extends('layouts.main')

@section('content')
<x-mobile-header title="Flujo de Caja" backUrl="{{ route('reportes.index') }}" />

<div class="mobile-content">
    @include('reportes.cashflow.toolbar')
    @include('reportes.cashflow.table')
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/cashflow.js') }}"></script>
@endpush
