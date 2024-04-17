<?php
use Carbon\Carbon;

$today = now()->format('Y-m-d');
?>

@extends('layouts.app')

@section('title', 'Detalles del Pago')

@section('content')
    @if ($errors->any())
        <div class="col-12 col-sm-6 col-xxl-5 mx-auto">
            <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                <span class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2">
                    <i class='bx bx-x-circle bx-md'></i>
                </span>
                <div class="d-flex flex-column ps-1 text-center w-100">
                    <h5 class="alert-heading d-flex align-items-center justify-content-center fw-bold mb-1">ERROR!🚩</h5>
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pagos / </span> Detalles</h4>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h5 class="mb-1 mt-3 text-body">ID Solicitud: <span class="fw-bold text-third">{{$creditos->solicituds_id}}</span>
                <span
                    class="badge 
                    @if ($creditos->estatus_credito == 'Pagado') bg-label-success
                    @elseif($creditos->estatus_credito == 'Vigente') bg-label-primary
                    @elseif($creditos->estatus_credito == 'Vencido') bg-label-danger 
                    @endif me-2 ms-2">
                    {{ $creditos->estatus_credito }}
                </span>
            </h5>
            <p class="text-body fw-semibold">Periodo del Credito:
                <span class="text-third">
                    {{ Carbon::parse($creditos->solicitud->fecha_primer_pago)->translatedFormat('d \d\e F') .
                        ' al ' .
                        Carbon::parse($creditos->solicitud->fecha_vencimiento)->translatedFormat('d \d\e F Y') }}
                </span>
            </p>
        </div>
        @if ($creditos->estatus_credito != 'Pagado')
           
            <div class="d-flex align-content-center flex-wrap gap-2">
                <button class="btn btn-primary delete-order" onclick="applyPago({{ $creditos->solicitud->id }},{{ $creditos->pago_semanal }})">
                    Aplicar Pago
                </button>
            </div>
            
        @else
            <h5 class="mb-1 mt-3">
                <span class="badge bg-label-primary me-2 ms-2">
                    Liquidado:
                    {{ $transacciones->latest('fecha_aplicacion')->first()->fecha_aplicacion->translatedFormat('d F Y') }} 
                </span>
            </h5>
        @endif
    </div>
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title m-0">Detalles del Cliente</h6>
                </div>
                @php
                    $cobrado = DB::table('tabla_amortizacion')->where('analisis_credito_id',$creditos->id)->where('estatus','Cobrado')->count();
                    $todosPago = DB::table('tabla_amortizacion')->where('analisis_credito_id',$creditos->id)->count();
                @endphp
                <div class="card-body">
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <div class="d-flex flex-column">
                            <a href="javascript:void()" class="text-body text-nowrap">
                                <h6 class="mb-0">{{ $creditos->solicitud->cliente->getFullName() }}</h6>
                            </a>
                            <small class="text-muted">Fecha Desembolso : {{ $creditos->detalleDesembolso ? date('d/m/Y', strtotime($creditos->detalleDesembolso->fecha_pago)) : '---' }}</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center mb-3">
                        <span
                            class="avatar rounded-circle bg-label-secondary me-2 d-flex align-items-center justify-content-center"><i
                                class="bx bx-file bx-sm lh-sm"></i></span>
                        <h6 class="text-body text-nowrap mb-0"><b class="text-success">{{ $cobrado }}</b> / {{$todosPago}} <b>Pagos</b></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6>Información del Crédito</h6>
                    </div>
                    <p class="mb-1 text-truncate">Monto del Prestamo:<b class="text-primary"> $ {{number_format($creditos->monto_autorizado, 2, '.', ',')}}</b></p>
                    <p class="mb-0">Monto a Pagar:<b class="text-success"> $ {{number_format($creditos->total, 2, '.', ',')}}</b></p>
                    <p class="mb-0">Pago:<b class="text-danger"> $ {{number_format($creditos->pago_semanal, 2, '.', ',')}}</b></p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title m-0">Pagos/Abonos</h5>
                </div>
                <div class="card-datatable table-responsive">
                    <div class="table-responsive text-nowrap mx-3">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Tipo</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach($transacciones as $detalle)
                                @php
                                    $fecha = Carbon::createFromFormat('Y-m-d', $detalle->fecha_aplicacion);
                                @endphp
                                    <tr>
                                        <td>{{$detalle->amortizacion->num_pago}}</td>
                                        <td class="fw-bold text-third">
                                            {{ $fechaFormateada = $fecha->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="text-primary">$ {{number_format($detalle->monto, 2, '.', ',')}}</td>
                                        <td  class="text-uppercase">{{ $detalle->tipo}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-end mt-2 me-3">{{ $transacciones->links()}}     
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center m-3 mb-2 p-1">
                        <div class="order-calculations">
                            <div class="d-flex justify-content-between">
                                <h6 class="w-px-200 mb-0 text-primary fw-bold">Total Abonado:</h6>
                                <h6 class="mb-0 text-primary fw-bold"> $ {{ ($abonado) ? number_format($abonado, 2, '.', ',') : '-- --'}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>

    @include('transacciones.applyPago')

    <script>
        function applyPago(id,monto) {
            $('#idSolicitud').val(id);
            $('#idSolicitudView').html(id);
            $('#pago_semanal').html(monto);
            $('#applyModal').modal('show');
        }
    </script>

    @if ($message = Session::get('error'))
        <script>
            Swal.fire({
                title: 'Lo sentimos😞',
                icon: 'error',
                text: '{{ $message }}',
                color: '#22697A',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3CB4D3'
            })
        </script>
    @endif

    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                title: '¡Hecho!👍🏻',
                icon: 'success',
                text: '{{ $message }}',
                color: '#22697A',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3CB4D3'
            })
        </script>
    @endif

@endsection
