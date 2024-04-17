<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitud</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>  

<style>
    #mitabla {
        width: 100%;
        height: 50px;
    }
        td {
            font-size: 8px;
        }
        
        h6{
            font-size:9px !important;
            padding-top: -12px;
            height: 12px;
            background-color:rgba(192,192,192,0.3);
        }
        table{
        padding-top: -10px !important;
        /*padding-buttom: -20px !important
        border-spacing: none !important;
        margin-buttom:none !important;
        margin-buttom:-250px !important;*/
        
        }
        .table td, .table th{
            padding:0px !important;
            min-width:1px !important;
            
        }
        label{
            font-size:8px;
        }
        input[type=checkbox]{
            /* Doble-tamaño Checkboxes */
            -ms-transform: scale(2); /* IE */
            -moz-transform: scale(2); /* FF */
            -webkit-transform: scale(2); /* Safari y Chrome */
            -o-transform: scale(2); /* Opera */
            
        }
        .answer{
            text-align:left;
        }
        /*tr{
            height: 20px !important;
        }*/
        .tr-borderless > td{
            border-top: none !important;
        }
        .border-topless{
            border-top: none !important;
        }
        .border-right{
            border-right: 1px solid black;
        }
        .signatures {
            margin-top:0px !important; /* tenia 5 */
            font-size:5.5px !important;
            width:125px !important;
            padding:5px;
        }
        .signature  td {
            padding:5px !important;
        }

        /*para los saltos de pagina del aval*/
        .wrapper-page {
            page-break-after: always;
        }
        
        .wrapper-page:last-child {
            page-break-after: avoid;
        }

        .cuadrado {
            width: 70px;           /* Ancho de 150 píxeles */
            height: 70px;          /* Alto de 150 píxeles */
            background: rgb(224, 221, 221);        /* Fondo de color rojo */
            border: 1px solid #000; /* Borde color negro y de 1 píxel de grosor */
        }

        .page_break {
            page-break-before: always;
        }
    </style>
