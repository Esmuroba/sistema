<?php
use Carbon\Carbon;
?>
@extends('layouts.app')
@section('title', 'Desembolsos')
@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Tesoreria /</span> Desembolsos</h4>
    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <ul class="nav flex-column flex-sm-row row gy-4 gy-sm-1" id="pills-tab" role="tablist">
                    <div class="col-sm-6 col-lg-6 mt-1 px-3">
                        <form action="{{ route('admin.desembolso.index') }}">
                            @csrf
                            <input type="hidden" id="estatus" name="estatus" value="Pendiente">
                            <li onclick="this.closest('form').submit();" role="presentation">
                                <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0"
                                    id="pills-pending-tab" data-bs-toggle="pill" data-bs-target="#pills-pending" type="button"
                                    role="tab" aria-controls="pills-pending" aria-selected="true">
                                    <div>
                                        <h3 class="mb-2">{{$statePendiente->count()}}</h3>
                                        <p class="mb-0">{{ $statePendiente->count() == 1 ? 'Pendiente' : 'Pendientes' }}</p>
                                    </div>
                                    <div class="avatar me-sm-4">
                                        <span class="avatar-initial rounded bg-label-warning">
                                            <i class='bx bxs-hourglass bx-sm'></i>
                                        </span>
                                    </div>
                                </div>
                            </li>
                        </form>
                    </div>
                    
                    <div class="col-sm-6 col-lg-6 mt-1 px-3">
                        <form action="{{ route('admin.desembolso.index') }}">
                            @csrf
                            <input type="hidden" id="estatus" name="estatus" value="Desembolsado">
                            <li onclick="this.closest('form').submit();" role="presentation">
                                <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0"
                                    id="pills-completed-tab" data-bs-toggle="pill" data-bs-target="#pills-completed" type="button"
                                    role="tab" aria-controls="pills-completed" aria-selected="false">
                                    <div>
                                        <h3 class="mb-2">{{$stateDsembolsado->count()}}</h3>
                                        <p class="mb-0">{{ $stateDsembolsado->count() == 1 ? 'Desembolsado' : 'Desembolsados' }}</p>
                                    </div>
                                    <div class="avatar me-lg-4">
                                        <span class="avatar-initial rounded bg-label-success">
                                            <i class='bx bx-check-circle bx-sm'></i>
                                        </span>
                                    </div>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none">
                            </li>
                        </form>
                    </div>                   
                </ul>
            </div>
        </div>
    </div>
   
    <div class="tab-content p-0" id="pills-tabContent">
        <div class="tab-pane fade show active card mb-4" id="pills-late" role="tabpanel" aria-labelledby="pills-late"
            tabindex="0">
            <div class="card-header align-items-center">
                <h5 class="card-action-title mb-0">Desembolsos</h5>
               
                <div class="d-flex justify-content-between">  
                    <div class="col d-flex mb-1 justify-content-end align-items-center">
                        <button class="btn btn-label-secondary" type="button" data-bs-toggle="modal"
                        data-bs-target="#modalContabilidad">
                        <i class="bx bx-export me-1"></i>
                        Reporte
                    </button>
                    </div>
                </div>

            </div>
            <div class="card-body p-0">
                @if (count($creditos) > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Producto</th>
                                    <th>Monto Aut.</th>
                                    <th>Fecha Aut.</th>
                                    <th>Estatus</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($creditos as $credito)
                                    <tr>
                                        <td># {{ $credito->solicituds_id }}</td>
                                        <td>{{ $credito->solicitud->cliente->getFullName() }}</td>
                                        <td>{{ $credito->solicitud->producto()->first()->nombre }}</td>
                                        <td>{{ number_format($credito->monto_autorizado,2,'.',',') }}</td>
                                        <td class="text-uppercase">{{ date('d/m/Y', strtotime($credito->created_at))}}</td>
                                        @if ($credito->desembolso == 'Pendiente')
                                            <td><span class="badge rounded bg-label-warning">{{$credito->desembolso}}</span></td>
                                            <td>
                                                <a data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="right" data-bs-original-title="Desembolso"
                                                    href="{{ route('admin.desembolso.edit', [$credito->id]) }}"
                                                    class="btn btn-sm btn-icon">
                                                    <i class='bx bx-money bx-sm'></i>
                                                </a>
                                            </td>
                                        @elseif($credito->desembolso == 'Desembolsado')
                                            <td><span class="badge rounded bg-label-success">{{$credito->desembolso}}</span></td>
                                            <td><a href="{{ route('admin.solicitudCredito', [$credito->solicituds_id]) }}" target="_blank" title="KIT LEGAL" class="btn btn-sm btn-icon"><i class='bx bxs-file-pdf'></i>
                                            </a></td>
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
                            <p class="mb-4 mx-2">Lo sentimos! 😞 Aún no hay solicitudes pendientes.</p>
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

    <div class="modal fade" id="modalContabilidad" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center mb-4">
                        <h3>Exportar reporte colocación</h3>
                        <p>Debes seleccionar un rango de fechas</p>
                    </div>
                    <div class="col-lg-10 mx-auto m-0">
                        <form action="{{ route('admin.colocacionClientes') }}" method="POST" class="m-0">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="basic-icon-default-phone">Fecha Inicial</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class='bx bx-calendar-event'></i>
                                        </span>
                                        <input type="date" id="fecha_inicial" name="fecha_inicial" class="form-control" value="{{ date('Y-m-d') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="basic-icon-default-phone">Fecha Final</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class='bx bx-calendar-event'></i>
                                        </span>
                                        <input type="date" id="fecha_final" name="fecha_final" class="form-control" value="{{ date('Y-m-d') }}" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="modal-footer text-center pt-3 pb-0 px-0">
                                <div class="col-12 ">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1 mt-0">
                                        Exportar
                                        <i class="bx bx-check-circle me-sm-n2"></i>
                                    </button>
                                    <button type="reset" class="btn btn-label-secondary btn-reset mt-0"
                                        data-bs-dismiss="modal" aria-label="Close">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


