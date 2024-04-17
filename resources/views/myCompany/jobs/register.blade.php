@extends('layouts.app')

@section('title', 'Registrar Puesto')

@section('section-name', 'Usuarios')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Mi Empresa / Puestos /</span> Registrar</h4>
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-center align-items-center">
                    <h5 class="mb-0">Datos del Puesto</h5>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('my-company.jobs.store') }}" autocomplete="off">
                @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="" class="form-label">Areas</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-buildings"></i>
                                </span>
                                <select class="form-select" id="areas" name="areas" aria-label="Default select example">
                                    <option selected="">-- SELECCIONA UN ÁREA --</option>
                                    @foreach($areas as $area)
                                        <option {{ old('areas') == $area->id ? 'selected' : '' }} value="{{$area->id}}">{{$area->name}}</option>
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
                                <input type="text" id="name_job" name="name_job" class="form-control text-uppercase" placeholder="Nombre del Puesto"/>
                            </div>
                        </div> 
                       
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Guardar</button>
                        <a type="button" href="{{ route('my-company.jobs') }}" class="btn btn-outline-secondary">Cerrar</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

