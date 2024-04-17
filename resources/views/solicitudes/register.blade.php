@extends('layouts.app')

@section('title', 'Registrar Solicitud')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">/ Captación / Solicitudes / </span>Nueva Solicitud</h4>
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                {{-- <div class="card-header d-flex justify-content-center align-items-center">
                    <h5 class="mb-0">Nueva Solicitud</h5>
                </div> --}}
                <div class="card-body">
                    <div class="row">
                        <form method="POST" action="{{ route('admin.solicitud.store') }}" autocomplete="off">
                        @csrf
                        <div class="col-xl-12 col-md-8 col-12 mb-md-0 mb-4">
                            <input type="hidden" id="idCliente" name="idCliente">
                            <input type="hidden" id="idAsociado" name="idAsociado">
                            <input type="hidden" id="idOperador" name="idOperador">
                            <div class="row">
                                <div class="col-md-7 ">
                                    <p class="mb-2">Realiza la busqueda del Cliente para cargar sus datos:</p>
                                    <select id="nombre_cliente" name="nombre_cliente" required class="form-select mb-4" onchange="cargarDetalles();ejecutaFunciones();">
                                        <option value="">Selecciona</option>
                                        @foreach($clientes as $cliente)
                                            <option {{ old('nombre_cliente') == $cliente->id ? 'selected' : '' }} value="{{$cliente->id}}">{{$cliente->getFullname()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5 ">
                                    <div class="mb-2">
                                        <span class="me-1"><b>Asociado:</b></span>
                                        <span id="name_asociado" class="fw-medium"></span>
                                    </div>
                                <div>
                                    <span class="me-1"><b>Operador:</b></span>
                                    <span id="name_operador" class="fw-medium"></span>
                                </div>
                            </div>
                        </div>
                            
                        <div class="card invoice-preview-card">  
                            <div class="card-body">
                            <div class="row p-sm-3 p-0">
                                <div class="col-xl-6 col-md-12 col-sm-5 col-12">
                                    <h6 class="pb-2">Datos de la Dirección:</h6>
                                    <b>Vialidad: </b><span class="mb-0" id="vialidad"></span><br>
                                    <b>Dirección: </b><span class="mb-0" id="direccion"></span><br>
                                    <b>Entre Calles: </b><span class="mb-0" id="entre_calles"></span><br>
                                    <b>C.P.: </b><span class="mb-0" id="cp"></span><br>
                                    <b>Colonia/Ciudad/Estado: </b><span class="mb-0" id="colonia"></span><br>
                                </div>
                                <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                                    <h6 class="pb-2">Detalles:</h6>
                                    <table>
                                    <tbody>
                                        <tr>
                                        <td class="pe-3">Edad:</td>
                                        <td id="edad"></td>
                                        </tr>
                                        <tr>
                                        <td class="pe-3">Género:</td>
                                        <td id="genero"></td>
                                        </tr>
                                        <tr>
                                        <td class="pe-3">Celular:</td>
                                        <td id="celular"></td>
                                        </tr>
                                        <tr>
                                        <td class="pe-3">Escolaridad:</td>
                                        <td id="escolaridad"></td>
                                        </tr>
                                        <tr>
                                        <td class="pe-3">Profesión:</td>
                                        <td id="profesion"></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Tipo de Negocio</p>
                                    <input type="text" class="form-control text-uppercase invoice-item-price mb-2" id="tipo_negocio" name="tipo_negocio" placeholder="Tipo de Negocio" required>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Antiguedad del Negocio</p>
                                    <input type="text" class="form-control text-uppercase invoice-item-price mb-2" id="antiguedad_negocio" name="antiguedad_negocio" placeholder="Antiguedad" required>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Años de Experiencia</p>
                                    <input type="text" class="form-control text-uppercase invoice-item-price mb-2" id="anios_exp" name="anios_exp" placeholder="Años">
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Tipo de Establecimiento</p>
                                    <select class="form-select item-details mb-2" id="establecimiento" name="establecimiento">
                                        <option value="Propio">Propio</option>
                                        <option value="Ambulante">Ambulante</option>
                                        <option value="Rentado">Rentado</option>
                                        <option value="Fijo">Fijo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <p class="mb-2 repeater-title">Dirección</p>
                                    <input type="text" class="form-control text-uppercase invoice-item-price mb-2" id="direccion" name="direccion" placeholder="Dirección" required>
                                </div>
                                <div class="col-md-5">
                                    <p class="mb-2 repeater-title">Entre Calles</p>
                                    <input type="text" class="form-control text-uppercase invoice-item-price mb-2" id="entre_calles" name="entre_calles" placeholder="Entre Calles" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <p class="mb-2 repeater-title">Codigo Postal</p>
                                    <div class="input-group" id="theCp">
                                        <span class="input-group-text">
                                            <i class="bx bx-barcode"></i>
                                        </span>
                                        <input type="text" onchange="buscarCodigoPostal()" id="codigo_postal" name="codigo_postal"
                                        class="form-control" placeholder="C.P.">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group" id="theSuburb">
                                        <p class="mb-2 repeater-title">Colonia</p>
                                        <select name="txt_colonia" id="txt_colonia" class="form-select text-uppercase theSuburbs" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group" id="theCity">
                                        <p class="mb-2 repeater-title">Ciudad</p>
                                        <input type="text" id="txt_ciudad" name="txt_ciudad" class="form-control" placeholder="Ciudad">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group" id="theState">
                                        <p class="mb-2 repeater-title">Estado</p>
                                        <input type="text" id="txt_estado" name="txt_estado" class="form-control" placeholder="Estado">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Número de Hijos</p>
                                    <input type="text" class="form-control text-uppercase invoice-item-price mb-2" id="num_hijos" name="num_hijos" placeholder="Num. Hijos">
                                </div>
                                <div class="col-md-9">
                                    <p class="mb-2 repeater-title">Garantía</p>
                                    <input type="text" class="form-control text-uppercase invoice-item-price mb-2" id="garantia" name="garantia" placeholder="Garantía">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                <p class="mb-2 repeater-title">Tipo de Cliente</p>
                                    <select class="form-select item-details mb-2" id="tipo_cliente" name="tipo_cliente">
                                        <option value="NUEVO">NUEVO</option>
                                        <option value="PB">PB</option>
                                        <option value="PBI">PBI</option>
                                        <option value="FB">FB</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                <p class="mb-2 repeater-title">Dependientes Economicos</p>
                                <input type="text" class="form-control invoice-item-price mb-2" id="dependientes_economicos" name="dependientes_economicos" placeholder="Dependientes Economicos" required maxlength="3">
                                </div>
                                <div class="col-md-3">
                                <p class="mb-2 repeater-title">Ingreso Mensual</p>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control"  id="ingreso_mensual" name="ingreso_mensual" placeholder="100" aria-label="Amount (to the nearest dollar)" onchange="capacidadPago()">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <p class="mb-2 repeater-title">Gasto Mensual</p>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control"  id="gasto_mensual" name="gasto_mensual" placeholder="100" aria-label="Amount (to the nearest dollar)" onchange="capacidadPago()">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Producto</p>
                                    <select class="form-select item-details mb-2" id="producto" name="producto" onchange="cargarProducto();">
                                        <option value="">Selecciona</option>
                                        @foreach($productos as $producto)
                                            <option {{ old('producto') == $producto->id ? 'selected' : '' }} value="{{$producto->id}}">{{$producto->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Tasa</p>
                                    <input type="text" class="form-control invoice-item-price mb-2" id="tasa" name="tasa" placeholder="Tasa" readonly>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Plazo</p>
                                    <input type="text" class="form-control invoice-item-price mb-2" id="plazo" name="plazo" placeholder="Plazo" readonly>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Frecuencia Pago</p>
                                    <input type="text" class="form-control invoice-item-price mb-2" id="frecuencia_pago" name="frecuencia_pago" placeholder="Frecuencia Pago" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Ciclo</p>
                                    <input type="text" class="form-control invoice-item-price mb-2" id="ciclo" name="ciclo" placeholder="Ciclo">
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Monto Solicitado</p>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control"  id="monto_solicitado" name="monto_solicitado" placeholder="100" onchange="capacidadPago(); calcularCuota();">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Capacidad de Pago</p>
                                    <input type="text" class="form-control invoice-item-price mb-2" id="capacidad_pago" name="capacidad_pago" placeholder="Capacidad de Pago" readonly>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-2 repeater-title">Cuota</p>
                                    <input type="text" class="form-control invoice-item-price mb-2" id="cuota" name="cuota" placeholder="Cuota" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-icon-default-phone">Fecha Solicitud</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class='bx bx-calendar-event'></i>
                                        </span>
                                        <input type="date" id="fsolicitud" name="fsolicitud" class="form-control" value="{{ date('Y-m-d') }}" onchange="calculaFechDesemb(); calculaFechaPpago(); calculaFechaVenc();" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-icon-default-phone">Fecha de Desembolso</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class='bx bx-calendar-event'></i>
                                        </span>
                                        <input type="date" id="fdesembolso" name="fdesembolso" class="form-control" value="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-icon-default-phone">Fecha de Primer Pago</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class='bx bx-calendar-event'></i>
                                        </span>
                                        <input type="date" id="fprimer_pago" name="fprimer_pago" class="form-control" value="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="basic-icon-default-phone">Fecha de Vencimiento</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class='bx bx-calendar-event'></i>
                                        </span>
                                        <input type="date" id="fvencimiento" name="fvencimiento" class="form-control" value="" />
                                    </div>
                                </div>
                            </div>
                            </div> 
                        </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">Guardar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function ejecutaFunciones(){
        calculaFechDesemb();
        calculaFechaPpago();
        calculaFechaVenc();
    }

    function cargarProducto(id){
        id = document.getElementById("producto").value;
        $.ajax({
            url: 'productos/' + id,
            type: 'get',
            cache: false,
            beforeSend(){

            },
            success: function(data){
                
               console.log(data.products);
               let tasa = parseFloat(data.products.tasa);
               let iva = parseFloat((data.products.tasaIVA)/100) * tasa;
               let tasaInteres = tasa * iva;
                $('#tasa').val(tasa + iva);
                $('#plazo').val(data.products.plazo);
                $('#frecuencia_pago').val(data.products.frecuencia_pago);     
                calcularCuota();           
            }
        });
       
    }

    function calcularCuota(){
        var monto_solicitado = document.getElementById('monto_solicitado').value;
        let tasa = $("#tasa").val();
        let plazo = $("#plazo").val();
        let porcentaje = tasa * (1/100);
        $('#cuota').html('');

        if (monto_solicitado === '' || tasa === '' || plazo === '') {
            $("#cuota").val("")
        }else{   
            let formulaCuota = ((monto_solicitado * porcentaje) + monto_solicitado) / plazo
            let saldoPendiente= ((monto_solicitado * porcentaje) + monto_solicitado)
            let resultado2 = formulaCuota.toFixed(2)
            $("#cuota").val(resultado2)
        }

    }

    function capacidadPago(){
        var ingreso = document.getElementById('ingreso_mensual').value;
        var gasto_mensual = document.getElementById('gasto_mensual').value;
        var monto_solic = document.getElementById('monto_solicitado').value;

        if (ingreso === '' || gasto_mensual === '' || monto_solic === '') {
            $("#capacidad_pago").val("")
        }else{   
            let formula = ((ingreso - gasto_mensual) / monto_solic) * 100
            // let resultado = formula.toFixed(2)
            $("#capacidad_pago").val(formula)
        }

    }

    function calculaFechDesemb(){
        var fecha_solic = document.getElementById('fsolicitud').value;
        var fecha = new Date(fecha_solic);

        fecha.setDate(fecha.getDate() + 2);

        var fechaFinal = fecha.toISOString().slice(0,10);

        $("#fdesembolso").val(fechaFinal);
    }

    function calculaFechaPpago(){
        var fecha_solic = document.getElementById('fsolicitud').value;
        var frecuencia_pago = $("#frecuencia_pago").val();
    
        var fecha = new Date(fecha_solic);
        // Sumar 2 días a la fecha
    
        if(frecuencia_pago == 'DIARIO'){
            fecha.setDate(fecha.getDate() + 2); // Número de días a agregar, SE SUMA 1 DIAS MAS TRES DIAS DEL DESEMBOLSO
        }else if(frecuencia_pago == 'SEMANAL'){
            fecha.setDate(fecha.getDate() + 9); // Número de días a agregar, SE SUMA 7 DIAS MAS TRES DIAS DEL DESEMBOLSO
        }else if(frecuencia_pago == 'QUINCENAL'){
            fecha.setDate(fecha.getDate() + 17);// Número de días a agregar, SE SUMA 15 DIAS MAS TRES DIAS DEL DESEMBOLSO   
        }else if(frecuencia_pago == 'MENSUAL'){
            fecha.setDate(fecha.getDate() + 32);; // Número de días a agregar, SE SUMA 15 DIAS MAS TRES DIAS DEL DESEMBOLSO
        }else{
            fecha.setDate(fecha.getDate() + 10);; // Número de días a agregar, SE SUMA 7 DIAS MAS TRES DIAS DEL DESEMBOLSO
        }
        // fechaFormat.setDate(fechaFormat.getDate() + dias);
        // fechaFinal = moment(fechaFormat).utc().format('DD/MM/YYYY');
        var fechaFinal = fecha.toISOString().slice(0,10);

        $("#fprimer_pago").val(fechaFinal);
    }

    function calculaFechaVenc(){
        var fecha_solic = document.getElementById('fsolicitud').value;
        var fecha = new Date(fecha_solic);
        let frecuencia_pago = $("#frecuencia_pago").val();
        let plazo = $("#plazo").val();
    
        if(frecuencia_pago == 'DIARIO'){
            var dias = (1 * plazo) + 2; // Número de días a agregar, 1 por la frecuencia diaria, multiplicado por el plazo mas los dos dias de la fecha de desembolso 
            fecha.setDate(fecha.getDate() + dias);
        }else if(frecuencia_pago == 'SEMANAL'){
            var dias = (7 * plazo) + 2; // Número de días a agregar, 7 por la frecuencia semanal, multiplicado por el plazo mas los dos dias de la fecha de desembolso 
            fecha.setDate(fecha.getDate() + dias);
        }else if(frecuencia_pago == 'QUINCENAL'){
            var dias = (15 * plazo) + 2;
            fecha.setDate(fecha.getDate() + dias);
        }else if(frecuencia_pago == 'MENSUAL'){
            var dias = (30 * plazo) + 2;
            fecha.setDate(fecha.getDate() + dias);
        }else{
            var dias = 101; // Número de días a agregar
            fecha.setDate(fecha.getDate() + dias);
        }

        var fechaFinal = fecha.toISOString().slice(0,10);

        $("#fvencimiento").val(fechaFinal);
    }


    function cargarDetalles(){

        let id = document.getElementById("nombre_cliente").value;
        $.ajax({
            type: "get",
            url: "{{ asset('admin/solicitud/detalleClienteSolicitud') }}/" + id,
            success: function(data){
                console.log(data);
                $('#idCliente').val(data.cliente.id);
                $('#idAsociado').val(data.asociado.id);
                $('#idOperador').val(data.operador.id);
                $('#name_asociado').html(data.asociado.nombre+" "+data.asociado.apellido_paterno+" "+data.asociado.apellido_materno).attr('disabled', true);
                $('#name_operador').html(data.operador.nombre+" "+data.operador.apellido_paterno+" "+data.operador.apellido_materno).attr('disabled', true);
                $('#edad').html(data.cliente.edad+" "+"Año(s)");
                $('#genero').html(data.cliente.genero);
                $('#celular').html(data.cliente.celular);
                $('#estado_civil').html(data.cliente.estado_civil);
                $('#escolaridad').html(data.cliente.escolaridad);
                $('#profesion').html(data.cliente.profesion);
                $('#direccion').html(data.cliente.direccion);
                $('#cp').html(data.cliente.cp);
                $('#colonia').html(data.cliente.colonia+", "+data.cliente.ciudad+", "+data.cliente.estado);
                $('#vialidad').html(data.cliente.tipo_vialidad);
                $('#entre_calles').html(data.cliente.entre_calles);
            },
        })
        return false;
    }


    function buscarCodigoPostal() {
        let cp = document.getElementById("codigo_postal").value;
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
                    $(".theSuburbs").empty().trigger('change');
                    if(data != 'Resultado no encontrado'){
                        cpError = 0;
                        $('#codigo_postal').removeClass('is-invalid');
                        $('#codigo_postal').addClass('is-valid');
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
                        $('#codigo_postal').addClass('is-invalid');
                        $('#cpError').remove();
                        $('#theCp').append('<span class="invalid-feedback" id="cpError" role="alert"><strong>No se ha encontrado ese C.P.</strong></span>');
                    }
                }
            });
        }
        else {
            $('#codigo_postal').addClass('is-invalid');
            $('#cpError').remove();
            $('#theCp').append('<span class="invalid-feedback" id="cpError" role="alert"><strong>El código postal debe contener 5 números.</strong></span>');
        }
    };
</script>

