@extends('layouts.app')

@section('title', 'Sucursal')

@section('section-name', 'Usuarios')

@section('content')

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Clientes /</span> Sucursal</h4>
    
    <div class="row">
        <form class="form-horizontal" autocomplete="off">
            <div class="form-group row text-right">

                <div class="col-lg-5">
                    <div class="mb-4 fv-plugins-icon-container">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-company2" class="input-group-text">
                                <i class='bx bx-search bx-sm'></i>
                            </span>
                            <input type="text" id="basic-icon-default-company" class="form-control text-uppercase" id="name_enterprise" name="name_enterprise" value="{{$name_enterprise}}"  placeholder="Buscar Empresa" aria-label="Buscar Empresa" aria-describedby="basic-icon-default-company2"/>
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
        <div class="d-flex mb-3 gap-3 justify-content-end align-items-center">
            <span class="badge bg-label-primary rounded-2">
                <i class="bx bx-buildings bx-md"></i>
            </span>
            <a class="btn btn-primary">
                <span>
                    <i class="bx bx-plus me-0 me-sm-1"></i>
                    <span class="d-none d-sm-inline-block">Agregar Sucursal</span>
                </span>
            </a>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Sucursales</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Estatus</th>
                        <th>Aciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($branch as $data)
                        
                        <tr>
                            <td>{{$data->name}}</td>
                            <td>-- --</td>
                            <td>{{$data->phone}}</td>
                            @if($data->status == 'Activo')
                                <td><span class="badge bg-label-primary me-1">{{$data->status}}</span></td>
                            @else
                                <td><span class="badge bg-label-danger me-1">{{$data->status}}</span></td>
                            @endif
                            <td>
                                <div class="d-flex justify-content-between">
                                    <a class="text-muted me-1" href="{{ route('admin.branch.edit', [$data->id]) }}" data-bs-toggle="tooltip" data-popup="tooltip-custom" 
                                        data-bs-placement="top" aria-label="Editar" data-bs-original-title="Editar">
                                        <i class="bx bx-edit bx-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination justify-content-end">
                {{ $branch->appends(request()->query())->links()}}
            </div>
        </div>
        
    </div>
@endsection
