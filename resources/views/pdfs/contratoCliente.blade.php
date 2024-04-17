<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitud</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>  

<style>
   
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
        }<
        
        .wrapper-page:last-child {
            page-break-after: avoid;
        }

        .cuadrado {
            width: 70px;           /* Ancho de 150 píxeles */
            height: 70px;          /* Alto de 150 píxeles */
            background: rgb(224, 221, 221);        /* Fondo de color rojo */
            border: 1px solid #000; /* Borde color negro y de 1 píxel de grosor */
        }
    </style>
<body>
    @php
        $empresa = App\Empresa::select('empresas.*')->first();
    @endphp
    <table width="100%">
        <tr>
            <td width="10%" align="left">
                <table width="100%" >
                    <tr>
                        <td>Fecha de Entrega:</td>
                        <td width="70%"><b> </b></td>
                    </tr>
                    <tr>
                        <td >Folio:</td>
                        <td width="70%"><b></b></td>
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
            <td  width="150px" class="answer"><b></b></td>
            <td  width="60px" >Fecha Nacimiento:</td>
            <td  width="50px"><b></b></td>
            <td  width="10px" >Edad:</td>
            <td  width="95px"><b></b></td>
            <td  width="10px" >Telefono:</td>
            <td  width="50px"><b></b></td>
        </tr>
    </table>
    <table class="table ">
        <tr>
            <td  width="15px" >Dirección:</td>
            <td  width="150px" ><b></b></td>
            <td  width="30px">Entre calles:</td>
            <td  width="150px"><b></b></td>
            <td  width="30px">C.P:</td>
            <td  width="35px"><b></b></td>
        </tr>
    </table>
    <table class="table ">
        <tr>
            <td  width="15px" >Colonia:</td>
            <td  width="20px"><b></b></td>
            <td  width="5px">Ciudad:</td>
            <td  width="50px"><b></b></td>
            <td  width="15px" >Estado:</td>
            <td  width="25px"><b></b></td>
            <td  width="10px" >País:</td>
            <td  width="50px"  ><b>MÉXICO</b></td>
        </tr>
    </table>
    <table class="table ">
       
        <tbody>
            <tr>
                <td  width="50px">Lugar de Nacimiento:</td>
                <td  width="60px" class="answer"><b></b></td>
                <td  width="40px" >Estado Civil:</td>
                <td  width="50px"><b></b></td>
                <td width="35px" class="">Tipo de casa:<small></td>
                <td width="5px"><label><input type="checkbox" class="" name="" id="">&nbsp;&nbsp;Rentada&nbsp;&nbsp; </label> </td>
                <td width="5px"> <label> <input type="checkbox" class="" name="" id=""  >&nbsp;&nbsp;Propia&nbsp;&nbsp; </label></td>
                <td width="5px"> <label> <input type="checkbox" class="" name="" id="" >&nbsp;&nbsp;Familiar&nbsp;&nbsp; </label></td>
                <td  width="40px" >Tiempo de vivir ahí:</td>
                <td  width="20px" ><b></b></td>
            </tr>
           
        </tbody>
    </table>   
    
    <h6 class="text-center">DATOS DEL NEGOCIO</h6>
    <table class="table ">
        <tr  class="tr-borderless">
            <td  width="55px" >Dirección del Negocio:</td>
            <td  width="150px" ><b></b></td>
            <td  width="35px">Entre calles:</td>
            <td  width="150px"><b></b></td>
            <td  width="30px">C.P:</td>
            <td  width="35px"><b></b></td>
        </tr>
    </table>
    <table class="table ">
        <tr>
            <td  width="10px" >Colonia:</td>
            <td  width="60px"><b></b></td>
            <td  width="10px">Ciudad:</td>
            <td  width="35px"><b></b></td>
            <td  width="10px" >Estado:</td>
            <td  width="35px"><b></b></td>
            <td  width="10px" >País:</td>
            <td  width="50px"><b>MÉXICO</b></td>
        </tr>
    </table>
    <table class="table ">
       
        <tr>
            <td  width="65px" >Antiguedad del Negocio:</td>
            <td  width="35px"><b></b></td>
            <td  width="55px" >Años de experiencia:</td>
            <td  width="35px"><b></b></td>
            <td width="65px" class="">Tipo de establecimiento:<small></td>
            <td width="0px"><label><input type="checkbox" class="" name="" id=""  >&nbsp;&nbsp;Propio&nbsp;&nbsp; </label> </td>
            <td width="0px"> <label> <input type="checkbox" class="" name="" id="" >&nbsp;&nbsp;Ambulante&nbsp;&nbsp; </label></td>
            <td width="0px"> <label> <input type="checkbox" class="" name="" id="" >&nbsp;&nbsp;Rentado&nbsp;&nbsp; </label></td>
            <td width="0px"> <label> <input type="checkbox" class="" name="" id=""  >&nbsp;&nbsp;Fijo&nbsp;&nbsp; </label></td>
            <td  width="50px">Giro del Negocio:</td>
            <td  width="55px"><b></b></td>
            
        </tr>
    </table>
    <table class="table ">
        <tbody>
            <tr>
                <td  width="25px" >Monto Solicitado:</td>
                <td  width="2px"><b>$ </b></td>
                <td width="20px">Plazo:</td>
                <td width="20px"><b></b></td>
                <td width="20px">Cuota:</td>
                <td width="20px"><b>$ </b></td>
                <td width="20px">Total a pagar:</td>
                <td width="20px"><b>$ </b></td>
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
            <td  width="200px" ><b></b></td>
            <td  width="50px" >Nombre Completo:</td>
            <td  width="200px" ><b></b></td>
        </tr>
        <tr>
            <td  width="40px" >Parentesco:</td>
            <td  width="70px" ><b></b></td>
            <td  width="40px" >Parentesco:</td>
            <td  width="70px" ><b></b></td>
        </tr>
        <tr>
            <td  width="40px" >Domicilio:</td>
            <td  width="100px" ><b></b></td>
            <td  width="40px" >Domicilio:</td>
            <td  width="100px" ><b></b></td>
        </tr>
        <tr>
            <td  width="40px" >Entre calle:</td>
            <td  width="100px" ><b></b></td>
            <td  width="40px" >Entre calle:</td>
            <td  width="100px" ><b></b></td>
        </tr>
        <tr>
            <td  width="40px" >Referencias:</td>
            <td  width="100px" ><b></b></td>
            <td  width="40px" >Referencias:</td>
            <td  width="100px" ><b></b></td>
        </tr>
        <tr>
            <td  width="40px" >Colonia:</td>
            <td  width="100px" ><b></b></td>
            <td  width="40px" >Colonia:</td>
            <td  width="100px" ><b></b></td>
        </tr>
        <tr>
            <td  width="40px" >Telefono:</td>
            <td  width="100px" ><b></b></td>
            <td  width="40px" >Telefono:</td>
            <td  width="100px" ><b></b></td>
        </tr>
    </table>
    <table class="table  " style="width: 90% !important">
        <tbody>
        <tr class="tr-borderless">
            <td class="" style="font-size:7px !important;" width="305px" align="center">
                <b class="text-center">
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
                    <b class="text-center">
                        ______________________________________________________________________________________________
                    </b>
                    <b class="text-center">NOMBRE Y FIRMA DEL ASESOR</b>
                </td>
                <td width="150px" ></td>
            </tr>
            <tr  class="tr-borderless" style="height:2.1cm;text-align:left;">
                <td  style="text-align: justify;font-size:8pt" colspan="4"><br>
                    ACEPTO Y ME COMPROMETO A RESPETAR LAS POLITICAS ESTABLECIDAS EN ESTE PRESTAMO Y PAGAR UNA PENALIZACIÓN POR FALTA DE PAGO POR CADA DÍA DE <strong>$ 20.00 (VEINTE PESOS 00/100 M.N.) DE MORATORIO, DESPUES DE LAS 18:00 HRS.</strong><br><br>
                </td>
            </tr>
            <tr class="tr-borderless">
                <td width="150px" ></td>
                <td class="" style="font-size:7px !important;" width="305px" align="center">
                    <b class="text-center">
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
                    <b class="text-center">
                        ______________________________________________________________________________________________
                    </b>
                    <b class="text-center">NOMBRE Y FIRMA DEL SOLICITANTE</b>
                </td>
                <td width="150px" ></td>
            </tr>
            
        </tbody>
    </table>     
</body>
</html>