<body>
    @php
        $domain = request()->root().'/';
    @endphp

    <table width="100%">
        <tr>
            <td width="10%" align="left">
                <table width="100%" >
                    <tr>
                        <td>Fecha de Entrega:</td>
                        <td width="70%"><b>{{ date('d/m/Y', strtotime($solicitud[0]->fecha_desembolso))}}</b></td>
                    </tr>
                    <tr>
                        <td >Folio:</td>
                        <td width="70%"><b>{{str_pad($solicitud[0]->id, 5, "0", STR_PAD_LEFT)}}{{str_pad($solicitud[0]->id, 5, "0", STR_PAD_LEFT)}}</b></td>
                    </tr>
                </table>
            </td>
            <td  width="10%" align="center">
                <P><b>SOLICITUD</P>
            </td>
            <td width="10%" align="right">
                {{-- <img style="width: 25%;" src="../public/img/logo.jpg"  alt="logo"> --}}
                <img style="width: 25%;" src="{{ asset('img/logo.jpg') }}"  alt="logo">
            </td>
        </tr>
    </table>
    <h6 class="text-center">IDENTIFICACION DEL CLIENTE</h6>
    <table class="table">
        <tr class="tr-borderless">
            <td  width="70px">Nombre Completo:</td>
            <td  width="150px" class="answer"><b>{{$solicitud[0]->cliente->getFullName()}}</b></td>
            <td  width="60px" >Fecha Nacimiento:</td>
            <td  width="50px"><b>{{$solicitud[0]->cliente->fecha_nacimiento}}</b></td>
            <td  width="10px" >Edad:</td>
            <td  width="95px"><b>{{$solicitud[0]->cliente->edad}} Años</b></td>
            <td  width="10px" >Telefono:</td>
            <td  width="50px"><b>{{$solicitud[0]->cliente->celular}}</b></td>
        </tr>
    </table>
    <table class="table ">
        <tr>
            <td  width="15px" >Dirección:</td>
            <td  width="150px" ><b>{{$solicitud[0]->cliente->direccion}}</b></td>
            <td  width="30px">Entre calles:</td>
            <td  width="150px"><b>{{$solicitud[0]->cliente->entre_calles}}</b></td>
            <td  width="30px" >C.P:</td>
            <td  width="35px"  ><b>{{$solicitud[0]->cliente->cp}}</b></td>
        </tr>
    </table>
    <table class="table ">
        <tr>
            <td  width="15px" >Colonia:</td>
            <td  width="20px"><b>{{$solicitud[0]->cliente->colonia}}</b></td>
            <td  width="5px">Ciudad:</td>
            <td  width="50px"><b>{{$solicitud[0]->cliente->ciudad}}</b></td>
            <td  width="15px" >Estado:</td>
            <td  width="25px"><b>{{$solicitud[0]->cliente->estado}}</b></td>
            <td  width="10px" >País:</td>
            <td  width="50px"  ><b>MÉXICO</b></td>
        </tr>
    </table>
    <table class="table ">
        @php
            if($solicitud[0]->cliente->tipo_vivienda == 'RENTADA'){
                $checkR = "checked";
                $checkP ="";
                $checkF ="";
            }else if($solicitud[0]->cliente->tipo_vivienda == 'PROPIA'){
                $checkP = "checked";
                $checkR ="";
                $checkF ="";

            }else if($solicitud[0]->cliente->tipo_vivienda == 'FAMILIAR'){
                $checkF = "checked";
                $checkP ="";
                $checkR ="";
            }else{
                $checkR ="";
                $checkP ="";
                $checkF ="";
            }
        @endphp
        <tbody>
            <tr> {{$solicitud[0]->cliente->tipo_vivienda == 'RENTADA'}}
                <td  width="50px">Lugar de Nacimiento:</td>
                <td  width="60px" class="answer"><b>{{$solicitud[0]->cliente->ciudad_nacimiento}}</b></td>
                <td  width="40px" >Estado Civil:</td>
                <td  width="50px"><b>{{$solicitud[0]->cliente->estado_civil}}</b></td>
                <td width="35px" class="">Tipo de casa:<small></td>
                <td width="5px"><label><input type="checkbox" class="" name="" id="" {{$checkR}}>&nbsp;&nbsp;Rentada&nbsp;&nbsp; </label> </td>
                <td width="5px"> <label> <input type="checkbox" class="" name="" id="" {{$checkP}} >&nbsp;&nbsp;Propia&nbsp;&nbsp; </label></td>
                <td width="5px"> <label> <input type="checkbox" class="" name="" id="" {{$checkF}}>&nbsp;&nbsp;Familiar&nbsp;&nbsp; </label></td>
                <td  width="40px" >Tiempo de vivir ahí:</td>
                <td  width="20px" ><b>{{$solicitud[0]->cliente->anios_residencia}}</b></td>
            </tr>
           
        </tbody>
    </table>   
    
    <h6 class="text-center">DATOS DEL NEGOCIO</h6>
    <table class="table ">
        <tr  class="tr-borderless">
            <td  width="55px" >Dirección del Negocio:</td>
            <td  width="150px" ><b>{{$solicitud[0]->direccion_negocio}}</b></td>
            <td  width="35px">Entre calles:</td>
            <td  width="150px"><b>{{$solicitud[0]->entre_calles}}</b></td>
            <td  width="30px" >C.P:</td>
            <td  width="35px"  ><b>{{$solicitud[0]->cp}}</b></td>
        </tr>
    </table>
    <table class="table ">
        <tr>
            <td  width="10px" >Colonia:</td>
            <td  width="60px"><b>{{$solicitud[0]->colonia}}</b></td>
            <td  width="10px">Ciudad:</td>
            <td  width="35px"><b>{{$solicitud[0]->ciudad}}</b></td>
            <td  width="10px" >Estado:</td>
            <td  width="35px"><b>{{$solicitud[0]->estado}}</b></td>
            <td  width="10px" >País:</td>
            <td  width="50px"  ><b>MÉXICO</b></td>
        </tr>
    </table>
    <table class="table ">
        @php
        if($solicitud[0]->tipo_establecimiento == 'Propio'){
            $checkProp = "checked";
            $checkAmb ="";
            $checkRent ="";
            $checkFijo ="";
        }else if($solicitud[0]->tipo_establecimiento == 'Ambulante'){
            $checkProp = "";
            $checkAmb ="checked";
            $checkRent ="";
            $checkFijo ="";
        }else if($solicitud[0]->tipo_establecimiento == 'Rentado'){
            $checkProp = "";
            $checkAmb ="";
            $checkRent ="checked";
            $checkFijo ="";
        }else if($solicitud[0]->tipo_establecimiento == 'Fijo'){
            $checkProp = "";
            $checkAmb ="";
            $checkRent ="";
            $checkFijo ="checked";
        }else{
            $checkProp = "";
            $checkAmb ="";
            $checkRent ="";
            $checkFijo ="checked";
        }
    @endphp
        <tr>
            <td  width="65px" >Antiguedad del Negocio:</td>
            <td  width="35px"><b>{{$solicitud[0]->antiguedad_negocio}}</b></td>
            <td  width="55px" >Años de experiencia:</td>
            <td  width="35px"><b>{{$solicitud[0]->anios_exp}}</b></td>
            <td width="65px" class="">Tipo de establecimiento:<small></td>
            <td width="0px"><label><input type="checkbox" class="" name="" id="" {{$checkProp}} >&nbsp;&nbsp;Propio&nbsp;&nbsp; </label> </td>
            <td width="0px"> <label> <input type="checkbox" class="" name="" id="" {{$checkAmb}}>&nbsp;&nbsp;Ambulante&nbsp;&nbsp; </label></td>
            <td width="0px"> <label> <input type="checkbox" class="" name="" id="" {{$checkRent}}>&nbsp;&nbsp;Rentado&nbsp;&nbsp; </label></td>
            <td width="0px"> <label> <input type="checkbox" class="" name="" id="" {{$checkFijo}} >&nbsp;&nbsp;Fijo&nbsp;&nbsp; </label></td>
            <td  width="50px">Giro del Negocio:</td>
            <td  width="55px"><b>{{$solicitud[0]->tipo_negocio}}</b></td>
            
        </tr>
    </table>
    <table class="table ">
        <tbody>
            <tr>
                <td  width="25px" >Monto Solicitado:</td>
                <td  width="2px"><b>$ {{$solicitud[0]->monto_solicitado}}</b></td>
                <td width="20px">Plazo:</td>
                <td width="20px"><b>{{$solicitud[0]->plazo}}</b></td>
                <td width="20px">Cuota:</td>
                <td width="20px"><b>$ {{$solicitud[0]->cuota}}</b></td>
                <td width="20px">Total a pagar:</td>
                <td width="20px"><b>$ {{$solicitud[0]->analisis->total}}</b></td>
            </tr>
        </tbody>
    </table>

    <h6 class="text-center">REFERENCIAS</h6>
    <table class="table" >
        <tr class="tr-borderless">
            <td class="text-center">FAMILIAR</td>
            <td></td>
            <td class="text-center">COMERCIAL</td>
            <td></td>

        </tr>
        <tr>
            <td  width="50px" >Nombre Completo:</td>
            <td  width="200px" ><b>{{$referencia_familiar ? $referencia_familiar->getFullName() : ''}}</b></td>
            <td  width="50px" >Nombre Completo:</td>
            <td  width="200px" ><b>{{ ($referencia_comercial) ? $referencia_comercial->getFullName() : ''}}</b></td>
        </tr>
        <tr>
            <td  width="40px" >Parentesco:</td>
            <td  width="70px" ><b>{{$referencia_familiar ? $referencia_familiar->parentesco : ''}}</b></td>
            <td  width="40px" >Parentesco:</td>
            <td  width="70px" ><b>{{$referencia_comercial ? $referencia_comercial->parentesco : ''}}</b></td>
        </tr>
        <tr>
            <td  width="40px" >Domicilio:</td>
            <td  width="100px" ><b>{{$referencia_familiar ? $referencia_familiar->direccion: ''}}</b></td>
            <td  width="40px" >Domicilio:</td>
            <td  width="100px" ><b>{{$referencia_comercial ? $referencia_comercial->direccion : ''}}</b></td>
        </tr>
        <tr>
            <td  width="40px" >Entre calle:</td>
            <td  width="100px" ><b>{{$referencia_familiar ? $referencia_familiar->entre_calles: ''}}</b></td>
            <td  width="40px" >Entre calle:</td>
            <td  width="100px" ><b>{{$referencia_comercial ? $referencia_comercial->entre_calles : ''}}</b></td>
        </tr>
        <tr>
            <td  width="40px" >Referencias:</td>
            <td  width="100px" ><b>{{$referencia_familiar ? $referencia_familiar->referencia: ''}}</b></td>
            <td  width="40px" >Referencias:</td>
            <td  width="100px" ><b>{{ $referencia_comercial ? $referencia_comercial->referencia : ''}}</b></td>
        </tr>
        <tr>
            <td  width="40px" >Colonia:</td>
            <td  width="100px" ><b>{{$referencia_familiar ? $referencia_familiar->colonia : ''}}</b></td>
            <td  width="40px" >Colonia:</td>
            <td  width="100px" ><b>{{$referencia_comercial ? $referencia_comercial->colonia : ''}}</b></td>
        </tr>
        <tr>
            <td  width="40px" >Telefono:</td>
            <td  width="100px" ><b>{{$referencia_familiar ? $referencia_familiar->telefono : ''}}</b></td>
            <td  width="40px" >Telefono:</td>
            <td  width="100px" ><b>{{$referencia_comercial ? $referencia_comercial->telefono : ''}}</b></td>
        </tr>
    </table>
    <table class="table  " style="width: 90% !important">
        <tbody>
        <tr class="tr-borderless">
            <td class="" style="font-size:7px !important;" width="305px" align="center">
                <b class="text-center">{{$solicitud[0]->cliente->getFullName()}}
                    ______________________________________________________________________________________________
                </b>
                <b class="text-center">NOMBRE Y FIRMA DEL SOLICITANTE</b>
            </td>
            <td width="40px" ></td>
            <td width="100px" align="center">
                <div class="cuadrado">Pulgar</div>
            </td>
            <td width="100px" align="center">
                <div class="cuadrado">Indice</div>
            </td>
            <td width="15px" ></td>

        </tr>
        </tbody>
    </table>
    <h6 class="text-center">TABLA DE AMORTIZACIÓN</h6>
    <table class="table">
            <tr class="tr-borderless text-center">
                <td>N°</td>
                <td>Fecha de Pago</td>
                <td>Pago</td>
                <td>Capital</td>
                <td>Interes</td>
                <td>Saldo Pendiente</td>
                <td>Firma Cliente</td>
                <td>Firma Asesor</td>
            </tr>
        <tbody>
            @php
                $cont = 0;
            @endphp
            @foreach($tablaAmortizacion as $tAmortizacion)      
                @php
                    $cont ++;
                @endphp  
            <tr class="text-center">
                <td>{{$cont}}</td>
                <td>{{ date('d/m/Y', strtotime($tAmortizacion->fecha_pago))}}</td> 
                <td>{{ $tAmortizacion->pago }}</td>
                <td>{{ $tAmortizacion->capital }}</td>
                <td>{{ $tAmortizacion->interes }}</td>
                <td>{{ $tAmortizacion->saldo_pendiente }}</td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table"  width="100%"> {{--  style="padding-top: 80px !important;" --}}
        <tbody > 
            <tr  class="tr-borderless" style="height:2.1cm;text-align:left;">
                <td  style="text-align: justify;font-size:8pt" colspan="4"><br>
                    MANIFIESTO QUE LOS DATOS CONTENIDOS EN LA PRESENTE CEDULA DE SUPERVISIÓN SON VERÍDICOS, SIENDO EL RESULTADO DE UN TRABAJO RESPONSABLE Y EXHAUSTIVO QUE MI PERSONA REALIZO EN EL DOMICILIO Y EN EL NEGOCIO DEL SOLICITANTE RECONOCIENDO LA IMPORTANCIA DE ESTA INFORMACIÓN IMPLICA PARA LA AUTORIZACIÓN DEL CRÉDITO EN TRAMITE, ESTANDO CONSIENTE DE MIS FACULTADES Y RESPONSABILIDADES ASIGNADAS EN ESTA REVISIÓN.<br><br>
                </td>
            </tr>
            <tr class="tr-borderless">
                <td width="150px" ></td>
                <td class="" style="font-size:7px !important;" width="305px" align="center">
                    <b class="text-center">{{$solicitud[0]->usuario->personal->getFullName()}}
                        ______________________________________________________________________________________________
                    </b>
                    <b class="text-center">NOMBRE Y FIRMA DEL ASESOR</b>
                </td>
                <td width="150px" ></td>
            </tr>
           
            <tr  class="tr-borderless" style="height:2.1cm;text-align:left;">
                <td  style="text-align: justify;font-size:8pt" colspan="4"><br>
                    @if($domain == 'http://institutomn.org/' ||$domain == 'http://www.institutomn.org/')
                        ACEPTO Y ME COMPROMETO A RESPETAR LAS POLITICAS ESTABLECIDAS EN ESTE PRESTAMO Y PAGAR UNA PENALIZACIÓN POR FALTA DE PAGO POR CADA DÍA DE <strong>$ 50.00 (CINCUENTA PESOS 00/100 M.N.) DE MORATORIO, DESPUES DE LAS 18:00 HRS.</strong><br><br>
                    @else
                        ACEPTO Y ME COMPROMETO A RESPETAR LAS POLITICAS ESTABLECIDAS EN ESTE PRESTAMO Y PAGAR UNA PENALIZACIÓN POR FALTA DE PAGO POR CADA DÍA DE <strong>$ 20.00 (VEINTE PESOS 00/100 M.N.) DE MORATORIO, DESPUES DE LAS 18:00 HRS.</strong><br><br>
                    @endif
                </td>
            </tr>
            <tr class="tr-borderless">
                <td width="150px" ></td>
                <td class="" style="font-size:7px !important;" width="305px" align="center">
                    <b class="text-center">{{$solicitud[0]->cliente->getFullName()}}
                        ______________________________________________________________________________________________
                    </b>
                    <b class="text-center">NOMBRE Y FIRMA DEL SOLICITANTE</b>
                </td>
                <td width="150px" ></td>
            </tr>
            <br>
            <tr class="tr-borderless">
                <td style="font-size:8pt;text-align:center;font-weight: bold" colspan="4" >
                    <strong>AUTORIZACIÓN DE BURO DE CREDITO<br>
                </td>
            </tr>
            <tr  class="tr-borderless" style="height:2.1cm;text-align:left;">
                <td  style="text-align: justify;font-size:8pt" colspan="4"><br>
                    AUTORIZO EXPRESAMENTE A <strong>{{$empresa->razon_social}}</strong> EN ADELANTE LA FINANCIERA O LA INSTITUCIÓN INDISTINTAMENTE, PARA QUE POR SU CONDUCTO, LLEVEN A CABO LA INVESTIGACIÓN SOBRE MI HISTORIAL CREDITICIO CON LAS SOCIEDADES DE INFORMACIÓN QUE SE SOLICITARÁ, DEL USO QUE LA FINANCIERA Y DE QUE ESTA PODRÁ REALIZAR CONSULTAS PERIODICAS DE MI HISTORIAL CREDITICIO.<br><br>
                </td>
            </tr>
            <tr class="tr-borderless">
                <td width="150px" ></td>
                <td class="" style="font-size:7px !important;" width="305px" align="center">
                    <b class="text-center">{{$solicitud[0]->cliente->getFullName()}}
                        ______________________________________________________________________________________________
                    </b>
                    <b class="text-center">NOMBRE Y FIRMA DEL SOLICITANTE</b>
                </td>
                <td width="150px" ></td>
            </tr>
            <br><br>
            <tr class="tr-borderless">
                <td style="font-size:7pt;font-weight: bold" colspan="2" >
                    <strong>NOMBRE DEL ASESOR: &nbsp;&nbsp;&nbsp;<u>{{$solicitud[0]->usuario->personal->getFullName()}}</u>
                </td>
                <td style="font-size:7pt;font-weight: bold" colspan="2" >
                    <strong>FIRMA: ____________________
                </td>
            </tr>
            <br>
            {{-- <tr class="tr-borderless">
                <td style="font-size:7pt;font-weight: bold" colspan="2" >
                    <strong>FECHA DE INGRESO: {{$solicitud[0]->usuario->personal->fecha_alta}}
                </td>
            </tr> --}}
        </tbody>
    </table>     
