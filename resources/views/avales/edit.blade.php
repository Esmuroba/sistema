@extends('layouts.app')

@section('title', 'Registrar Cliente')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Comercial / Avales / </span>Registrar</h4>
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
                    <h5 class="mb-0">Datos del Aval</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <form method="POST" action="{{action('AvalController@update', $aval->id)}}" autocomplete="off">
                                @method('PUT')	
                                @csrf
                                <div class="row">
                                    <label class="form-label" for="basic-icon-default-company">Nombre Completo</label>
                                    <div class="col-md-4 mb-4">
                                        <div class="input-group">
                                            <span id="basic-icon-default-company2" class="input-group-text">
                                                <i class='bx bx-user'></i>
                                            </span>
                                            <input type="text"
                                                class="form-control text-uppercase @error('nombre') is-invalid @enderror"
                                                id="nombre" name="nombre" placeholder="Nombres"
                                                aria-label="Nombres" value="{{ $aval->nombre}}" />
                                        </div>
                                        @error('nombre')
                                            <div class="form-text text-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-4 mb-4">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control text-uppercase @error('apellido_paterno') is-invalid @enderror"
                                                id="apellido_paterno" name="apellido_paterno" placeholder="Apellido Paterno"
                                                aria-label="Apellido Paterno" value="{{ $aval->apellido_paterno}}" />
                                        </div>

                                        @error('apellido_paterno')
                                            <div class="form-text text-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control text-uppercase @error('apellido_materno') is-invalid @enderror"
                                                id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno"
                                                aria-label="Apellido Materno" value="{{ $aval->apellido_materno}}" />
                                        </div>
                                        @error('apellido_materno')
                                            <div class="form-text text-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Género</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-venus-mars"></i>
                                            </span>
                                            <select id="genero" name="genero" class="form-select">
                                                <option {{ $aval->genero == 'MASCULINO' ? 'selected' : ''}} value="MASCULINO">Masculino</option>
                                                <option {{ $aval->genero == 'FEMENINO' ? 'selected' : ''}} value="FEMENINO">Femenino</option>
                                                <option {{ $aval->genero == 'INDISTINTO' ? 'selected' : ''}} value="INDISTINTO">Indistinto</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Fecha de nacimiento</label>
                                        <div class="row">
                                            <div class="col input-group">
                                                <span id="basic-icon-default-company2" class="input-group-text">
                                                    <i class='bx bx-calendar-star'></i>
                                                </span>
                                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                                                    class="form-control"
                                                    value="{{ $aval->fecha_nacimiento}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default">Ciudad</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bxs-city"></i>
                                            </span>
                                            <input type="text" id="basic-icon-default"
                                                class="form-control text-uppercase" id="ciudad" name="ciudad"
                                                placeholder="ciudad" value="{{ $aval->ciudad_nacimiento}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Estado</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-buildings'></i>
                                            </span>
                                            <select id="estado" name="estado"
                                                class="form-select">
                                                <option value="">Seleccionar</option>
                                                <option {{ $aval->estado == 'AGUASCALIENTES' ? 'selected' : ''}} value="AGUASCALIENTES">AGUASCALIENTES</option>
                                                <option {{ $aval->estado == 'BAJA CALIFORNIA' ? 'selected' : ''}} value="BAJA CALIFORNIA">BAJA CALIFORNIA</option>
                                                <option {{ $aval->estado == 'BAJA CALIFORNIA SUR' ? 'selected' : ''}} value="BAJA CALIFORNIA SUR">BAJA CALIFORNIA SUR</option>
                                                <option {{ $aval->estado == 'CAMPECHE' ? 'selected' : ''}} value="CAMPECHE">CAMPECHE</option>
                                                <option {{ $aval->estado == 'CHIAPAS' ? 'selected' : ''}} value="CHIAPAS">CHIAPAS</option>
                                                <option {{ $aval->estado == 'CHIHUAHUA' ? 'selected' : ''}} value="CHIHUAHUA">CHIHUAHUA</option>
                                                <option {{ $aval->estado == 'COAHUILA' ? 'selected' : ''}} value="COAHUILA">COAHUILA</option>
                                                <option {{ $aval->estado == 'COLIMA' ? 'selected' : ''}} value="COLIMA">COLIMA</option>
                                                <option {{ $aval->estado == 'DISTRITO FEDERAL' ? 'selected' : ''}} value="DISTRITO FEDERAL">DISTRITO FEDERAL</option>
                                                <option {{ $aval->estado == 'DURANGO' ? 'selected' : ''}} value="DURANGO">DURANGO</option>
                                                <option {{ $aval->estado == 'GUANAJUATO' ? 'selected' : ''}} value="GUANAJUATO">GUANAJUATO</option>
                                                <option {{ $aval->estado == 'GUERRERO' ? 'selected' : ''}} value="GUERRERO">GUERRERO</option>
                                                <option {{ $aval->estado == 'HIDALGO' ? 'selected' : ''}} value="HIDALGO">HIDALGO</option>
                                                <option {{ $aval->estado == 'JALISCO' ? 'selected' : ''}} value="JALISCO">JALISCO</option>
                                                <option {{ $aval->estado == 'MEXICO' ? 'selected' : ''}} value="MEXICO">MÉXICO</option>
                                                <option {{ $aval->estado == 'MORELOS' ? 'selected' : ''}} value="MORELOS">MORELOS</option>
                                                <option {{ $aval->estado == 'MICHOACAN' ? 'selected' : ''}} value="MICHOACAN">MICHOACAN</option>
                                                <option {{ $aval->estado == 'NAYARIT' ? 'selected' : ''}} value="NAYARIT">NAYARIT</option>
                                                <option {{ $aval->estado == 'NUEVO LEON' ? 'selected' : ''}} value="NUEVO LEON">NUEVO LEON</option>
                                                <option {{ $aval->estado == 'OAXACA' ? 'selected' : ''}} value="OAXACA">OAXACA</option>
                                                <option {{ $aval->estado == 'PUEBLA' ? 'selected' : ''}} value="PUEBLA">PUEBLA</option>
                                                <option {{ $aval->estado == 'QUERETARO' ? 'selected' : ''}} value="QUERETARO">QUERETARO</option>
                                                <option {{ $aval->estado == 'QUINTANA ROO' ? 'selected' : ''}} value="QUINTANA ROO">QUINTANA ROO</option>
                                                <option {{ $aval->estado == 'SAN LUIS POTOSI' ? 'selected' : ''}} value="SAN LUIS POTOSI">SAN LUIS POTOSI</option>
                                                <option {{ $aval->estado == 'SINALOA' ? 'selected' : ''}} value="SINALOA">SINALOA</option>
                                                <option {{ $aval->estado == 'SONORA' ? 'selected' : ''}} value="SONORA">SONORA</option>
                                                <option {{ $aval->estado == 'TABASCO' ? 'selected' : ''}} value="TABASCO">TABASCO</option>
                                                <option {{ $aval->estado == 'TAMAULIPAS' ? 'selected' : ''}} value="TAMAULIPAS">TAMAULIPAS</option>
                                                <option {{ $aval->estado == 'TLAXCALA' ? 'selected' : ''}} value="TLAXCALA">TLAXCALA</option>
                                                <option {{ $aval->estado == 'VERACRUZ' ? 'selected' : ''}} value="VERACRUZ">VERACRUZ</option>
                                                <option {{ $aval->estado == 'YUCATAN' ? 'selected' : ''}} value="YUCATAN">YUCATAN</option>
                                                <option {{ $aval->estado == 'ZACATECAS' ? 'selected' : ''}} value="ZACATECAS">ZACATECAS</option>
                                                <option {{ $aval->estado == 'EXTRANJERO' ? 'selected' : ''}} value="EXTRANJERO">EXTRANJERO</option>
                                            </select>
                                        </div>
                                        @error('estado')
                                            <div class="form-text text-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default">Nacionalidad</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-building"></i>
                                            </span>
                                            <input type="text" id="basic-icon-default"
                                                class="form-control text-uppercase @error('nacionalidad') is-invalid @enderror" id="nacionalidad" name="nacionalidad"
                                                placeholder="nacionalidad" value="{{ $aval->nacionalidad}}" />
                                        </div>
                                        @error('nacionalidad')
                                            <div class="form-text text-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">CURP</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-id-card"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control text-uppercase" id="curp" name="curp"
                                                placeholder="CURP" value="{{ $aval->curp}}"  maxlength="18" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">RFC</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-id-card"></i>
                                            </span>
                                            <input type="text" id="basic-icon-default-email"
                                                class="form-control text-uppercase @error('rfc') is-invalid @enderror" id="rfc" name="rfc"
                                                placeholder="rfc" value="{{ $aval->rfc}}"  maxlength="13" />
                                        </div>
                                        @error('rfc')
                                            <div class="form-text text-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Parentesco</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bxs-user-detail'></i>
                                            </span>
                                            <select class="form-select" id="parentesco" name="parentesco">
                                                <option>-- Elíge --</option>
                                                <option {{ $aval->parentesco == 'HIJO(A)' ? 'selected' : ''}} value="HIJO(A)">HIJO(A)</option>
                                                <option {{ $aval->parentesco == 'PADRE' ? 'selected' : ''}} value="PADRE">PADRE</option>
                                                <option {{ $aval->parentesco == 'MADRE' ? 'selected' : ''}} value="MADRE">MADRE</option>
                                                <option {{ $aval->parentesco == 'ESPOSO(A)' ? 'selected' : ''}} value="ESPOSO(A)">ESPOSO(A)</option>
                                                <option {{ $aval->parentesco == 'HERMANO(A)' ? 'selected' : ''}} value="HERMANO(A)">HERMANO(A)</option>
                                                <option {{ $aval->parentesco == 'ABUELO(A)' ? 'selected' : ''}} value="ABUELO(A)">ABUELO(A)</option>
                                                <option {{ $aval->parentesco == 'NIETO(A)' ? 'selected' : ''}} value="NIETO(A)">NIETO(A)</option>
                                                <option {{ $aval->parentesco == 'SOBRINO(A)' ? 'selected' : ''}} value="SOBRINO(A)">SOBRINO(A)</option>
                                                <option {{ $aval->parentesco == 'YERNO' ? 'selected' : ''}} value="YERNO">YERNO</option>
                                                <option {{ $aval->parentesco == 'NUERA' ? 'selected' : ''}} value="NUERA">NUERA</option>
                                                <option {{ $aval->parentesco == 'CUÑADO(A)' ? 'selected' : ''}} value="CUÑADO(A)">CUÑADO(A)</option>
                                                <option {{ $aval->parentesco == 'TIO(A)' ? 'selected' : ''}} value="TIO(A)">TIO(A)</option>
                                                <option {{ $aval->parentesco == 'PRIMO(A)' ? 'selected' : ''}} value="PRIMO(A)">PRIMO(A)</option>
                                                <option {{ $aval->parentesco == 'CONOCIDO(A)' ? 'selected' : ''}} value="CONOCIDO(A)">CONOCIDO(A)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Tipo de Vivienda</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-buildings'></i>
                                            </span>
                                            <select id="vivienda" name="vivienda" class="form-select">
                                                <option {{ $aval->tipo_vivienda == 'PROPIA' ? 'selected' : ''}} value="PROPIA">Propia</option>
                                                <option {{ $aval->tipo_vivienda == 'RENTADA' ? 'selected' : ''}} value="RENTADA">Rentada</option>
                                                <option {{ $aval->tipo_vivienda == 'FAMILIAR' ? 'selected' : ''}} value="FAMILIAR">Familiar</option>
                                            </select>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-icon-default">Dirección</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-map"></i>
                                            </span>
                                            <input type="text" id="direccion" name="direccion" id="basic-icon-default" name="direccion"
                                            class="form-control text-uppercase" placeholder="Dirección" value="{{ $aval->direccion}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="basic-icon-default">Años de Residencia</label>
                                        <div class="input-group">
                                            <input name="residencia" id="residencia" type="text" value="{{ $aval->anios_residencia}}" id="basic-icon-default" class="form-control" placeholder="Años">
                                        </div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-9 mb-3">
                                        <label class="form-label" for="basic-icon-default">Referencias</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-health'></i>
                                            </span>
                                            <input type="text" id="referencias" name="referencias" id="basic-icon-default"
                                            class="form-control text-uppercase" placeholder="Referencias" value="{{ $aval->referencia}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="basic-icon-default">Codigo Postal</label>
                                        <div class="input-group" id="theCp">
                                            <span class="input-group-text">
                                                <i class="bx bx-barcode"></i>
                                            </span>
                                            <input type="text" oninput="buscarCodigoPostal()" id="cp" name="cp" id="basic-icon-default" name="cp"
                                            class="form-control" placeholder="C.P." value="{{ $aval->cp}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group" id="theSuburb">
                                            <label class="form-label" for="basic-icon-default" for="txt_colonia">COLONIA</label>
                                            <select name="txt_colonia" id="txt_colonia" class="form-select text-uppercase theSuburbs">
                                                <option value="{{ $aval->colonia }}">{{ $aval->colonia }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group" id="theCity">
                                            <label class="form-label" for="basic-icon-default" for="txt_ciudad">CIUDAD</label>
                                            <input type="text" id="txt_ciudad" name="txt_ciudad" class="form-control" placeholder="Ciudad" value="{{ $aval->ciudad}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group" id="theState">
                                            <label class="form-label" for="basic-icon-default" for="txt_estado">ESTADO</label>
                                            <input type="text" id="txt_estado" name="txt_estado" class="form-control" placeholder="Estado" value="{{ $aval->estado}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="" class="form-label">Célular</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-phone"></i>
                                            </span>
                                            <input type="text" id="celular" name="celular"
                                                class="form-control" placeholder="TELÉFONO" maxlength="10"
                                                onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
                                                value="{{ $aval->celular}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Fecha de Alta</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-calendar-event'></i>
                                            </span>
                                            <input type="date" name="fecha_alta"
                                                class="form-control @error('fecha_alta') is-invalid @enderror"
                                                value="{{ $aval->fecha_alta}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Escolaridad</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-filter"></i>
                                            </span>
                                            <select name="escolaridad" class="form-select">
                                                <option {{ $aval->escolaridad == 'NINGUNA' ? 'selected' : ''}} value="NINGUNA">Ninguna</option>
                                                <option {{ $aval->escolaridad == 'LEER Y ESCRIBIR' ? 'selected' : ''}} value="LEER Y ESCRIBIR">Leer y Escribir</option>
                                                <option {{ $aval->escolaridad == 'PREESCOLAR' ? 'selected' : ''}} value="PREESCOLAR">Preescolar</option>
                                                <option {{ $aval->escolaridad == 'PRIMARIA' ? 'selected' : ''}} value="PRIMARIA">Primaria</option>
                                                <option {{ $aval->escolaridad == 'SECUNDARIA' ? 'selected' : ''}} value="SECUNDARIA">Secundaria</option>
                                                <option {{ $aval->escolaridad == 'PREPARATORIA' ? 'selected' : ''}} value="SOCIO FUNDADOR">Preparatoria</option>
                                                <option {{ $aval->escolaridad == 'LICENCIATURA' ? 'selected' : ''}} value="LICENCIATURA">Licenciatura</option>
                                                <option {{ $aval->escolaridad == 'MAESTRIA' ? 'selected' : ''}} value="MAESTRIA">Maestria</option>
                                                <option {{ $aval->escolaridad == 'DOCTORADO' ? 'selected' : ''}} value="DOCTORADO">Doctorado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default">Profesión</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-group"></i>
                                            </span>
                                            <input type="text" id="basic-icon-default"
                                                class="form-control text-uppercase" name="profesion"
                                                placeholder="Profesión" value="{{ $aval->profesion}}" />
                                        </div>

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Religión</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-church"></i>
                                            </span>
                                            <select name="religion" class="form-select">
                                                <option {{ $aval->religion == 'SIN RELIGION' ? 'selected' : ''}} value="SIN RELIGION">Sin Religion</option>
                                                <option {{ $aval->religion == 'CRISTIANISMO' ? 'selected' : ''}} value="CRISTIANISMO">Cristianismo</option>
                                                <option {{ $aval->religion == 'BUDISMO' ? 'selected' : ''}} value="BUDISMO">Budismo</option>
                                                <option {{ $aval->religion == 'HINDUISMO' ? 'selected' : ''}} value="HINDUISMO">Hinduismo</option>
                                                <option {{ $aval->religion == 'TESTIGO DE JEHOVA' ? 'selected' : ''}} value="TESTIGO DE JEHOVA">Testigo de Jehova</option>
                                                <option {{ $aval->religion == 'PRESBISTERIANA' ? 'selected' : ''}} value="PRESBISTERIANA">Presbiteriana</option>
                                                <option {{ $aval->religion == 'CATOLICA' ? 'selected' : ''}} value="CATOLICA">Catolica</option>
                                                <option {{ $aval->religion == 'PROTESTANTE' ? 'selected' : ''}} value="PROTESTANTE">Protestante</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Estado Civil</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-filter"></i>
                                            </span>
                                            <select name="estado_civil" class="form-select">
                                                <option {{ $aval->estado_civil == 'SOLTERO(A)' ? 'selected' : ''}} value="SOLTERO(A)">Soltera</option>
                                                <option {{ $aval->estado_civil == 'CASADO(A)' ? 'selected' : ''}} value="CASADO(A)">Casada</option>
                                                <option {{ $aval->estado_civil == 'UNION LIBRE' ? 'selected' : ''}} value="UNION LIBRE">Union Libre</option>
                                                <option {{ $aval->estado_civil == 'DIVORCIADO(A)' ? 'selected' : ''}} value="DIVORCIADO(A)">Divorciada</option>
                                                <option {{ $aval->estado_civil == 'VIUDO(A)' ? 'selected' : ''}} value="VIUDO(A)">Viuda</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Clave de Elector</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-id-card"></i>
                                            </span>
                                            <input type="text" id="basic-icon-default-email"
                                                class="form-control text-uppercase" name="clave_elector"
                                                placeholder="clave de elector" value="{{ $aval->clave_elector}}" maxlength="18" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label" for="basic-icon-default">Vencimiento</label>
                                        <div class="input-group">
                                            <input name="vencimiento" id="vencimiento" type="number" maxlength="4" value="{{ $aval->anio_vencimiento_ine}}"  id="basic-icon-default" class="form-control" placeholder="Año">
                                        </div>
                                    </div> 
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Folio</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bxs-credit-card'></i>
                                            </span>
                                            <input type="text" id="basic-icon-default-email"
                                                class="form-control text-uppercase" name="folio_ine"
                                                placeholder="Folio" value="{{ $aval->folio_ine}}" maxlength="20" />
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">OCR</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-credit-card-front'></i>
                                            </span>
                                            <input type="text" id="basic-icon-default-email"
                                                class="form-control text-uppercase" name="ocr"
                                                placeholder="ocr" value="{{ $aval->ocr}}" maxlength="13" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Número de Tarjeta</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-credit-card-alt'></i>
                                            </span>
                                            <input type="text" id="basic-icon-default-email"
                                                class="form-control text-uppercase" name="num_tarjeta"
                                                placeholder="N° tarjeta" value="{{ $aval->numero_tarjeta}}" maxlength="16" />
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Número de Cuenta</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bxs-credit-card-front'></i>
                                            </span>
                                            <input type="text" id="basic-icon-default-email"
                                                class="form-control text-uppercase" name="num_cuenta"
                                                placeholder="N° de Cuenta" value="{{ $aval->numero_cuenta}}" maxlength="20" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Clabe Interbancaria</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-credit-card-front'></i>
                                            </span>
                                            <input type="text" id="basic-icon-default-email"
                                                class="form-control text-uppercase" id="clabe_interbancaria" name="clabe_interbancaria"
                                                placeholder="Clabe Interbancaria" value="{{ $aval->clave_interbancaria}}" maxlength="18" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Banco</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bxs-bank'></i>
                                            </span>
                                            <input type="text" id="basic-icon-default-email"
                                                class="form-control text-uppercase" name="banco"
                                                placeholder="Banco" value="{{ $aval->banco}}" />
                                        </div>
                                    </div>
                                  
                                       
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    Registrar
                                    <i class='bx bx-check-circle'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('scripts/js/curp.js') }}"></script>
