@extends('layouts.app')

@section('title', 'Pagos Masivos')

@section('content')
    @if ($message = Session::get('mensaje'))
    <div class="alert alert-success alert-dismissible d-flex" role="alert">
        <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2">
            <i class='bx bx-check-circle bx-sm'></i>
        </span>
        <div class="d-flex flex-column ps-1">
            <h5 class="alert-heading d-flex align-items-center fw-bold mb-1">¡Hecho!👍🏻</h5>
            <span>{{ Session::get('mensaje') }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Tesoreria /</span> Pagos Masivos</h4>

    <div class="d-flex justify-content-between">
     
        <form class="col-8 form-horizontal" autocomplete="off">
            <div class="form-group row text-right">
                <div class="col-lg-8">
                    <div class="mb-4 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-company2" class="input-group-text">
                                <i class='bx bx-search bx-sm'></i>
                            </span>
                            <input type="text" id="basic-icon-default-company" class="form-control text-uppercase"
                                id="name" name="name" value="{{ $name }}"
                                placeholder="Buscar Cliente" aria-label="Buscar Cliente"
                                aria-describedby="basic-icon-default-company2" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-primary mb-4">
                        <span class="d-none d-sm-inline-block">Buscar</span>
                    </button>
                </div>
            </div>
        </form>
        
        <div class="col d-flex mb-3 gap-3 justify-content-end align-items-center">
            <span class="badge bg-label-primary rounded-2">
                <i class='bx bx-file bx-md'></i>
            </span>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary">Action</button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#import-excel">
                            <i class='bx bxs-file-import'></i>
                            Importar desde Excel
                        </button>
                    </li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li>               
                    <a class="dropdown-item text-danger" method="GET"  title="Procesar Datos" href="{{ route('admin.procesarDatos') }}">
                        <i class='bx bx-loader-circle'></i> 
                        Procesar Datos</a>
                  </li>
                </ul>
              </div>
        </div>
    </div>
    @if (count($pagos) > 0)
        <div class="card">
            <h5 class="card-header">Pagos Masivos</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID solicitud</th>
                            <th>Cliente</th>
                            <th>Monto Pago</th>
                            <th>Fecha Pago</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($pagos as $pago) 
                            <tr>
                                <td>ID: {{ $pago->solicituds_id }}</td>
                                <td>{{ $pago->solicitud->cliente->getFullName() }}</td>
                                <td>{{ number_format($pago->monto_pago,2,'.',',') }}</td>
                                <td>{{ $pago->fecha_pago ? date('d/m/Y', strtotime($pago->fecha_pago)) : '---' }}</td>
                                <td><span class="badge rounded bg-label-warning">Pendiente</span></td>
                        
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination justify-content-end">
                    {{ $pagos->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center container-xxl container-p-y">
            <div class="misc-wrapper text-center">
                <h2 class="mb-2 mx-2">No hay nada para mostrar :(</h2>
                <p class="mb-4 mx-2">Realiza la importación de tu archivo excel.</p>
                <div class="mt-3">
                    <img src="{{ asset('img/no-data.svg') }}" alt="page-misc-error-light" width="400" class="img-fluid"
                        data-app-dark-img="illustrations/page-misc-error-dark.png"
                        data-app-light-img="illustrations/page-misc-error-light.png" />
                </div>
            </div>
        </div>
    @endif
@endsection
@include('pagos_masivos.importFromExcel')
