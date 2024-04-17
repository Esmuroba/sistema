<?php
use Carbon\Carbon;
?>
@extends('layouts.app')
@section('title', 'Solicitudes')
@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Comercial /</span> Solicitudes</h4>
    <div class="d-flex justify-content-between">
        
        <div class="col d-flex mb-3 gap-3 justify-content-end align-items-center">
            <span class="badge bg-label-primary rounded-2">
                <i class="bx bx-building-house bx-md"></i>
            </span>
            <div class="btn-group">
                <a href="{{ route('admin.solicitud.create') }}" class="btn btn-primary">
                    <span>
                        <i class='bx bxs-folder-open  me-0 me-sm-1' ></i>
                        <span class="d-none d-sm-inline-block">Nueva Solicitud</span>
                    </span>
                </a>
               
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <ul class="nav flex-column flex-sm-row row gy-4 gy-sm-1" id="pills-tab" role="tablist">
                    <div class="col-sm-6 col-lg-2 mt-1 px-3">
                        <form action="{{ route('admin.solicitud.index') }}">
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
                    
                    <div class="col-sm-6 col-lg-2 mt-1 px-3">
                        <form action="{{ route('admin.solicitud.index') }}">
                            @csrf
                            <input type="hidden" id="estatus" name="estatus" value="Proceso">
                            <li onclick="this.closest('form').submit();" role="presentation">
                                <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0"
                                    id="pills-completed-tab" data-bs-toggle="pill" data-bs-target="#pills-completed" type="button"
                                    role="tab" aria-controls="pills-completed" aria-selected="false">
                                    <div>
                                        <h3 class="mb-2">{{$stateProceso->count()}}</h3>
                                        <p class="mb-0">{{ 'Proceso' }}</p>
                                    </div>
                                    <div class="avatar me-lg-4">
                                        <span class="avatar-initial rounded bg-label-grey">
                                            <i class='bx bx-refresh bx-sm'></i>

                                        </span>
                                    </div>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none">
                            </li>
                        </form>
                    </div>
                    <div class="col-sm-6 col-lg-3 mt-1 px-3">
                        <form action="{{ route('admin.solicitud.index') }}">
                            @csrf
                            <input type="hidden" id="estatus" name="estatus" value="Pre-autorizado">
                            <li onclick="this.closest('form').submit();" role="presentation">
                                <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0"
                                    id="pills-completed-tab" data-bs-toggle="pill" data-bs-target="#pills-completed" type="button"
                                    role="tab" aria-controls="pills-completed" aria-selected="false">
                                    <div>
                                        <h3 class="mb-2">{{$statePre->count()}}</h3>
                                        <p class="mb-0">{{ $statePre->count() == 1 ? 'Pre-autorizado' : 'Pre-autorizados' }}</p>
                                    </div>
                                    <div class="avatar me-lg-4">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class='bx bx-list-check bx-sm'></i>
                                        </span>
                                    </div>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none">
                            </li>
                        </form>
                    </div>
                    <div class="col-sm-6 col-lg-3 mt-1 px-3">
                        <form action="{{ route('admin.solicitud.index') }}">
                            @csrf
                            <input type="hidden" id="estatus" name="estatus" value="Autorizado">
                            <li onclick="this.closest('form').submit();" role="presentation">
                                <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0"
                                    id="pills-completed-tab" data-bs-toggle="pill" data-bs-target="#pills-completed" type="button"
                                    role="tab" aria-controls="pills-completed" aria-selected="false">
                                    <div>
                                        <h3 class="mb-2">{{$stateTerminado->count()}}</h3>
                                        <p class="mb-0">{{ $stateTerminado->count() == 1 ? 'Autorizado' : 'Autorizados' }}</p>
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
                    <div class="col-sm-6 col-lg-2 mt-1 px-3">
                        <form action="{{ route('admin.solicitud.index') }}">
                        @csrf
                        <input type="hidden" id="estatus" name="estatus" value="Rechazado">
                        <li onclick="this.closest('form').submit();" role="presentation">
                            <div class="d-flex justify-content-between align-items-start {{-- border-end --}} pb-3 pb-sm-0 card-widget-3"
                                id="pills-late-tab" data-bs-toggle="pill" data-bs-target="#pills-late" type="button"
                                role="tab" aria-controls="pills-late" aria-selected="false">
                                <div>
                                    <h3 class="mb-2">{{ $stateRechazado->count() }}</h3>
                                    <p class="mb-0">{{ $stateRechazado->count() == 1 ? 'Cancelado' : 'Cancelados' }}</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-danger">
                                        <i class="bx bx-error-alt bx-sm"></i>
                                    </span>
                                </div>
                            </div>
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
                <h5 class="card-action-title mb-0">Solicitudes</h5>
            </div>
            <div class="card-body p-0">
                @if (count($solicitudes) > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID solicitud</th>
                                    <th>Cliente</th>
                                    <th>Producto</th>
                                    <th>Monto Solicitado</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Estatus</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($solicitudes as $solicitud)
                                    <tr>
                                        <td>{{ $solicitud->id }}</td>
                                        <td class="text-third fw-bold">{{ $solicitud->cliente->getFullName() }}</td>
                                        <td>{{ $solicitud->producto()->first()->nombre }}</td>
                                        <td class="text-info">${{ number_format($solicitud->monto_solicitado, 2) }}</td>
                                        <td class="text-uppercase">
                                            {{ Carbon::parse($solicitud->fecha_solicitud)->translatedFormat('d F Y') }}</td>
                                        @if ($solicitud->estatus == 'Pendiente')
                                            <td><span class="badge rounded bg-label-warning">{{$solicitud->estatus}}</span></td>
                                        @elseif($solicitud->estatus == 'Proceso')
                                            <td><span class="badge rounded bg-label-info">{{$solicitud->estatus}}</span></td>
                                        @elseif($solicitud->estatus == 'Pre-autorizado')
                                            <td><span class="badge rounded bg-label-primary">{{$solicitud->estatus}}</span></td>
                                        @elseif($solicitud->estatus == 'Autorizado')
                                            <td><span class="badge rounded bg-label-success">{{$solicitud->estatus}}</span></td>
                                        @elseif($solicitud->estatus == 'Rechazado')
                                            <td><span class="badge rounded bg-label-danger">{{$solicitud->estatus}}</span></td>
                                        @endif
                                        <td>
                                            <div class="d-inline-block text-nowrap">
                                                @if ($solicitud->estatus == 'Autorizado' || $solicitud->estatus == 'Pre-autorizado')
                                                    <a href="{{ route('admin.solicitudCredito', [$solicitud->id]) }}" target="_blank" title="KIT LEGAL" class="btn btn-sm btn-icon"><i class='bx bxs-file-pdf'></i>
                                                    </a>
                                                    <a href="{{ route('admin.pdfBlanco', [$solicitud->id]) }}" target="_blank" title="CONTRATO" class="btn btn-sm btn-icon"><i class='bx bxs-file-pdf'></i>
                                                    </a>
                                                @else
                                                    <a href="#" title="NINGUNA ACCION" class="btn btn-sm btn-icon"><i class='bx bxs-x-circle'></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-end">
                            {{ $solicitudes->appends(request()->query())->links() }}
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
@endsection
