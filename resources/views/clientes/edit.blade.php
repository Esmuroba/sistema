@extends('layouts.app')

@section('title', 'Registrar Cliente')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Comercial / Clientes / </span>Registrar</h4>
    <!-- Basic Layout -->
    <div class="row">
      @if(Session::has('mensaje') == 'Referencia agregada' || Session::has('mensaje') == 'Registro exitoso')
          @php
              $activeC = '';
              $activeR = 'active';
              $activeCShow = '';
              $activeRShow = 'active show';
          @endphp
      @else
          @php
              $activeC = 'active';
              $activeR = '';
              $activeCShow = 'active show';
              $activeRShow = '';
          @endphp
      @endif 
      <div class="col-md-12">
        <div class="card text-center">
          <div class="card-header py-3">
            <ul class="nav nav-pills" role="tablist">
              <li class="nav-item" role="presentation">
                <button type="button" class="nav-link {{$activeC}}" role="tab" data-bs-toggle="tab" data-bs-target="#navCliente" aria-controls="navCliente" aria-selected="true">Datos del Cliente</button>
              </li>
              <li class="nav-item" role="presentation">
                <button type="button" class="nav-link {{$activeR}}" role="tab" data-bs-toggle="tab" data-bs-target="#navReferencia" aria-controls="navReferencia" aria-selected="false" tabindex="-1">Referencias</button>
              </li>
              
            </ul>
          </div>
          <div class="tab-content pt-0">
            <div class="tab-pane fade {{$activeCShow}}" id="navCliente" role="tabpanel">
              <div class="table-responsive text-start">
                <div class="col-lg-11 mx-auto">
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
                                      class="form-control text-uppercase"
                                      id="nombre" name="nombre" placeholder="Nombres"
                                      aria-label="Nombres" value="{{ $cliente->nombre}}" />
                              </div>
                          </div>
                          
                          <div class="col-md-4 mb-4">
                              <div class="input-group">
                                  <input type="text"
                                      class="form-control text-uppercase"
                                      id="apellido_paterno" name="apellido_paterno" placeholder="Apellido Paterno"
                                      aria-label="Apellido Paterno" value="{{ $cliente->apellido_paterno}}" />
                              </div>
                          </div>
                          <div class="col-md-4 mb-4">
                              <div class="input-group">
                                  <input type="text"
                                      class="form-control text-uppercase @error('apellido_materno') is-invalid @enderror"
                                      id="apellido_materno" name="apellido_materno" placeholder="Apellido Materno"
                                      aria-label="Apellido Materno" value="{{ $cliente->apellido_materno }}" />
                              </div>
                             
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
                                      <option {{ $cliente->genero == 'M' ? 'selected' : ''}} value="M">Masculino</option>
                                      <option {{ $cliente->genero == 'F' ? 'selected' : ''}} value="F">Femenino</option>
                                      <option {{ $cliente->genero == 'x' ? 'selected' : ''}} value="x">Indistinto</option>
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
                                          value="{{ $cliente->fecha_nacimiento }}">
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
                                      placeholder="ciudad" value="{{ $cliente->ciudad_nacimiento}}" />
                              </div>
                          </div>
                          <div class="col-md-4 mb-3">
                              <label class="form-label" for="basic-icon-default-phone">Estado</label>
                              <div class="input-group">
                                  <span class="input-group-text">
                                      <i class='bx bx-buildings'></i>
                                  </span>
                                  <select id="estado" name="estado"
                                      class="form-select" onchange="btGenCurp(this.form, '3');">
                                      <option value="">ELIGE UNA OPCIÓN</option>
                                          @foreach($estados_nac as $estado)
                                              <option {{ old('txt_estado_nacimiento') == $estado->clave ? 'selected' : ($opcionEstado != "N/A" ? ($opcionEstado == $estado->clave ? 'selected' : '')  : '') }} value="{{$estado->clave}}">{{$estado->nombre}}</option>
                                          @endforeach
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-4 mb-3">
                              <label class="form-label" for="basic-icon-default">Nacionalidad</label>
                              <div class="input-group">
                                  <span class="input-group-text">
                                      <i class="bx bx-building"></i>
                                  </span>
                                  <input type="text" id="basic-icon-default"
                                      class="form-control text-uppercase" id="nacionalidad" name="nacionalidad"
                                      placeholder="nacionalidad" value="{{ $cliente->nacionalidad}}" />
                              </div>
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
                                      placeholder="CURP" value="{{ $cliente->curp }}" maxlength="18" />
                              </div>

                  
                          </div>
                          <div class="col-md-5 mb-3">
                              <label class="form-label" for="basic-icon-default-email">RFC</label>
                              <div class="input-group">
                                  <span class="input-group-text">
                                      <i class="bx bx-id-card"></i>
                                  </span>
                                  <input type="text" id="basic-icon-default-email"
                                      class="form-control text-uppercase" id="rfc" name="rfc"
                                      placeholder="rfc" value="{{ $cliente->rfc }}" maxlength="13" />
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
                                      <option {{ $cliente->tipo_vivienda == 'PROPIA' ? 'selected' : ''}} value="PROPIA">Propia</option>
                                      <option {{ $cliente->tipo_vivienda == 'RENTADA' ? 'selected' : ''}} value="RENTADA">Rentada</option>
                                      <option {{ $cliente->tipo_vivienda == 'FAMILIAR' ? 'selected' : ''}} value="FAMILIAR">Familiar</option>
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
                                  class="form-control text-uppercase" placeholder="Dirección"  value="{{ $cliente->direccion}}">
                              </div>
                          </div>
                          <div class="col-md-3 mb-3">
                              <label class="form-label" for="basic-icon-default">Años de Residencia</label>
                              <div class="input-group">
                                  <input name="residencia" id="residencia" type="text" value="{{ $cliente->anios_residencia}}" id="basic-icon-default" class="form-control" placeholder="Años">
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
                                          <option {{ $cliente->tipo_vialidad == 'Ampliacion' ? 'selected' : ''}} value="Ampliacion">Ampliación</option>
                                          <option {{ $cliente->tipo_vialidad == 'Andador' ? 'selected' : ''}} value="Andador">Andador</option>
                                          <option {{ $cliente->tipo_vialidad == 'Avenida' ? 'selected' : ''}} value="Avenida">Avenida</option>
                                          <option {{ $cliente->tipo_vialidad == 'Boulevard' ? 'selected' : ''}} value="Boulevard">Boulevard</option>
                                          <option {{ $cliente->tipo_vialidad == 'Calle' ? 'selected' : ''}} value="Calle">Calle</option>
                                          <option {{ $cliente->tipo_vialidad == 'Callejon' ? 'selected' : ''}} value="Callejon">Callejon</option>
                                          <option {{ $cliente->tipo_vialidad == 'Calzada' ? 'selected' : ''}} value="Calzada">Calzada</option>
                                          <option {{ $cliente->tipo_vialidad == 'Cerrada' ? 'selected' : ''}} value="Cerrada">Cerrada</option>
                                          <option {{ $cliente->tipo_vialidad == 'Circuito' ? 'selected' : ''}} value="Circuito">Circuito</option>
                                          <option {{ $cliente->tipo_vialidad == 'Circumbalacion' ? 'selected' : ''}} value="Circumbalacion">Circumbalación</option>
                                          <option {{ $cliente->tipo_vialidad == 'Continuacion' ? 'selected' : ''}} value="Continuacion">Continuación</option>
                                          <option {{ $cliente->tipo_vialidad == 'Corredor' ? 'selected' : ''}} value="Corredor">Corredor</option>
                                          <option {{ $cliente->tipo_vialidad == 'Diagonol' ? 'selected' : ''}} value="Diagonol">Diagonol</option>
                                          <option {{ $cliente->tipo_vialidad == 'Eje Vial' ? 'selected' : ''}} value="Eje Vial">Eje Vial</option>
                                          <option {{ $cliente->tipo_vialidad == 'Pasaje' ? 'selected' : ''}} value="Pasaje">Pasaje</option>
                                          <option {{ $cliente->tipo_vialidad == 'Peatonal' ? 'selected' : ''}} value="Peatonal">Peatonal</option>
                                          <option {{ $cliente->tipo_vialidad == 'Periferico' ? 'selected' : ''}} value="Periferico">Periferico</option>
                                          <option {{ $cliente->tipo_vialidad == 'Privada' ? 'selected' : ''}} value="Privada">Privada</option>
                                          <option {{ $cliente->tipo_vialidad == 'Prolongacion' ? 'selected' : ''}} value="Prolongacion">Prolongación</option>
                                          <option {{ $cliente->tipo_vialidad == 'Retorno' ? 'selected' : ''}} value="Retorno">Retorno</option>
                                          <option {{ $cliente->tipo_vialidad == 'Viaducto' ? 'selected' : ''}} value="Viaducto">Viaducto</option>
                                  </select>
                              </div>
                          </div>

                          <div class="col-md-8 mb-3">
                              <label class="form-label" for="basic-icon-default">Entre Calles</label>
                              <div class="input-group">
                                  <span class="input-group-text">
                                      <i class='bx bx-directions'></i>
                                  </span>
                                  <input type="text" id="entre_calles" name="entre_calles" id="basic-icon-default"
                                  class="form-control text-uppercase" placeholder="Entre Calles" value="{{ $cliente->entre_calles}}">
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
                                  class="form-control text-uppercase" placeholder="Referencias" value="{{ $cliente->referencia}}">
                              </div>
                          </div>
                          <div class="col-md-3 mb-3">
                              <label class="form-label" for="basic-icon-default">Codigo Postal</label>
                              <div class="input-group" id="theCp">
                                  <span class="input-group-text">
                                      <i class="bx bx-barcode"></i>
                                  </span>
                                  <input type="text" oninput="buscarCodigoPostal()" id="cp" name="cp" class="form-control" placeholder="Codigo Postal" value="{{ $cliente->cp}}">
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-4 mb-3">
                              <div class="form-group" id="theSuburb">
                                  <label class="form-label" for="basic-icon-default" for="txt_colonia">COLONIA</label>
                                  <select name="txt_colonia" id="txt_colonia" class="form-select text-uppercase theSuburbs" required>
                                      <option value="{{ $cliente->colonia }}">{{ $cliente->colonia }}</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-4 mb-3">
                              <div class="form-group" id="theCity">
                                  <label class="form-label" for="basic-icon-default" for="txt_ciudad">CIUDAD</label>
                                  <input type="text" id="txt_ciudad" name="txt_ciudad" class="form-control" placeholder="Ciudad" value="{{ $cliente->ciudad}}">
                              </div>
                          </div>
                          <div class="col-md-4 mb-3">
                              <div class="form-group" id="theState">
                                  <label class="form-label" for="basic-icon-default" for="txt_estado">ESTADO</label>
                                  <input type="text" id="txt_estado" name="txt_estado" class="form-control" placeholder="Estado" value="{{ $cliente->estado}}">
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
                                      value="{{ $cliente->celular}}" />
                              </div>
                          </div>
                          <div class="col-md-4 mb-3">
                              <label class="form-label" for="basic-icon-default-phone">Fecha de Alta</label>
                              <div class="input-group">
                                  <span class="input-group-text">
                                      <i class='bx bx-calendar-event'></i>
                                  </span>
                                  <input type="date" name="fecha_alta"
                                      class="form-control"
                                      value="{{ $cliente->fecha_alta}}" />
                              </div>
                          </div>
                          <div class="col-md-4 mb-3">
                              <label class="form-label" for="basic-icon-default-phone">Escolaridad</label>
                              <div class="input-group">
                                  <span class="input-group-text">
                                      <i class="bx bx-filter"></i>
                                  </span>
                                  <select name="escolaridad" class="form-select">
                                      <option {{ $cliente->escolaridad == 'NINGUNA' ? 'selected' : ''}} value="NINGUNA">Ninguna</option>
                                      <option {{ $cliente->escolaridad == 'LEER Y ESCRIBIR' ? 'selected' : ''}} value="LEER Y ESCRIBIR">Leer y Escribir</option>
                                      <option {{ $cliente->escolaridad == 'PREESCOLAR' ? 'selected' : ''}} value="PREESCOLAR">Preescolar</option>
                                      <option {{ $cliente->escolaridad == 'PRIMARIA' ? 'selected' : ''}} value="PRIMARIA">Primaria</option>
                                      <option {{ $cliente->escolaridad == 'SECUNDARIA' ? 'selected' : ''}} value="SECUNDARIA">Secundaria</option>
                                      <option {{ $cliente->escolaridad == 'PREPARATORIA' ? 'selected' : ''}} value="SOCIO FUNDADOR">Preparatoria</option>
                                      <option {{ $cliente->escolaridad == 'LICENCIATURA' ? 'selected' : ''}} value="LICENCIATURA">Licenciatura</option>
                                      <option {{ $cliente->escolaridad == 'MAESTRIA' ? 'selected' : ''}} value="MAESTRIA">Maestria</option>
                                      <option {{ $cliente->escolaridad == 'DOCTORADO' ? 'selected' : ''}} value="DOCTORADO">Doctorado</option>
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
                                      placeholder="Profesión" value="{{ $cliente->profesion}}" />
                              </div>

                          </div>
                          <div class="col-md-4 mb-3">
                              <label class="form-label" for="basic-icon-default-phone">Religión</label>
                              <div class="input-group">
                                  <span class="input-group-text">
                                      <i class="bx bx-church"></i>
                                  </span>
                                  <select name="religion" class="form-select">
                                      <option {{ $cliente->religion == 'SIN RELIGION' ? 'selected' : ''}} value="SIN RELIGION">Sin Religion</option>
                                      <option {{ $cliente->religion == 'CRISTIANISMO' ? 'selected' : ''}} value="CRISTIANISMO">Cristianismo</option>
                                      <option {{ $cliente->religion == 'BUDISMO' ? 'selected' : ''}} value="BUDISMO">Budismo</option>
                                      <option {{ $cliente->religion == 'HINDUISMO' ? 'selected' : ''}} value="HINDUISMO">Hinduismo</option>
                                      <option {{ $cliente->religion == 'TESTIGO DE JEHOVA' ? 'selected' : ''}} value="TESTIGO DE JEHOVA">Testigo de Jehova</option>
                                      <option {{ $cliente->religion == 'PRESBISTERIANA' ? 'selected' : ''}} value="PRESBISTERIANA">Presbiteriana</option>
                                      <option {{ $cliente->religion == 'CATOLICA' ? 'selected' : ''}} value="CATOLICA">Catolica</option>
                                      <option {{ $cliente->religion == 'PROTESTANTE' ? 'selected' : ''}} value="PROTESTANTE">Protestante</option>
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
                                      <option {{ $cliente->estado_civil == 'SOLTERO(A)' ? 'selected' : ''}} value="SOLTERO(A)">Soltera</option>
                                      <option {{ $cliente->estado_civil == 'CASADO(A)' ? 'selected' : ''}} value="CASADO(A)">Casada</option>
                                      <option {{ $cliente->estado_civil == 'UNION LIBRE' ? 'selected' : ''}} value="UNION LIBRE">Union Libre</option>
                                      <option {{ $cliente->estado_civil == 'DIVORCIADO(A)' ? 'selected' : ''}} value="DIVORCIADO(A)">Divorciada</option>
                                      <option {{ $cliente->estado_civil == 'VIUDO(A)' ? 'selected' : ''}} value="VIUDO(A)">Viuda</option>
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
                                      placeholder="clave de elector" value="{{ $cliente->clave_elector}}" maxlength="18" />
                              </div>
                          </div>
                          <div class="col-md-2 mb-3">
                              <label class="form-label" for="basic-icon-default">Vencimiento</label>
                              <div class="input-group">
                                  <input name="vencimiento" id="vencimiento" type="number" maxlength="4" value="{{ $cliente->anio_vencimiento_ine}}" id="basic-icon-default" class="form-control" placeholder="Año">
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
                                      placeholder="Folio" value="{{ $cliente->folio_ine}}" maxlength="20" />
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
                                      placeholder="ocr" value="{{ $cliente->ocr}}" maxlength="13" />
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
                                      placeholder="N° tarjeta" value="{{ $cliente->numero_tarjeta}}" maxlength="16" />
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
                                      placeholder="N° de Cuenta" value="{{ $cliente->numero_cuenta}}" maxlength="20" />
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
                                      placeholder="Clabe Interbancaria" value="{{ $cliente->clave_interbancaria}}" maxlength="18" />
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
                                      placeholder="Banco" value="{{ $cliente->banco}}" />
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
                                          <option {{ old('cuenta') == $cuenta->id ? 'selected' : ($opcionCuenta != "N/A" ? ($opcionCuenta == $cuenta->id ? 'selected' : '')  : '') }} value="{{$cuenta->id}}">{{$cuenta->nombre_cuenta}}</option>
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
                                          <option {{ old('asociado') == $asociado->id ? 'selected' : ($personAsociado != "N/A" ? ($personAsociado == $asociado->id ? 'selected' : '')  : '') }} value="{{$asociado->id}}">{{$asociado->getFullname()}}</option>
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
                                          <option {{ old('aval') == $aval->id ? 'selected' : ($personAval != "N/A" ? ($personAval == $aval->id ? 'selected' : '')  : '') }} value="{{$aval->id}}">{{$aval->getFullname()}}</option>
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
            <div class="tab-pane fade {{$activeRShow}}" id="navReferencia" role="tabpanel">
              <div class="table-responsive text-start">
                <div class="col-lg-11 mx-auto">
                  <form method="POST" action="{{ route('admin.addreferencias', $cliente->id) }}" autocomplete="off">
                      @csrf
                      <input type="hidden" id="idReferencia" name="idReferencia" value="0">
                      <input type="hidden" id="idClienteRef" name="idClienteRef" value="0">
                      <div class="row">
                          <label class="form-label" for="basic-icon-default-company">Nombre Completo</label>
                          <div class="col-md-4 mb-4">
                              <div class="input-group">
                                  <span id="basic-icon-default-company2" class="input-group-text">
                                      <i class='bx bx-user'></i>
                                  </span>
                                  <input type="text"
                                      class="form-control text-uppercase"
                                      id="nombre_ref" name="nombre_ref" placeholder="Nombres"
                                      aria-label="Nombres" />
                              </div>
                          </div>
                          <div class="col-md-4 mb-4">
                              <div class="input-group">
                                  <input type="text"
                                      class="form-control text-uppercase"
                                      id="apellido_paterno_ref" name="apellido_paterno_ref" placeholder="Apellido Paterno"
                                      aria-label="Apellido Paterno" />
                              </div>
                          </div>
                          <div class="col-md-4 mb-4">
                              <div class="input-group">
                                  <input type="text" class="form-control text-uppercase" id="apellido_materno_ref" name="apellido_materno_ref" placeholder="Apellido Materno" aria-label="Apellido Materno" />
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-4 mb-3">
                              <label class="form-label" for="basic-icon-default-email">Parentesco</label>
                              <div class="input-group">
                                  <span class="input-group-text">
                                      <i class="fa fa-venus-mars"></i>
                                  </span>
                                  <select id="parentesco_ref" name="parentesco_ref" class="form-select">
                                      <option>-- Elíge --</option>
                                      <option>HIJO(A)</option>
                                      <option>PADRE</option>
                                      <option>MADRE</option>
                                      <option>ESPOSO(A)</option>
                                      <option>HERMANO(A)</option>
                                      <option>ABUELO(A)</option>
                                      <option>NIETO(A)</option>
                                      <option>SOBRINO(A)</option>
                                      <option>YERNO</option>
                                      <option>NUERA</option>
                                      <option>CUÑADO(A)</option>
                                      <option>TIO(A)</option>
                                      <option>PRIMO(A)</option>
                                      <option>CONOCIDO(A)</option>
                                  </select>
                              </div>
                          </div>
                          <div class="mb-3 col-md-4">
                            <label for="" class="form-label">Célular</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bx bx-phone"></i>
                                </span>
                                <input type="text" id="celular_ref" name="celular_ref"
                                    class="form-control" placeholder="TELÉFONO" maxlength="10"
                                    onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
                                    value="" />
                            </div>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label class="form-label" for="basic-icon-default-email">Tipo</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class='bx bx-filter'></i>
                                </span>
                                <select id="tipo_ref" name="tipo_ref" class="form-select">
                                  <option>FAMILIAR</option>
                                  <option>COMERCIAL</option>
                                </select>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="basic-icon-default">Dirección</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bx bx-map"></i>
                                </span>
                                <input type="text" id="direccion_ref" name="direccion_ref" id="basic-icon-default"
                                class="form-control text-uppercase" placeholder="Dirección">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="basic-icon-default">Entre Calles</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class='bx bx-directions'></i>
                                </span>
                                <input type="text" id="entre_calles_ref" name="entre_calles_ref" id="basic-icon-default"
                                class="form-control text-uppercase" placeholder="Entre Calles">
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-2 mb-3">
                            <label class="form-label" for="basic-icon-default">Codigo Postal</label>
                            <div class="input-group" id="theCpRef">
                                <span class="input-group-text">
                                    <i class="bx bx-barcode"></i>
                                </span>
                                <input type="text" oninput="buscarCodigoPostalRef()" id="cp_ref" name="cp_ref" class="form-control" placeholder="Codigo Postal" value="">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group" id="theSuburbRef">
                                <label class="form-label" for="basic-icon-default" for="txt_colonia_ref">COLONIA</label>
                                <select name="txt_colonia_ref" id="txt_colonia_ref" class="form-select text-uppercase theSuburbs" required>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group" id="theCityRef">
                                <label class="form-label" for="basic-icon-default" for="txt_ciudad_ref">CIUDAD</label>
                                <input type="text" id="txt_ciudad_ref" name="txt_ciudad_ref" class="form-control" placeholder="Ciudad">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group" id="theStateRef">
                                <label class="form-label" for="basic-icon-default" for="txt_estado_ref">ESTADO</label>
                                <input type="text" id="txt_estado_ref" name="txt_estado_ref" class="form-control" placeholder="Estado">
                            </div>
                        </div>
                      </div>
                      <div class="row">
                          <div class="col-md-9 mb-3">
                            <label class="form-label" for="basic-icon-default">Referencia del Domicilio</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class='bx bx-health'></i>
                                </span>
                                <input type="text" id="referencia_ref" name="referencia_ref" id="basic-icon-default"
                                class="form-control text-uppercase" placeholder="Referencias">
                            </div>
                          </div>
                          <div class="col-md-3 mb-3">
                            <button type="submit" class="btn btn-sm btn-primary" style="margin-top: 34;">
                              <i class="bx bx-plus"></i>
                              <span class="align-middle">Agregar Referencia</span>
                            </button>
                          </div>
                      </div>
                  </form>
                  <div class="table-responsive">
                    <table class="table border-top">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>NOMBRE</th>
                          <th>PARENTESCO</th>
                          <th>TIPO</th>
                          <th>ACCIÓN</th>
                        </tr>
                      </thead>
                      @if (!empty($referencias))
                          <tbody>
                                  @php
                                      $cont = 0;
                                  @endphp
                              @foreach($referencias as $referencia)
                                  @php
                                      $cont ++;
                                  @endphp
                              <tr>
                                  <td>{{ $cont }}.</td>
                                  <td>{{ $referencia->getFullName() }}</td>
                                  <td>{{ $referencia->parentesco}}</td>
                                  <td>{{ $referencia->tipo_referencia}}</td>
                                  <td><a href="#" class="badge bg-info" title="Click para editar" onclick="cargarReferencia('{{ $referencia->id }}')">Editar</a></td>
                              </tr>
                              @endforeach
                          </tbody>
                      @endif
                    </table>
                  </div>
                </div>
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

    function buscarCodigoPostalRef() {
        cp = $('#cp_ref').val();
        if(cp.length == 5){
            $.ajax({
                type: "POST",
                url: "{{ url('/api/checkCp') }}",
                data: {
                    cp : cp
                },
                success:function(data){
                    $(".theSuburbsRef").empty().trigger('change');
                    if(data != 'Resultado no encontrado'){
                        cpErrorRef = 0;
                        $('#cp_ref').removeClass('is-invalid');
                        $('#cp_ref').addClass('is-valid');
                        $('#cpErrorRef').remove();
                        $('#txt_ciudad_ref').val(data.Ciudad);
                        $('#txt_estado_ref').val(data.Estado);
                        let theSuburbsRef = data.Asentamiento;
                        var data = {};

                        theSuburbsRef.forEach(function(theCurrentSuburbRef){
                            data.id = theCurrentSuburbRef;
                            data.text = theCurrentSuburbRef;
                            var newOption = new Option(data.text, data.id, false, false);
                            $('#txt_colonia_ref').append(newOption).trigger('change');
                        });
                    }
                    else {
                        cpErrorRef = 1;
                        $('#cp_ref').addClass('is-invalid');
                        $('#cpErrorRef').remove();
                        $('#theCpRef').append('<span class="invalid-feedback" id="cpErrorRef" role="alert"><strong>No se ha encontrado ese C.P.</strong></span>');
                    }
                }
            });
        }
        else {
            $('#cp_ref').addClass('is-invalid');
            $('#cpErrorRef').remove();
            $('#theCpRef').append('<span class="invalid-feedback" id="cpErrorRef" role="alert"><strong>El código postal debe contener 5 números.</strong></span>');
        }
    };

    function cargarReferencia(idRef){
        $.ajax({
            url: "{{ asset('admin/clientes/datosReferencia') }}/" + idRef,
            type: 'get',
            cache: false,
            beforeSend(){

            },
            success: function(data){
                console.log(data);
                $('#idReferencia').val(data.referencia.id);
                $('#idClienteRef').val(data.referencia.clientes_id);
                $('#nombre_ref').val(data.referencia.nombre);
                $('#apellido_paterno_ref').val(data.referencia.apellido_paterno);
                $('#apellido_materno_ref').val(data.referencia.apellido_materno);
                $('#parentesco_ref').val(data.referencia.parentesco);
                $('#celular_ref').val(data.referencia.telefono);
                $('#tipo_ref').val(data.referencia.tipo_referencia);
                $('#direccion_ref').val(data.referencia.direccion);
                $('#entre_calles_ref').val(data.referencia.entre_calles);
                $('#cp_ref').val(data.referencia.cp);
                $('#txt_colonia_ref').append($('<option>').val(data.referencia.colonia).text(data.referencia.colonia));
                $('#txt_ciudad_ref').val(data.referencia.ciudad);
                $('#txt_estado_ref').val(data.referencia.estado);
                $('#referencia_ref').val(data.referencia.referencia);

            }
        });
    }

</script>

