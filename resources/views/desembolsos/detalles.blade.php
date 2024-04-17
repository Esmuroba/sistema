@extends('layouts.app')

@section('title', 'Desembolso')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Tesorería / </span>Desembolso</h4>
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="card invoice-preview-card">  
                            <div class="card-body">
                                <span class="h5 text-capitalize mb-0 text-nowrap"><i class='bx bxs-user'></i> {{$credito->solicitud->cliente->getFullname()}}</span>
                                
                                <div class="row p-sm-3 p-0">
                                    <div class="col-xl-4 col-md-12">
                                        <b>Vialidad: </b><span class="mb-0" id="vialidad">{{ $credito->solicitud->cliente->tipo_vialidad}}</span><br>
                                        <b>Dirección: </b><span class="mb-0">{{ $credito->solicitud->cliente->direccion}}</span><br>
                                        <b>Entre Calles: </b><span class="mb-0">{{ $credito->solicitud->cliente->entre_calles}}</span><br>
                                        <b>C.P.: </b><span class="mb-0">{{ $credito->solicitud->cliente->cp}}</span><br>
                                        <b>Colonia/Ciudad/Estado: </b><span class="mb-0">{{ $credito->solicitud->cliente->colonia}},{{ $credito->solicitud->cliente->ciudad}}, {{ $credito->solicitud->cliente->estado}}</span><br>
                                    </div>
                                    <div class="col-xl-4 col-md-12">
                                        <b>Operador: </b><span class="mb-0">{{$credito->solicitud->asociado->operadores->getFullname()}}</span><br>
                                        <b>Producto: </b><span class="mb-0">{{ $credito->solicitud->producto->nombre}}</span><br>
                                        <b>Plazo: </b><span class="mb-0">{{ $credito->solicitud->plazo}}</span><br>
                                        <b>Tasa: </b><span class="mb-0">{{ $credito->solicitud->tasa}} %</span><br>
                                        <b>Monto Autorizado: </b><span class="mb-0 text-success"><b>{{ number_format($credito->monto_autorizado,2,'.',',') }}</b></span><br>
                                    </div>
                                    <div class="col-xl-4 col-md-12">
                                        <b>Fecha Desembolso: </b><span class="mb-0" id="">{{ date('d/m/Y', strtotime($credito->solicitud->fecha_desembolso))}}</span><br>
                                        <b>Num. Tarjeta: </b><span class="mb-0" id="">{{ $credito->solicitud->cliente->numero_tarjeta}}</span><br>
                                        <b>Cuenta: </b><span class="mb-0" id="">{{ $credito->solicitud->cliente->numero_cuenta}}</span><br>
                                        <b>Clabe Interbancaria: </b><span class="mb-0" id="">{{ $credito->solicitud->cliente->clave_interbancaria}}</span><br>
                                    </div>
                                
                                </div>
                            </div>   
                        </div>
                        
                            
                            <input type="hidden" id="montoAutorizado" name="montoAutorizado" value="{{$credito->monto_autorizado}}">
                            <input type="hidden" id="idAnalisisCred" name="idAnalisisCred" value="{{$credito->id}}">
                            <input type="hidden" id="idSolicitud" name="idSolicitud" value="{{$credito->solicitud->id}}">
                            <input type="hidden" id="cuota" name="cuota" value="{{$credito->solicitud->cuota}}">
                            <input type="hidden" id="plazo" name="plazo" value="{{$credito->solicitud->plazo}}">
                            <input type="hidden" id="frecuencia_pago" name="frecuencia_pago" value="{{$credito->solicitud->frecuencia_pago}}">
                            <input type="hidden" id="tasa" name="tasa" value="{{$credito->solicitud->tasa}}">
                            <input type="hidden" id="fdesembolso" name="fdesembolso" value="{{$credito->solicitud->fecha_desembolso}}">
                            <input type="hidden" id="monto_autorizado" name="monto_autorizado" value="{{$credito->monto_autorizado}}">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="mb-3" data-repeater-list="group-a">
                                <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
                                    <div class="d-flex border rounded position-relative pe-0">  
                                        <div class="row w-100 m-0 p-3">
                                           
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="basic-icon-default-phone">Tipo Desembolso</label>
                                                    <select class="form-select item-details mb-2" id="tipo_pago" name="tipo_pago" disabled>
                                                        <option>-- Selecciona --</option>
                                                        <option {{ $detalle->tipo_pago == 'Transferencia' ? 'selected' : ''}} value="Transferencia">Transferencia</option>
                                                        <option {{ $detalle->tipo_pago == 'Efectivo' ? 'selected' : ''}} value="Efectivo">Efectivo</option>
                                                        <option {{ $detalle->tipo_pago == 'Cheque' ? 'selected' : ''}} value="Cheque">Cheque</option>
                                                        <option {{ $detalle->tipo_pago == 'Especie' ? 'selected' : ''}} value="Especie">Especie</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label class="form-label" for="basic-icon-default-phone">Fecha Desembolso</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class='bx bx-calendar-event'></i>
                                                        </span>
                                                        <input type="date" id="fdesembolso" name="fdesembolso" class="form-control" value="{{ date($detalle['fecha_pago']) }}" disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="basic-default-message">Concepto</label>
                                                    <textarea id="basic-default-message" id="observaciones" name="observaciones" class="form-control text-uppercase" placeholder="Concepto ..." readonly>{{$detalle->observaciones}}</textarea>
                                                </div>
                                            </div>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <a type="button" class="btn btn-danger" href="{{ route('admin.desembolso.index') }}" data-repeater-create="">Cerrar</a>
                                </div>
                            </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


