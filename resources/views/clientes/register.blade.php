@extends('layouts.app')

@section('title', 'Registrar Cliente')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Comercial / Clientes / </span>Registrar</h4>
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-center align-items-center">
                    <h5 class="mb-0">Datos del Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <form action="{{ route('admin.cliente.store') }}" method="POST" autocomplete="off">
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
                                                aria-label="Nombres" value="{{ old('nombre') }}" />
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
                                                aria-label="Apellido Paterno" value="{{ old('apellido_paterno') }}" />
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
                                                aria-label="Apellido Materno" value="{{ old('apellido_materno') }}" />
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
                                            <select id="genero" name="genero" class="form-select @error('genero') is-invalid @enderror">
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                                <option value="x">Indistinto</option>
                                            </select>
                                        </div>

                                        @error('genero')
                                            <div class="form-text text-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                                    value="{{ old('fecha_nacimiento') }}">
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
                                                class="form-control text-uppercase @error('ciudad') is-invalid @enderror" id="ciudad" name="ciudad"
                                                placeholder="ciudad" value="{{ old('ciudad') }}" />
                                        </div>

                                        @error('ciudad')
                                            <div class="form-text text-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Estado</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-buildings'></i>
                                            </span>
                                            <select id="estado" name="estado"
                                                class="form-select @error('estado') is-invalid @enderror" onchange="btGenCurp(this.form, '3');">
                                                <option value="">ELIGE UNA OPCIÓN</option>
                                                    @foreach($estados_nac as $estados)
                                                        <option {{ old('estado') == $estados->clave ? 'selected' : '' }} value="{{$estados->clave}}">{{$estados->nombre}}</option>
                                                    @endforeach
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
                                                placeholder="nacionalidad" value="{{ old('nacionalidad') }}" />
                                        </div>

                                        @error('nacionalidad')
                                            <div class="form-text text-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">CURP</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-id-card"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control text-uppercase" id="curp" name="curp"
                                                placeholder="CURP" value="{{ old('curp') }}" maxlength="18" />
                                        </div>

                            
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">RFC</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-id-card"></i>
                                            </span>
                                            <input type="text" id="basic-icon-default-email"
                                                class="form-control text-uppercase @error('rfc') is-invalid @enderror" id="rfc" name="rfc"
                                                placeholder="rfc" value="{{ old('rfc') }}" maxlength="13" />
                                        </div>

                                        @error('rfc')
                                            <div class="form-text text-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                                <option value="Propia">Propia</option>
                                                <option value="Rentada">Rentada</option>
                                                <option value="Familiar">Familiar</option>
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
                                            class="form-control text-uppercase" placeholder="Dirección">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="basic-icon-default">Años de Residencia</label>
                                        <div class="input-group">
                                            <input name="residencia" id="residencia" type="text" value="{{ old('residencia') }}" id="basic-icon-default" class="form-control" placeholder="Años">
                                        </div>
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Vialidad</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-vertical-center'></i>
                                            </span>
                                            <select class="form-select" id="vialidad" name="vialidad">
                                                <option value="Ampliacion">Ampliación</option>
                                                <option value="Andador">Andador</option>
                                                <option value="Avenida">Avenida</option>
                                                <option value="Boulevard">Boulevard</option>
                                                <option value="Calle">Calle</option>
                                                <option value="Callejon">Callejon</option>
                                                <option value="Calzada">Calzada</option>
                                                <option value="Cerrada">Cerrada</option>
                                                <option value="Circuito">Circuito</option>
                                                <option value="Circumbalacion">Circumbalación</option>
                                                <option value="Continuacion">Continuación</option>
                                                <option value="Corredor">Corredor</option>
                                                <option value="Diagonol">Diagonol</option>
                                                <option value="Eje Vial">Eje Vial</option>
                                                <option value="Pasaje">Pasaje</option>
                                                <option value="Peatonal">Peatonal</option>
                                                <option value="Periferico">Periferico</option>
                                                <option value="Privada">Privada</option>
                                                <option value="Prolongacion">Prolongación</option>
                                                <option value="Retorno">Retorno</option>
                                                <option value="Viaducto">Viaducto</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-8 mb-3">
                                        <label class="form-label" for="basic-icon-default">Entre Calles</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-directions'></i>
                                            </span>
                                            <input type="text" id="entre_calles" name="entre_calles" id="basic-icon-default" name="entre_calles"
                                            class="form-control text-uppercase" placeholder="Entre Calles">
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
                                            <input type="text" id="referencias" name="referencias" id="basic-icon-default" name="referencias"
                                            class="form-control text-uppercase" placeholder="Referencias">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="basic-icon-default">Codigo Postal</label>
                                        <div class="input-group" id="theCp">
                                            <span class="input-group-text">
                                                <i class="bx bx-barcode"></i>
                                            </span>
                                            <input type="text" oninput="buscarCodigoPostal()" id="cp" name="cp" id="basic-icon-default" name="cp"
                                            class="form-control" placeholder="C.P.">
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Sueldo diario</label>
                                        <div class="input-group">
                                            <span id="basic-icon-default-phone2" class="input-group-text">
                                                <i class="fa-solid fa-hand-holding-dollar"></i>
                                            </span>
                                            <input type="number" id="dailySalary" name="daily_salary"
                                                class="form-control phone-mask @error('daily_salary') is-invalid @enderror"
                                                placeholder="$250"
                                                onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
                                                value="{{ old('daily_salary') }}" />
                                        </div>

                                        @error('daily_salary')
                                            <div class="form-text text-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group" id="theSuburb">
                                            <label class="form-label" for="basic-icon-default" for="txt_colonia">COLONIA</label>
                                            <select name="txt_colonia" id="txt_colonia" class="form-select text-uppercase theSuburbs" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group" id="theCity">
                                            <label class="form-label" for="basic-icon-default" for="txt_ciudad">CIUDAD</label>
                                            <input type="text" id="txt_ciudad" name="txt_ciudad" class="form-control" placeholder="Ciudad">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group" id="theState">
                                            <label class="form-label" for="basic-icon-default" for="txt_estado">ESTADO</label>
                                            <input type="text" id="txt_estado" name="txt_estado" class="form-control" placeholder="Estado">
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
                                                value="{{ old('celular') }}" />
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
                                                value="{{ old('fecha_alta') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Escolaridad</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-filter"></i>
                                            </span>
                                            <select name="escolaridad" class="form-select">
                                                <option>Ninguna</option>
                                                <option>Leer y Escribir</option>
                                                <option>Preescolar</option>
                                                <option>Primaria</option>
                                                <option>Secundaria</option>
                                                <option>Preparatoria</option>
                                                <option>Licenciatura</option>
                                                <option>Maestria</option>
                                                <option>Doctorado</option>
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
                                                placeholder="Profesión" value="{{ old('profesion') }}" />
                                        </div>

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Religión</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bx bx-church"></i>
                                            </span>
                                            <select name="religion" class="form-select">
                                                <option>Sin Religion</option>
                                                <option>Cristianismo</option>
                                                <option>Budismo</option>
                                                <option>Hinduismo</option>
                                                <option>Testigo de Jehova</option>
                                                <option>Presbiteriana</option>
                                                <option>Catolica</option>
                                                <option>Protestante</option>
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
                                                <option>Soltero(a)</option>
                                                <option>Casado(a)</option>
                                                <option>Union Libre</option>
                                                <option>Divorciado(a)</option>
                                                <option>Viuda(a)</option>
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
                                                placeholder="clave de elector" value="{{ old('clave_elector') }}" maxlength="18" />
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label" for="basic-icon-default">Vencimiento</label>
                                        <div class="input-group">
                                            <input name="vencimiento" id="vencimiento" type="number" maxlength="4" value="{{ old('vencimiento') }}" id="basic-icon-default" class="form-control" placeholder="Año">
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
                                                placeholder="Folio" value="{{ old('folio_ine') }}" maxlength="20" />
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
                                                placeholder="ocr" value="{{ old('ocr') }}" maxlength="13" />
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
                                                placeholder="N° tarjeta" value="{{ old('num_tarjeta') }}" maxlength="16" />
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
                                                placeholder="N° de Cuenta" value="{{ old('num_cuenta') }}" maxlength="20" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Clabe Interbancaria</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-credit-card-front'></i>
                                            </span>
                                            <input type="text" id="basic-icon-default-email"
                                                class="form-control text-uppercase" name="clabe_interbancaria"
                                                placeholder="Clabe Interbancaria" value="{{ old('clabe_interbancaria') }}" maxlength="18" />
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
                                                placeholder="Banco" value="{{ old('banco') }}" />
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-7 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Cuenta Contable</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-filter'></i>
                                            </span>
                                            <select name="cuenta"
                                                class="form-select select2">
                                                <option value="">SELECCIONA</option>
                                                @foreach($cuentas as $cuenta)
                                                    <option {{ old('cuenta') == $cuenta->id ? 'selected' : '' }} value="{{$cuenta->id}}">{{$cuenta->nombre_cuenta}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Asociado</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-filter'></i>
                                            </span>
                                            <select name="asociado"
                                                class="form-select select2">
                                                <option value="">SELECCIONA</option>
                                                @foreach($asociados as $asociado)
                                                    <option {{ old('asociado') == $asociado->id ? 'selected' : '' }} value="{{$asociado->id}}">{{$asociado->getFullname()}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Aval</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-filter'></i>
                                            </span>
                                            <select name="aval"
                                                class="form-select select2">
                                                <option value="">SELECCIONA</option>
                                                @foreach($avales as $aval)
                                                    <option {{ old('aval') == $aval->id ? 'selected' : '' }} value="{{$aval->id}}">{{$aval->getFullname()}}</option>
                                                @endforeach
                                            </select>
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
     $.ajaxSetup({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
    });

    function buscarCodigoPostal() {
        cp = $('#cp').val();
        if(cp.length == 5){
            $.ajax({
                type: "GET",
                url: "{{ asset('admin/cp/buscarCodigoPostal') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType:"json",
                data: {
                    cp : cp
                },
                success:function(data){
                    console.log(data);
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