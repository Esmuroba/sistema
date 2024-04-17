@extends('layouts.app')

@section('title', 'Analisis')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Autorización / </span>Analisis</h4>
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="card invoice-preview-card">  
                            <div class="card-body">
                                <span class="h5 text-capitalize mb-0 text-nowrap"><i class='bx bxs-user'></i> {{$solicitud->cliente->getFullname()}}</span>
                                
                                <div class="row p-sm-3 p-0">
                                    <div class="col-xl-4 col-md-12">
                                        <b>Vialidad: </b><span class="mb-0" id="vialidad">{{ $solicitud->cliente->tipo_vialidad}}</span><br>
                                        <b>Dirección: </b><span class="mb-0">{{ $solicitud->cliente->direccion}}</span><br>
                                        <b>Entre Calles: </b><span class="mb-0">{{ $solicitud->cliente->entre_calles}}</span><br>
                                        <b>C.P.: </b><span class="mb-0">{{ $solicitud->cliente->cp}}</span><br>
                                        <b>Colonia/Ciudad/Estado: </b><span class="mb-0">{{ $solicitud->cliente->colonia}},{{ $solicitud->cliente->ciudad}}, {{ $solicitud->cliente->estado}}</span><br>
                                    </div>
                                    <div class="col-xl-4 col-md-12">
                                        <b>Asociado: </b><span class="mb-0">{{$solicitud->asociado->getFullname()}}</span><br>
                                        <b>Operador: </b><span class="mb-0">{{$solicitud->asociado->operadores->getFullname()}}</span><br>
                                        <b>Producto: </b><span class="mb-0">{{ $solicitud->producto->nombre}}</span><br>
                                        <b>Plazo: </b><span class="mb-0">{{ $solicitud->plazo}}</span><br>
                                        <b>Tasa: </b><span class="mb-0">{{ $solicitud->tasa}} %</span><br>
                                    </div>
                                    <div class="col-xl-4 col-md-12">
                                        <b>Monto Solicitado: </b><span class="mb-0 text-success"><b>{{ number_format($solicitud->monto_solicitado,2,'.',',') }}</b></span><br>
                                        <b>Ingreso Mensual: </b><span class="mb-0" id="">{{ number_format($solicitud->ingreso_mensual,2,'.',',') }}</span><br>
                                        <b>Capacidad Pago: </b><span class="mb-0" id="">{{ $solicitud->capacidad_pago}}</span><br>
                                        <b>Frecuencia Pago: </b><span class="mb-0" id="">{{ $solicitud->frecuencia_pago}}</span><br>
                                    </div>
                                
                                </div>
                            </div>   
                        </div>
                        <form method="POST" action="{{ route('admin.analisis_credito.store') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" id="idSolicitud" name="idSolicitud" value="{{$solicitud->id}}">
                            <input type="hidden" id="cliente_id" name="cliente_id" value="{{$solicitud->cliente->id}}">
                            <input type="hidden" id="cuota" name="cuota" value="{{$solicitud->cuota}}">
                            <input type="hidden" id="plazo" name="plazo" value="{{$solicitud->producto->plazo}}">
                            <input type="hidden" id="frecuencia_pago" name="frecuencia_pago" value="{{$solicitud->producto->frecuencia_pago}}">
                            <input type="hidden" id="tasa" name="tasa" value="{{$solicitud->producto->tasa}}">
                            <input type="hidden" id="tasa_iva" name="tasa_iva" value="{{$solicitud->producto->tasaIVA}}">
                            <input type="hidden" id="monto_solicitado" name="monto_solicitado" value="{{$solicitud->monto_solicitado}}">
                            <input type="hidden" id="gasto_mensual" name="gasto_mensual" value="{{$solicitud->gasto_mensual}}">
                            <input type="hidden" id="ingreso_mensual" name="ingreso_mensual" value="{{$solicitud->ingreso_mensual}}">
                            <input type="hidden" id="fprimer_pago" name="fprimer_pago" value="">
                            <input type="hidden" id="fvencimiento" name="fvencimiento" value="">
                            <input type="hidden" id="total" name="total" value="">
                            <input type="hidden" id="pago_semanal" name="pago_semanal" value="">
                            <input type="hidden" id="capPago" name="capPago" value="">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="mb-3" data-repeater-list="group-a">
                                <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item="">
                                <div class="d-flex border rounded position-relative pe-0">
                                    <div class="row w-100 m-0 p-3">
                                   
                                    <div class="col-md-4  col-12 mb-md-0 mb-3 ps-md-0">
                                        <label class="form-label" for="basic-icon-default-phone">Fecha Desembolso</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class='bx bx-calendar-event'></i>
                                            </span>
                                            <input type="date" id="fdesembolso" name="fdesembolso" class="form-control" value="{{ date($solicitud->fecha_desembolso) }}"/>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 col-12 mb-md-0 mb-3 ps-md-0">
                                        <label class="form-label" for="">Monto Autorizado</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control"  id="monto_autorizado" name="monto_autorizado" placeholder="100" onkeyup="calcularTablaAmortizacionRiesgo()" onchange="verMontoAutorizado()">
                                            <span class="input-group-text">.00</span>
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
    $.ajaxSetup({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
    });
   function calcularTablaAmortizacionRiesgo(){
    let cuota = document.getElementById("cuota").value;
    let plazo = document.getElementById("plazo").value;
    let tasa = document.getElementById("tasa").value;
    let tasaIva = document.getElementById("tasa_iva").value;
    let frecuencia_pago = document.getElementById("frecuencia_pago").value;
    let monto_solicitado = document.getElementById("monto_solicitado").value;
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
            monto_solicitado : monto_solicitado,
            monto_autorizado : monto_autorizado,
            fecha_desembolso : fecha_desembolso,
            cuota : cuota,
            plazo : plazo,
            tasa : tasa,
            tasaIva : tasaIva,
            frecuencia_pago : frecuencia_pago,
        },
        
        success:function(data){
            console.log(data);
            vistaTablaAmortizacion(data);
            calculoTotal(tasa,plazo,tasaIva);

        }
    });

}

