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
                        
                        <form method="POST" action="{{action('DesembolsoController@store', $credito->id)}}" autocomplete="off">
                            @csrf
                            
                            <input type="hidden" id="montoAutorizado" name="montoAutorizado" value="{{$credito->monto_autorizado}}">
                            <input type="hidden" id="deduccion" name="deduccion" value="{{$pagosP[0]->monto}}">
                            <input type="hidden" id="hidentotalDesembolso" name="hidentotalDesembolso" value="">

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
                                            <div class="col-md-3  col-12 mb-md-0 mb-3 ps-md-0">
                                                <div class="input-group">
                                                    <button class="btn btn-info" type="button" id="button-addon1">Desembolsar</button>
                                                    <input type="text" class="form-control" id="monto_desembolso" name="monto_desembolso" value="{{number_format($credito->monto_autorizado, 2, '.', ',')}}" disabled placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                </div>
                                            </div>
                                            <div class="col-md-3  col-12 mb-md-0 mb-3">
                                                <div class="input-group">
                                                    <button class="btn btn-danger" type="button" id="button-addon1">Pendiente</button>
                                                    <input type="text" class="form-control" id="montoP" name="montoP" placeholder="" value="{{ ($pagosP[0]) ? number_format($pagosP[0]->monto, 2, '.', ',') : '0.00'}}" disabled aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                </div>
                                            </div>
                                            <div class="col-md-3  col-12 mb-md-0 mb-3 ps-md-0">
                                                <div class="input-group">
                                                    <button class="btn btn-warning" type="button" id="button-addon1">Comisión</button>
                                                    <input type="number" class="form-control" id="comision" name="comision"  onkeyup="verTotalDesembolso()" placeholder="0.00" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                </div>
                                            </div>
                                            <div class="col-md-3  col-12 mb-md-0 mb-3 ps-md-0">
                                                <div class="input-group">
                                                    <button class="btn btn-success" type="button" id="button-addon1">Total</button>
                                                    <input type="text" class="form-control" id="totalDesembolso" name="totalDesembolso" disabled="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="basic-icon-default-phone">Tipo Desembolso</label>
                                                    <select class="form-select item-details mb-2" id="tipo_pago" name="tipo_pago" required onchange="cuentaTipoPago()">
                                                        <option>-- Selecciona --</option>
                                                        <option value="Transferencia">Transferencia</option>
                                                        <option value="Efectivo">Efectivo</option>
                                                        <option value="Cheque">Cheque</option>
                                                        <option value="Especie">Especie</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <label class="form-label" for="basic-icon-default-phone">Fecha Desembolso</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class='bx bx-calendar-event'></i>
                                                        </span>
                                                        <input type="date" id="fdesembolso" name="fdesembolso" class="form-control" value="" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div id="cuentaTransferencia" style="display: none">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="basic-icon-default-phone">Cuenta Transferencia</label>
                                                            <select class="form-select item-details mb-2" id="cuenta_transferencia" name="cuenta_transferencia">
                                                                <option>-- Selecciona --</option>
                                                                @foreach($bancos as $banco)
                                                                    <option {{ old('cuenta_transferencia') == $banco->id ? 'selected' : '' }} value="{{$banco->id}}">{{$banco->nombre_cuenta}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="cuentaEfectivo" style="display: none">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">                                            
                                                            <label class="form-label" for="basic-icon-default-phone">Cuenta Efectivo</label>
                                                            <select class="form-select item-details mb-2" id="cuenta_efectivo" name="cuenta_efectivo">
                                                                <option>-- Selecciona --</option>
                                                                @foreach($cuentasCaja as $cuentaC)
                                                                    <option {{ old('cuenta_efectivo') == $cuentaC->id ? 'selected' : '' }} value="{{$cuentaC->cuentas_id}}">{{$cuentaC->nombre_caja}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="cuentaCheque" style="display: none">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="basic-icon-default-phone">Cuenta Cheque</label>
                                                            <select class="form-select item-details mb-2" id="cuenta_cheque" name="cuenta_cheque">
                                                                <option>-- Selecciona --</option>
                                                                @foreach($bancos as $banco)
                                                                    <option {{ old('cuenta_cheque') == $banco->id ? 'selected' : '' }} value="{{$banco->id}}">{{$banco->nombre_cuenta}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="cuentaEspecie" style="display: none">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="basic-icon-default-phone">Cuenta Especie</label>
                                                            <select class="form-select item-details mb-2" id="cuenta_especie" name="cuenta_especie">
                                                                <option>-- Selecciona --</option>
                                                                @foreach($cuentaActivo as $cuentaAct)
                                                                    <option {{ old('cuenta_especie') == $cuentaAct->id ? 'selected' : '' }} value="{{$cuentaAct->cuentas_id}}">{{$cuentaAct->cuentas->nombre_cuenta}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="basic-default-message">Concepto</label>
                                                    <textarea id="basic-default-message" id="observaciones" name="observaciones" class="form-control text-uppercase" placeholder="Concepto ..."></textarea>
                                                </div>
                                            </div>
                                        </div>   
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                <button type="submit" class="btn btn-primary" data-repeater-create="">Guardar</button>
                                </div>
                            </div>
                        </form>
                        <br>

                        <div class="table-responsive">
                            <table class="table border-top m-0">
                              <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Fecha de Pago</th>
                                    <th>Pago</th>
                                    <th>Capital</th>
                                    <th>Interes</th>
                                    <th>Saldo Pendiente</th>
                                    {{-- <th>Gasto por cobranza</th> --}}
                                </tr>
                              </thead>
                              <tbody id="tablaAmortizacion">
                              </tbody>
                            </table>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        verTotalDesembolso();
        calcularTablaAmortizacionRiesgo();
    });
    function verTotalDesembolso(){
        let autorizado = document.getElementById("montoAutorizado").value;
        let pendiente = document.getElementById("deduccion").value;
        let comision = document.getElementById("comision").value;

        let total = autorizado - pendiente - comision;
        $("#hidentotalDesembolso").val(total.toFixed(2));  
        $("#totalDesembolso").val(total.toFixed(2)); 

    }
</script>

<script>
    function cuentaTipoPago() {
        if($("#tipo_pago").val() == "Transferencia"){
            $("#cuentaTransferencia").slideDown('slow');
            $("#cuentaEfectivo").hide(1000);
            $("#cuentaCheque").hide(1000);
            $("#cuentaEspecie").hide(1000);
        }else if($("#tipo_pago").val() == "Efectivo"){
            $("#cuentaEfectivo").slideDown('slow');
            $("#cuentaTransferencia").hide(1000);
            $("#cuentaCheque").hide(1000);
            $("#cuentaEspecie").hide(1000);
        }else if($("#tipo_pago").val() == "Cheque"){
            $("#cuentaCheque").slideDown('slow');
            $("#cuentaEfectivo").hide(1000);
            $("#cuentaTransferencia").hide(1000);
            $("#cuentaEspecie").hide(1000);
        }else if($("#tipo_pago").val() == "Especie"){
            $("#cuentaEspecie").slideDown('slow');
            $("#cuentaTransferencia").hide(1000);
            $("#cuentaEfectivo").hide(1000); 
            $("#cuentaCheque").hide(1000);
        }else{
            $("#cuentaTransferencia").hide(1000);
            $("#cuentaEfectivo").hide(1000); 
            $("#cuentaCheque").hide(1000);
            $("#cuentaEspecie").hide(1000);

        }
    }


function calcularTablaAmortizacionRiesgo(){
    let cuota = document.getElementById("cuota").value;
    let plazo = document.getElementById("plazo").value;
    let tasa = document.getElementById("tasa").value;
    let frecuencia_pago = document.getElementById("frecuencia_pago").value;
    let monto_autorizado = document.getElementById("monto_autorizado").value;
    let fecha_desembolso = document.getElementById("fdesembolso").value;
    csrfc = $('meta[name="csrf-token"]').attr('content')

    $.ajax({
        type: 'POST',
        url: "{{ asset('admin/analisis_credito/detalleTablaAmortizacion') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType:"json",
        data: {
            _token: csrfc,
            monto_autorizado : monto_autorizado,
            fecha_desembolso : fecha_desembolso,
            cuota : cuota,
            plazo : plazo,
            tasa : tasa
        },
        
        success:function(data){
            console.log(data);
            vistaTablaAmortizacion(data);
        }
    });


    function vistaTablaAmortizacion(tabla) {
        let html = '';
        tabla.forEach(fila =>  {
            ultimoPago = fila.fecha_pago;
            var fechaFormateada = new Date(fila.fecha_pago).toISOString().slice(0,10).split('-').reverse().join('/');
            html += '<tr><td>'+fila.mes+'</td><td>'+fechaFormateada+'</td><td>'+fila.cuota+'</td><td>'+fila.capital+'</td><td>'+fila.interes+'</td><td class="text-center">'+fila.saldo+'</td></tr>'
        })
        $("#tablaAmortizacion").html(html);
    }
  }

</script>

