@extends('layouts.app')

@section('title', 'Puestos')

@section('section-name', 'Usuarios')

@section('content')

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Mi Empresa /</span> Puestos</h4>

    <div class="d-flex justify-content-between">
        @if (count($jobs) > 0)
            <form class="col-8 form-horizontal" autocomplete="off">
                <div class="form-group row text-right">
                    <div class="col-lg-8">
                        <div class="mb-4 fv-plugins-icon-container">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-company2" class="input-group-text">
                                    <i class='bx bx-search bx-sm'></i>
                                </span>
                                <input type="text" id="basic-icon-default-company" class="form-control text-uppercase"
                                    id="name_job" name="name_job" value="{{ $name_job }}"
                                    placeholder="Buscar Puesto" aria-label="Buscar Puesto"
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
        @endif
        <div class="col d-flex mb-3 gap-3 justify-content-end align-items-center">
            <span class="badge bg-label-primary rounded-2">
                <i class="bx bx-building bx-md"></i>
            </span>
            <a href="{{ route('my-company.jobs.register') }}" class="btn btn-primary">
                <span>
                    <i class="bx bx-plus me-0 me-sm-1"></i>
                    <span class="d-none d-sm-inline-block">Agregar Puesto</span>
                </span>
            </a>
        </div>
    </div>
    @if (count($jobs) > 0)
        <div class="card">
            <h5 class="card-header">Puestos</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Area</th>
                            <th>Nombre Puesto</th>
                            <th>Estatus</th>
                            <th>Aciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($jobs as $data)
                            <tr>
                                <td>{{ $data->area->name }}</td>
                                <td>{{ $data->name }}</td>
                                @if ($data->status == 'ACTIVO')
                                    <td><span class="badge bg-label-primary me-1">{{ $data->status }}</span></td>
                                @else
                                    <td><span class="badge bg-label-danger me-1">{{ $data->status }}</span></td>
                                @endif
                                <td>
                                    <div class="d-flex justify-content-between">
        
                                        <a class="text-muted me-1"
                                            href="{{ route('my-company.jobs.edit', [$data->id]) }}"
                                            data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            aria-label="Editar" data-bs-original-title="Editar">
                                            <i class="bx bx-edit bx-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination justify-content-end">
                    {{ $jobs->appends(request()->query())->links()}}
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center container-xxl container-p-y">
            <div class="misc-wrapper text-center">
                <h2 class="mb-2 mx-2">No hay nada para mostrar :(</h2>
                <p class="mb-4 mx-2">Lo sentimos! 😞 Revisa tu búsqueda o agrega un nuevo puesto.</p>
                <div class="mt-3">
                    <img src="{{ asset('img/no-data.svg') }}" alt="page-misc-error-light" width="400" class="img-fluid"
                        data-app-dark-img="illustrations/page-misc-error-dark.png"
                        data-app-light-img="illustrations/page-misc-error-light.png" />
                </div>
            </div>
        </div>
    @endif
@endsection