function vistaTablaAmortizacion(tabla) {
    let html = '';
    let ultimoPago = '';
    let primer_pago = new Date(tabla[0].fecha_pago).toISOString().slice(0,10).split('-').reverse().join('/');

    tabla.forEach(fila =>  {
        ultimoPago = fila.fecha_pago;
        var fechaFormateada = new Date(fila.fecha_pago).toISOString().slice(0,10).split('-').reverse().join('/');
        html += '<tr><td>'+fila.mes+'</td><td>'+fechaFormateada+'</td><td>'+fila.cuota+'</td><td>'+fila.capital+'</td><td>'+fila.interes+'</td><td class="text-center">'+fila.saldo+'</td></tr>'
    })
    $("#tablaAmortizacion").html(html);
    $("#fprimer_pago").val(primer_pago);
    $("#fvencimiento").val(ultimoPago);
}


function calculoTotal(tasa,plazo,iva){
    let monto_autorizado = document.getElementById("monto_autorizado").value;
    let ingreso_mensual = document.getElementById("ingreso_mensual").value;
    let gasto_mensual = document.getElementById("gasto_mensual").value;

  
    let intereses = monto_autorizado * (tasa/100);
    let ivaInteres = intereses * (iva/100);

    if (isNaN(monto_autorizado) || isNaN(tasa) || isNaN(plazo)) {
        $("#total").val("")
    }else{   
        let formulaTotal = parseFloat(monto_autorizado) + parseFloat(intereses) + parseFloat(ivaInteres);

        let fPagoSemanal = formulaTotal / plazo;
        let fCapPago = (ingreso_mensual - gasto_mensual) / formulaTotal;

        $("#total").val(formulaTotal)
        $("#pago_semanal").val(fPagoSemanal)
        $("#capPago").val(fCapPago.toFixed(4))
    }
}

</script>