<script>
     function buscarCodigoPostal() {
        cp = $('#cp').val();
        if(cp.length == 5){
            $.ajax({
                type: "POST",
                url: "{{ url('/api/checkCp') }}",
                data: {
                    cp : cp
                },
                success:function(data){
                    $(".theSuburbs").empty().trigger('change');
                    if(data != 'Resultado no encontrado'){
                        cpError = 0;
                        $('#cp').removeClass('is-invalid');
                        $('#cp').addClass('is-valid');
                        $('#cpError').remove();
                        $('#txt_ciudad').val(data.Ciudad);
                        $('#txt_estado').val(data.Estado);
                        let theSuburbs = data.Asentamiento;
                        var data = {};

                        theSuburbs.forEach(function(theCurrentSuburb){
                            data.id = theCurrentSuburb;
                            data.text = theCurrentSuburb;
                            var newOption = new Option(data.text, data.id, false, false);
                            $('#txt_colonia').append(newOption).trigger('change');
                        });
                    }
                    else {
                        cpError = 1;
                        $('#cp').addClass('is-invalid');
                        $('#cpError').remove();
                        $('#theCp').append('<span class="invalid-feedback" id="cpError" role="alert"><strong>No se ha encontrado ese C.P.</strong></span>');
                    }
                }
            });
        }
        else {
            $('#cp').addClass('is-invalid');
            $('#cpError').remove();
            $('#theCp').append('<span class="invalid-feedback" id="cpError" role="alert"><strong>El código postal debe contener 5 números.</strong></span>');
        }
    };
</script>

