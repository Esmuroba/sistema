@extends('layouts.app')

@section('title', 'Registrar Area')

@section('section-name', 'Usuarios')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Mi Empresa / Áreas /</span> Registrar</h4>
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-center align-items-center">
                    <h5 class="mb-0">Datos del Área</h5>
                </div>
                <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <form method="POST" action="{{ route('my-company.areas.store') }}" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="" class="form-label">Departamentos</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">
                                        <i class="bx bx-buildings"></i>
                                    </span>
                                    <select class="form-select" id="departments" name="departments" aria-label="Default select example">
                                        <option selected="">-- SELECCIONA UN DEPARTAMENTO --</option>
                                        @foreach($departments as $department)
                                            <option {{ old('departments') == $department->id ? 'selected' : '' }} value="{{$department->id}}">{{$department->name}}</option>
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
                                    <input type="text" id="name_area" name="name_area" class="form-control text-uppercase" placeholder="Nombre del Área" maxlength="150" value="{{ old('name_area') }}"/>
                                </div>
                            </div>
                        
                            
                            <div class="mb-3 col-md-4">
                                <label for="" class="form-label">Teléfono</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">
                                        <i class="bx bx-phone"></i>
                                    </span>
                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Teléfono" maxlength="10" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="{{ old('phone') }}"/>
                                </div>
                            </div>
                        
                            <div class="mb-3 col-md-2">
                                <label for="" class="form-label">Extensión</label>
                                    <input type="text" id="ext" name="ext" class="form-control" placeholder="Extensión"  maxlength="5" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="{{ old('phone') }}"/>
                            </div>
                        
                    
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Guardar</button>
                            <a type="button" href="{{ route('my-company.areas') }}" class="btn btn-outline-secondary">Cerrar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

