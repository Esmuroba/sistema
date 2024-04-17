@extends('layouts.app')

@section('title', 'Areas')

@section('section-name', 'Usuarios')

@section('content')

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Mi Empresa /</span> Áreas</h4>

    <div class="d-flex justify-content-between">
        @if (count($areas) > 0)
            <form class="col-8 form-horizontal" autocomplete="off">
                <div class="form-group row text-right">
                    <div class="col-lg-8">
                        <div class="mb-4 fv-plugins-icon-container">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-company2" class="input-group-text">
                                    <i class='bx bx-search bx-sm'></i>
                                </span>
                                <input type="text" id="basic-icon-default-company" class="form-control text-uppercase"
                                    id="name_area" name="name_area" value="{{ $name_area }}"
                                    placeholder="Buscar Área" aria-label="Buscar Area"
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
            <a href="{{ route('my-company.areas.register') }}" class="btn btn-primary">
                <span>
                    <i class="bx bx-plus me-0 me-sm-1"></i>
                    <span class="d-none d-sm-inline-block">Agregar Área</span>
                </span>
            </a>
        </div>
    </div>
    @if (count($areas) > 0)
        <div class="card">
            <h5 class="card-header">Areas</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            {{-- <th>Departamento</th> --}}
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Extensión</th>
                            <th>Estatus</th>
                            <th>Aciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($areas as $area)
                            <tr>
                                {{-- <td>{{ $area->departments->name }}</td> --}}
                                <td>{{ $area->name }}</td>
                                <td>{{ $area->phone }}</td>
                                <td>{{ $area->ext }}</td>
                                @if ($area->status == 'Activo')
                                    <td><span class="badge bg-label-primary me-1">{{ $area->status }}</span></td>
                                @else
                                    <td><span class="badge bg-label-danger me-1">{{ $area->status }}</span></td>
                                @endif
                                <td>
                                    <div class="d-flex justify-content-between">
        
                                        <a class="text-muted me-1"
                                            href="{{ route('my-company.areas.edit', [$area->id]) }}"
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
                    {{ $areas->appends(request()->query())->links()}}
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center container-xxl container-p-y">
            <div class="misc-wrapper text-center">
                <h2 class="mb-2 mx-2">No hay nada para mostrar :(</h2>
                <p class="mb-4 mx-2">Lo sentimos! 😞 Revisa tu búsqueda o agrega una nueva área.</p>
                <div class="mt-3">
                    <img src="{{ asset('img/no-data.svg') }}" alt="page-misc-error-light" width="400" class="img-fluid"
                        data-app-dark-img="illustrations/page-misc-error-dark.png"
                        data-app-light-img="illustrations/page-misc-error-light.png" />
                </div>
            </div>
        </div>
    @endif
@endsection
