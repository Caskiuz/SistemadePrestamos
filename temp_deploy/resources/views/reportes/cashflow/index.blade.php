@extends('layouts.main')

@section('content')
<div class="cashflow-page">
    @include('reportes.cashflow.header')
    @include('reportes.cashflow.toolbar')
    @include('reportes.cashflow.table')
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/cashflow.js') }}"></script>
@endpush
