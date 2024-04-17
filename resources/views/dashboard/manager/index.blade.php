<?php

    $thereReq = $allRequests > 0;
    $percentInProgress = $thereReq ? ($inProgressRequests * 100) / $allRequests : 0;
    $percentapproved = $thereReq ? ($approvedRequests * 100) / $allRequests : 0;
    $percentDeny = $thereReq ? ($denyRequests * 100) / $allRequests : 0;
    $percentAwaiting = $thereReq ? ($awaitingRequests * 100) / $allRequests : 0;

?>

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @can('home')
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/</span> Dashboard</h4>
        <div class="card bg-transparent shadow-none border-0 my-4">
            <div class="card-body row p-0 pb-3">
                <div class="col-12 col-md-8 card-separator">
                    <h3>¡Bienvenid@, {{ $user->collaborator->first_name }}! 👋🏻 </h3>
                    <div class="col-12 col-lg-7">
                        <p>Te presentamos los datos más relevantes de la actividad dentro de tu empresa.</p>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
                        <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
                            <span class=" bg-label-third p-2 rounded">
                                <i class="fa-solid fa-user-tie bx-sm"></i>
                            </span>
                            <div class="content-right">
                                <p class="mb-0">Colaboradores Registrados</p>
                                <h4 class="text-third mb-0">{{ $collaborators }}</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="bg-label-primary p-2 rounded">
                                <i class='bx bx-user bx-sm'></i>
                            </span>
                            <div class="content-right">
                                <p class="mb-0">Usuarios Registrados</p>
                                <h4 class="text-primary mb-0">{{ $percentUsers }}%</h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="bg-label-secondary p-2 rounded">
                                <i class="bx bx-check-circle bx-sm"></i>
                            </span>
                            <div class="content-right">
                                <p class="mb-0">Adelantos Solicitados</p>
                                <h4 class="text-secondary mb-0">{{ count($lastRequests) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 ps-md-3 ps-lg-5 pt-3 pt-md-0">
                    <div class="d-flex justify-content-between align-items-center" style="position: relative;">
                        <div>
                            <div>
                                <h5 class="mb-2 fw-bold">
                                    <i class='bx bx-building-house'></i>
                                    {{ $user->collaborator->enterprise->name }}
                                </h5>
                                <p class="mb-4">EMPRESA</p>
                            </div>
                            {{-- <div class="time-spending-chart">
                                <h3 class="mb-2">231<span class="text-muted">h</span> 14<span class="text-muted">m</span>
                                </h3>
                                <span class="badge bg-label-success">+18.4%</span>
                            </div> --}}
                        </div>
                        <div id="leadsReportChart" style="min-height: 140.756px;">
                            <img src="{{ $user->collaborator->enterprise->logo ? $user->collaborator->enterprise->logo : asset('img/icon-enterprise.jpg') }}"
                                alt="" width="130" class="rounded-circle">
                        </div>
                        <div class="resize-triggers">
                            <div class="expand-trigger">
                                <div style="width: 315px; height: 142px;"></div>
                            </div>
                            <div class="contract-trigger"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-6 mb-4 order-1 order-xxl-0">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title mb-0">
                            <h5 class="m-0">Reporte de Solicitudes</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-none d-lg-flex vehicles-progress-labels mb-3">
                            <div class="d-block text-truncate vehicles-progress-label on-the-way-text" style="width: {{ $percentInProgress }}%;">En Proceso</div>
                            <div class="d-block text-truncate vehicles-progress-label unloading-text" style="width: {{ $percentapproved }}%;">Aceptadas</div>
                            <div class="d-block text-truncate vehicles-progress-label loading-text" style="width: {{ $percentDeny }}%;">Rechazadas</div>
                            <div class="d-block text-truncate vehicles-progress-label waiting-text" style="width: {{ $percentAwaiting }}%;">Pendientes</div>
                        </div>
                        <div class="vehicles-overview-progress progress rounded-2 mb-3" style="height: 46px;">
                            <div class="progress-bar fs-big fw-medium text-start bg-primary px-1 px-lg-3 rounded-start shadow-none"
                                role="progressbar" style="width: {{ $percentInProgress }}%" aria-valuemin="0"
                                aria-valuemax="100" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                data-bs-original-title="En Proceso">{{ $percentInProgress }}%</div>
                            <div class="progress-bar fs-big fw-medium text-start bg-secondary text-body px-1 px-lg-3 shadow-none"
                                role="progressbar" style="width: {{ $percentapproved }}%" aria-valuemin="0" aria-valuemax="100"
                                data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                data-bs-original-title="Aprobadas">{{ $percentapproved }}%</div>
                            <div class="progress-bar fs-big fw-medium text-start bg-danger px-1 px-lg-3 shadow-none"
                                role="progressbar" style="width: {{ $percentDeny }}%" aria-valuemin="0" aria-valuemax="100"
                                data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                data-bs-original-title="Rechazadas">{{ $percentDeny }}%</div>
                            <div class="progress-bar fs-big fw-medium text-start bg-third px-1 px-lg-3 rounded-end shadow-none"
                                role="progressbar" style="width: {{ $percentAwaiting }}%" aria-valuemin="0" aria-valuemax="100"
                                data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                data-bs-original-title="Pendientes">{{ $percentAwaiting }}%</div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table">
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td class="w-50 ps-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="me-2">
                                                    <i class="fa-solid fa-spinner"></i>
                                                </div>
                                                <h6 class="mb-0 fw-normal">En Proceso</h6>
                                            </div>
                                        </td>
                                        <td class="text-end pe-0 text-nowrap">
                                            <h6 class="mb-0">{{ $inProgressRequests }} solicitudes</h6>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="fw-medium">{{ $percentInProgress }}%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 ps-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="me-2">
                                                    <i class='bx bx-check-circle'></i>
                                                </div>
                                                <h6 class="mb-0 fw-normal">Aceptadas</h6>
                                            </div>
                                        </td>
                                        <td class="text-end pe-0 text-nowrap">
                                            <h6 class="mb-0">{{ $approvedRequests }} solicitudes</h6>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="fw-medium">{{ $percentapproved }}%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 ps-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="me-2">
                                                    <i class='bx bx-x-circle'></i>
                                                </div>
                                                <h6 class="mb-0 fw-normal">Rechazadas</h6>
                                            </div>
                                        </td>
                                        <td class="text-end pe-0 text-nowrap">
                                            <h6 class="mb-0">{{ $denyRequests }} solicitudes</h6>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="fw-medium">{{ $percentDeny }}%</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 ps-0">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <div class="me-2">
                                                    <i class='bx bx-help-circle'></i>
                                                </div>
                                                <h6 class="mb-0 fw-normal">Pendientes</h6>
                                            </div>
                                        </td>
                                        <td class="text-end pe-0 text-nowrap">
                                            <h6 class="mb-0">{{ $awaitingRequests }} solicitudes</h6>
                                        </td>
                                        <td class="text-end pe-0">
                                            <span class="fw-medium">{{ $percentAwaiting }}%</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-xxl-6 mb-4 order-2 order-xxl-1">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Últimas Solicitudes</h5>
                            <small class="text-muted">Total de solicitudes: {{ $allRequests }}</small>
                        </div>
                        <div class="{{-- dropdown --}}">
                            <a href="{{ route('requests') }}" {{-- type="button" --}} class="btn btn-{{-- label- --}}primary {{-- dropdown-toggle --}}" {{-- data-bs-toggle="dropdown" --}}
                                aria-expanded="false">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                Todas las solicitudes
                            </a>
                            {{-- <ul class="dropdown-menu" style="">
                                <li><a class="dropdown-item" href="javascript:void(0);">January</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">February</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">March</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">April</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">May</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">June</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">July</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">August</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">September</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">October</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">November</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">December</a></li>
                            </ul> --}}
                        </div>
                    </div>
                    <div class="card-body" style="position: relative;">
                        @if (count($lastRequests) > 0)
                            <div class="table-responsive text-nowrap">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Colaborador</th>
                                            <th>Monto</th>
                                            <th>Fecha</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lastRequests as $request)
                                            <tr>
                                                <td class="text-third fw-bold">{{ $request->collaborator->getFullName() }}
                                                </td>
                                                <td class="text-secondary">
                                                    ${{ number_format($request->details->request_amount, 2) }}</td>
                                                <td class="text-uppercase">
                                                    {{ $request->created_at->translatedFormat('d M Y | h:i a') }}</td>
                                                <td>
                                                    @if ($request->status == 'PENDIENTE')
                                                        <span class="badge bg-label-third me-1">{{ $request->status }}</span>
                                                    @elseif ($request->status == 'EN PROCESO')
                                                        <span
                                                            class="badge bg-label-secondary me-1">{{ $request->status }}</span>
                                                    @elseif ($request->status == 'CONCLUIDA')
                                                        <span
                                                            class="badge bg-label-primary me-1">{{ $request->status }}</span>
                                                    @elseif ($request->status == 'RECHAZADA')
                                                        <span class="badge bg-label-danger me-1">{{ $request->status }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="d-flex justify-content-center {{-- container-xxl  --}}container-p-y">
                                <div class="misc-wrapper text-center">
                                    <h3 class="mb-2 mx-2">No hay nada para mostrar :(</h3>
                                    <p class="mb-4 mx-2">Lo sentimos! 😞 Aún no hay solicitudes realizadas.</p>
                                    <div class="mt-3">
                                        <img src="{{ asset('img/no-data.svg') }}" alt="page-misc-error-light" width="140"
                                            class="img-fluid" />
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
