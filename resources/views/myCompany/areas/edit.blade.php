@extends('layouts.app')

@section('title', 'Editar Area')

@section('section-name', 'Usuarios')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Mi Empresa / Áreas /</span> Editar</h4>

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
                    <h5 class="mb-0">Datos del Área</h5>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('my-company.areas.update', [$area->id]) }}" autocomplete="off">
                @method('PUT')	
                @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="" class="form-label">Departamentos</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-buildings"></i>
                                </span>
                                <select class="form-select" id="departments" name="departments" aria-label="Default select example">
                                    <option selected="">-- SELECCIONA UNA EMPRESA --</option>
                                    @foreach($departments as $department)
                                        <option {{ old('departments') == $department->id ? 'selected' : ($opcion != "N/A" ? ($opcion == $department->id ? 'selected' : '')  : '') }} value="{{$department->id}}">{{$department->name}}</option>
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
                                <input type="text" id="name_area" name="name_area" class="form-control text-uppercase" value="{{ $area->name}}"  placeholder="Nombre del Área" maxlength="150"/>
                            </div>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="" class="form-label">Teléfono</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bx bx-phone"></i>
                                </span>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Teléfono" value="{{ $area->phone}}" maxlength="10"/>
                            </div>
                        </div>
                       
                        <div class="mb-3 col-md-2">
                            <label for="" class="form-label">Extensión</label>
                                <input type="text" id="ext" name="ext" class="form-control" placeholder="Extensión" value="{{ $area->ext}}" maxlength="5"/>
                        </div>
                       
                       
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Editar<i class='bx bx-check-circle'></i></button>
                        <a type="button" href="{{ route('my-company.areas') }}" class="btn btn-outline-secondary">Cerrar</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
