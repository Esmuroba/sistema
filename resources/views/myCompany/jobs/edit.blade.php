@extends('layouts.app')

@section('title', 'Editar Puesto')

@section('section-name', 'Usuarios')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Mi Empresa / Puestos /</span> Editar</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
               
                @if(Session::has('mensaje'))
                    <div class="alert alert-success alert-dismissible d-flex" role="alert">
                        
                        <div class="d-flex flex-column ps-1">
                            <span>{{Session::get('mensaje')}}</span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif  


            <div class="card mb-4">
                <div class="card-header d-flex justify-content-center align-items-center">
                    <h5 class="mb-0">Datos del Puesto</h5>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('my-company.jobs.update', [$jobs->id]) }}" autocomplete="off">
                @method('PUT')	
                @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="" class="form-label">Áreas</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-buildings"></i>
                                </span>
                                <select class="form-select" id="areas" name="areas" aria-label="Default select example">
                                    <option selected="">-- SELECCIONA UNA EMPRESA --</option>
                                    @foreach($areas as $area)
                                        <option {{ old('areas') == $area->id ? 'selected' : ($opcion != "N/A" ? ($opcion == $area->id ? 'selected' : '')  : '') }} value="{{$area->id}}">{{$area->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="" class="form-label">Nombre</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-building"></i>
                                </span>
                                <input type="text" id="name_job" name="name_job" class="form-control text-uppercase" value="{{ $jobs->name}}"  placeholder="Nombre del Puesto"/>
                            </div>
                        </div>                       
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Editar<i class='bx bx-check-circle'></i></button>
                        <a type="button" href="{{ route('my-company.jobs') }}" class="btn btn-outline-secondary">Cerrar</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
