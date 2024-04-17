<?php
use Carbon\Carbon;
?>
@extends('layouts.app')
@section('title', 'Analisis')
@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Autorización /</span> Analisis</h4>
    
    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <ul class="nav flex-column flex-sm-row row gy-4 gy-sm-1" id="pills-tab" role="tablist">
                    <div class="col-sm-6 col-lg-2 mt-1 px-3">
                        <form action="{{ route('admin.analisis_credito.index') }}">
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
                        <form action="{{ route('admin.analisis_credito.index') }}">
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
                        <form action="{{ route('admin.analisis_credito.index') }}">
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
                        <form action="{{ route('admin.analisis_credito.index') }}">
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
                        <form action="{{ route('admin.analisis_credito.index') }}">
                        @csrf
                        <input type="hidden" id="estatus" name="estatus" value="Rechazado">
                        <li onclick="this.closest('form').submit();" role="presentation">
                            <div class="d-flex justify-content-between align-items-start {{-- border-end --}} pb-3 pb-sm-0 card-widget-3"
                                id="pills-late-tab" data-bs-toggle="pill" data-bs-target="#pills-late" type="button"
                                role="tab" aria-controls="pills-late" aria-selected="false">
                                <div>
                                    <h3 class="mb-2">{{ $stateRechazado->count() }}</h3>
                                    <p class="mb-0">{{ $stateRechazado->count() == 1 ? 'Rechazado' : 'Rechazados' }}</p>
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
                <h5 class="card-action-title mb-0">Analisis</h5>
            </div>
            <div class="card-body p-0">
                @if (count($solicitudes) > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
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
                                        <td class="text-info">${{ number_format($solicitud->monto_solicitado, 2) }}</td>
                                        <td class="text-uppercase">
                                            {{ Carbon::parse($solicitud->fecha_solicitud)->translatedFormat('d F Y') }}</td>
                                        @if ($solicitud->estatus == 'Pendiente')
                                            <td><span class="badge rounded bg-label-warning">{{$solicitud->estatus}}</span></td>
                                            <td class="project-actions text-right">
                                                <a data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="right" data-bs-original-title="Click para tomarlo"
                                                    href="{{ route('admin.analisis_credito.edit', [$solicitud->id]) }}"
                                                    class="btn btn-sm btn-icon payment-details">
                                                    <i class='bx bx-message-alt-add bx-sm'></i>
                                                </a>
                                            </td>
                                        @elseif($solicitud->estatus == 'Proceso')
                                            <td><span class="badge rounded bg-label-secondary">{{$solicitud->estatus}}</span></td>
                                            @if ($solicitud->users_id_analisis == auth()->user()->id)
                                                <td class="project-actions text-right">
                                                    <a data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="right" data-bs-original-title="Click para tomarlo"
                                                        href="{{ route('admin.analisis_credito.edit', [$solicitud->id]) }}"
                                                        class="btn btn-sm btn-icon payment-details">
                                                        <i class='bx bx-message-alt-add bx-sm'></i>
                                                    </a>
                                                </td>
                                            @else
                                                <td class="project-actions text-right">
                                                    <a data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="right"
                                                        class="btn btn-sm btn-icon payment-details">
                                                        <i class='bx bx-notification-off bx-sm'></i>
                                                    </a>
                                                </td>
                                            @endif
                                        @elseif($solicitud->estatus == 'Pre-autorizado')
                                            <td><span class="badge rounded bg-label-primary">{{$solicitud->estatus}}</span></td>
                                            @if (auth()->user()->roles_id == "1" || $solicitud->users_id_analisis == auth()->user()->id || auth()->user()->id == "5")
                                                <td class="project-actions text-right">
                                                    <a type="button" class="btn btn-sm btn-icon text-success"
                                                        data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="right"
                                                        data-bs-original-title="Autorizar"
                                                        onclick="openModal('{{ $solicitud->id }}','{{ $solicitud->cliente->getFullName() }}','{{ $solicitud->analisis->monto_autorizado }}','{{ $solicitud->cliente->banco }}','{{ $solicitud->cliente->numero_tarjeta }}','{{ $solicitud->cliente->clave_interbancaria }}','{{ $solicitud->cliente->numero_cuenta }}')">
                                                        <i class="bx bx-check-circle bx-sm"></i>
                                                    </a>
                                                </td>
                                            @else
                                                <td class="project-actions text-right">
                                                    <button class="btn btn-info btn-sm"><i class="fas fa-ban"></i></button>
                                                </td>
                                            @endif
                                        @elseif($solicitud->estatus == 'Autorizado')
                                            <td><span class="badge rounded bg-label-success">{{$solicitud->estatus}}</span></td>
                                            <td class="project-actions text-right">
                                                <a data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="right" data-bs-original-title="Ver Detalles"
                                                    href=""
                                                    class="btn btn-sm btn-icon payment-details">
                                                    <i class='bx bx-detail bx-sm'></i>
                                                </a>
                                            </td>
                                        @elseif($solicitud->estatus == 'Rechazado')
                                            <td><span class="badge rounded bg-label-danger">{{$solicitud->estatus}}</span></td>
                                            <td class="project-actions text-right">
                                                <a data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="right"
                                                    class="btn btn-sm btn-icon payment-details">
                                                    <i class='bx bx-notification-off bx-sm'></i>
                                                </a>
                                            </td>
                                        @endif
                                       
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
    <div class="modal fade" id="ModalAutorizacion" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="modal-cliente"></h3>
                        <p>Verifica los datos antes de Autorizar.</p>
                    </div>
                    <form action="{{ route('admin.autorizacion') }}" method="POST" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                    @csrf
                        <input type="hidden" id="idSolicitud" name="idSolicitud" value="">
                        <div class="col-12 col-md-6 fv-plugins-icon-container">
                            <label class="form-label" for="banco">Banco</label>
                            <input type="text" id="banco" name="banco" class="form-control"
                                placeholder="Banco" value="" readonly>
                        </div>
                        <div class="col-12 col-md-6 fv-plugins-icon-container">
                            <label class="form-label" for="num_tarjeta">Número de Tarjeta</label>
                            <input type="text" id="num_tarjeta" name="num_tarjeta" class="form-control" placeholder="Número de Tarjeta" readonly>
                        </div>
                        <div class="col-12 col-md-6 fv-plugins-icon-container">
                            <label class="form-label" for="num_cuenta">Número de Cuenta</label>
                            <input type="text" id="num_cuenta" name="num_cuenta" class="form-control"
                                placeholder="Número de Cuenta" value="" readonly>
                        </div>
                        <div class="col-12 col-md-6 fv-plugins-icon-container">
                            <label class="form-label" for="clabe_interbancaria">Cuenta Clabe</label>
                            <input type="text" id="clabe_interbancaria" name="clabe_interbancaria" class="form-control"
                                placeholder="Cuenta Clabe" value="" readonly>
                        </div>
                        <div class="col-12 col-md-12 fv-plugins-icon-container">
                            <label class="form-label" for="observaciones">Observaciones</label>
                            <textarea class="form-control text-uppercase" id="observaciones" name="observaciones" rows="1"
                                placeholder="..."></textarea>
                        </div>
                        <div class="text-center">
                            <p class="text-muted">Monto Pre-autorizado</small>
                            <div class="d-flex justify-content-center">
                                <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">$</sup>
                                <h1 class="monto_autorizado mb-0 text-primary">0</h1>
                                <sub class="h6 pricing-duration mt-auto mb-2 text-muted fw-normal"></sub>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" name="Autorizado" class="btn btn-primary me-sm-3 me-1">Autorizar</button>
                            <button type="submit" name="Rechazado" class="btn btn-danger me-sm-3 me-1">Rechazar</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
function openModal(idSolicitud, name, monto_autorizado, banco, num_tarjeta, clabe_interbancaria, num_cuenta) {
    var modal = $('#ModalAutorizacion');
    modal.modal('show');
    modal.find('.modal-cliente').text(name);
    modal.find('.monto_autorizado').text(monto_autorizado);
    $("#idSolicitud").val(idSolicitud);
    $("#banco").val(banco);
    $("#num_tarjeta").val(num_tarjeta);
    $("#clabe_interbancaria").val(clabe_interbancaria);
    $("#num_cuenta").val(num_cuenta);
    
}
</script>
@endsection
