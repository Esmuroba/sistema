@extends('layouts.app')

@section('title', 'Clientes')

<style>
    .swal2-container .swal2-html-container {
        font-size: 15px;
    }

    .swal2-html-container {
        font-size: 15px;
        max-height: 130px;
        overflow: hidden;
    }

    .swal2-container .swal2-html-container::-webkit-scrollbar {
        width: 0.25rem;
        right: 0;
        background: transparent;
        border-radius: 10rem;
    }

    .swal2-container .swal2-html-container::-webkit-scrollbar-thumb {
        background-color: #3CB4D3;
        border-radius: 10rem;
        border: 2px solid transparent;
    }
</style>

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Comercial /</span> Avales</h4>

    <div class="d-flex justify-content-between">
        
        <div class="col d-flex mb-3 gap-3 justify-content-end align-items-center">
            <span class="badge bg-label-primary rounded-2">
                <i class="bx bx-buildings bx-md"></i>
            </span>
            <div class="btn-group">
                <a href="{{ route('admin.aval.create') }}" class="btn btn-primary">
                    <span>
                        <i class="bx bx-plus me-0 me-sm-1"></i>
                        <span class="d-none d-sm-inline-block">Agregar Avales</span>
                    </span>
                </a>
               
            </div>
        </div>
    </div>
    @if (count($avales) > 0)
        <div class="card">
            <h5 class="card-header">Avales</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 1%">ID</th>
                            <th>Nombre</th>
                            <th>Genero</th>
                            <th>Fecha Nac.</th>
                            <th>Edad</th>
                            <th>Estatus</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($avales as $aval)
                        @php
                            if($aval->genero == 'M'){
                                $genero = 'MASCULINO'; 
                            }else if($aval->genero == 'F'){
                                $genero = 'FEMENINO';  
                            }else{
                                $genero = 'INDISTINTO';
                            }
                        @endphp
                        <tr>
                            <td>{{ $aval->id }}</td>
                            <td>{{ $aval->getFullName() }}</td>
                            <td>{{ $genero }}</td>
                            <td>{{ $aval->fecha_nacimiento }}</td>
                            <td>{{ $aval->edad }} Años</td>
                            <td>
                                @if ($aval->state == 'Activo')
                                    <span data-id="{{ $aval->id }}" class="badge bg-label-success me-1 " style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Haz click para inactivar aval">{{$aval->state}}</span>
                                @else
                                    <span data-id="{{ $aval->id }}" class="badge bg-label-danger me-1" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Haz click para activar aval">{{$aval->state}}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">  
                                        {{-- <a class="text-muted me-1"
                                            href=""
                                            data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            aria-label="Detalles" data-bs-original-title="Detalles">
                                            <i class='bx bx-detail bx-sm'></i>
                                        </a> --}}
                                        <a class="text-muted me-1"
                                            href="{{ route('admin.aval.edit', [$aval->id]) }}" title="Editar"
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
                    {{ $avales->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center container-xxl container-p-y">
            <div class="misc-wrapper text-center">
                <h2 class="mb-2 mx-2">No hay nada para mostrar :(</h2>
                <p class="mb-4 mx-2">Lo sentimos! 😞 Revisa tu búsqueda o agrega una nueva empresa.</p>
                <div class="mt-3">
                    <img src="{{ asset('img/no-data.svg') }}" alt="page-misc-error-light" width="400" class="img-fluid"
                        data-app-dark-img="illustrations/page-misc-error-dark.png"
                        data-app-light-img="illustrations/page-misc-error-light.png" />
                </div>
            </div>
        </div>
    @endif


@endsection