</body>
<body>
    
    <div class="text-center"><b>TABLA DE PAGOS $ {{number_format($solicitud[0]->analisis->monto_autorizado, 2, '.', '')}} A {{$tablaAmortizacion->count()}} SEMANAS</b></div><br>
    @if($domain == 'http://institutomn.org/' ||$domain == 'http://www.institutomn.org/')
        <table BORDER WIDTH="100%">
            <tr class="text-center">
                <td><b>SEMANA</b></td>
                <td><b>FECHA DE PAGO</b></td>
                <td><b>PAGO PUNTUAL</b></td>
                <td><b>PAGO ATRASADO</b></td>
                
            </tr>
            <tbody>
                @php
                    $cont = 0;
                    $totalPago = 0;

                @endphp
                @foreach($tablaAmortizacion as $tAmortizacion)      
                    @php
                        $cont ++;
                        $totalPago += $tAmortizacion->pago;
                        $porcentaje = 50;
                    @endphp  
                <tr class="text-center">
                    <td>{{$cont}}</td>
                    <td>{{ date('d/m/Y', strtotime($tAmortizacion->fecha_pago))}}</td> 
                    <td>{{ $tAmortizacion->pago }}</td>
                    <td>{{ number_format($tAmortizacion->pago + $porcentaje, 2, '.', '') }}</td>
                </tr>
                @endforeach
            </tbody>
        
        </table>
    @else
        <table BORDER WIDTH="100%" id="miTabla">
            <tr class="text-center">
                <td style="font-size: 11px;"><b>SEMANA</b></td>
                <td style="font-size: 11px;"><b>FECHA DE PAGO</b></td>
                <td style="font-size: 11px;"><b>PAGO PUNTUAL</b></td>
                <td style="font-size: 11px;"><b>PAGO TRADICIONAL</b></td>
                
            </tr>
            <tbody>
                @php
                    $cont = 0;
                    $totalPago = 0;

                @endphp
                @foreach($tablaAmortizacion as $tAmortizacion)      
                    @php
                        $cont ++;
                        $totalPago += $tAmortizacion->pago;
                        $porcentaje = $tAmortizacion->pago * 0.10;
                    @endphp  
                <tr class="text-center">
                    <td style="font-size: 14px;">{{$cont}}</td>
                    <td style="font-size: 14px;">{{ date('d/m/Y', strtotime($tAmortizacion->fecha_pago))}}</td> 
                    <td style="font-size: 14px;">{{ $tAmortizacion->pago }}</td>
                    <td style="font-size: 14px;">{{ number_format($tAmortizacion->pago + $porcentaje, 2, '.', '') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <br>
    <p style="text-align: center;justify;font-size:12pt">
        HOY ES EL MEJOR DIA DE TU VIDA, DISFRUTALO!! <br>
        Recuerda que tu pago puntual, te ayudara a incrementar de nivel
    </p>
    @php
        $empresa = App\Models\Empresa::select('empresas.*')->first();
        $bancos = App\Models\Banco::select('bancos.*')->where('uso_Cuenta','LIKE',"%RECUPERACION%")->get();
        use App\Models\NumerosEnLetras;

    @endphp
    <table BORDER WIDTH="100%">
        <tr class="text-center">
            <td COLSPAN=3 style="font-size: 14px;"><b>CUENTA PARA DEPOSITO</b></td>
        </tr>
        <tr class="text-center">
            <td COLSPAN=3 style="font-size: 14px;">TITULAR: {{$empresa->razon_social}}</td>
        </tr>
        <tr class="text-center">
            <td style="font-size: 14px;"><b>METODO DE PAGO</b></td>
            <td style="font-size: 14px;"><b>BANCO</b></td>
            <td style="font-size: 14px;"><b>Número de Tarjeta</b></td>
            
        </tr>
        <tbody>
           @if ($bancos->isEmpty())
                <tr class="text-center">
                    <td>--- ---</td>
                    <td>--- --</td>
                    <td>--- --</td>
                </tr>
           @else 
                @foreach($bancos as $banco)      
                    <tr class="text-center">
                        <td style="font-size: 12px;">{{ ($banco->banco == 'BBVA BANCOMER') ? 'TRANSFERENCIA' : 'OXXO'}}</td>
                        <td style="font-size: 12px;">{{ $banco->banco }}</td>
                        <td style="font-size: 12px;">{{ $banco->num_tarjeta }}</td>
                    </tr>
                @endforeach
               
           @endif
           <tr class="text-left">
                <td style="font-size: 10px;" COLSPAN=3>NOTA: ESTIMADO CLIENTE ES MUY IMPORTANTE QUE TU NOMBRE COMPLETO ESTE EN EL CONCEPTO DEL PAGO</td>
            </tr>
        </tbody>
        
    </table>
        @php
            $fechaDesembolso = $solicitud[0]->fecha_desembolso; // Tu fecha en formato 'YYYY-MM-DD'
            $fechaVencimiento = $solicitud[0]->fecha_vencimiento; // Tu fecha en formato 'YYYY-MM-DD'
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    
            $fechaDesembolso = \Carbon\Carbon::parse($fechaDesembolso);
            $fechaVencimiento = \Carbon\Carbon::parse($fechaVencimiento);
            $mes = $meses[($fechaDesembolso->format('n')) - 1];
            $mesVencimiento = $meses[($fechaVencimiento->format('n')) - 1];
            $fechaDesembolso = $fechaDesembolso->format('d') . ' de  ' . $mes . ' del ' . $fechaDesembolso->format('Y');
            $fechaVencimiento = $fechaVencimiento->format('d') . ' de  ' . $mesVencimiento . ' del ' . $fechaVencimiento->format('Y');
        @endphp
    <div class="page_break">
        <table BORDER WIDTH="100%" id="mitabla">
          
            <tr class="text-center">
                <td style="font-size: 14px;"><b>PAGARE No. 1 / 1<br><br>&nbsp;</b></td>
                <td style="font-size: 14px;"><b>VENCIMIENTO: {{$fechaVencimiento}}<br><br>&nbsp;</b></td>
                <td style="font-size: 14px;"><b>BUENO POR: $ {{number_format($totalPago, 2, '.', ',')}}<br><br>&nbsp;</b></td>
                
            </tr>
        </table>
           
            <br>
            <br>
            <br>

            <p style="text-align: right;justify;font-size:12pt" class="text-justify">
                Por el presente pagare declaro deber y me obligo a pagar incondicionalmente a la orden de: {{$empresa->razon_social}} la suma de: 
                $ {{number_format($solicitud[0]->analisis->total, 2, '.', ',')}} ({{NumerosEnLetras::convertir($solicitud[0]->analisis->total,'pesos',false,'Centavos')}})<br>
                Valor que he recibido a mi entera satisfacción y me obligo a pagar en {{$tablaAmortizacion->count()}} abonos semanales el primero de:
            </p>
            
            <p style="text-align: right;justify;font-size:12pt" class="text-justify">
                $ {{number_format($tablaAmortizacion[0]->pago, 2, '.', ',')}} ({{NumerosEnLetras::convertir($tablaAmortizacion[0]->pago,'pesos',false,'Centavos')}}) Y los demás por: <br>
                $ {{number_format($tablaAmortizacion[0]->pago, 2, '.', ',')}} ({{NumerosEnLetras::convertir($tablaAmortizacion[0]->pago,'pesos',false,'Centavos')}})
            </p>
            <p style="text-align: right;justify;font-size:12pt" class="text-justify">
                Mientras quede una cantidad insoluta este pagare devengare un interés normal del 24.00% anual
                 que deberá pagarse con el abono, de no pagarse con las fechas establecidas causara además un 
                 interés moratorio del 26.28% anual sobre el importe de cada abono vencido, en caso de que se 
                 dejen de pagar más de 3 abonos, el saldo se dará por vencido y podrá exigirse el pago total. <br><br>
                 Tuxtla Gutiérrez, Chiapas. A {{$fechaDesembolso}}.
            </p>
            <br>
            <br>
            <table BORDER WIDTH="100%">
          
                <tr class="text-center">
                    <td WIDTH="50%" style="font-size: 14px;">DEUDOR:<br><br><br><br><br><br><br>
                        <br><b>&nbsp;{{$solicitud[0]->cliente->getFullName()}}</b><br>
                        {{strtoupper($solicitud[0]->cliente->tipo_vialidad)}} {{$solicitud[0]->cliente->direccion}} ENTRE CALLES {{$solicitud[0]->cliente->entre_calles}}, COL. {{$solicitud[0]->cliente->colonia}}, C.P. {{$solicitud[0]->cliente->cp}}. {{$solicitud[0]->cliente->ciudad}},{{$solicitud[0]->cliente->estado}}.
                    </td>
                    <td WIDTH="50%" style="font-size: 14px;">AVAL:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br><br><br><br><br>&nbsp;
                        <b>{{($solicitud[0]->cliente->aval) ? $solicitud[0]->cliente->aval->getFullName() : ''}}</b><br>
                        {{($solicitud[0]->cliente->aval) ? $solicitud[0]->cliente->aval->direccion.' ENTRE CALLES '.$solicitud[0]->cliente->aval->entre_calles.' COL. '.$solicitud[0]->cliente->aval->colonia.', C.P. '.$solicitud[0]->cliente->aval->cp.'.'.$solicitud[0]->cliente->aval->ciudad.','.$solicitud[0]->cliente->estado : ''}}<br>
                        
                    </td>
                    
                </tr>
               
            </table>
           
    

    </div>
</body>
</html>