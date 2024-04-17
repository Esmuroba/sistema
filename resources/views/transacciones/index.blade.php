<?php
use Carbon\Carbon;
?>
@extends('layouts.app')
@section('title', 'Transacciones')
@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Tesorería /</span> Transacciones</h4>
    
   

    <div class="tab-content p-0" id="pills-tabContent">
        <div class="tab-pane fade show active card mb-4" id="pills-late" role="tabpanel" aria-labelledby="pills-late"
            tabindex="0">
            <div class="card-header align-items-center">
                <h5 class="card-action-title mb-0">Solicitudes</h5>
            </div>
            <div class="card-body p-0">
                @if (count($creditos) > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID Solicitud</th>
                                    <th>Cliente</th>
                                    <th>Producto</th>
                                    <th>Monto Autorizado</th>
                                    <th>Fecha Autorización</th>
                                    <th>Saldo Actual</th>
                                    <th>Pagos</th>
                                    <th>Credito</th>
                                    <th>Estatus</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($creditos as $credito)
                                    @php
                                        $cobrado = DB::table('tabla_amortizacion')->where('analisis_credito_id',$credito->id)->where('estatus','Cobrado')->count();
                                        $todosPago = DB::table('tabla_amortizacion')->where('analisis_credito_id',$credito->id)->count();
                                    
                                        $saldo1 = DB::table('tabla_amortizacion')
                                        ->where('analisis_credito_id',$credito->id)
                                        ->where('saldo_actual', '>', 0)
                                        ->orderBy('id', 'desc')
                                        ->latest('updated_at')->first();
                                    
                                        $numPagos = DB::table('tabla_amortizacion')->where('analisis_credito_id', $credito->id)->where('estatus','No cobrado')->count();
                                        if($cobrado == 0){
                                            if($saldo1 != null){
                                                $saldo_actual = $saldo1->saldo_amortizaciones;
                                            }else{
                                                $saldo_actual = $credito->total;
                                            }
                                        }else{
                                            if($saldo1 != null){
                                                $saldo_actual = $saldo1->saldo_amortizaciones;
                                            }else{
                                                $saldo_actual = 0;
                                            }
                                        }
                                        
                                    @endphp
                                    <tr>
                                        <td># {{ $credito->solicituds_id }}</td>
                                        <td class="text-third fw-bold">{{ $credito->solicitud->cliente->getFullName() }}</td>
                                        <td>{{ $credito->solicitud->producto()->first()->nombre }}</td>
                                        <td>{{ number_format($credito->monto_autorizado,2,'.',',') }}</td>
                                        <td>{{($credito->detalleDesembolso) ? Carbon::parse($credito->fecha_solicitud)->translatedFormat('d F Y') : '-- --'}}</td>
                                        @if ($credito->estatus_credito == 'Pagado')
                                            <td>{{ number_format(0,2,'.',',') }}</td>
                                        @else
                                            <td>{{ number_format($saldo_actual,2,'.',',') }}</td>
                                        @endif
                                        <td>{{ $cobrado }} / {{$todosPago}}</td>
                                       
                                        @if ($credito->estatus_credito == 'Vigente')
                                            <td><span class="badge rounded bg-label-info">{{$credito->estatus_credito}}</span></td>
                                        @elseif($credito->estatus_credito == 'Pagado')
                                            <td><span class="badge rounded bg-label-success">{{$credito->estatus_credito}}</span></td>
                                        @elseif($credito->estatus_credito == 'Vencido')
                                            <td><span class="badge rounded bg-label-danger">{{$credito->estatus_credito}}</span></td>
                                        @endif

                                        @if ($credito->desembolso == 'Pendiente')
                                            <td><span class="badge rounded bg-label-warning">{{$credito->desembolso}}</span></td>
                                        @elseif($credito->desembolso == 'Desembolsado')
                                            <td><span class="badge rounded bg-label-success">{{$credito->desembolso}}</span></td>
                                        @endif

                                        @if ($credito->estatus_credito == 'Pagado')
                                            <td><a class="btn btn-info btn-sm" href="{{ route('admin.transacciones.show', [$credito->solicituds_id]) }}" title="Ver detalles"><i class="fas fa-eye"></i></a></td>
                                        @else
                                            <td>
                                                <div class="btn-group">
                                                    <a data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="right" data-bs-original-title="Ver Detalles"
                                                        href="{{ route('admin.transacciones.show', [$credito->solicituds_id]) }}"
                                                        class="btn btn-sm btn-icon">
                                                        <i class='bx bx-detail bx-sm'></i>
                                                    </a>
                                                    <a data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="right" data-bs-original-title="Aplicar Pago"
                                                        href="#" onclick="applyPago({{ $credito->solicitud->id }},{{ $credito->pago_semanal }})"
                                                        class="btn btn-sm btn-icon">
                                                        <i class='bx bx-money bx-sm'></i>
                                                    </a>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-end">
                            {{ $creditos->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-center container-xxl container-p-y">
                        <div class="misc-wrapper text-center">
                            <h2 class="mb-2 mx-2">No hay nada para mostrar :(</h2>
                            <p class="mb-4 mx-2">Lo sentimos! 😞.</p>
                            <div class="mt-3">
                                <img src="{{ asset('img/no-data.svg') }}" alt="page-misc-error-light" width="400"
                                    class="img-fluid" data-app-dark-img="illustrations/page-misc-error-dark.png"
                                    data-app-light-img="illustrations/page-misc-error-light.png" />
                            </div>
                        </div>
                    </div>
                @endif
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

